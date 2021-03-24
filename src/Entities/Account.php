<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Entities;

use Rauwang\Settlement\Entities\AmountValueCalculationImpl\AmountValueAddition;
use Rauwang\Settlement\Entities\AmountValueCalculationImpl\AmountValueSubtraction;

class Account
{
    /**
     * @var Amount 余额
     */
    private $amount;

    public function __construct(Amount $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return Amount
     */
    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function flowIn(Amount $amount) : void
    {
        $amountCalc = new AmountCalculation($this->amount);
        $amountCalc->join(new AmountValueAddition($amount));
        $this->amount = $amountCalc->calc();
    }

    public function flowOut(Amount $amount) : void
    {
        $amountCalc = new AmountCalculation($this->amount);
        $amountCalc->join(new AmountValueSubtraction($amount));
        $this->amount = $amountCalc->calc();
    }
}