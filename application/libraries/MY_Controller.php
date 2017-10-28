<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->database();
//        $result = $this->db->query("select * from jobs where excute_time < now() and is_expired = false and is_success = false");
//        $result = $result->result();
//        $update_user_sql = array();
//        $update_job_sql = array();
//        if (count($result) > 0) {
//            foreach($result as $k => $v) {
//                $return_profit = money($v->return_profit);
//                $update_user_sql[] = "update users set profit = profit::decimal + {$return_profit},
//                balance = balance::decimal + {$return_profit}
//                where id = {$v->user_id};";
//                $update_job_sql[] = "update jobs set is_expired = true, is_success = true where id = {$v->id};";
//            }
//            $this->db->trans_start();
//            $this->db->query("set constraints all deferred");
//            foreach($result as $k => $v) {
//                $this->db->query($update_user_sql[$k]);
//                $this->db->query($update_job_sql[$k]);
//            }
//            $this->db->trans_complete();
//        }
        if (!$this->session->userdata('initiation')) {
            if ($this->session->userdata('role') == 'user') {
                $result = $this->db->query("select initiation from users where id = ?", [$this->session->userdata('current_user_id')]);
                $result = $result->result();
                if ($result[0]->initiation)
                    $this->session->set_userdata('initiation', true);
            }
        }

        $now = now();
        $check_sql = "select count(*) from coupons where is_active = false and active_time < '{$now}'";
        $check_result = $this->db->query($check_sql)->result();
        $this->db->trans_start();
        if (intval($check_result[0]->count) > 0) {
            $update_sql_users = "
                update users u
                set active_coupon = 
                        coalesce(active_coupon, '$0')
                            + 
                        coalesce(
                            (select sum(c.volume) 
                                from coupons c 
                            where c.is_active = false 
                              and c.active_time < '{$now}' 
                              and c.user_id = u.id),
                        '$0'),
                    inactivated_coupon =
                        coalesce(inactivated_coupon, '$0')
                            - 
                        coalesce(
                            (select sum(c.volume) 
                                from coupons c 
                            where c.is_active = false 
                              and c.active_time < '{$now}'
                              and c.user_id = u.id),
                        '$0')
                ";
            $update_sql_coupons = "
                update coupons set is_active = true where active_time < '{$now}';
            ";
            $this->db->query($update_sql_users);
            $this->db->query($update_sql_coupons);
        }

        $check_bonus_sql = "select count(*) from bonus_product_jobs where is_active = false and active_time < '{$now}'";
        $check_result = $this->db->query($check_bonus_sql)->result();
        if (intval($check_result[0]->count) > 0) {
                $update_sql_bonus_users = "
                update users u
                set bonus_product = 
                        coalesce(bonus_product, '$0')
                            + 
                        coalesce(
                            (select sum(c.volume) 
                                from coupons c 
                            where c.is_active = false 
                              and c.is_finished = false
                              and c.active_time < '{$now}' 
                              and c.user_id = u.id),
                        '$0')
                ";
                $update_sql_bonus = "
                update bonus_product_jobs set is_active = true where active_time < '{$now}';
            ";
            $this->db->query($update_sql_bonus_users);
            $this->db->query($update_sql_bonus);
        }

        $check_bonus_sql = "select count(*) from bonus_delivery where is_active = false and active_at < '{$now}'";
        $check_result = $this->db->query($check_bonus_sql)->result();
        if (intval($check_result[0]->count) > 0) {
            $update_sql_bonus = "
                update bonus_delivery set is_active = true where active_at < '{$now}';
            ";
            $this->db->query($update_sql_bonus_users);
            $this->db->query($update_sql_bonus);
        }
        $this->db->trans_complete();
    }
}
