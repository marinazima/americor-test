<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 19.01.2020
 * Time: 20:55
 */

namespace app\types\history\event;


use app\models\Call;
use yii\helpers\Html;

class CallOutgoingType extends Type
{
    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->render('call-incoming', [
            'model' => $this->history,
            'body' => $this->getBody(),
            'footer' => $this->getFooter(),
            'content' => $this->getContent(),
            'iconClass' => $this->getIconClass(),
        ]);
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        if($call = $this->history->call) {
            $disposition = $call->getTotalDisposition(false) ?
                Html::tag('span', $call->getTotalDisposition(false), ['class' => 'text-grey']) :
                '';

            return $call->totalStatusText . $disposition;
        }

        return Html::tag('i', 'Deleted');
    }

    /**
     * @return string
     */
    protected function getFooter(): string
    {
        if($call = $this->history->call) {
            //return ($call->applicant ?? null) ? 'Called ' . Html::tag('span', $call->applicant->name) : '';

            //NOTE is there bug in original code?
            //there is no 'creditorGroup' attribute or relation on Fax model
            //should there be customer instead?
            //
            return $call->customer ? 'Called ' . Html::tag('span', $call->customer->name) : '';
        }

        return '';
    }

    /**
     * @return null|string
     */
    protected function getContent(): ?string
    {
        if($call = $this->history->call) {
            return $call->comment;
        }

        return null;
    }

    /**
     * @return string
     */
    protected function getIconClass(): string
    {
        return $this->isAnswered() ? 'glyphicon glyphicon-earphone bg-success' : 'glyphicon glyphicon-earphone bg-danger';
    }

    /**
     * @return bool
     */
    protected function isAnswered(): bool
    {
        return $this->history->call && $this->history->call->status == Call::STATUS_ANSWERED;
    }
}