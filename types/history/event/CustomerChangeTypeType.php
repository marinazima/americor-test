<?php
/**
 * Created by PhpStorm.
 * User: zima
 * Date: 19.01.2020
 * Time: 20:55
 */

namespace app\types\history\event;


use app\models\Customer;

class CustomerChangeTypeType extends Type
{
    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->render('customer-change-type', [
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
        if($dto = $this->history->getAudit('type')) {
            return $dto->getOld() ? Customer::getTypeTextByType($dto->getOld()) : null;
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function getNewValue(): ?string
    {
        if($dto = $this->history->getAudit('type')) {
            return $dto->getNew() ? Customer::getTypeTextByType($dto->getNew()) : null;
        }
        return null;
    }
}