<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/26/17
 * Time: 10:34 PM
 */

class Mpayment extends CI_Model
{
    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database("default", true);
    }

    public function listPayments($where = '', $order = '', $limit = '')
    {
        $query_sql = "";
        $query_sql .= "
            select
                p.id id,
                p.amount amount,
                p.type,
                u.username username,
                u.name,
                u.id    user_id,
                o.id    order_id,
                p.is_verified,
                p.pay_at
            from
                payments p
                left join users u
                on u.id = p.user_id
                left join orders o
                on o.id = p.order_id
            where
                1 = 1
                {$where}
            {$order}
            {$limit}
        ";
        $data = array();
        $query = $this->db->query($query_sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        return $data;
    }

    public function countPayments($where)
    {
        $query_sql = "";
        $query_sql .= "
            select count(1) from payments p
            where
            1 = 1
              {$where}
        ;";
        $query = $this->db->query($query_sql);


        if ($query->num_rows() > 0) {
            $count = $query->row()->count;
        }

        $query->free_result();

        return $count;
    }

}