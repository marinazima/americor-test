<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 19.01.2020
 * Time: 20:55
 */

namespace app\types\history\event;


use app\models\Sms;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SmsIncomingType extends Type
{
    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->render('sms-incoming', [
            'model' => $this->history,
            'body' => $this->getBody(),
            'footer' => $this->getFooter(),
            'iconClass' => $this->getIconClass(),
        ]);
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return ArrayHelper::getValue($this->history->sms, 'message', 'Sms is missed');
    }

    /**
     * @return string
     */
    protected function getFooter(): string
    {
        if($sms = $this->history->sms) {
            return $sms->direction == Sms::DIRECTION_OUTGOING ?
                \Yii::t('app', 'Incoming message from {number}', [
                    'number' => $sms->phone_from ?: ''
                ])
                : '';
        }

        return Html::tag('i', 'Deleted');
    }

    /**
     * @return string
     */
    protected function getIconClass(): string
    {
        return 'glyphicon glyphicon-comment bg-primary';
    }
}