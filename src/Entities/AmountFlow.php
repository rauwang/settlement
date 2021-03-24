<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Entities;

use Rauwang\Settlement\Drivers\FeeHandler;

class AmountFlow
{
    private $amount;

    private $feeHandler;

    public function __construct(Amount $amount, FeeHandler $feeHandler)
    {
        $this->amount = $amount;
        $this->feeHandler = $feeHandler;
    }

    public function flowOut(Account $account) : void
    {
        $amount = $this->feeHandler->calcFlowOutAmount($this->amount);
        $account->flowOut($amount);
    }

    public function flowIn(Account $account) : void
    {
        $amount = $this->amount;
        // todo: 判断交易金额的币种和转入账户的币种是否相同，若不同，则需要执行汇率转换
        if (!$account->getAmount()->getCurrent()->equal($this->amount->getCurrent())) {
            // todo: 汇率转换，将交易金额的币种转换成转入账户的币种
        }
        $amount = $this->feeHandler->calcFlowInAmount($amount);
        $account->flowIn($amount);
    }
}