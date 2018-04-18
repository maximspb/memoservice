<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "memo".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $text
 * @property int $ref_number
 * @property string $customDate
 * @property User $user
 */
class Memo extends \yii\db\ActiveRecord
{
    public $recipientsList = [];

    /**
     * @var string $pdfPath
     * путь к сохраненному файлу pdf
     */
    protected $pdfPath;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'memo';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                //'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'title', 'text'], 'required'],
            [['recipientsList'], 'safe'],
            [['user_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 250],
            ['ref_number', 'integer'],
            ['customDate', 'safe'],
            ['customDate', 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Касается',
            'text' => 'Текст',
            'recipientsList' => 'Получатели',
            'created_at' => 'Создан',
            'customDate' => 'Произвольная дата',
            'ref_number' => 'Исходящий номер'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRecipients()
    {
        return $this->hasMany(Recipient::class, ['id' => 'recipient_id'])
            ->viaTable('memo_recipient', ['memo_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MemoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MemoQuery(get_called_class());
    }


    /**
     * @param string $content
     * генерация pdf-файла на основе шаблона html
     */
    public function makePdf($content)
    {
        $recipients = implode('_', array_column($this->recipients, 'name'));
        $user_id = Yii::$app->user->id;

        if (!file_exists(__DIR__ . '/../archive/uploads/' . $user_id) && !is_dir(__DIR__.'/../archive/uploads/'.$user_id)) {
            mkdir(__DIR__ . '/../archive/uploads/'.$user_id);
        }

        $filename = str_replace(' ', '_', $this->ref_number.'_'.$recipients.'_'.$this->title.'.pdf');
        $fullPath = __DIR__.'/../archive/uploads/'.$user_id.'/'.$filename;
        $pdf = Yii::$app->pdf;
        $pdf->content = $content;
        $pdf->cssInline ='.memo-block{font-family: "Times New Roman", Times, serif;}';
        $pdf->Output($pdf->content, $fullPath, 'F');
        if (file_exists($fullPath)) {
            $this->pdfPath = $fullPath;
        }
    }

    /**
     * отправка письма адресату служебной записки
     */
    public function sendMail()
    {
        $whom = array_column($this->recipients, 'email');
        Yii::$app->mailer->compose()
            //$params.php gitignored
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($whom)
            ->setSubject($this->title)
            ->setHtmlBody($this->text)
            ->attach($this->pdfPath)
            ->send();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!empty($this->recipientsList)) {
            $listOfRecipients = $this->recipientsList;
            foreach ($listOfRecipients as $key => $id) {
                $setRecipients = new MemoRecipient();
                $setRecipients->memo_id = $this->id;
                $setRecipients->recipient_id = (int)$id;
                $setRecipients->save();
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeSave($insert)
    {
        if (empty($this->ref_number)) {
            $lastRefnumber = (int)(new \yii\db\Query())
                ->from('memo')
                ->orderBy('id DESC')
                ->limit(1)
                ->one()['ref_number'];
            $this->ref_number = $lastRefnumber + 1;
        }


        return parent::beforeSave($insert);
    }

    public function beforeValidate()
    {
        $this->user_id = Yii::$app->user->id;
        return parent::beforeValidate();
    }
}
