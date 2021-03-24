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

### 金额流水

```php
// 转账操作

$rmb = Current::instance('rmb', 1, '分');

$amount = Amount::instance($rmb, 100, 100); // 交易金额，这里的金额是100元

$amountFlow = new AmountFlow(
    $amount,
    new FeeHandlerImpl( // 费用处理
        Amount::instance($rmb, 10), // 转出费用，费用0.1元
        Amount::instance($rmb, 10) // 转入费用，费用0.1元
    )
);

// 需要注意，在实例化账户时，必须对数据库上锁（排他锁、写锁）
$account1 = new Account(Amount::instance($rmb, 1000, 100)); // 余额1000元
$account2 = new Account(Amount::instance($rmb, 0)); // 余额0元

echo 'account1 余额: ', $account1->getAmount()->getValue() . $rmb->getUnit(), PHP_EOL; // 余额：1000元
echo 'account2 余额: ', $account2->getAmount()->getValue() . $rmb->getUnit(), PHP_EOL; // 余额：0元

$amountFlow->flowOut($account1);
$amountFlow->flowIn($account2);

echo '转账后：', PHP_EOL;
echo 'account1 余额: ', $account1->getAmount()->getValue() . $rmb->getUnit(), PHP_EOL; // 余额：899.9元
echo 'account2 余额: ', $account2->getAmount()->getValue() . $rmb->getUnit(), PHP_EOL; // 余额：99.9元

// 在计算完成后，更新数据库，并解锁
```