<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 19.01.2020
 * Time: 20:55
 */

namespace app\types\history\event;


use yii\helpers\Html;

class FaxOutgoingType extends Type
{
    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->render('fax-incoming', [
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
        if($fax = $this->history->fax) {
            //NOTE: there is no 'document' attribute or relation in Fax model
            $docUrl = ($fax->document ?? null) ? ' - ' . Html::a(\Yii::t('app', 'view document'), $fax->document->getViewUrl(), [
                    'target' => '_blank',
                    'data-pjax' => 0
                ]) : '';
            return $this->history->eventText . $docUrl;
        }

        return Html::tag('i', 'Deleted');
    }

    /**
     * @return string
     */
    protected function getFooter(): string
    {
        if($fax = $this->history->fax) {
            \Yii::t('app', '{type} was sent {group}', [
                'type' => $fax ? $fax->getTypeText() : 'Fax',
                //'group' => ($fax->creditorGroup ?? null) ? 'to ' . Html::a($fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
                //NOTE is there a bug in original code?
                //there is no 'creditorGroup' attribute or relation on Fax model
                //should there be customer instead?
                'group' => ($fax->customer ?? null) ? 'to ' . Html::a($fax->customer->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
            ]);
        }

        return '';
    }


    /**
     * @return string
     */
    protected function getIconClass(): string
    {
        return 'glyphicon glyphicon-open-file bg-success';
    }
}