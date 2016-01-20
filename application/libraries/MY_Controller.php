<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->database();
        $result = $this->db->query("select * from jobs where excute_time < now() and is_expired = false and is_success = false");
        $result = $result->result();
        $update_user_sql = array();
        $update_job_sql = array();
        if (count($result) > 0) {
            foreach($result as $k => $v) {
                $update_user_sql[] = "update users set profit = profit::decimal + '{$v->return_profit}'::decimal,
                balance = balance::decimal + '{$v->return_profit}'
                where id = {$v->user_id};";
                $update_job_sql[] = "update jobs set is_expired = true and is_success = true;";
            }
            $this->db->trans_start();
            $this->db->query("set constraints all deferred");
            foreach($result as $k => $v) {
                $this->db->query($update_user_sql[$k]);
                $this->db->query($update_job_sql[$k]);
            }
            $this->db->trans_complete();
        }
    }
}
