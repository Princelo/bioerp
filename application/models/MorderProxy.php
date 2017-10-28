<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 4:52 PM
 */

class MorderProxy extends CI_Model
{
    private $order_model;
    private $db;

    public function __construct()
    {
        $this->db = $this->load->database("default", true);
    }

    public function setMorder($order_model)
    {
        $this->order_model = $order_model;
    }

    function finish_with_pay($order_id, $pay_amt, $user_id, $parent_user_id, $grand_parent_user_id, $pay_amt_without_post_fee, $is_first,
                            $original_amount, $db)
    {
        $db = $this->db;
        $update_sql_first_purchase = "
            update users set first_purchase = '{$pay_amt}'::decimal
             where not exists
                (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_deleted = false)
             and id = {$user_id}
        ";
        /*$insert_sql_job = "
            insert into jobs (user_id, order_id, return_profit, excute_time)
            values ({$user_id}, {$order_id},
            {$ten_percent}+{$ten_percent}+{$ten_percent}+{$ten_percent}
            + case when
                not exists
                    (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_deleted = false)
                then 0
                else {$ten_percent}
                end ,
            '{$next_week}')
        ";*/
//        $update_sql_initiation = "
//            update
//                users
//                set initiation = true
//            where initiation = false
//                  and id = {$user_id}
//        ";
        $finish_log = "
            insert into
                finish_log(order_id, pay_amt, user_id, parent_user_id, pay_amt_without_post_fee, g_parent_user_id, is_first)
                values
                ({$order_id}, ?, ?, ?, ?, ?,
                    case when
                        not exists
                            (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_finished = true and is_deleted = false)
                        then true
                        else false
                    end
                )
            ;";
        $binds_finish_log = array(
            $pay_amt, $user_id, $parent_user_id, $pay_amt_without_post_fee, $grand_parent_user_id
        );
        $db->trans_start();

        $db->query("set constraints all deferred");
        //$this->objDB->query($insert_sql_job);
        $db->query($update_sql_first_purchase);
        $this->order_model->finish_with_pay($order_id, $pay_amt, $user_id, $parent_user_id, $grand_parent_user_id, $pay_amt_without_post_fee, $is_first,
                            $original_amount, $db);
//        $db->query($update_sql_initiation);
        $db->query($finish_log, $binds_finish_log);
        $db->trans_complete();
        $result = $db->trans_status();

        if ($result === true) {
            return true;
        } else {
            return false;
        }
    }
}