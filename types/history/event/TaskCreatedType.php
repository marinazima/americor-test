<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 19.01.2020
 * Time: 20:55
 */

namespace app\types\history\event;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TaskCreatedType extends Type
{
    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->render('task-updated', [
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
        if($task = $this->history->task) {
            return $this->history->eventText . ': ' . $task->title;
        }

        return Html::tag('i', 'Deleted');
    }

    /**
     * @return string
     */
    protected function getFooter(): string
    {
        if($task = $this->history->task) {
            //return ($task->customerCreditor ?? null) ? 'Creditor: ' . $task->customerCreditor->name : '';
            //NOTE is there bug in original code?
            //there is no 'creditorGroup' attribute or relation on Fax model
            //should there be customer instead?

            return ArrayHelper::getValue($task->customer, 'name', '');
        }

        return '';
    }

    /**
     * @return string
     */
    protected function getIconClass(): string
    {
        return 'glyphicon glyphicon-check bg-warning';
    }
}