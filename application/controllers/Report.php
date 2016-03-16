<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include('application/libraries/MY_Controller.php');
class Report extends MY_Controller {

    public $db;
    public function __construct(){
        parent::__construct();
        if($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'user')
            redirect('login');
        $this->load->model('Mproduct', 'Mproduct');
        $this->load->model('Mbill', 'Mbill');
        $this->load->model('Muser', 'Muser');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->db = $this->load->database('default', true);
    }

    public function index()
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $this->load->view('templates/header_user');
        $this->load->view('report/index');
    }

    public function index_admin($offset = 0)
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $get_config = array(
            array(
                'field' =>  'search',
                'label' =>  '用戶名',
                'rules' =>  'trim|xss_clean'
            ),
        );
        $this->form_validation->set_rules($get_config);
        if($this->input->get('search', true) != '' ) {
            $search = $this->input->get('search', true);
            $search = $this->db->escape_like_str($search);
            $data = array();
            $config['base_url'] = base_url()."report/index_admin/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $where = '';
            //$where .= ' and p.is_valid = true ';
            $where .= $this->__get_search_str($search);
            $config['total_rows'] = $this->Muser->intGetUsersCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            //$where = '';
            $order = '';
            $data['users'] = $this->Muser->objGetUserList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('report/listuser_admin', $data);
        }else{
            $data = array();
            $config['base_url'] = base_url()."report/index_admin/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $where = '';
            $config['total_rows'] = $this->Muser->intGetUsersCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            //$where = ' and p.is_valid = true ';
            $order = '';
            $data['users'] = $this->Muser->objGetUserList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('report/listuser_admin', $data);
        }
        //$this->load->view('templates/header');
        //$this->load->view('report/index_admin');
    }

    public function index_user()
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $user_id = $this->input->get('user');
        if(!is_numeric($user_id))
            exit('ERROR');
        $this->load->view('templates/header');
        $this->load->view('report/index_user');
    }

    public function index_zents()
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $this->load->view('templates/header');
        $this->load->view('report/index_zents');
    }

    public function index_sub($offset = 0)
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $current_user_id = $this->session->userdata('current_user_id');
        $get_config = array(
            array(
                'field' =>  'search',
                'label' =>  '用戶名',
                'rules' =>  'trim|xss_clean'
            ),
        );
        $this->form_validation->set_rules($get_config);
        if($this->input->get('search', true) != '') {
            $search = $this->input->get('search', true);
            $search = $this->db->escape_like_str($search);
            $data = array();
            $config['base_url'] = base_url()."report/index_sub/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $iwhere = " and p.id = {$current_user_id} ";
            //$where .= ' and p.is_valid = true ';
            $where = "";
            $where .= $this->__get_search_str($search);
            $config['total_rows'] = $this->Muser->intGetSubUsersCount($where, $iwhere);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            //$where = '';
            $order = '';
            $data['users'] = $this->Muser->objGetSubUserList($where, $iwhere, $order, $limit, 2);
            $this->load->view('templates/header_user', $data);
            $this->load->view('report/index_sub', $data);
        }else{
            $data = array();
            $config['base_url'] = base_url()."report/index_sub/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $iwhere = " and p.id = {$current_user_id} ";
            $where = "";
            $config['total_rows'] = $this->Muser->intGetSubUsersCount($where, $iwhere);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            //$where = ' and p.is_valid = true ';
            $order = '';
            $data['users'] = $this->Muser->objGetSubUserList($where, $iwhere, $order, $limit, 2);
            $this->load->view('templates/header_user', $data);
            $this->load->view('report/index_sub', $data);
        }
    }

    public function query_sub($id)
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $pid = $this->session->userdata('current_user_id');
        if(!is_numeric($id))
            exit('ERROR');
        if(!$this->Muser->isAccessibleSons($pid, $id))
            exit('You are not the Superior of this user');
        $data['id'] = $id;
        $this->load->view('templates/header_user');
        $this->load->view('report/query_sub', $data);
    }

    public function listpage_sub($offset = 0)
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $user_id = $this->input->get('user');
        if(!is_numeric($user_id))
            exit('ERROR');
        $pid = $this->session->userdata('current_user_id');
        if(!$this->Muser->isAccessibleSons($pid, $user_id))
            exit('You are not the Superior of this user');
        $get_config = array(
            array(
                'field' => 'is_filter',
                'label' => 'Is Filter',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' =>  'report_type',
                'label' =>  'Report Type',
                'rules' =>  'trim|xss_clean|required'
            ),
        );
        if ($this->input->get('date-type', true) == 'day') {
            array_merge($get_config,
                array(
                    'field' =>  'date_from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'date_to',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        } elseif ($this->input->get('date-type', true) == 'month') {
            array_merge($get_config,
                array(
                    'field' =>  'birthyearmonth-date-from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthmonthmonth-date-from',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthyearmonth-date-to',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthmonthmonth-date-to',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        } elseif ($this->input->get('date-type', true) == 'year') {
            array_merge($get_config,
                array(
                    'field' =>  'birthyearyear-date-from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthyearyear-date-to',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        }
        $this->form_validation->set_rules($get_config);
        $report_type = $this->input->get('report_type', true);
        if ($this->input->get('date-type', true) == 'day') {
            $date_from = $this->input->get('date_from', true);
            $date_to = $this->input->get('date_to', true);
        } elseif ($this->input->get('date-type', true) == 'month') {
            $date_from = $this->input->get('birthyearmonth-date-from', true) . '-' .$this->input->get('birthmonthmonth-date-from', true).'-01';
            $date_to = date( 'Y-m-t', strtotime($this->input->get('birthyearmonth-date-to', true) . '-' .$this->input->get('birthmonthmonth-date-to', true).'-01'));
        } elseif ($this->input->get('date-type', true) == 'year') {
            $date_from = $this->input->get('birthyearyear-date-from', true).'-01-01';
            $date_to = $this->input->get('birthyearyear-date-to', true).'-12-31';
        }
        $interval = date_diff(new \DateTime($date_from), new \DateTime($date_to), true);
        $date_from = strtotime($date_from);
        $date_to = strtotime($date_to);
        if($this->input->get('report_type', true) != '' &&
            $date_from != '' && $date_to != ''
        )
        {
            $date_from = date('Y-m-d', $date_from);
            $date_to = date('Y-m-d', $date_to);
            //$search = $this->db->escape_like_str($search);
            $data = array();
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['base_url'] = base_url()."report/listpage_sub/";
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            //$where = '';
            //$where .= ' and p.is_valid = true ';
            //$where .= $this->__get_search_str($search, $price_low, $price_high);
            //$config['total_rows'] = $this->Mproduct->intGetProductsCount($where);

            $config['per_page'] = 30;
            switch($report_type)
            {
                case "day":
                    $config['total_rows'] = $interval->days + 1;
                    //if($this->input->get('is_filter') == 'on')
                    //$config['total_rows'] = $this->Mbill->objGetBillsOfDay($date_from, $date_to, $limit);
                    break;
                case "month":
                    $config['total_rows'] = $interval->y*12 + $interval->m + 1;
                    //if($this->input->get('is_filter') == 'on')
                    //$config['total_rows'] = $this->Mbill->objGetBillsOfDay($date_from, $date_to, $limit);
                    break;
                case "year":
                    $config['total_rows'] = $interval->y + 1;;
                    break;
                default:
                    $report_type = "";
                    break;
            }
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            $where = '';
            $order = '';
            switch($report_type)
            {
                case 'day':
                    if($this->input->get('is_filter') == 'on') {
                        $data['bills'] = $this->Mbill->objGetBillsOfDayWithFilter($date_from, $date_to, $user_id, $limit);
                        $config['total_rows'] = $this->Mbill->objGetBillsOfDayWithFilterCount($date_from, $date_to, $user_id);
                        $this->pagination->initialize($config);
                        $data['page'] = $this->pagination->create_links();
                    }else
                        $data['bills'] = $this->Mbill->objGetBillsOfDay($date_from, $date_to, $user_id, $limit);
                    $this->load->view('templates/header_user', $data);
                    $this->load->view('report/listpage_day', $data);
                    break;
                case 'month':
                    if($this->input->get('is_filter') == 'on') {
                        $data['bills'] = $this->Mbill->objGetBillsOfMonthWithFilter($date_from, $date_to, $user_id, $limit);
                        $config['total_rows'] = $this->Mbill->objGetBillsOfMonthWithFilterCount($date_from, $date_to, $user_id);
                        $this->pagination->initialize($config);
                        $data['page'] = $this->pagination->create_links();
                    } else
                        $data['bills'] = $this->Mbill->objGetBillsOfMonth($date_from, $date_to, $user_id, $limit);
                    $this->load->view('templates/header_user', $data);
                    $this->load->view('report/listpage_month', $data);
                    break;
                case 'year':
                    if($this->input->get('is_filter') == 'on')
                        $data['bills'] = $this->Mbill->objGetBillsOfYearWithFilter($date_from, $date_to, $user_id);
                    else
                        $data['bills'] = $this->Mbill->objGetBillsOfYear($date_from, $date_to, $user_id);
                    $this->load->view('templates/header_user', $data);
                    $this->load->view('report/listpage_year', $data);
                    break;
                default:
                    break;
            }
            //$this->load->view('templates/header', $data);
            //$this->load->view('report/listpage', $data);
        }else{
            $this->session->set_flashdata('flashdata', '参数错误');
            redirect('report/index');
        }
    }

    public function listpage_user($offset = 0)
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $user_id = $this->input->get('user');
        if(!is_numeric($user_id))
            exit('ERROR');
        $get_config = array(
            array(
                'field' => 'is_filter',
                'label' => 'Is Filter',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' =>  'report_type',
                'label' =>  'Report Type',
                'rules' =>  'trim|xss_clean|required'
            ),
        );
        if ($this->input->get('date-type', true) == 'day') {
            array_merge($get_config,
                array(
                    'field' =>  'date_from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'date_to',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        } else {
            array_merge($get_config,
                array(
                    'field' =>  'birthyearmonth-date-from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthmonthmonth-date-from',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthyearmonth-date-to',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthmonthmonth-date-to',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        }
        $this->form_validation->set_rules($get_config);
        $report_type = $this->input->get('report_type', true);
        if ($this->input->get('date-type', true) == 'day') {
            $date_from = $this->input->get('date_from', true);
            $date_to = $this->input->get('date_to', true);
        } else {
            $date_from = $this->input->get('birthyearmonth-date-from', true) . '-' .$this->input->get('birthmonthmonth-date-from', true).'-01';
            $date_to = date( 'Y-m-t', strtotime($this->input->get('birthyearmonth-date-to', true) . '-' .$this->input->get('birthmonthmonth-date-to', true).'-01'));
        }
        $interval = date_diff(new \DateTime($date_from), new \DateTime($date_to), true);
        $date_from = strtotime($date_from);
        $date_to = strtotime($date_to);
        if($this->input->get('report_type', true) != '' &&
            $date_from != '' && $date_to != ''
        )
        {
            $date_from = date('Y-m-d', $date_from);
            $date_to = date('Y-m-d', $date_to);
            $data = array();
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['base_url'] = base_url()."report/listpage_user/";
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

            $config['per_page'] = 30;
            switch($report_type)
            {
                case "day":
                    $config['total_rows'] = $interval->days + 1;
                    break;
                case "month":
                    $config['total_rows'] = $interval->y*12 + $interval->m + 1;
                    break;
                case "year":
                    $config['total_rows'] = $interval->y + 1;;
                    break;
                default:
                    $report_type = "";
                    break;
            }
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            switch($report_type)
            {
                case 'day':
                    $data['bills'] = $this->Mbill->objGetBillsOfDay($date_from, $date_to, $user_id, $limit);
                    $this->load->view('templates/header', $data);
                    $this->load->view('report/listpage_day_users', $data);
                    break;
                case 'month':
                    $data['bills'] = $this->Mbill->objGetBillsOfMonth($date_from, $date_to, $user_id, $limit);
                    $this->load->view('templates/header', $data);
                    $this->load->view('report/listpage_month_users', $data);
                    break;
                default:
                    break;
            }
        }else{
            $this->session->set_flashdata('flashdata', '参数错误');
            redirect('report/index_admin');
        }
    }

    public function listpage($offset = 0)
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $user_id = $this->session->userdata('current_user_id', true);
        $get_config = array(
            array(
                'field' => 'is_filter',
                'label' => 'Is Filter',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' =>  'report_type',
                'label' =>  'Report Type',
                'rules' =>  'trim|xss_clean|required'
            ),
        );
        if ($this->input->get('date-type', true) == 'day') {
            array_merge($get_config,
                array(
                    'field' =>  'date_from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'date_to',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        } elseif ($this->input->get('date-type', true) == 'month') {
            array_merge($get_config,
                array(
                    'field' =>  'birthyearmonth-date-from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthmonthmonth-date-from',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthyearmonth-date-to',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthmonthmonth-date-to',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        } elseif ($this->input->get('date-type', true) == 'year') {
            array_merge($get_config,
                array(
                    'field' =>  'birthyearyear-date-from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthyearyear-date-to',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        }
        $this->form_validation->set_rules($get_config);
        $report_type = $this->input->get('report_type', true);
        if ($this->input->get('date-type', true) == 'day') {
            $date_from = $this->input->get('date_from', true);
            $date_to = $this->input->get('date_to', true);
        } elseif ($this->input->get('date-type', true) == 'month') {
            $date_from = $this->input->get('birthyearmonth-date-from', true) . '-' .$this->input->get('birthmonthmonth-date-from', true).'-01';
            $date_to = date( 'Y-m-t', strtotime($this->input->get('birthyearmonth-date-to', true) . '-' .$this->input->get('birthmonthmonth-date-to', true).'-01'));
        } elseif ($this->input->get('date-type', true) == 'year') {
            $date_from = $this->input->get('birthyearyear-date-from', true).'-01-01';
            $date_to = $this->input->get('birthyearyear-date-to', true).'-12-31';
        }
        $interval = date_diff(new \DateTime($date_from), new \DateTime($date_to), true);
        $date_from = strtotime($date_from);
        $date_to = strtotime($date_to);
        if($this->input->get('report_type', true) != '' &&
            $date_from != '' && $date_to != ''
        )
        {
            $date_from = date('Y-m-d', $date_from);
            $date_to = date('Y-m-d', $date_to);
            //$search = $this->db->escape_like_str($search);
            $data = array();
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['base_url'] = base_url()."report/listpage/";
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

            $config['per_page'] = 30;
            switch($report_type)
            {
                case "day":
                    $config['total_rows'] = $interval->days + 1;
                    break;
                case "month":
                    $config['total_rows'] = $interval->y*12 + $interval->m + 1;
                    break;
                case "year":
                    $config['total_rows'] = $interval->y + 1;;
                    break;
                case "products":
                    $config['total_rows'] = $this->Mbill->objGetProductBillsItemCount($date_from, $date_to);
                    break;
                default:
                    $report_type = "";
                    break;
            }
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            $where = '';
            $order = '';
            switch($report_type)
            {
                case 'day':
                    $data['bills'] = $this->Mbill->objGetBillsOfDay($date_from, $date_to, $user_id, $limit);
                    $this->load->view('templates/header_user', $data);
                    $this->load->view('report/listpage_day', $data);
                    break;
                case 'month':
                    $data['bills'] = $this->Mbill->objGetBillsOfMonth($date_from, $date_to, $user_id, $limit);
                    $this->load->view('templates/header_user', $data);
                    $this->load->view('report/listpage_month', $data);
                    break;
                case 'year':
                    $data['bills'] = $this->Mbill->objGetBillsOfYear($date_from, $date_to, $user_id);
                    $this->load->view('templates/header_user', $data);
                    $this->load->view('report/listpage_year', $data);
                    break;

                default:
                    break;
            }
            //$this->load->view('templates/header', $data);
            //$this->load->view('report/listpage', $data);
        }else{
            $this->session->set_flashdata('flashdata', '参数错误');
            redirect('report/index');
        }
    }

    public function listpage_admin($offset = 0)
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $get_config = array(
            array(
                'field' => 'is_filter',
                'label' => 'Is Filter',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' =>  'report_type',
                'label' =>  'Report Type',
                'rules' =>  'trim|xss_clean|required'
            ),
        );
        if ($this->input->get('date-type', true) == 'day') {
            array_merge($get_config,
                array(
                    'field' =>  'date_from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'date_to',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        } elseif ($this->input->get('date-type', true) == 'month') {
            array_merge($get_config,
                array(
                    'field' =>  'birthyearmonth-date-from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthmonthmonth-date-from',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthyearmonth-date-to',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthmonthmonth-date-to',
                    'label' =>  'Date To',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        } elseif ($this->input->get('date-type', true) == 'year') {
            array_merge($get_config,
                array(
                    'field' =>  'birthyearyear-date-from',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
            array_merge($get_config,
                array(
                    'field' =>  'birthyearyear-date-to',
                    'label' =>  'Date From',
                    'rules' =>  'trim|xss_clean|required'
                ) );
        }
        $this->form_validation->set_rules($get_config);
        $report_type = $this->input->get('report_type', true);
        if ($this->input->get('date-type', true) == 'day') {
            $date_from = $this->input->get('date_from', true);
            $date_to = $this->input->get('date_to', true);
        } elseif ($this->input->get('date-type', true) == 'month') {
            $date_from = $this->input->get('birthyearmonth-date-from', true) . '-' .$this->input->get('birthmonthmonth-date-from', true).'-01';
            $date_to = date( 'Y-m-t', strtotime($this->input->get('birthyearmonth-date-to', true) . '-' .$this->input->get('birthmonthmonth-date-to', true).'-01'));
        } elseif ($this->input->get('date-type', true) == 'year') {
            $date_from = $this->input->get('birthyearyear-date-from', true).'-01-01';
            $date_to = $this->input->get('birthyearyear-date-to', true).'-12-31';
        }
        $interval = date_diff(new \DateTime($date_from), new \DateTime($date_to), true);
        $date_from = strtotime($date_from);
        $date_to = strtotime($date_to);
        if($this->input->get('report_type', true) != '' &&
            $date_from != '' && $date_to != ''
        )
        {
            $date_from = date('Y-m-d', $date_from);
            $date_to = date('Y-m-d', $date_to);
            //$search = $this->db->escape_like_str($search);
            $data = array();
            $data['report_type'] = $report_type;
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['base_url'] = base_url()."report/listpage_admin/";
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            //$where = '';
            //$where .= ' and p.is_valid = true ';
            //$where .= $this->__get_search_str($search, $price_low, $price_high);
            //$config['total_rows'] = $this->Mproduct->intGetProductsCount($where);

            $config['per_page'] = 30;
            switch($report_type)
            {
                case "day":
                    $config['total_rows'] = $interval->days + 1;
                    //if($this->input->get('is_filter') == 'on')
                    //$config['total_rows'] = $this->Mbill->objGetZentsBillsOfDay($date_from, $date_to, $limit)->count;
                    break;
                case "month":
                    $config['total_rows'] = $interval->y*12 + $interval->m + 1;
                    break;
                case "year":
                    $config['total_rows'] = $interval->y + 1;;
                    break;
                case "products":
                    $config['per_page'] = 9999;
                    $config['total_rows'] = 9999;
                    break;
                case "users":
                    $config['total_rows'] = $this->Mbill->intGetUserBillsCount($date_from, $date_to);
                    break;
                default:
                    $report_type = "";
                    break;
            }
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            $where = '';
            $order = '';
            switch($report_type)
            {
                case 'day':
                    $data['bills'] = $this->Mbill->objGetZentsBillsOfDay($date_from, $date_to, $limit);
                    $this->load->view('templates/header', $data);
                    $this->load->view('report/listpage_day_admin', $data);
                    break;
                case 'month':
                    $data['bills'] = $this->Mbill->objGetZentsBillsOfMonth($date_from, $date_to, $limit);
                    $this->load->view('templates/header', $data);
                    $this->load->view('report/listpage_month_admin', $data);
                    break;
                case 'year':
                    $data['bills'] = $this->Mbill->objGetZentsBillsOfYear($date_from, $date_to);
                    $this->load->view('templates/header', $data);
                    $this->load->view('report/listpage_year_admin', $data);
                    break;
                case 'products':
                    $data['bills'] = $this->Mbill->objGetProductBills($date_from, $date_to);
                    $this->load->view('templates/header', $data);
                    $this->load->view('report/listpage_productbills', $data);
                    break;
                case 'users':
                    $data['bills'] = $this->Mbill->objGetUserBills($date_from, $date_to, $limit);
                    $this->load->view('templates/header', $data);
                    $this->load->view('report/listpage_userbills', $data);
                    break;
                default:
                    break;
            }
            //$this->load->view('templates/header', $data);
            //$this->load->view('report/listpage', $data);
        }else{
            $this->session->set_flashdata('flashdata', '参数错误');
            redirect('report/index_zents');
        }

    }

    public function listpage_withdraw($offset = 0)
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $date_from = $this->input->get('date_from', true);
        $date_to = $this->input->get('date_to', true);
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        if( $date_from != '' && $date_to != '' )
        {
            $date_from = date('Y-m-d', strtotime($date_from));
            $date_to = date('Y-m-d', strtotime($date_to));
            //$search = $this->db->escape_like_str($search);
            $data = array();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['base_url'] = base_url()."report/withdraw/";
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            $where = ' and w.user_id = '.$this->session->userdata('current_user_id');
            $data['logs'] = $this->Mbill->objGetWithdrawLogs($where, $date_from, $date_to, $limit);
            $this->load->view('templates/header_user', $data);
            $this->load->view('report/withdraw_log', $data);
        }else {
            $this->session->set_flashdata('flashdata', '参数错误');
            redirect('report/withdraw');
        }
    }

    public function withdraw()
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $this->load->view('templates/header_user');
        $this->load->view('report/withdraw');
    }


    public function listpage_withdraw_admin($offset = 0)
    {
        $date_from = $this->input->get('date_from', true);
        $date_to = $this->input->get('date_to', true);
        if ($date_from != '')
            $date_from = date('Y-m-d', strtotime($date_from));
        if ($date_to != '')
            $date_to = date('Y-m-d', strtotime($date_to));
        //$search = $this->db->escape_like_str($search);
        $data = array();
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['base_url'] = base_url()."report/withdraw/";
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

        $config['per_page'] = 30;
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();
        $limit = '';
        $limit .= " limit {$config['per_page']} offset {$offset} ";
        $where = $this->__get_search_str($this->input->get('search', true));
        if ($date_from == '') {
            $date_from = '2016-01-01';
        }
        if ($date_to == '') {
            $date_to = '2099-12-31';
        }
        $data['logs'] = $this->Mbill->objGetWithdrawLogs($where, $date_from, $date_to, $limit);
        $this->load->view('templates/header', $data);
        $this->load->view('report/withdraw_log_admin', $data);
    }

    private function __get_search_str($search = '')
    {
        $where = '';
        if($search != '')
            $where .= " and (u.username like '%{$search}%' or u.name like '%{$search}%' ) ";
        return $where;
    }

    public function download_xls()
    {
        $report_type = $this->input->post('report_type');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        if($report_type != '' &&
            $date_from != '' && $date_to != ''
        ) {
            $this->load->library('PHPExcel');
            $objPHPExcel = new PHPExcel();

            $title = "untitled";
            switch($report_type) {
                case 'day':
                    $title = "ERP 日报表 $date_from - $date_to";
                    $bills = $this->Mbill->objGetZentsBillsOfDay($date_from, $date_to);
                    break;
                case 'month':
                    $bills = $this->Mbill->objGetZentsBillsOfMonth($date_from, $date_to);
                    $date_from = date('Y-m', strtotime($date_from));
                    $date_to = date('Y-m', strtotime($date_to));
                    $title = "ERP 月报表 $date_from - $date_to";
                    break;
                case 'year':
                    $bills = $this->Mbill->objGetZentsBillsOfYear($date_from, $date_to);
                    $date_from = date('Y', strtotime($date_from));
                    $date_to = date('Y', strtotime($date_to));
                    $title = "ERP 年报表 $date_from - $date_to";
                    break;
                case 'products':
                    $bills = $this->Mbill->objGetProductBills($date_from, $date_to);
                    $title = "ERP 产品报表 $date_from - $date_to";
                    break;
                case 'users':
                    $bills = $this->Mbill->objGetUserBills($date_from, $date_to);
                    $title = "ERP 代理交易统计报表 $date_from - $date_to";
                    break;
                default:
                    break;
            }
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Princelo Lamkimcheung@gmail.com")
                ->setLastModifiedBy("Princelo Lamkimcheung@gmail.com")
                ->setTitle($title)
                ->setSubject($title)
                ->setDescription($title)
                ->setKeywords("Princelo lamkimcheung@gmail.com")
                ->setCategory($report_type);


            if($report_type == 'products') {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', $title)
                    ->setCellValue('A2', '产品ID')
                    ->setCellValue('B2', '产品名称')
                    ->setCellValue('C2', '出货量')
                    ->setCellValue('D2', '总金额');
                foreach ($bills as $k => $v) {
                    $i = $k + 3;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$i", $v->product_id)
                        ->setCellValue("B$i", $v->title)
                        ->setCellValue("C$i", $v->total_quantity)
                        ->setCellValue("D$i", $v->amount);
                }
            } elseif ($report_type == 'users') {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', $title)
                    ->setCellValue('A2', '代理')
                    ->setCellValue('B2', '业绩增量')
                    ->setCellValue('C2', '自下级(下下级)收益增量(不含推荐)')
                    ->setCellValue('D2', '自下级推荐收益增量')
                    //->setCellValue('E2', '自身延时收益增量')
                    ->setCellValue('E2', '总收益增量')
                    ->setCellValue('F2', '至推荐人收益')
                    ->setCellValue('G2', '至推荐人推荐收益')
                    ->setCellValue('H2', '至推荐人总收益')
                    ->setCellValue('I2', '至跨界推荐人收益')
                    ->setCellValue('J2', '推荐人代理')
                    ->setCellValue('K2', '跨界推荐人代理');
                foreach ($bills as $k => $v) {
                    $i = $k + 3;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$i", $v->name."(".$v->username."/".$v->id.")")
                        ->setCellValue("B$i", cny($v->turnover))
                        ->setCellValue("C$i", cny($v->normal_return_profit_sub2self))
                        ->setCellValue("D$i", cny($v->extra_return_profit_sub2self))
                        //->setCellValue("E$i", cny($v->delay_return_profit))
                        ->setCellValue("E$i", '￥'.bcadd(bcadd(money($v->normal_return_profit_sub2self), money($v->extra_return_profit_sub2self), 2 ),0,2))
                        ->setCellValue("F$i", cny($v->normal_return_profit_self2parent))
                        ->setCellValue("G$i", cny($v->extra_return_profit_self2parent))
                        ->setCellValue("H$i", "￥".bcadd(money($v->normal_return_profit_self2parent), money($v->extra_return_profit_self2parent), 2 ))
                        ->setCellValue("I$i", cny($v->normal_return_profit_self2gparent));
                    if(intval($v->pid) > 0)
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("J$i", $v->pname."(".$v->pusername."/".$v->pid.")");
                    else
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("J$i", "无推荐人");
                    if(intval($v->gpid) > 0)
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("K$i", $v->gpname."(".$v->gpusername."/".$v->gpid.")");
                    else
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("K$i", "无跨界推荐人");

                }
            } else {
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', $title)
                    ->setCellValue('A2', '日期')
                    ->setCellValue('B2', '总金额(含运费)')
                    ->setCellValue('C2', '产品总金额')
                    ->setCellValue('D2', '运费总金额')
                    ->setCellValue('E2', '即时收益总量')
                    //->setCellValue('F2', '用户自身收益总量')
                    ->setCellValue('F2', '收益总量')
                    ->setCellValue('G2', '订单数');
                // Miscellaneous glyphs, UTF-8
                foreach($bills as $k => $v)
                {
                    $i = $k + 3;
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$i", $v->date)
                        ->setCellValue("B$i", $v->total_volume)
                        ->setCellValue("C$i", $v->products_volume)
                        ->setCellValue("D$i", $v->post_fee)
                        ->setCellValue("E$i", $v->normal_return_profit_volume)
                        //->setCellValue("F$i", $v->delay_return_profit_volume)
                        ->setCellValue("F$i", "￥".bcadd(money($v->normal_return_profit_volume), 0, 2))
                        ->setCellValue("G$i", $v->order_quantity);
                }
            }

            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('REPORT');


            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);


            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$title.'.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else {
            exit('This page is expired !');
        }
    }
}

