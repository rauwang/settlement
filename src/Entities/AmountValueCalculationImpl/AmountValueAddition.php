<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Entities\AmountValueCalculationImpl;

use Rauwang\Settlement\Drivers\AmountValueCalculation;

class AmountValueAddition extends AmountValueCalculation
{
    public function calc($amountValue)
    {
        $amountValue += $this->amount->getValue();
        return $amountValue;
    }
}