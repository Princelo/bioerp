<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 10/22/17
 * Time: 11:13 PM
 */

include('application/libraries/MY_Controller.php');
class Bonus extends MY_Controller
{
    public $db;
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'user')
            redirect('login');
        $this->load->model('Mbonus_delivery', 'Mbonus_delivery');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->db = $this->load->database('default', true);
    }

    public function listpage_admin($offset = 0)
    {
        if ($this->session->userdata('role') != 'admin') {
            exit('You are not the admin.');
        }
        $get_config = array(
            array(
                'field' =>  'year',
                'label' =>  '年',
                'rules' =>  'trim|xss_clean|numeric'
            ),
            array(
                'field' =>  'month',
                'label' =>  '月',
                'rules' =>  'trim|xss_clean|numeric'
            ),
        );
        $this->form_validation->set_rules($get_config);
        if ($this->input->get('year', true) != '' ||
            $this->input->get('month', true) != ''
        ) {
            $year = $this->input->get('year', true);
            $month = $this->input->get('month', true);
            $data = array();
            $config['base_url'] = base_url()."bonus/listpage_admin/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $where = '';
            $where .= $this->__get_search_str($year, $month);
            $config['total_rows'] = $this->Mbonus_delivery->intGetCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            //$where = '';
            $order = '';
            $data['bonus'] = $this->Mbonus_delivery->objGetList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('bonus/listpage_admin', $data);
        } else {
            $data = array();
            $config['base_url'] = base_url()."bonus/listpage_admin/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $where = '';
            $config['total_rows'] = $this->Mbonus_delivery->intGetCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $order = '';
            $data['bonus'] = $this->Mbonus_delivery->objGetList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('bonus/listpage_admin', $data);
        }
    }

    public function delivery()
    {
        if ($this->session->userdata('role') != 'admin') {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                        array("state" => "error", "message" => "操作失败! 登录时效已过")
                    )
                );
        }
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $now = now();
        $update_info = array("title" => $title, "is_delivered" => true, "delivered_at" => $now);
        if ($this->Mbonus_delivery->update($update_info, $id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                        array("state" => "success", "message" => "操作成功!")
                    )
                );
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                        array("state" => "error", "message" => "操作失败! 请重新操作")
                    )
                );
        }
    }

    private function __get_search_str($year, $month, $actived)
    {
        $active_begin_at = new DateTime();
        $active_begin_at->setDate($year, $month, 1);
        $active_end_at = new DateTime();
        $active_end_at->setDate($year, $month == 12 ? 1 : $month + 1, 1);
        $where = " and ";
        $where .= " b.active_at >= " . $active_begin_at->format("Y-m-d") . ":date ";
        $where .= " and b.active_at < " . $active_end_at->format("Y-m-d") . ":date ";
        if ($actived == 1) {
            $where .= " and is_active = true ";
        } elseif ($actived == 2) {
            $where .= " and is_active = false ";
        }
        return $where;
    }

}