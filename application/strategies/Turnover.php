<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 5:21 PM
 */

include_once('application/strategies/IPaybackStrategy.php');
class Turnover implements IPaybackStrategy
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    function payback($user_id, $purchase_amount)
    {
        $update_sql_turnover = "
            update
                users
                    set turnover =
                        turnover::decimal + {$purchase_amount}
                where id = {$user_id};";


        $this->db->query($update_sql_turnover);
    }
}