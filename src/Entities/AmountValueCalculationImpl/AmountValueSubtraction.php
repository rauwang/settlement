<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Entities\AmountValueCalculationImpl;

use Rauwang\Settlement\Drivers\AmountValueCalculation;

class AmountValueSubtraction extends AmountValueCalculation
{
    public function calc($amountValue)
    {
        $amountValue -= $this->amount->getValue();
        if (0 > $amountValue) throw new \Exception('金额不足', 1);
        return $amountValue;
    }
}