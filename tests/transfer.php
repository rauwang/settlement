<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */
include '../vendor/autoload.php';

use \Rauwang\Settlement\Entities\Current;
use \Rauwang\Settlement\Entities\AmountFlow;
use \Rauwang\Settlement\Entities\FeeHandler\FeeHandlerImpl;
use \Rauwang\Settlement\Entities\Amount;
use \Rauwang\Settlement\Entities\Account;

// 转账操作

$rmb = Current::instance('rmb', 1, '分');

$amount = Amount::instance($rmb, 100, 100); // 交易金额

$amountFlow = new AmountFlow(
    $amount,
    new FeeHandlerImpl( // 费用处理
        Amount::instance($rmb, 10), // 转出费用
        Amount::instance($rmb, 10) // 转入费用
    )
);

// 需要注意，在实例化账户时，必须对数据库上锁（排他锁、写锁）
$account1 = new Account(Amount::instance($rmb, 1000, 100));
$account2 = new Account(Amount::instance($rmb, 0));

echo 'account1 余额: ', $account1->getAmount()->getValue() . $rmb->getUnit(), PHP_EOL;
echo 'account2 余额: ', $account2->getAmount()->getValue() . $rmb->getUnit(), PHP_EOL;

$amountFlow->flowOut($account1);
$amountFlow->flowIn($account2);

echo '转账后：', PHP_EOL;
echo 'account1 余额: ', $account1->getAmount()->getValue() . $rmb->getUnit(), PHP_EOL;
echo 'account2 余额: ', $account2->getAmount()->getValue() . $rmb->getUnit(), PHP_EOL;

// 在计算完成后，更新数据库，并解锁