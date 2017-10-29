<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 4:16 PM
 */

include_once('application/strategies/IPaybackStrategy.php');
class PurchaseCouponToParent implements IPaybackStrategy
{
    private $db;
    private $order_id;
    public function __construct($db, $order_id)
    {
        $this->db = $db;
        $this->order_id = $order_id;
    }

    function payback($user_id, $purchase_amount)
    {
        $next_month = date('Y-m-1 00:00:00', strtotime("+1 month"));
        $ten_percent = bcmul($purchase_amount, 0.1, 2);
        $five_percent = bcmul($purchase_amount, 0.05, 2);
        $insert_coupon_sql_parent = "
            insert into coupons (user_id, active_time, order_id, volume) 
            values 
            (?,?,?,
            case when
                not exists
                    (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_deleted = false)
                then ".bcmul( bcmul(bcadd($ten_percent, $ten_percent, 2), 2, 2), 0.1, 2)."
                else ".bcmul( bcadd(bcadd($ten_percent, $ten_percent, 2), $five_percent, 2), 0.1, 2)."
            end
            )
            where (select iu.pid from users iu where iu.id = {$user_id}) <> 0
        ";
        $this->db->query($insert_coupon_sql_parent, array($user_id, $next_month, $this->order_id));
    }
}