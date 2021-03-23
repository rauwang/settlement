<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description: 数值类
 */

namespace Rauwang\Settlement\Entities;

class Numerical
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int|float
     */
    private $value;

    public function __construct($numeric)
    {
        if (!is_numeric($numeric)) throw new \Exception('不是数值', 1);
        $this->value = $numeric - 0;
        $this->type = gettype($this->value);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int|float
     */
    public function getValue()
    {
        return $this->value;
    }

    public function equal(Numerical $numeric) : bool
    {
        if ($this->type !== $numeric->getType()) return false;
        return $this->value === $numeric->getValue();
    }
}