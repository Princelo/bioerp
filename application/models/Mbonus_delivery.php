<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/26/17
 * Time: 10:34 PM
 */

class Mbonus_delivery extends CI_Model
{
    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database("default", true);
    }

    public function objGetList($where = '', $order = '', $limit = '')
    {
        $query_sql = "";
        $query_sql .= "
            select
                b.id id,
                b.title title,
                b.price price,
                u.username username,
                u.name,
                u.id    user_id,
                b.is_active,
                b.is_delivered,
                b.active_at,
                b.delivered_at
            from
                bonus_delivery b
                left join users u
                on u.id = b.user_id
            where
                1 = 1
                {$where}
            {$order}
            {$limit}
        ";
        $data = array();
        $query = $this->db->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        return $data;
    }

    public function intGetCount($where)
    {
        $query_sql = "";
        $query_sql .= "
            select count(1) from bonus_delivery b
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

    public function update($data, $id)
    {
        $update_sql = $this->db->update_string("bonus_delivery", $data, array("id" => $id));
        $this->db->trans_start();

        $this->db->query($update_sql);

        $sql_jobs = "update bonus_product_jobs set is_finished = true and finished_at = 
                    '{$data['delivered_at']}' where 
                    id = (select job_id from bonus_delivery d where d.id = {$id})";
        $this->db->query($sql_jobs);

        $this->db->trans_complete();

        $result = $this->db->trans_status();

        if ($result === true) {
            return true;
        } else {
            return false;
        }
    }

}