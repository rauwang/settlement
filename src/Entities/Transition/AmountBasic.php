<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Entities\Transition;

class AmountBasic
{
    private static $amountBasic;

    private $amountQuantity;

    private $basicValue;

    private function __construct() { }

    public static function transition($amountValue, $basicValue) : self
    {
        $amountBasic = empty(self::$amountBasic) ? self::$amountBasic = new self() : clone self::$amountBasic;

        $amountQuantity = $amountValue / $basicValue;
        $basicValue = 1; // 因将金额值转换成金额数量，基本面重置为1
        $amountQuantityStr = strval($amountQuantity);
        if (strstr($amountQuantityStr, '.')) {
            // 若数量是小数，则调整基本面，使数量变成整数
            $decimal = explode('.', $amountQuantityStr, 2)[1];
            $power = intval(strlen($decimal)); // 乘方
            $per = pow(10, $power); // 倍数
            $amountQuantity *= $per;
            $basicValue /= $per;
        }
        $amountBasic->amountQuantity = intval($amountQuantity);
        $amountBasic->basicValue = $basicValue;
        return $amountBasic;
    }

    /**
     * @return mixed
     */
    public function getAmountQuantity() : int
    {
        return $this->amountQuantity;
    }

    /**
     * @return int|float
     */
    public function getBasicValue()
    {
        return $this->basicValue;
    }
}