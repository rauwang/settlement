<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Drivers;


use Rauwang\Settlement\Entities\Amount;

abstract class AmountValueCalculation
{
    /**
     * @var Amount
     */
    protected $amount;

    public function __construct(Amount $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount() : Amount
    {
        return $this->amount;
    }

    /**
     * @param int|float $amountValue
     *
     * @return int|float
     */
    abstract public function calc($amountValue) ;
}