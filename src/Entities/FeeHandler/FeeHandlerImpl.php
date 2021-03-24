<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Entities\FeeHandler;

use Rauwang\Settlement\Drivers\FeeHandler;
use Rauwang\Settlement\Entities\Amount;
use Rauwang\Settlement\Entities\AmountCalculation;
use Rauwang\Settlement\Entities\AmountValueCalculationImpl\AmountValueAddition;
use Rauwang\Settlement\Entities\AmountValueCalculationImpl\AmountValueSubtraction;

class FeeHandlerImpl implements FeeHandler
{
    private $flowInFee;

    private $flowOutFee;

    public function __construct(Amount $flowOutFee, Amount $flowInFee)
    {
        $this->flowOutFee = $flowOutFee;
        $this->flowInFee = $flowInFee;
    }

    public function calcFlowOutAmount(Amount $amount): Amount
    {
        $amountCalc = new AmountCalculation($amount);
        $amountCalc->join(new AmountValueAddition($this->flowOutFee));
        return $amountCalc->calc();
    }

    public function calcFlowInAmount(Amount $amount): Amount
    {
        $amountCalc = new AmountCalculation($amount);
        $amountCalc->join(new AmountValueSubtraction($this->flowInFee));
        return $amountCalc->calc();
    }
}