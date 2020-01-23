<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 19.01.2020
 * Time: 20:55
 */

namespace app\types\history\event;


use app\models\Customer;

class CustomerChangeQualityType extends Type
{
    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->render('customer-change-quality', [
            'model' => $this->history,
            'oldValue' => $this->getOldValue(),
            'newValue' => $this->getNewValue(),
        ]);
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->history->eventText . ($this->getOldValue() ?? 'not set') . ' to ' . ($this->getNewValue() ?? 'not set') ;
    }

    /**
     * @return null|string
     */
    protected function getOldValue(): ?string
    {
        if($dto = $this->history->getAudit('quality')) {
            return $dto->getOld() ? Customer::getQualityTextByQuality($dto->getOld()) : null;
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function getNewValue(): ?string
    {
        if($dto = $this->history->getAudit('quality')) {
            return $dto->getNew() ? Customer::getQualityTextByQuality($dto->getNew()) : null;
        }
        return null;
    }
}