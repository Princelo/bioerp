<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 4:36 PM
 */

include_once('application/strategies/IPaybackStrategy.php');
class PurchaseCouponToGrand implements IPaybackStrategy
{
    private $order_id;
    private $grand_id;
    private $db;

    public function __construct($db, $order_id, $grand_id)
    {
        $this->db = $db;
        $this->order_id = $order_id;
        $this->grand_id = $grand_id;
    }

    function payback($user_id, $purchase_amount)
    {
        $next_month = date('Y-m-1 00:00:00', strtotime("+1 month"));
        $ten_percent = bcmul($purchase_amount, 0.1, 2);
        $insert_coupon_sql_grand_parent_binds = [$this->grand_id, $next_month, $this->order_id, bcmul(bcadd($ten_percent, $ten_percent, 2), 0.1, 2)];
        $insert_coupon_sql_grand_parent = "
            insert into coupons (user_id, active_time, order_id, volume) 
            values 
            (?,?,?,?)
        ";
        if ($this->grand_id > 0) {
            $this->db->query($insert_coupon_sql_grand_parent, $insert_coupon_sql_grand_parent_binds);
        }
    }
}