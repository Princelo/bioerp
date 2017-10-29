<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 9:23 PM
 */

include_once('application/strategies/IPaybackStrategy.php');
class RegisterProductBonus implements IPaybackStrategy
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    function payback($user_id, $pay_amt)
    {
        $tomorrow = new DateTime('tomorrow');
        $day = $tomorrow->format('d');
        $next = $tomorrow;
        if ($day <= 28) {
            $values = array();
            $jobs = array();
            for ($i = 1; $i <= 12; $i++) {
                if ($i > 1) {
                    $next = $next->modify("+1 month");
                }
                $append = array(
                    "user_id" => $user_id,
                    "price" => '$1200',
                    "active_at" =>$next->format('Y-m-d 00:00:00'),
                );
            }
            array_push($values, $append);
        } else {
            $values = array();
            $jobs = array();
            $next = new DateTime($next->format('Y-m-28 00:00:00'));
            for ($i = 1; $i <= 12; $i++) {
                if ($i > 1) {
                    $next = $next->modify("+1 month");
                }
                if ($next->format('m') == '1'
                    || $next->format('m') == '3'
                    || $next->format('m') == '5'
                    || $next->format('m') == '7'
                    || $next->format('m') == '8'
                    || $next->format('m') == '10'
                    || $next->format('m') == '12') {
                    $append = array(
                        "user_id" => $user_id,
                        "price" => '$1200',
                        "active_at" =>$next->format("Y-m-{$day} 00:00:00"),
                    );
                    $sql = "insert into bonus_product_jobs (user_id, active_time, amount) values ($user_id,
                        '{$append['active_at']}', '{$append['price']}')";
                    array_push($jobs, $sql);
                }
                if ($next->format('m') == '4'
                    || $next->format('m') == '6'
                    || $next->format('m') == '9'
                    || $next->format('m') == '11') {
                    if ($day == 31) {
                        $append = array(
                            "user_id" => $user_id,
                            "price" => '$1200',
                            "active_at" =>$next->format("Y-m-30 00:00:00"),
                        );
                    } else {
                        $append = array(
                            "user_id" => $user_id,
                            "price" => '$1200',
                            "active_at" =>$next->format("Y-m-{$day} 00:00:00"),
                        );
                    }
                }
                if ($next->format('m') == '2') {
                    if ($day >= 29) {
                        if (date('L', strtotime("{$next->format('Y')}-01-01"))) {
                            $append = array(
                                "user_id" => $user_id,
                                "price" => '$1200',
                                "active_at" =>$next->format("Y-m-29 00:00:00"),
                            );
                        } else {
                            $append = array(
                                "user_id" => $user_id,
                                "price" => '$1200',
                                "active_at" =>$next->format("Y-m-28 00:00:00"),
                            );
                        }
                    } else {
                        $append = array(
                            "user_id" => $user_id,
                            "price" => '$1200',
                            "active_at" =>$next->format("Y-m-{$day} 00:00:00"),
                        );
                    }
                }
                $sql = "insert into bonus_product_jobs (user_id, active_time, amount) values ($user_id,
                        '{$append['active_at']}', '{$append['price']}')";
                array_push($jobs, $sql);
                array_push($values, $append);
            }
        }
        $i = -1;
        foreach ($jobs as $job) {
            $i ++;
            $this->db->query($job);
            $value = $values[$i];
            $sql = "insert into bonus_delivery (user_id, price, active_at, job_id) values ({$value['user_id']},
                    '{$value['price']}', '{$value['active_at']}', currval('bonus_product_jobs_id_seq'))";
            $this->db->query($sql);
        }
//        $sql = $this->db->insert_string("bonus_delivery", $values);
//        $this->db->query($sql);
    }
}