<?php
/**
 *
 **/
class Morder extends CI_Model
{
    private $objDB;

    function __construct()
    {
        parent::__construct();
        $this->objDB = $this->load->database("default", true);
    }

    public function objGetOrderList($where = '', $order = '', $limit = '')
    {
        $query_sql = "";
        $query_sql .= "
         select
           sum(iq.amount) amount,sum(quantity) quantity,count(opid) diff_quantity,id,username,parent_user_id,post_fee,
                          is_pay, is_correct, pay_time, pay_amt, is_cancelled, is_post, province_id, city_id,
                          address_info,linkman,mobile,remark,finish_time,stock_time,is_pay_online,pay_method,
                          pay_amt_without_post_fee,post_info,uid,iq.username name_ch,iq.account username,
                          return_profit,p_return_invite,profit_potential,coupon_volume,is_finished
           from (select
                   --p.title          title,
                   --p.id             pid,
                   op.id	opid,
                   sum(op.quantity) quantity,
                   count(op.id)  diff_quantity,
                   --string_agg(op.product_id::character(255), ',')     products,
                   o.id             id,
                   u.name           username,
                   u.username       account,
                   u.id             uid,
                   u.pid            parent_user_id,
                   o.post_fee       post_fee,
                   sum(a.amount*a.quantity)         amount,
                   o.is_pay         is_pay,
                   o.is_correct     is_correct,
                   o.pay_time       pay_time,
                   o.pay_amt        pay_amt,
                   o.is_cancelled   is_cancelled,
                   o.is_post        is_post,
                   b.province_id    province_id,
                   b.city_id        city_id,
                   b.address_info   address_info,
                   b.contact        linkman,
                   b.mobile         mobile,
                   b.remark         remark,
                   o.finish_time    finish_time,
                   o.create_time    stock_time,
                   o.is_pay_online  is_pay_online,
                   o.pay_method     pay_method,
                   o.pay_amt_without_post_fee   pay_amt_without_post_fee,
                   o.is_first       is_first,
                   o.post_info      post_info,
                   o.return_profit  return_profit,
                   o.p_return_invite p_return_invite,
                   o.profit_potential profit_potential,
                   o.coupon_volume coupon_volume,
                   o.is_finished is_finished
            from
                orders o
                join order_product op
                on op.order_id = o.id
                and o.is_deleted = false
                join users u
                on o.user_id = u.id
                join address_books b
                on b.id = o.address_book_id
                join product_amount a
                on a.order_id = o.id
                and a.product_id = op.product_id

            where
                1 = 1
                and o.is_deleted != true
                {$where}


            group by o.id, u.name, u.id, a.amount, b.province_id, b.city_id, b.address_info, b.contact, b.mobile, b.remark, op.id
            {$order}
            ) as iq
            where 1 = 1
            group by id,username,parent_user_id,post_fee,
                          is_pay, is_correct, pay_time, pay_amt, is_cancelled, is_post, province_id, city_id,
                          address_info,linkman,mobile,remark,finish_time,stock_time,is_pay_online,pay_method,
                          pay_amt_without_post_fee,post_info,uid,iq.username, return_profit,
                          p_return_invite,iq.account,profit_potential,coupon_volume,is_finished
            order by id desc
            {$limit}
        ";
        $data = array();
        $query = $this->objDB->query($query_sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        return $data;
    }

    public function addToCart($user_id, $product_id, $quantity)
    {
        $insert_sql = "
            insert into cart_product(user_id, product_id, quantity)
            values(?, ?, ?)
            ;
        ";
        $binds = array(
            $user_id, $product_id, $quantity
        );
        $result = $this->objDB->query($insert_sql, $binds);
        if ($result === true) {
            return true;
        } else {
            return false;
        }
    }

    public function getCartInfo($user_id)
    {
        $query_sql = "
            select
                c.product_id pid,
                p.title title,
                c.quantity quantity,
                pr.price as unit_price_original,
                pr.discount_price as unit_price
            from
                cart_product c
                left join products p
                on p.id = c.product_id
                left join price pr
                on pr.product_id = c.product_id
            where
                c.user_id = {$user_id}
        ";
        $data = array();
        $query = $this->objDB->query($query_sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        return $data;
    }

    public function intAddReturnOrderId($main_data, $address_info)
    {
        $post_fee = $main_data['post_fee'];
        $current_user_id = $this->session->userdata('current_user_id');
        $insert_sql_address = "";
        $insert_sql_address .= "
            insert into address_books
            (user_id, contact, province_id, city_id, address_info, remark, mobile)
            values ({$current_user_id},?,?,?,?,?,?);
        ";
        $binds_address = array(
            $address_info['contact'],
            $address_info['province_id'],
            $address_info['city_id'],
            $address_info['address_info'],
            $address_info['remark'],
            $address_info['mobile'],
        );
        $insert_sql_order = "";
        $insert_sql_order .= "

            insert into orders (user_id, address_book_id, is_post, post_fee, is_first, pay_method, is_confirmed)
            select {$current_user_id} user_id,
                    currval('address_books_id_seq') address_book_id,
                    ? is_post,
                    ? post_fee,
                    (   case when
                          not exists
                              ( select id from orders where is_deleted = false and user_id = {$current_user_id} )
                          and u.initiation = false
                        then
                            true
                        else
                            false
                        end
                    ),
                    ?,
                    case when
                        (select active_coupon::decimal from users where id = {$current_user_id}) > 0
                        then false
                        else true
                    end
                from users u where u.id = {$current_user_id}
            ;
        ";
        $binds_order = array(
            $main_data['is_post'], $post_fee, $main_data['pay_method']
        );

        $insert_sql_order_product = "insert into order_product(order_id, product_id, quantity) values";
        foreach($main_data['products'] as $k => $v)
        {
            if(!is_numeric($k)) {
                exit;
            }
            if(!is_numeric($v)) {
                exit;
            }
            $insert_sql_order_product .= "(currval('orders_id_seq'), ".$k . ", " . $v . " ),";
        }
        $insert_sql_order_product = substr($insert_sql_order_product, 0, -1);
        $insert_sql_order_product .= ";";

        $product_id_implode_by_comma = "";

        foreach ($main_data['products'] as $k => $v) {
            $product_id_implode_by_comma .= $k . ",";
        }
        $product_id_implode_by_comma = substr($product_id_implode_by_comma, 0, -1);

        $temp_amounts_str = "";
        $temp_amounts_str_2 = "";
        $temp_original_amounts_str = "";


        foreach ($main_data['products'] as $k => $v) {
            $temp_amounts_str .= "coalesce(pr{$k}.discount_price::decimal, 0) * {$v} +";
            $temp_amounts_str_2 .= " left join price pr{$k} on pr{$k}.product_id = {$k} ";
            $temp_original_amounts_str .= "coalesce(pr{$k}.price::decimal, 0) * {$v} +";
        }
        $temp_amounts_str = substr($temp_amounts_str, 0, -1);
        $temp_original_amounts_str = substr($temp_original_amounts_str, 0, -1);

        $insert_sql_amount = "";
        $insert_sql_amount .= "
            insert into amounts (amount, order_id, original_amount)
            values
            (
                (select {$temp_amounts_str} as amount from products p {$temp_amounts_str_2} group by amount),
                currval('orders_id_seq'),
                (select {$temp_original_amounts_str} as amount from products p {$temp_amounts_str_2} group by amount)
            )
            ;
        ";
        $insert_sql_product_amount = [];
        foreach ($main_data['products'] as $product_id => $quantity) {
            $product_id = intval($product_id);
            $insert_sql_product_amount[] = "
            insert into product_amount (amount, original_amount, order_id, product_id, quantity)
            values
            (
                (select pr.discount_price from products p left join price pr on pr.product_id = p.id where p.id = {$product_id}),
                (select pr.price from products p left join price pr on pr.product_id = p.id where p.id = {$product_id}),
                currval('orders_id_seq'),
                {$product_id},
                {$quantity}
            )
            ;
        ";
        }


        $clean_cart_sql = "delete from cart_product where user_id = {$current_user_id} and product_id in ({$product_id_implode_by_comma});";

        $this->objDB->trans_start();

        $this->objDB->query($insert_sql_address, $binds_address);
        $this->objDB->query($insert_sql_order, $binds_order);
        $this->objDB->query($insert_sql_order_product);
        $this->objDB->query($insert_sql_amount);
        foreach ($insert_sql_product_amount as $v) {
            $this->objDB->query($v);
        }
        $this->objDB->query($clean_cart_sql);
        $inserted_order_id_result = $this->objDB->query(
            "select currval('orders_id_seq') id;"
        );

        $this->objDB->trans_complete();

        $result = $this->objDB->trans_status();

        if ($result === true) {
            if($inserted_order_id_result->num_rows() > 0) {
                $inserted_order_id = $inserted_order_id_result->row()->id;
            }

            $inserted_order_id_result->free_result();
            return $inserted_order_id;
        } else {
            return 0;
        }
    }

    public function intGetOrdersCount($where)
    {
        $query_sql = "";
        $query_sql .= "
            select count(1) from orders o
            where
            1 = 1
            and o.is_deleted != true
              {$where}
        ;";
        $query = $this->objDB->query($query_sql);


        if ($query->num_rows() > 0) {
            $count = $query->row()->count;
        }

        $query->free_result();

        return $count;
    }

    public function objGetOrderInfo($order_id)
    {
        $order_id = $this->objDB->escape($order_id);
        $query_sql = "";
        $query_sql .= "
           select
           sum(iq.amount) amount,sum(quantity) quantity,count(opid) diff_quantity,id,username,parent_user_id,grand_parent_user_id,post_fee,
                          is_pay, is_correct, pay_time, pay_amt, is_cancelled, is_post, province_id, city_id,
                          address_info,linkman,mobile,remark,finish_time,stock_time,is_pay_online,pay_method,
                          pay_amt_without_post_fee,post_info,uid, iq.username name_ch, is_first, return_profit,
                          p_return_invite, iq.account username,profit_potential,has_coupon_volume,cash_volume,coupon_volume,is_finished
            from (select
                   op.id            opid,
                   op.quantity      quantity,
                   o.id             id,
                   u.name           username,
                   u.username       account,
                   u.id             uid,
                   u.pid            parent_user_id,
                   (select pid from users where id = u.pid)            grand_parent_user_id,
                   o.post_fee       post_fee,
                   sum(a.amount*a.quantity)         amount,
                   o.is_pay         is_pay,
                   o.is_correct     is_correct,
                   o.pay_time       pay_time,
                   o.pay_amt        pay_amt,
                   o.is_cancelled   is_cancelled,
                   o.is_post        is_post,
                   b.province_id    province_id,
                   b.city_id        city_id,
                   b.address_info   address_info,
                   b.contact        linkman,
                   b.mobile         mobile,
                   b.remark         remark,
                   o.finish_time    finish_time,
                   o.create_time    stock_time,
                   o.is_pay_online  is_pay_online,
                   o.pay_method     pay_method,
                   o.pay_amt_without_post_fee   pay_amt_without_post_fee,
                   o.is_first       is_first,
                   o.post_info      post_info,
                   o.return_profit  return_profit,
                   o.p_return_invite    p_return_invite,
                   o.profit_potential   profit_potential,
                   o.has_coupon_volume  has_coupon_volume,
                   o.coupon_volume      coupon_volume,
                   o.cash_volume        cash_volume,
                   o.is_finished        is_finished
            from
                orders o
                join order_product op
                on op.order_id = o.id
                and o.is_deleted = false
                and
                o.id = {$order_id}
                join users u
                on o.user_id = u.id
                join address_books b
                on b.id = o.address_book_id
                join product_amount a
                on a.order_id = o.id
                and a.product_id = op.product_id

            where
                1 = 1


            group by o.id, u.name, u.id, a.amount, b.province_id, b.city_id, b.address_info, b.contact, b.mobile, b.remark,op.id) as iq
            where 1 = 1
            group by id,username,parent_user_id,grand_parent_user_id,post_fee,is_pay,is_correct,is_pay_online,post_info
            ,is_first, pay_method,stock_time,finish_time,remark,mobile,linkman,pay_time,pay_amt,pay_amt_without_post_fee,
            is_cancelled,is_post,province_id,city_id,address_info,uid,return_profit,p_return_invite,
            iq.account,profit_potential,has_coupon_volume,coupon_volume,cash_volume,is_finished
        ";
        $data = array();
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        if(isset($data[0]))
            return $data[0];
        else
            return null;
    }

    function getOrderProducts($order_id)
    {
        $query_sql = "
            select
                p.id id,
                p.title title,
                op.quantity quantity,
                pa.amount   amount
            from
                products p
                join order_product op
                on op.product_id = p.id
                join orders o
                on o.id = op.order_id
                join product_amount pa
                on pa.product_id = p.id
            where
                op.order_id = ?
                and pa.order_id = o.id
            group by pa.amount, p.id, op.quantity
        ";
        $binds = array($order_id);
        $query = $this->objDB->query($query_sql, $binds);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        return $data;
    }

    function finish_with_pay($order_id, $pay_amt, $user_id, $parent_user_id, $grand_parent_user_id, $pay_amt_without_post_fee, $is_first,
                            $original_amount, $db)
    {
        $order_id = intval($order_id);
        $order_id = $db->escape($order_id);
        $now = now();
        $ten_percent = bcmul($pay_amt_without_post_fee, 0.1, 2);
        $five_percent = bcmul($pay_amt_without_post_fee, 0.05, 2);
        $parent_profit = 0;
        $grand_parent_profit = 0;
        if ($grand_parent_user_id > 0) {
            $profit_potential_first_order = 0;
            $profit_potential = 15;
        } else {
            if ($parent_user_id > 0) {
                $profit_potential_first_order = 20;
                $profit_potential = 35;
            } else {
                $profit_potential_first_order = 60;
                $profit_potential = 60;
            }
        }

//        $purchase_profit_to_parent = new PurchaseProfitToParent($db, $parent_user_id);
//        $purchase_coupon_to_parent = new PurchaseCouponToParent($db, $order_id);
//        $purchase_profit_to_grand = new PurchaseProfitToGrand($db, $grand_parent_user_id);
//        $purchase_coupon_to_grand = new PurchaseCouPonToGrand($db, $order_id, $grand_parent_user_id);
        include('application/strategies/Turnover.php');
        $turnover = new Turnover($db);

//        $parent_profit = $purchase_profit_to_parent->payback($user_id, $pay_amt_without_post_fee);
//        $purchase_coupon_to_parent->payback($user_id, $pay_amt_without_post_fee);
//        $grand_parent_profit = $purchase_profit_to_grand->payback($user_id, $pay_amt_without_post_fee);
//        $purchase_coupon_to_grand->payback($grand_parent_user_id, $pay_amt_without_post_fee);
        $turnover->payback($user_id, $pay_amt_without_post_fee);

        $update_sql_order = "
            update orders
                set pay_amt = '{$pay_amt}',
                    is_pay = true,
                    is_correct = true,
                    is_finished = true,
                    pay_amt_without_post_fee = '{$pay_amt_without_post_fee}',
                    original_amount = '{$original_amount}',
                    update_time = '{$now}',
                    finish_time = '{$now}',
                    return_profit = ( {$parent_profit} + {$grand_parent_profit} ),
                    p_return_profit = {$parent_profit},
                    gp_return_profit = {$grand_parent_profit},
                    cash_volume = {$pay_amt} - coupon_volume::decimal,
                    profit_potential = 
                        case when
                            not exists
                                (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_deleted = false)
                            then {$profit_potential_first_order}
                            else {$profit_potential}
                        end,
                    p_return_invite =
                     case when
                        not exists
                        (select id from orders where user_id = {$user_id} and is_pay = true and is_correct = true and is_deleted = false)
                        and {$parent_user_id} > 0
                        then {$ten_percent} + {$five_percent}
                        else 0
                        end
            where
                id = {$order_id};
                ";

        $db->query($update_sql_order);


    }

    public function finishPayment($order_id)
    {
        $update_sql = "
            update orders
                set is_pay  = true,
                    pay_amt = ?,
                    pay_amt_without_post_fee = ?,
                    is_correct = true,
                    pay_method = offline
            where
                id = ?
        ";
        $price = $this->getOrderPrice($order_id);
        $query = $this->objDB->query($update_sql, [$price->total_fee, $price->pay_amt_without_post_fee, $order_id]);
        if ($query === true) {
            return true;
        } else {
            return false;
        }
    }

    public function checkIsOwn($user_id, $order_id)
    {
        $query_sql = "select count(1) from orders where id = ? and user_id = ?;";
        $binds = array($order_id, $user_id);
        $query = $this->objDB->query($query_sql, $binds);
        if($query->num_rows() > 0){
            if($query->result()[0]->count > 0) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    public function delete($order_id)
    {
        $this->objDB->from("orders");
        $this->objDB->where("id", $order_id);
        $this->objDB->delete();
        return ($this->objDB->affected_rows() > 0 );
    }

    public function move_to_trash($order_id)
    {
        $data['is_deleted'] = 'true';
        $where = array(
            'id'    =>  $order_id,
        );
        $update_sql = $this->objDB->update_string('orders', $data, $where);
        $query = $this->objDB->query($update_sql);

        if ($query === true) {
            return true;
        } else {
            return false;
        }
    }

    public function is_paid( $order_id )
    {
        $query_sql = "";
        $query_sql .= "
            select
                count(*) as count
            from
                orders
                where
                is_pay = true
                and id = ?
        ";
        $binds = array($order_id);
        $query = $this->objDB->query($query_sql, $binds);
        if($query->num_rows() > 0){
            if($query->result()[0]->count > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function has_coupon_volume( $order_id )
    {
        $query_sql = "";
        $query_sql .= "
            select
                count(*) as count
            from
                orders
                where
                    (has_coupon_volume = true
                or   coupon_volume::decimal > 0)
                and id = ?
        ";
        $binds = array($order_id);
        $query = $this->objDB->query($query_sql, $binds);
        if($query->num_rows() > 0){
            if($query->result()[0]->count > 0) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    public function getOrderPrice($id)
    {
        $query_sql = "
            select sum(pay_amt_without_post_fee) as pay_amt_without_post_fee,
                   post_fee,
                   sum(pay_amt_without_post_fee) + post_fee as total
                   from(
                        select
                            sum(pa.amount::decimal * pa.quantity) pay_amt_without_post_fee,
                            o.post_fee::decimal as post_fee
                        from
                            orders o, product_amount pa
                        where
                            pa.order_id = ?
                        and pa.order_id = o.id
                        and o.is_pay = false
                        group by o.post_fee, pa.amount
                        ) as iq
                where 1 = 1
                group by post_fee
            ;";
        $binds = array($id);
        $query = $this->objDB->query($query_sql, $binds);
        $data = $query->result()[0];
        $query->free_result();

        return $data;
    }

    public function updatePaymentCoupon($order_id, $volume)
    {
        $data['update_time'] = now();
        $data['coupon_volume'] = $volume;
        $data['has_coupon_volume'] = true;
        $data['is_confirmed'] = true;
        $where = [
            'is_pay' => 'false',
            'id'     => $order_id,
            'has_coupon_volume'  => 'false'
            ];
        $user_id = $this->objGetOrderInfo($order_id)->uid;
        $update_sql = $this->objDB->update_string('orders', $data, $where);
        $update_user_sql = "
            update users set active_coupon = active_coupon::decimal - $volume where id = ?
            and (select has_coupon_volume from orders where id = ?) = false
        ";
        $price = $this->getOrderPrice($order_id);
        $update_payment_sql = "
            update orders
                set is_pay  = true,
                    pay_amt = ?,
                    pay_amt_without_post_fee = ?,
                    is_correct = true,
                    pay_method = 'offline'
            where
                id = ?
                and coupon_volume::decimal >= ?
        ";
        $this->objDB->trans_start();
        $this->objDB->query($update_sql);
        $this->objDB->query($update_user_sql, [$user_id, $order_id]);
        if ($volume >= floatval(money($price->total))) {
            $this->objDB->query(
                $update_payment_sql, 
                [$price->total, $price->pay_amt_without_post_fee, $order_id, $price->total]
            );
        }
        $this->objDB->trans_complete();

        $result = $this->objDB->trans_status();

        if ($result === true) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOrderTradeNo($trade_no, $order_id)
    {
        $data['trade_no'] = $trade_no;
        $where = array(
            'is_pay'    =>  'false',
            'pay_method'    =>  'alipay',
            'id'    =>  $order_id,
        );
        $update_sql = $this->objDB->update_string('orders', $data, $where);
        $query = $this->objDB->query($update_sql);

        if ($query === true) {
            return true;
        } else {
            return false;
        }
    }


    public function updatePaymentStatus($trade_no)
    {
        $data = array();
        $data['is_pay'] = 'true';
        $data['pay_time'] = date('Y-m-d H:i:s');
        $where = array(
            'id'  =>  $trade_no,
        );
        $update_sql = $this->objDB->update_string('orders', $data, $where);
        $query = $this->objDB->query($update_sql);

        if ($query === true) {
            return true;
        } else {
            return false;
        }
    }

}
