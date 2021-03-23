<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Entities;

class Amount
{
    /**
     * @var Current 币种
     */
    private $current;

    /**
     * @var Numerical 基本面
     */
    private $basic;

    /**
     * @var Numerical 数量
     */
    private $quantity;

    /**
     * @var int|float|null 金额值
     */
    private $amountValue;

    /**
     * @var Amount 金额对象（用作克隆）
     */
    private static $amount;

    private function __construct() { }

    /**
     * 金额实例
     *
     * @param Current   $current      [币种]
     * @param int       $quantity     [数量]
     * @param int|float $basicValue   [基本面]
     *
     * @return Amount
     * @throws
     */
    public static function instance(Current $current, $quantity, $basicValue = 1) : self
    {
        if ($basicValue <= 0) throw new \Exception('基本面值必须大于0', 1);
        $amount = empty(self::$amount) ? self::$amount = new self() : clone self::$amount;
        $amount->current = $current;
        $amount->basic = new Numerical($basicValue);
        $amount->quantity = new Numerical($quantity);
        $amount->amountValue = null;
        return $amount;
    }

    /**
     * @return Current
     */
    public function getCurrent(): Current
    {
        return $this->current;
    }

    /**
     * @return Numerical
     */
    public function getBasic(): Numerical
    {
        return $this->basic;
    }

    /**
     * @return Numerical
     */
    public function getQuantity(): Numerical
    {
        return $this->quantity;
    }

    /**
     * @return float|int|null
     */
    public function getValue()
    {
        if (isset($this->amountValue)) return $this->amountValue;
        return $this->amountValue = $this->current->getBasic()->getValue() *
                                    $this->basic->getValue() *
                                    $this->quantity->getValue();
    }
}