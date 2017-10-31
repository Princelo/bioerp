<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 3:52 PM
 */
include_once('application/strategies/IPaybackStrategy.php');
class PurchaseProfitToParent implements IPaybackStrategy
{
    private $db;
    private $parent_user_id;

    public function __construct($db, $parent_user_id)
    {
        $this->db = $db;
        $this->parent_user_id = $parent_user_id;
    }

    function payback($user_id, $purchase_amount)
    {
        $ten_percent = bcmul($purchase_amount, 0.1, 2);
        $five_percent = bcmul($purchase_amount, 0.05, 2);
        $parent_profit =  bcadd(bcadd($ten_percent, $ten_percent, 2), $five_percent, 2);
        $update_sql_parent_profit = "
            update users set profit = profit::decimal + (
                    {$parent_profit} +
                    case when
                        not exists
                            (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_finished = true and is_deleted = false)
                        then ".bcadd( $ten_percent, $five_percent, 2)."
                        else 0
                    end
            ),
            balance = balance::decimal + (
                    {$parent_profit} +
                    case when
                        not exists
                            (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_finished = true and is_deleted = false)
                        then ".bcadd( $ten_percent, $five_percent, 2)."
                        else 0
                    end
            ),
            real_balance = real_balance::decimal + (
                    ".bcmul($parent_profit, 0.9, 2)." +
                    case when
                        not exists
                            (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_finished = true and is_deleted = false)
                        then ".bcmul(bcadd( $ten_percent, $five_percent, 2), 0.9, 2)."
                        else 0
                    end
            ),
            inactivated_coupon = inactivated_coupon::decimal + (
                    ".bcmul($parent_profit, 0.1, 2)." +
                    case when
                        not exists
                            (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_finished = true and is_deleted = false)
                        then ".bcmul(bcadd( $ten_percent, $five_percent, 2), 0.1, 2)."
                        else 0
                    end
            ),
            coupon_volume = coupon_volume::decimal + (
                    ".bcmul($parent_profit, 0.1, 2)." +
                    case when
                        not exists
                            (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_finished = true and is_deleted = false)
                        then ".bcmul(bcadd( $ten_percent, $five_percent, 2), 0.1, 2)."
                        else 0
                    end
            )
            where id = $this->parent_user_id and id <> 0;
            ";
        if ($this->parent_user_id > 0) {
            $this->db->query($update_sql_parent_profit);
            return $parent_profit;
        } else {
            return 0;
        }
    }
}