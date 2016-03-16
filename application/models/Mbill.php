<?php
/**
 *
 **/
class Mbill extends CI_Model
{
    private $objDB;

    function __construct()
    {
        parent::__construct();
        $this->objDB = $this->load->database("default", true);
    }

    public function objGetBillsOfDay($date_from = '', $date_to = '', $current_user_id = '', $limit = '')
    {
        $interval = date_diff(new \DateTime($date_from), new \DateTime($date_to), true);
        $days = $interval->days;
        $query_sql = "
            select
                u.id,
                u.username,
                u.name,
                coalesce( sum(s_amount.amount), '$0')               self_turnover,
                coalesce(o_sub.volume, '$0')+coalesce(o_sub_0.volume, '$0') as      sub_turnover,
                coalesce(sum(o_self.return_profit), '$0')           normal_return_profit_self2parents,
                coalesce(sum(o_self.p_return_profit), '$0')         normal_return_profit_self2parent,
                coalesce(sum(o_self.gp_return_profit), '$0')        normal_return_profit_self2gparent,
                coalesce(sum(o_self.p_return_invite), '$0')         extra_return_profit_self2parent,
                coalesce(o_sub.gp_return_profit, '$0')+coalesce(o_sub_0.p_return_profit, '$0')                 normal_return_profit_sub2self,
                coalesce(o_sub_0.extra_return_profit, '$0')         extra_return_profit_sub2self,
                --coalesce(jobs.return_profit, '$0')                  delay_return_profit,
                pu.id                                               pid,
                pu.name                                             pname,
                pu.username                                         pusername,
                gpu.id                                              gpid,
                gpu.name                                            gpname,
                gpu.username                                        gpusername,
                '{$date_from}'                                      date_from,
                '{$date_to}'                                        date_to,
                coalesce(date(o_self.finish_time)::char(10),
                    date(o_sub.finish_time)::char(10), d.date) as   date
            FROM (
                select to_char(date_trunc('day', (date('{$date_from}') + offs)), 'YYYY-MM-DD')
                AS date
                FROM generate_series(0, {$days}, 1)
                AS offs
                ) d
            left join
                orders o_self
                on o_self.finish_time between '{$date_from} 00:00:00' and '{$date_to} 23:59:59'
                and o_self.is_pay = true and o_self.is_correct = true
                and date(o_self.finish_time)::char(10) = d.date
                and o_self.user_id = {$current_user_id}
            left join amounts s_amount
                on o_self.id = s_amount.order_id
            --left join jobs jobs
            --    on date(jobs.excute_time)::char(10) = d.date
            --    and jobs.user_id = {$current_user_id}
            --    and jobs.is_success = true
            left join (
                select sum(i.gp_return_profit) gp_return_profit, sum(i.volume) volume, i.pid, finish_time from(
                SELECT Sum(o.gp_return_profit) AS gp_return_profit,
                         Sum(sa.amount)       volume,
                         u.pid,
                         Date(o.finish_time)  finish_time
                  FROM   users u
                         LEFT JOIN orders o
                                ON o.finish_time BETWEEN '{$date_from} 00:00:00'
                                                         AND
                                                         '{$date_to} 23:59:59'
                                   AND o.is_pay = true
                                   AND o.is_correct = true
                                   AND o.user_id = u.id
                         JOIN amounts sa
                         ON sa.order_id = o.id
                  WHERE  --u.pid = {$current_user_id}
                          (select pid from users where id = u.pid) = {$current_user_id}
                  GROUP  BY u.pid,
                            Date(o.finish_time)
                  ORDER  BY u.pid) as i
                  group by pid,finish_time

                ) as o_sub
                on date(o_sub.finish_time)::char(10) = d.date
            left join (
                select sum(i.extra_return_profit) extra_return_profit, i.pid, finish_time, sum(i.volume) volume, sum(i.p_return_profit) p_return_profit from
                    (select
                           sum(o.p_return_invite) as extra_return_profit,
                           sum(o.p_return_profit) as p_return_profit,
                           Sum(sa.amount)       volume,
                           u.pid,
                           date(o.finish_time) finish_time
                       from
                           users u
                           join orders o
                           on o.finish_time between '{$date_from} 00:00:00' and '{$date_to} 23:59:59'
                           and o.is_pay = true and o.is_correct = true
                           and o.user_id = u.id
                         JOIN amounts sa
                         ON sa.order_id = o.id
                           where u.pid = {$current_user_id}
                       group by u.pid, date(o.finish_time)
                       order by u.pid ) as i
                       group by pid,finish_time
                ) as o_sub_0
                on date(o_sub_0.finish_time)::char(10) = d.date
            join users u
                on u.id = {$current_user_id}
            left join users pu
                on u.pid = pu.id
            left join users gpu
                on pu.pid = gpu.id
            where 1 = 1
            group by u.id, u.username, u.name, u.pid, pu.id, pu.name, pu.username,gpu.id, gpu.name, gpu.username,
            o_sub.volume, o_sub.gp_return_profit, o_sub_0.extra_return_profit,
            --jobs.return_profit,
            o_sub_0.volume, o_sub_0.p_return_profit
            , d.date,date(o_sub.finish_time)::char(10),
                date(o_self.finish_time)::char(10)
            order by date
            {$limit};
        ";
        //http://stackoverflow.com/questions/15691127/postgresql-query-to-count-group-by-day-and-display-days-with-no-data
        $data = array();
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();
        return $data;
    }

    public function objGetZentsBillsOfDay($date_from = '', $date_to = '', $limit = '')
    {
        $interval = date_diff(new \DateTime($date_from), new \DateTime($date_to), true);
        $days = $interval->days;
        $query_sql = "
            SELECT
                d.date,
                sum(o.pay_amt) as total_volume,
                sum(o.pay_amt_without_post_fee) as products_volume,
                sum(o.post_fee) as post_fee,
                coalesce(sum(o.return_profit), '$0') as normal_return_profit_volume,
                coalesce(sum(o.p_return_invite), '$0') as invite_return_profit_volume,
                --coalesce(sum(j.return_profit), '$0') as delay_return_profit_volume,
                count(o.id) order_quantity
                FROM (
                select to_char(date_trunc('day', (date('{$date_from}') + offs)), 'YYYY-MM-DD')
                AS date
                FROM generate_series(0, {$days}, 1)
                AS offs
                ) d
            left join orders o
            on (d.date=to_char(date_trunc('day', o.finish_time), 'YYYY-MM-DD'))
            --left join jobs j
            --on (d.date=to_char(date_trunc('day', j.excute_time), 'YYYY-MM-DD'))
            --and j.order_id = o.id
            --and j.is_success = true and j.is_expired = true
            where o.is_pay = true and o.is_correct = true
            group by d.date
            order by d.date
            {$limit}
        ";
        //http://stackoverflow.com/questions/15691127/postgresql-query-to-count-group-by-day-and-display-days-with-no-data
        $data = array();
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();
        return $data;
    }



    public function objGetBillsOfMonth($date_from = '', $date_to = '', $current_user_id = '', $limit = '', $type = '')
    {
        $interval = date_diff(new \DateTime($date_from), new \DateTime($date_to), true);
        $months = $interval->y*12 + $interval->m + 1;
        $query_sql = "
            select
                u.id,
                u.username,
                u.name,
                coalesce( sum(s_amount.amount), '$0')               self_turnover,
                coalesce(o_sub.volume, '$0')+coalesce(o_sub_0.volume, '$0') as      sub_turnover,
                coalesce(sum(o_self.return_profit), '$0')           normal_return_profit_self2parents,
                coalesce(sum(o_self.p_return_profit), '$0')         normal_return_profit_self2parent,
                coalesce(sum(o_self.gp_return_profit), '$0')        normal_return_profit_self2gparent,
                coalesce(sum(o_self.p_return_invite), '$0')         extra_return_profit_self2parent,
                coalesce(o_sub.gp_return_profit, '$0')+coalesce(o_sub_0.p_return_profit, '$0')                 normal_return_profit_sub2self,
                coalesce(o_sub_0.extra_return_profit, '$0')         extra_return_profit_sub2self,
                --coalesce(jobs.return_profit, '$0')                  delay_return_profit,
                pu.id                                               pid,
                pu.name                                             pname,
                pu.username                                         pusername,
                gpu.id                                              gpid,
                gpu.name                                            gpname,
                gpu.username                                        gpusername,
                '{$date_from}'                                      date_from,
                '{$date_to}'                                        date_to,
                coalesce(date(o_self.finish_time)::char(7),
                    date(o_sub.finish_time)::char(7), d.date::char(7)) as date
            FROM (
                select DATE '{$date_from}' + (interval '1' month * generate_series(0,month_count::int)) date
                    from (
                       select extract(year from diff) * 12 + extract(month from diff) as month_count
                       from (
                         select age(TIMESTAMP '{$date_to} 00:00:00', TIMESTAMP '{$date_from} 00:00:00') as diff
                       ) td
                    ) t
                ) d
            left join
                orders o_self
                on o_self.finish_time between '{$date_from} 00:00:00' and '{$date_to} 23:59:59'
                and o_self.is_pay = true and o_self.is_correct = true
                and date(o_self.finish_time)::char(7) = d.date::char(7)
                and o_self.user_id = {$current_user_id}
            left join amounts s_amount
                on o_self.id = s_amount.order_id
            --left join jobs jobs
            --    on date(jobs.excute_time)::char(7) = d.date::char(7)
            --    and jobs.user_id = {$current_user_id}
            --    and jobs.is_success = true
            left join (
                select sum(i.gp_return_profit) gp_return_profit, sum(i.volume) volume, i.pid, finish_time from(
                SELECT Sum(o.gp_return_profit) AS gp_return_profit,
                         Sum(sa.amount)       volume,
                         u.pid,
                         Date_trunc('month', o.finish_time)  finish_time
                  FROM   users u
                         LEFT JOIN orders o
                                ON o.finish_time BETWEEN '{$date_from} 00:00:00'
                                                         AND
                                                         '{$date_to} 23:59:59'
                                   AND o.is_pay = true
                                   AND o.is_correct = true
                                   AND o.user_id = u.id
                         JOIN amounts sa
                         ON sa.order_id = o.id
                  WHERE  --u.pid = {$current_user_id}
                          (select pid from users where id = u.pid) = {$current_user_id}
                  GROUP  BY u.pid,
                            Date_trunc('month', o.finish_time)
                  ORDER  BY u.pid) as i
                  group by pid,finish_time

                ) as o_sub
                on date(o_sub.finish_time)::char(7) = d.date::char(7)
            left join (
                select sum(i.extra_return_profit) extra_return_profit, i.pid, finish_time,
                        sum(i.volume) volume, sum(i.p_return_profit) p_return_profit
                        from
                    (select
                           sum(o.p_return_invite) as extra_return_profit,
                           sum(o.p_return_profit) as p_return_profit,
                           Sum(sa.amount)       volume,
                           u.pid,
                           date_trunc('month', o.finish_time) finish_time
                       from
                           users u
                           left join orders o
                           on o.finish_time between '{$date_from} 00:00:00' and '{$date_to} 23:59:59'
                           and o.is_pay = true and o.is_correct = true
                           and o.user_id = u.id
                       JOIN amounts sa
                       ON sa.order_id = o.id
                           where u.pid = {$current_user_id}
                             --OR (select pid from users where id = u.pid) = {$current_user_id}
                       group by u.pid, date_trunc('month', o.finish_time)
                       order by u.pid ) as i
                       group by pid,finish_time
                ) as o_sub_0
                on date(o_sub_0.finish_time)::char(7) = d.date::char(7)
            left join users u
                on u.id = {$current_user_id}
            left join users pu
                on u.pid = pu.id
            left join users gpu
                on pu.pid = gpu.id
            where 1 = 1
            group by u.id, u.username, u.name, u.pid, pu.id, pu.name, pu.username,gpu.id, gpu.name, gpu.username,
            o_sub.volume,
                o_sub.gp_return_profit, o_sub_0.extra_return_profit,o_sub_0.extra_return_profit,
                --jobs.return_profit,
                o_sub_0.volume, o_sub_0.p_return_profit
            , d.date,date(o_sub.finish_time)::char(7),
                date(o_self.finish_time)::char(7)
                --, jobs.return_profit
            order by date
            {$limit};
        ";
        //http://stackoverflow.com/questions/17492167/group-query-results-by-month-and-year-in-postgresql
        $data = array();
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();

        return $data;
    }

    public function objGetZentsBillsOfMonth($date_from = '', $date_to = '', $limit = '')
    {
        $interval = date_diff(new \DateTime($date_from), new \DateTime($date_to), true);
        $months = $interval->y*12 + $interval->m + 1;

        $query_sql = "
            SELECT  to_char(date_trunc('month', d.date), 'YYYY-MM') date,
                    count(o.id),
                    sum(o.pay_amt) as total_volume,
                    sum(o.pay_amt_without_post_fee) as products_volume,
                    sum(o.post_fee) as post_fee,
                    coalesce(sum(o.return_profit), '$0') as normal_return_profit_volume,
                    coalesce(sum(o.p_return_invite), '$0') as invite_return_profit_volume,
                    --coalesce(sum(j.return_profit), '$0') as delay_return_profit_volume,
                    count(o.id) order_quantity
                    FROM (
                        select DATE '{$date_from}' + (interval '1' month * generate_series(0,month_count::int)) date
                            from (
                               select extract(year from diff) * 12 + extract(month from diff) as month_count
                                   from (
                                     select age(TIMESTAMP '{$date_to} 23:59:59', TIMESTAMP '{$date_from} 00:00:00') as diff
                               ) td
                            ) t
                        ) d
            left join orders o
            ON (to_char(date_trunc('month', d.date), 'YYYY-MM')=to_char(date_trunc('month', o.finish_time), 'YYYY-MM'))
            --left join jobs j
            --on (to_char(date_trunc('month', d.date), 'YYYY-MM')=to_char(date_trunc('month', j.excute_time), 'YYYY-MM'))
            --and j.order_id = o.id
            --and j.is_success = true and j.is_expired = true
            where o.is_pay = true and o.is_correct = true
            GROUP BY d.date
            order by d.date
            {$limit};
        ";
        //http://stackoverflow.com/questions/7450515/postgresql-generate-series-of-months
        $data = array();
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();
        return $data;
    }


    public function objGetZentsBillsOfYear($date_from = '', $date_to = '')
    {
        $interval = date_diff(new \DateTime($date_from), new \DateTime($date_to), true);
        $years = $interval->y + 1;
        $query_sql = "
            SELECT  to_char(date_trunc('year', d.date), 'YYYY') date,
                    count(o.id),
                    sum(o.pay_amt) as total_volume,
                    sum(o.pay_amt_without_post_fee) as products_volume,
                    sum(o.post_fee) as post_fee,
                    coalesce(sum(o.return_profit), '$0') as normal_return_profit_volume,
                    coalesce(sum(o.p_return_invite), '$0') as invite_return_profit_volume,
                    --coalesce(sum(j.return_profit), '$0') as delay_return_profit_volume,
                    count(o.id) order_quantity
                    FROM (
                        select DATE '{$date_from}' + (interval '1' year * generate_series(0,year_count::int)) date
                            from (
                               select extract(year from diff) as year_count
                                   from (
                                     select age(TIMESTAMP '{$date_to} 23:59:59', TIMESTAMP '{$date_from} 00:00:00') as diff
                           ) td
                        ) t
                    ) d
            left join orders o
            ON (to_char(date_trunc('year', d.date), 'YYYY')=to_char(date_trunc('year', o.finish_time), 'YYYY'))
            --left join jobs j
            --on (to_char(date_trunc('year', d.date), 'YYYY')=to_char(date_trunc('year', j.excute_time), 'YYYY'))
            --and j.order_id = o.id
            --and j.is_success = true and j.is_expired = true
            where o.is_pay = true and o.is_correct = true
            GROUP BY d.date
            order by d.date
        ";
        //http://stackoverflow.com/questions/15691127/postgresql-query-to-count-group-by-day-and-display-days-with-no-data
        $data = array();
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();
        return $data;
    }


    public function objGetProductBills($date_from, $date_to)
    {
        $query_sql = "
        select
              '{$date_from}' as date_from,
              '{$date_to}' as date_to,
              list.product_id product_id,
              p.title,
              list.quantity total_quantity,
              coalesce(list.quantity, 0) quantity,
              list.amount amount,
              list.original_amount original_amount
            from
              (
                select
                  sum(op.quantity) quantity,
                  p.id product_id,
                  sum(pa.amount*op.quantity) amount,
                  sum(pa.original_amount*op.quantity) original_amount
                from order_product op, orders o, product_amount pa, products p
                where
                  op.order_id = o.id
                  and pa.order_id = o.id
                  and pa.product_id = op.product_id
                  and p.id = op.product_id
                  and o.finish_time between '{$date_from} 00:00:00' and '{$date_to} 23:59:59'
                group by op.product_id, p.id--, pa.amount
              ) as list
                join products p on p.id = list.product_id
            order by list.product_id
        ";
        $query = $this->objDB->query($query_sql);
        return $query->result();
        //return $data;
    }

    function objGetUserBills($date_from, $date_to, $limit = '')
    {
        $query_sql = "
            select
                u.id,
                u.username,
                u.name,
                coalesce(
                    sum(s_amount.amount),
                        '$0')
                    as turnover,
                coalesce(sum(o_self.p_return_profit), '$0') normal_return_profit_self2parent,
                coalesce(sum(o_self.gp_return_profit), '$0') normal_return_profit_self2gparent,
                coalesce(sum(o_self.p_return_invite), '$0') extra_return_profit_self2parent,
                --coalesce(sum(j.return_profit), '$0') delay_return_profit,
                coalesce(o_sub.p_return_profit,'$0')+coalesce(o_sub_0.gp_return_profit, '$0') normal_return_profit_sub2self,
                coalesce(o_sub.p_return_invite, '$0') extra_return_profit_sub2self,
                pu.id pid,
                pu.name pname,
                pu.username pusername,
                gpu.id gpid,
                gpu.name gpname,
                gpu.username gpusername,
                '{$date_from}' date_from,
                '{$date_to}' date_to
            from
                users u
                left join
                orders o_self
                on u.id = o_self.user_id
                and o_self.finish_time between '{$date_from} 00:00:00' and '{$date_to} 23:59:59'
                and o_self.is_pay = true and o_self.is_correct = true
                join amounts s_amount
                on o_self.id = s_amount.order_id
                --left join jobs j
                --on j.user_id = u.id
                --and j.order_id = o_self.id
                --and j.is_success = true and j.is_expired = true
                --and j.excute_time between '{$date_from} 00:00:00' and '{$date_to} 23:59:59'
                left join (
                select sum(i.p_return_profit) p_return_profit, sum(i.p_return_invite) p_return_invite, sum(i.volume) volume, i.pid from(
                SELECT Sum(o.p_return_profit) AS p_return_profit,
                         Sum(o.p_return_invite) AS p_return_invite,
                         Sum(sa.amount)       volume,
                         u.pid,
                         Date(o.finish_time)  finish_time
                  FROM   users u
                         LEFT JOIN orders o
                                ON o.finish_time BETWEEN '{$date_from} 00:00:00'
                                                         AND
                                                         '{$date_to} 23:59:59'
                                   AND o.is_pay = true
                                   AND o.is_correct = true
                                   AND o.user_id = u.id
                         JOIN amounts sa
                           ON sa.order_id = o.id
                  WHERE  u.pid > 0
                  GROUP  BY u.pid,
                            Date(o.finish_time)
                  ORDER  BY u.pid) as i
                  group by pid
                ) as o_sub
                on o_sub.pid = u.id
                left join (
                select sum(i.gp_return_profit) gp_return_profit, i.pid from
                    (select
                           sum(o.gp_return_profit) as gp_return_profit,
                           u.pid,
                           date(o.finish_time) finish_time
                       from
                           users u
                           left join orders o
                           on o.finish_time between '{$date_from} 00:00:00' and '{$date_to} 23:59:59'
                           and o.is_pay = true and o.is_correct = true
                           and o.user_id = u.id
                           where u.pid > 0
                       group by u.pid, date(o.finish_time)
                       order by u.pid ) as i
                       group by pid
                ) as o_sub_0
                on (select pid from users where id = o_sub_0.pid) = u.id
                left join users pu
                on u.pid = pu.id
                left join users gpu
                on gpu.id = pu.pid
            where 1 = 1
            and u.id > 0
            group by u.id, u.username, u.name, u.pid, pu.id, pu.name, pu.username,o_sub.volume,
                o_sub.p_return_profit,o_sub.p_return_invite, o_sub_0.gp_return_profit,gpu.id,gpu.name, gpu.username
            order by u.id
            {$limit}
            ;
        ";
        $query = $this->objDB->query($query_sql);
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();
        return $data;
    }

    function intGetUserBillsCount($date_from, $date_to)
    {
        $query_sql = "
            select
                count(distinct(o.user_id))
            from
                orders o
            where 1 = 1
            and o.user_id <> 1
            and o.finish_time between '{$date_from} 00:00:00' and '{$date_to} 23:59:59'
            and o.is_pay = true and o.is_correct = true
        ";
        $query = $this->objDB->query($query_sql);


        if($query->num_rows() > 0) {
            $count = $query->row()->count;
        } else {
            return 0;
        }

        $query->free_result();

        return $count;

    }

    function objGetWithdrawLogs($where, $date_from, $date_to, $limit)
    {
        $query_sql = "
            select
                w.id wid,
                w.user_id uid,
                w.volume volume,
                w.balance_before balance_before,
                u.name as name,
                u.username username,
                u.balance,
                u.profit,
                u.turnover,
                w.create_time
            from withdraw_logs w
            left join users u
            on u.id = w.user_id
            where w.create_time > '{$date_from} 00:00:00'
                  and w.create_time < '{$date_to} 23:59:58'
            {$where}
            {$limit}
        ";
        $query = $this->objDB->query($query_sql);
        $data = [];
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $val) {
                $data[] = $val;
            }
        }
        $query->free_result();
        return $data;
    }

}