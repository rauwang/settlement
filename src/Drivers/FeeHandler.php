<?php
/**
 * author: rauwang
 * email: hi.rauwang@gmail.com
 * description:
 */

namespace Rauwang\Settlement\Drivers;

use Rauwang\Settlement\Entities\Amount;

interface FeeHandler
{
    public function calcFlowOutAmount(Amount $amount) : Amount ;
    public function calcFlowInAmount(Amount $amount) : Amount ;
}