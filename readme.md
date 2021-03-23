### 金额计算

```php
$rmb = Current::instance('rmb', 1, '分'); // 实例化币种
$amount = Amount::instance($rmb, 100); // 实例化金额。默认相对基本面值为1，即1分，所以该金额为100分=1元
$amountCalculation = new AmountCalculation($amount); // 实例化金额计算器
$amountCalculation->join(new AmountValueAddition(Amount::instance($rmb, 100.01, 100))); // 添加一个金额计算，且添加的金额的相对基本面值为100，即100分=1元，所以该金额为100.01元
$amount = $amountCalculation->calc();

echo $amount->getValue() . $rmb->getUnit(); // 所以结果为：10101分=101.01元
```

> 因为内部转换成整型进行计算，所以不存在失真的情况。
>
> 币种实例化时，确定了改币种的最小单位，即币种基本面。
>
> 金额实例化时，确定的是相对于币种的基本面，默认是1。

