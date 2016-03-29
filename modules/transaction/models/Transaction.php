<?php

namespace app\modules\transaction\models;

use Yii;
use amnah\yii2\user\models\User;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property string $transaction_id
 * @property integer $sender_id
 * @property integer $recipient_id
 * @property string $cost
 * @property integer $type_id
 * @property string $protect_code
 * @property integer $status_id
 *
 * @property User $recipient
 * @property User $sender
 * @property Status $status
 * @property Type $type
 */
class Transaction extends \yii\db\ActiveRecord {

    public $PROTECT;
    const PROTECT = 2;
    const PAY = 3;
    const WAIT = 5;
    const WAITPAY = 2;
    const OK = 1;
    
     /**
     * @inheritdoc
     */
    public static function PROTECT()
    {
        return self::PROTECT;;
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipient_id', 'cost', 'type_id'], 'required'],
            [['sender_id', 'recipient_id', 'type_id', 'status_id'], 'integer'],
            //[['cost'], 'passwordStrength'],
            ['cost', 'match', 'pattern' => '/^\d{1,8}\.\d{2}$/'],
            [['transaction_id', 'protect_code'], 'string', 'max' => 255],
            [['transaction_id'], 'unique'],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'sender_id' => 'Отправитель',
            'recipient_id' => 'Получатель',
            'cost' => 'Сумма',
            'type_id' => 'Тип',
            'protect_code' => 'Protect Code',
            'status_id' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            $security = Yii::$app->security;
            if (!$this->transaction_id)
                $this->transaction_id = $security->generateRandomString();
            if (Yii::$app->user->identity->id)
                $this->sender_id = Yii::$app->user->identity->id;

            if ($this->type_id == self::PROTECT)
            {
                $this->protect_code = uniqid();
                $this->status_id = self::WAIT;
            }
            elseif ($this->type_id == self::PAY)
            {
                $this->status_id = self::WAITPAY;
            }
            else
                $this->status_id = self::OK;

            return true;
        }
        return false;
    }

    /* public function beforeValidate()
      {
      $this->transaction_id = $this->status_id = $this->sender_id = 1;
      if ($this->cost)
      $this->cost = str_replace(',', '.', $this->cost);

      parent::beforeValidate();
      } */
}
