<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 4:29 PM
 */

class PurchaseProfitToGrand implements IPaybackStrategy
{

    private $db;
    private $grand_id;
    public function __construct($db, $grand_id)
    {
        $this->db = $db;
        $this->grand_id = $grand_id;
    }

    function payback($user_id, $purchase_amount)
    {
        $ten_percent = bcmul($purchase_amount, 0.1, 2);
        $grand_parent_profit = bcadd($ten_percent, $ten_percent, 2);
        $update_sql_grand_parent_profit = "
            update users set profit = profit::decimal +
                    {$grand_parent_profit},
                    balance = balance::decimal +
                    {$grand_parent_profit},
                    real_balance = real_balance::decimal +
                    ".bcmul($grand_parent_profit, 0.9, 2).",
                    coupon_volume = coupon_volume::decimal +
                    ".bcmul($grand_parent_profit, 0.1, 2).",
                    inactivated_coupon = inactivated_coupon::decimal +
                    ".bcmul($grand_parent_profit, 0.1, 2)."
            where id = {$this->grand_id};
            ";
        if ($this->grand_id > 0) {
            $this->db->query($update_sql_grand_parent_profit);
            return $grand_parent_profit;
        }
        return 0;
    }
}