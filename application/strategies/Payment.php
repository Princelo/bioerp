<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/29/17
 * Time: 10:31 PM
 */
class Payment
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function record($user_id, $pay_amt, $type)
    {
        $data = array();
        $data['user_id'] = $user_id;
        $data['amount'] = $pay_amt;
        $data['type'] = $type;
        $data['is_verified'] = true;
        $sql = $this->db->insert_string("payments", $data);
        $this->db->query($sql);
    }
}