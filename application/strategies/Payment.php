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
        $sql = "insert into payments(user_id, amount, type)
                select $user_id user_id, $pay_amt amount, '$type' as type
                where not exists (
                  select 1 from payments where user_id = $user_id and type = '$type'
                )";
        $this->db->query($sql);
        return $this->db->affected_rows() > 0;

    }

    public function verifyRegister($user_id)
    {
        $sql = $this->db->update_string("payments", array('is_verified' => true),
            array("user_id" => $user_id, "type" => "register"));
        $this->db->query($sql);
        return $this->db->affected_rows() > 0;
    }
}