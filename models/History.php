<?php

namespace app\models;

use app\behaviors\JsonBehavior;
use app\dto\HistoryDto;
use app\types\history\event\CallIncomingType;
use app\types\history\event\CallOutgoingType;
use app\types\history\event\CustomerChangeQualityType;
use app\types\history\event\CustomerChangeTypeType;
use app\types\history\event\FaxIncomingType;
use app\types\history\event\FaxOutgoingType;
use app\types\history\event\SmsIncomingType;
use app\types\history\event\SmsOutgoingType;
use app\types\history\event\TaskCompletedType;
use app\types\history\event\TaskCreatedType;
use app\types\history\event\TaskUpdatedType;
use app\types\history\event\TypeInterface;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%history}}".
 *
 * @property integer $id
 * @property string $ins_ts
 * @property integer $customer_id
 * @property string $event
 * @property string $object
 * @property integer $object_id
 * @property string $message
 * @property array $detail
 * @property integer $user_id
 *
 * @property string $eventText
 *
 * @property Customer $customer
 * @property User $user
 * @property Task $task
 * @property Sms $sms
 * @property Call $call
 * @property Fax $fax
 *
 */
class History extends \yii\db\ActiveRecord
{
    const OBJECT_TASK = 'task';
    const OBJECT_SMS = 'sms';
    const OBJECT_CALL = 'call';
    const OBJECT_FAX = 'fax';

    const EVENT_CREATED_TASK = 'created_task';
    const EVENT_UPDATED_TASK = 'updated_task';
    const EVENT_COMPLETED_TASK = 'completed_task';

    const EVENT_INCOMING_SMS = 'incoming_sms';
    const EVENT_OUTGOING_SMS = 'outgoing_sms';

    const EVENT_INCOMING_CALL = 'incoming_call';
    const EVENT_OUTGOING_CALL = 'outgoing_call';

    const EVENT_INCOMING_FAX = 'incoming_fax';
    const EVENT_OUTGOING_FAX = 'outgoing_fax';

    const EVENT_CUSTOMER_CHANGE_TYPE = 'customer_change_type';
    const EVENT_CUSTOMER_CHANGE_QUALITY = 'customer_change_quality';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%history}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'JsonBehavior' => [
                'class' => JsonBehavior::class,
                'attribute' => 'detail',
                'value' => 'detail',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ins_ts'], 'safe'],
            [['customer_id', 'object_id', 'user_id'], 'integer'],
            [['event'], 'required'],
            [['message', 'detail'], 'string'],
            [['event', 'object'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ins_ts' => Yii::t('app', 'Ins Ts'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'event' => Yii::t('app', 'Event'),
            'object' => Yii::t('app', 'Object'),
            'object_id' => Yii::t('app', 'Object ID'),
            'message' => Yii::t('app', 'Message'),
            'detail' => Yii::t('app', 'Detail'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return null|TypeInterface
     */
    public function createEventType(): ?TypeInterface
    {
        if($eventClass = $this->getEventTypeClass()) {
            /** @var TypeInterface $type */
            $type = Yii::createObject($eventClass, [
                $this,
            ]);
        }
        return $type ?? null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Task::class, ['id' => 'object_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSms(): ActiveQuery
    {
        return $this->hasOne(Sms::class, ['id' => 'object_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCall(): ActiveQuery
    {
        return $this->hasOne(Call::class, ['id' => 'object_id']);

    }

    /**
     * @return ActiveQuery
     */
    public function getFax(): ActiveQuery
    {
        return $this->hasOne(Fax::class, ['id' => 'object_id']);
    }

    /**
     * @return array
     */
    public static function getEventTexts(): array
    {
        return [
            self::EVENT_CREATED_TASK => Yii::t('app', 'Task created'),
            self::EVENT_UPDATED_TASK => Yii::t('app', 'Task updated'),
            self::EVENT_COMPLETED_TASK => Yii::t('app', 'Task completed'),

            self::EVENT_INCOMING_SMS => Yii::t('app', 'Incoming message'),
            self::EVENT_OUTGOING_SMS => Yii::t('app', 'Outgoing message'),

            self::EVENT_OUTGOING_CALL => Yii::t('app', 'Outgoing call'),
            self::EVENT_INCOMING_CALL => Yii::t('app', 'Incoming call'),

            self::EVENT_INCOMING_FAX => Yii::t('app', 'Incoming fax'),
            self::EVENT_OUTGOING_FAX => Yii::t('app', 'Outgoing fax'),

            self::EVENT_CUSTOMER_CHANGE_TYPE => Yii::t('app', 'Type changed'),
            self::EVENT_CUSTOMER_CHANGE_QUALITY => Yii::t('app', 'Property changed'),
        ];
    }

    /**
     * @return array
     */
    public static function getEventTypeClassList(): array
    {
        return [
            self::EVENT_CREATED_TASK => TaskCreatedType::class,
            self::EVENT_UPDATED_TASK => TaskUpdatedType::class,
            self::EVENT_COMPLETED_TASK => TaskCompletedType::class,

            self::EVENT_INCOMING_SMS => SmsIncomingType::class,
            self::EVENT_OUTGOING_SMS => SmsOutgoingType::class,

            self::EVENT_INCOMING_CALL => CallIncomingType::class,
            self::EVENT_OUTGOING_CALL => CallOutgoingType::class,

            self::EVENT_INCOMING_FAX => FaxIncomingType::class,
            self::EVENT_OUTGOING_FAX => FaxOutgoingType::class,

            self::EVENT_CUSTOMER_CHANGE_TYPE => CustomerChangeTypeType::class,
            self::EVENT_CUSTOMER_CHANGE_QUALITY => CustomerChangeQualityType::class,
        ];
    }

    /**
     * @return null|string
     */
    public function getEventTypeClass(): ?string
    {
        return ArrayHelper::getValue(self::getEventTypeClassList(), $this->event);
    }

    /**
     * @param null $event
     * @return null|string
     */
    public function getEventText($event = null): ?string
    {
        $event = $event ?: $this->event;
        return ArrayHelper::getValue(self::getEventTexts(), $event);
    }


    /**
     * @param $attribute
     * @return HistoryDto|null
     */
    public function getAudit($attribute): ?HistoryDto
    {
        if($list = ArrayHelper::getValue($this->detail, 'changedAttributes')) {
            return new HistoryDto(ArrayHelper::getValue($list, $attribute));
        }

        return null;
    }
}
