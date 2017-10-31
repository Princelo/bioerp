<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 8:41 PM
 */

include_once('application/strategies/IPaybackStrategy.php');
class RegisterProfitToParent implements IPaybackStrategy
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function payback($user_id, $pay_amount)
    {
        $ten_percent = bcmul($pay_amount, 0.1, 2);
        $sql = "update users set profit = profit::decimal + {$ten_percent} where id = 
                  (select iu.pid from users iu where iu.id = {$user_id}) and id <> 0
               ";
        $this->db->query($sql);
    }
}