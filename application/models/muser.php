<?php
/**
 *
 **/
class Muser extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function boolVerify( $login_id, $password)
    {
        $query_sql = "";
        $query_sql .= "
            select
                count(1) as count
            from
                users
                where
                username = ?
                and password = ?
                and is_valid = true
        ";
        $binds = array($login_id, $password);
        $data = array();
        $query = $this->db->query($query_sql, $binds);
        if($query->result()[0]->count > 0 ) {
            $this->session->set_userdata('role', 'user');
            return true;
        } else {
            $query_sql = "
            select
                count(1) as count
            from
                admins
                where
                username = ?
                and password = ?
        ";
            $binds = array($login_id, $password);
            $data = array();
            $query = $this->db->query($query_sql, $binds);
            if($query->result()[0]->count > 0 ) {
                $this->session->set_userdata('role', 'admin');
                return true;
            } else {
                return false;
            }
        }
    }

    public function boolUpdatePassword($password, $login_id){
        $update_data = array("password" => $password);
        $update_sql =  $this->db->update_string('users', $update_data, array("id"=>$login_id));
        $result = $this->db->query($update_sql);
        if($result === true)
            return true;
        else
            return false;
    }

    public function addRootUser($main_data)
    {
        $current_user_id = $this->session->userdata('current_user_id');
        $now = now();
        $insert_sql_user = "";
        $insert_sql_user .= "
            insert into users
                (username, password, name, citizen_id, mobile_no, wechat_id, qq_no, is_valid,
                pid, lft, rgt)
            values
                (?, ?, ?, ?, ?, ?, ?, ?, 1, 1, 2);
            update users set initiation = true where id = currval('users_id_seq');
        ";
        $binds = array(
            $main_data['username'], $main_data['password'],
            $main_data['name'],
            $main_data['citizen_id'], $main_data['mobile_no'], $main_data['wechat_id'], $main_data['qq_no'],
            $main_data['is_valid'],
        );

        $this->db->trans_start();

        $this->db->query($insert_sql_user, $binds);

        $this->db->trans_complete();

        $result = $this->db->trans_status();

        if($result === true){
            return true;
        }else{
            return false;
        }
    }

    public function addWithPid($main_data, $pid)
    {
        $current_user_id = $pid;
        $temp = substr(md5(date('YmdHis').rand(0, 32000)), 0, 8);
        $update_left_right_sql_1 = "
            select rgt into temp table variables{$temp} from users where id = {$current_user_id};
            ";
        $update_left_right_sql_2 = "
            update users set lft = case when lft >= (select rgt from variables{$temp}) then lft + 2
                                      else lft end,
                              rgt = rgt + 2
                   where rgt >= (select rgt from variables{$temp})
        ";
        $insert_sql_user = "";
        $insert_sql_user .= "
            insert into users
            (username, password, name, citizen_id, mobile_no, wechat_id, qq_no, pid, is_valid, lft, rgt, dept)
            values
            (?, ?, ?, ?, ?, ?, ?, ?, ?,
            (select rgt from variables{$temp}), (select rgt + 1 from variables{$temp}),
            (select count(1)+1 from users where lft<(select rgt from variables{$temp}) and rgt>(select rgt+1 from variables{$temp})));
        ";
        $binds = array(
            $main_data['username'], $main_data['password'], $main_data['name'],
            $main_data['citizen_id'], $main_data['mobile_no'], $main_data['wechat_id'], $main_data['qq_no'],
            $current_user_id, $main_data['is_valid']
        );

        $this->db->trans_start();

        $this->db->query("set constraints all deferred;");
        $this->db->query($update_left_right_sql_1);
        $this->db->query($update_left_right_sql_2);
        $this->db->query($insert_sql_user, $binds);
        $this->db->query("DROP TABLE IF EXISTS variables{$temp};");

        $this->db->trans_complete();

        $result = $this->db->trans_status();

        if($result === true){
            return true;
        }else{
            return false;
        }
    }

    public function add($main_data)
    {
        $current_user_id = $this->session->userdata('current_user_id');
        $main_data['is_valid'] = false;
        return $this->addWithPid($main_data, $current_user_id);
    }

    public function strGetRoleType($username)
    {
        return 'user';
    }

    public function intGetCurrentUserId($username)
    {
        $query_sql = "";
        $query_sql .= "
            select id from users where username = ?;
        ";
        $binds = array($username);
        $result = $this->db->query($query_sql, $binds);
        if($result->result()[0]->id > 0)
            return $result->result()[0]->id;
        else
            exit('error');
    }

    public function intGetUsersCount($where = '')
    {
        $query_sql = "
            select count(1) from users u
            where 1 = 1
            {$where};
        ";
        $query = $this->db->query($query_sql);
        if($query->num_rows() > 0) {
            $count = $query->row()->count;
        }else{
            return 0;
        }

        $query->free_result();

        return $count;
    }

    public function objGetUserList($where = '', $order = '', $limit = '')
    {
        $query_sql = "";
        $query_sql .= "
            select
                u.name as name,
                u.username as username,
                u.id id,
                u.citizen_id citizen_id,
                u.mobile_no mobile_no,
                u.wechat_id wechat_id,
                u.qq_no qq_no,
                u.turnover turnover,
                u.profit profit,
                u.is_valid is_valid,
                u.pid pid,
                u.balance,
                u.withdraw_volume,
                pu.name pname,
                pu.username pusername,
                ppu.name ppname,
                ppu.username ppusername,
                ppu.id ppid
            from
                users u
                left join users pu
                on pu.id = u.pid
                left join users ppu
                on ppu.id = pu.pid
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
        }else{
            return 0;
        }
        $query->free_result();

        //debug($data);
        return $data;
    }

    public function objGetUserInfo($id = '')
    {
        $query_sql = "";
        $query_sql .= "
            select
                *
            from
                users
            where
                id = ?
        ";
        $binds = array($id);
        $data = array();
        $query = $this->db->query($query_sql, $binds);
        if($query->num_rows() > 0){
            return $query->result()[0];
        }else{
        }
        $query->free_result();

        //debug($data);
        return $data;
    }

    public function update($data, $id)
    {
        $update_sql = $this->db->update_string("users", $data, array("id" => $id));
        $this->db->trans_start();

        $this->db->query($update_sql);

        $this->db->trans_complete();

        $result = $this->db->trans_status();

        if($result === true) {
            return true;
        }else {
            return false;
        }
    }

    public function boolWithdraw($volume, $id)
    {
        $insert_log_sql = "insert into withdraw_logs (user_id, volume, balance_before)
                           values (?, ?, (select balance from users where id = ?));";
        $insert_log_binds = [$id, $volume, $id];
        $update_user_sql = "update users
                        set balance = balance::decimal - ?,
                        withdraw_volume = withdraw_volume::decimal + ?
                        where id = ?;
                        ";
        $update_user_binds = [$volume, $volume, $id];
        $this->db->trans_start();
        $this->db->query($insert_log_sql, $insert_log_binds);
        $this->db->query($update_user_sql, $update_user_binds);
        $this->db->trans_complete();
        $result = $this->db->trans_status();

        if($result === true) {
            return true;
        }else {
            return false;
        }
    }

    public function isEnough($volume, $id)
    {
        $query_sql = "select balance::decimal from users where id = ?";
        $query = $this->db->query($query_sql, [$id]);
        if (floatval($query->result()[0]->balance) >= floatval($volume))
            return true;
        else
            return false;
    }

    public function objGetSubUserList($where = '', $iwhere = '', $order = '', $limit = '', $depth = 1)
    {
        $depth = $depth + 1;
        $query_sql = "
            SELECT u.*
                FROM users AS u,
                        users AS p,
                        users AS sub_parent,
                        (
                                SELECT p.id, (COUNT(iparent.id) - 1) AS idepth
                                FROM users AS p,
                                        users AS iparent
                                WHERE p.lft BETWEEN iparent.lft AND iparent.rgt
                                        {$iwhere}
                                GROUP BY p.id
                                ORDER BY p.lft
                        )AS sub_tree
                WHERE u.lft BETWEEN p.lft AND p.rgt
                        AND u.lft BETWEEN sub_parent.lft AND sub_parent.rgt
                        AND sub_parent.id = sub_tree.id
                        {$where}
                GROUP BY u.id, sub_tree.idepth
                HAVING  (COUNT(p.id) - (sub_tree.idepth + 1)) < {$depth}
                        and
                        (COUNT(p.id) - (sub_tree.idepth + 1)) > 0
                {$order}
                {$limit}
        ";
        $query = $this->db->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }else{
            return 0;
        }
        $query->free_result();

        return $data;
    }

    public function intGetSubUsersCount($where = '', $iwhere = '')
    {
        $query_sql = "
            SELECT count(u.id)
                FROM users AS u,
                        users AS p,
                        users AS sub_parent,
                        (
                                SELECT p.id, (COUNT(iparent.id) - 1) AS idepth
                                FROM users AS p,
                                        users AS iparent
                                WHERE p.lft BETWEEN iparent.lft AND iparent.rgt
                                        {$iwhere}
                                GROUP BY p.id
                                ORDER BY p.lft
                        )AS sub_tree
                WHERE u.lft BETWEEN p.lft AND p.rgt
                        AND u.lft BETWEEN sub_parent.lft AND sub_parent.rgt
                        AND sub_parent.id = sub_tree.id
                        {$where}
                GROUP BY u.id, sub_tree.idepth
                HAVING  (COUNT(p.id) - (sub_tree.idepth + 1)) = 1
                limit 1;
        ";
        //debug($query_sql);exit;
        $query = $this->db->query($query_sql);
        $count = 0;
        if($query->num_rows() > 0) {
            $count = $query->row()->count;
        }

        $query->free_result();

        return $count;
    }

    public function isParent($pid, $id)
    {
        $query_sql = "";
        $query_sql .= "
            select count(p.id)
                from users as p, users as u
                where
                1 = 1
                and u.pid = p.id
                and p.id = ?
                and u.id = ?
        ";
        $binds = array($pid, $id);
        $query = $this->db->query($query_sql, $binds);
        if($query->num_rows() > 0) {
            $count = $query->row()->count;
        }else{
            return false;
        }

        $query->free_result();
        if($count > 0)
            return true;
    }

    public function getSuperiorInfo($id)
    {
        $query_sql = "
            select * from users where id = (select pid from users where id = ?);
        ";
        $binds = array($id);
        $query = $this->db->query($query_sql, $binds);
        if($query->num_rows() > 0){
            $data = $query->result()[0];
        }else{
        }
        $query->free_result();

        //debug($data);
        return $data;
    }

    public function getTree($id = '#', $dept = 3, $current_user_id = 0)
    {
        if ($current_user_id > 0) {
            return $this->getTreeForUser($id, $dept, $current_user_id);
        }
        if ($id == '#') {
            $query_sql = " select id,pid,name,is_valid,dept from users where dept <= ? ";
            $binds = array($dept);
            $query = $this->db->query($query_sql, $binds);
            $data = $query->result();
        } else {
            $data = $this->objGetSubUserList('', ' and p.id = '. $id);
            if ($data == 0)
                return null;
        }

        $return = array();
        $max_dept = 1;
        foreach($data as $k => $v) {
            if ($v->dept > $max_dept) {
                $max_dept = $v->dept;
            }
        }
        foreach($data as $k => $v) {
            $return[$k] = [
                'id' => $v->id,
                'parent'=>$v->pid == 0 ? '#':$v->pid,
                'text' => $v->name.'<span class="id-remark">(id:'.$v->id.')</span>',
                'type' => $v->is_valid?'valid':'invalid',
                'icon' => $v->is_valid?'person32px':'person32px-disable'
            ];
            if ($this->printChildren($data, $v->id) === true) {
                $return[$k]['children'] = true;
            }
            if ($max_dept > 1)
                if ($v->dept < $max_dept)
                    $return[$k]['state'] = ['open'=>true];
        }
        return $return;
    }

    public function getTreeForUser($id, $dept, $current_user_id)
    {
        $current_user = $this->objGetUserInfo($current_user_id);
        if ($id == '#') {
            $query_sql = "
                select
                    id,pid,name,is_valid,dept
                from
                    users
                where id = {$current_user->pid}                                     -- parent
                or id = (select pid from users where id = {$current_user->pid})     -- parent's parent
                or pid = {$current_user->id}                                        -- sons
                or id = {$current_user_id}                                          -- self
                order by id;
            ";
            $query = $this->db->query($query_sql);
            $data = $query->result();
            $return = array();
            foreach($data as $k => $v) {
                $return[$k] = [
                    'id' => $v->id,
                    'parent'=>$k == 0 ? '#':$v->pid,  // the first record is the root
                    'text' => $v->name.'<span class="id-remark">(id:'.$v->id.')</span>',
                    'type' => $v->is_valid?'valid':'invalid',
                    'icon' => $v->is_valid?'person32px':'person32px-disable'
                ];
                $return[$k]['state'] = ['open'=>true];
                if ($v->pid == $current_user_id ) {
                    $return[$k]['children'] = true;
                }
            }
            return $return;
        } else {
            if ($id <= $current_user_id) {
                exit;
            }
            if ($this->isParent($current_user_id, $id)) {
                $data = $this->objGetSubUserList('', ' and p.id = '. $id);
                if ($data == 0)
                    return null;
            } else {
                exit;
            }
            $return = array();
            foreach($data as $k => $v) {
                $return[$k] = [
                    'id' => $v->id,
                    'parent'=> $v->pid,
                    'text' => $v->name.'<span class="id-remark">(id:'.$v->id.')</span>',
                    'type' => $v->is_valid?'valid':'invalid',
                    'icon' => $v->is_valid?'person32px':'person32px-disable'
                ];
                $return[$k]['children'] = false;
            }
            return $return;
        }
    }

    public function printChildren($data, $id)
    {
        $max_dept = 1;
        foreach($data as $k => $v) {
            if ($v->dept > $max_dept) {
                $max_dept = $v->dept;
            }
        }
        foreach($data as $k => $v) {
            if($v->dept == $max_dept && $v->id == $id) {
                return true;
            }
        }
        return null;
    }

    public function isAccessibleSons($current_user_id, $id) {
        $id = intval($id);
        $current_user_id = intval($current_user_id);
        $query_sql = "
            select pid from users where id = {$id}
            union all
            select pid from users where id = (select pid from users where id = {$id})
        ";
        $query = $this->db->query($query_sql);
        $data = $query->result();
        foreach ($data as $k => $v) {
            if ($v->pid == $current_user_id) {
                return true;
            }
        }
        return false;
    }

}
