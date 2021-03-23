<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Entities;


class Current
{
    /**
     * @var string 币种名称
     */
    private $name;

    /**
     * @var Numerical 基本面
     */
    private $basic;

    /**
     * @var string 单位名称
     */
    private $unit;

    /**
     * @var self 币种对象（用作克隆）
     */
    private static $current;

    private function __construct() { }

    /**
     * @param string    $name
     * @param int|float $basicValue
     * @param string    $unit
     *
     * @return Current
     * @throws \Exception
     */
    public static function instance(string $name, $basicValue, string $unit) : self
    {
        $current = empty(self::$current) ? self::$current = new self() : clone self::$current;
        $current->name = $name;
        $current->basic = new Numerical($basicValue);
        $current->unit = $unit;
        return $current;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Numerical
     */
    public function getBasic(): Numerical
    {
        return $this->basic;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    public function equal(Current $current) : bool
    {
        return $this->name === $current->getName();
    }
}