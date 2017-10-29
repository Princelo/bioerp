<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 8:46 PM
 */

include_once('application/strategies/IPaybackStrategy.php');
class RegisterProfitToGrand implements IPaybackStrategy
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function payback($user_id, $pay_amount)
    {
        $five_percent = bcmul($pay_amount, 0.05, 2);
        $sql = "update users set profit = profit::decimal + {$five_percent} where id = 
                  (select iu.pid from users iu, users iiu where iu.id = iiu.pid and iiu.id = {$user_id}) and id <> 0
               ";
        $this->db->query($sql);
    }
}