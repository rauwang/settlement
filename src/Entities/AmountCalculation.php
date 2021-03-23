<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description: 金额计算类，用于相同币种间的计算
 */

namespace Rauwang\Settlement\Entities;

use Rauwang\Settlement\Drivers\AmountValueCalculation;
use Rauwang\Settlement\Entities\Transition\AmountBasic;

class AmountCalculation
{
    private $amount;

    private $amountValueCalculationImplList = [];

    public function __construct(Amount $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param AmountValueCalculation $amountValueCalculationImpl
     *
     * @return AmountCalculation
     * @throws
     */
    public function join(AmountValueCalculation $amountValueCalculationImpl) : self
    {
        if (!$this->amount->getCurrent()->equal($amountValueCalculationImpl->getAmount()->getCurrent())) {
            throw new \Exception('只能计算相同币种的金额', 1);
        }
        $this->amountValueCalculationImplList[] = $amountValueCalculationImpl;
        return $this;
    }

    /**
     * @return Amount
     * @throws \Exception
     */
    public function calc() : Amount
    {
        $amount = $this->amount;
        foreach ($this->amountValueCalculationImplList as $amountValueCalcImpl) {
            // 调整基本面
            $amountBasic = AmountBasic::transition(
                $amountValueCalcImpl->calc($amount->getValue()),
                $this->amount->getCurrent()->getBasic()->getValue()
            );
            // 金额实例
            $amount = Amount::instance(
                $this->amount->getCurrent(),
                $amountBasic->getAmountQuantity(),
                $amountBasic->getBasicValue()
            );
        } return $amount;
    }
}