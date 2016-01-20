<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include('application/libraries/MY_Controller.php');
class User extends MY_Controller {

    public $db;
    public function __construct(){
        parent::__construct();
        if($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'user')
            redirect('login');
        $this->load->model('Muser', 'Muser');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->db = $this->load->database('default', true);
    }

    public function treepage()
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $data = array();
        $data['users'] = $this->Muser->getTree();
        $this->load->view('templates/header_user', $data);
        $this->load->view('user/treepage', $data);
    }

    public function get_tree()
    {
        $current_user_id = $this->session->userdata('current_user_id');
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        if ($this->input->get('id', true) == '#') {
            $tree = $this->Muser->getTree('#', 1, $current_user_id);
        } else {
            $id = filter_var($this->input->get('id', true), FILTER_VALIDATE_INT);
            if ($id < $current_user_id) {
                exit;
            }
            $tree = $this->Muser->getTree($id, 1, $current_user_id);
        }
        if ($tree == null){
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                        $tree
                    )
                );
        }
    }

    public function listpage($offset = 0)
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $current_user_id = $this->session->userdata('current_user_id');
        $get_config = array(
            array(
                'field' =>  'search',
                'label' =>  '用戶名',
                'rules' =>  'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($get_config);
        if($this->input->get('search', true) != '' )
        {
            $search = $this->input->get('search', true);
            $search = $this->db->escape_like_str($search);
            $data = array();
            $config['base_url'] = base_url()."user/listpage/";
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
            //$where = ' and is_admin = false ';
            $order = ' order by u.id ';
            $data['users'] = $this->Muser->objGetSubUserList($where, $iwhere, $order, $limit, 2);
            $this->load->view('templates/header_user', $data);
            $this->load->view('user/listpage', $data);
        } else {
            exit('<script>alert("请输入搜索关键词");window.close();</script>');
        }
    }

    public function sublistpage($id, $offset = 0)
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $current_user_id = //$this->session->userdata('current_user_id');
            $id;
        $get_config = array(
            array(
                'field' =>  'search',
                'label' =>  '用戶名',
                'rules' =>  'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($get_config);
        if($this->input->get('search', true) != '' )
        {
            $search = $this->input->get('search', true);
            $search = $this->db->escape_like_str($search);
            $data = array();
            $config['base_url'] = base_url()."user/sublistpage/".$id;
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
            //$where = ' and is_admin = false ';
            $order = ' order by u.id ';
            $data['users'] = $this->Muser->objGetSubUserList($where, $iwhere, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('user/sublistpage', $data);
        }else{
            $data = array();
            $config['base_url'] = base_url()."user/sublistpage/".$id;
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
            $order = ' order by u.id ';
            $data['users'] = $this->Muser->objGetSubUserList($where, $iwhere, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('user/sublistpage', $data);
        }
    }

    public function listpage_admin($offset = 0)
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
        if($this->input->get('search', true) != '' )
        {
            $search = $this->input->get('search', true);
            $search = $this->db->escape_like_str($search);
            $data = array();
            $config['base_url'] = base_url()."user/listpage_admin/";
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
            //$where = ' and is_admin = false ';
            $order = ' order by u.id ';
            $data['users'] = $this->Muser->objGetUserList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('user/listpage_admin', $data);
        }else{
            $data = array();
            $config['base_url'] = base_url()."user/listpage_admin/";
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
            $order = ' order by u.id ';
            $data['users'] = $this->Muser->objGetUserList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('user/listpage_admin', $data);
        }
    }

    public function admin_add_user($error = '')
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $id = filter_var($this->input->get('id'), FILTER_VALIDATE_INT);
        $this->load->database();
        $result = $this->db->query('select name,id from users where id = ?', array($id))->result();
        if (empty($result)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                        array('state'=>'error','message'=>'无效用戶')
                    )
                );
        }
        $data = array();
        $data['error'] = $error;
        $config = array(
            array(
                'field'   => 'username',
                'label'   => '代理账号',
                //'rules'   => 'trim|required|xss_clean|is_unique[products.title]'
                'rules'   => 'trim|required|xss_clean|min_length[5]|max_length[16]|is_unique[users.username]'
            ),
            array(
                'field'   => 'name',
                'label'   => '姓名',
                'rules'   => 'trim|xss_clean|required|min_length[2]|max_length[10]'
            ),
            array(
                'field'   => 'citizen_id',
                'label'   => '身份证',
                'rules'   => 'trim|xss_clean|min_length[10]|max_length[20]'
            ),
            array(
                'field'   => 'mobile_no',
                'label'   => '移动电话',
                'rules'   => 'trim|xss_clean|required|min_length[10]|max_length[20]|is_unique[users.mobile_no]'
            ),
            array(
                'field'   => 'wechat_id',
                'label'   => '微信号',
                'rules'   => 'trim|xss_clean|max_length[50]'
            ),
            array(
                'field'   => 'qq_no',
                'label'   => 'QQ号',
                'rules'   => 'trim|xss_clean|required|min_length[5]|max_length[50]|is_unique[users.qq_no]'
            ),
            array(
                'field'   => 'is_valid',
                'label'   => '是否生效',
                'rules'   => 'trim|xss_clean|required|is_natural|less_than[2]'
            ),
        );

        $this->form_validation->set_rules($config);
        if(isset($_POST) && !empty($_POST))
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(
                            array('state'=>'error','message'=>'操作失败'.validation_errors())
                        )
                    );
            }else{
                $main_data = array(
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'name' => $this->input->post('name'),
                    'citizen_id' => $this->input->post('citizen_id'),
                    'mobile_no' => $this->input->post('mobile_no'),
                    'wechat_id' => $this->input->post('wechat_id'),
                    'qq_no' => $this->input->post('qq_no'),
                    'is_valid' => $this->input->post('is_valid'),
                );
                if(  $_POST['password'] != $_POST['password2'])
                {
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(
                                array('state'=>'error','message'=>'两次密码输入不一致'.validation_errors())
                            )
                        );
                }
                $result = $this->Muser->addWithPid($main_data, $id);
                if($result){
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(
                                array('state'=>'success','message'=>'代理帐号添加成功')
                            )
                        );
                }
                else{
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(
                                array('state'=>'success','message'=>'代理帐号添加失败')
                            )
                        );
                }
            }
        }else{
            $data['user'] = $result[0];
            $this->load->view('templates/header_simple', $data);
            $this->load->view('user/admin_add_user', $data);
        }

    }


    public function add($error = '')
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $data = array();
        $data['error'] = $error;
        $config = array(
            array(
                'field'   => 'username',
                'label'   => '代理账号',
                'rules'   => 'trim|required|xss_clean|min_length[5]|max_length[16]|is_unique[users.username]'
            ),
            array(
                'field'   => 'password',
                'label'   => '代理密码',
                'rules'   => 'trim|xss_clean|required|min_length[8]|max_length[30]'
            ),
            array(
                'field'   => 'name',
                'label'   => '姓名',
                'rules'   => 'trim|xss_clean|required|min_length[2]|max_length[10]'
            ),
            array(
                'field'   => 'citizen_id',
                'label'   => '身份证',
                'rules'   => 'trim|xss_clean|min_length[10]|max_length[20]'
            ),
            array(
                'field'   => 'mobile_no',
                'label'   => '移动电话',
                'rules'   => 'trim|xss_clean|required|min_length[10]|max_length[20]|is_unique[users.mobile_no]'
            ),
            array(
                'field'   => 'wechat_id',
                'label'   => '微信号',
                'rules'   => 'trim|xss_clean|max_length[50]'
            ),
            array(
                'field'   => 'qq_no',
                'label'   => 'QQ号',
                'rules'   => 'trim|xss_clean|required|min_length[5]|max_length[50]|is_unique[users.qq_no]'
            ),
        );

        $this->form_validation->set_rules($config);
        if(isset($_POST) && !empty($_POST))
        {
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('templates/header_user', $data);
                $this->load->view('user/add', $data);
            }else{
                $main_data = array(
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'name' => $this->input->post('name'),
                    'citizen_id' => $this->input->post('citizen_id'),
                    'mobile_no' => $this->input->post('mobile_no'),
                    'wechat_id' => $this->input->post('wechat_id'),
                    'qq_no' => $this->input->post('qq_no'),
                );
                if(  $_POST['password'] != $_POST['password2'])
                {
                    $this->session->set_flashdata('flashdata', '兩次輸入密碼不一致');
                    redirect('user/add');
                }
                $result = $this->Muser->add($main_data);
                if($result){
                    $this->session->set_flashdata('flashdata', '代理账号添加成功');
                    redirect('user/add');
                }
                else{
                    $this->session->set_flashdata('flashdata', '代理账号添加失败');
                    redirect('user/add');
                }
            }
        }else{
            $this->load->view('templates/header_user', $data);
            $this->load->view('user/add', $data);
        }

    }

    public function nable_user($id)
    {
        $op = $this->input->post('op');
        $id = intval($id);
        if ($op == 'enable') {
            $result = $this->Muser->update(['is_valid' => true], $id);
        } else {
            $result = $this->Muser->update(['is_valid' => false], $id);
        }
        if($result){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                        array('state'=>'success','message'=>'代理账号修改成功')
                    )
                );
        }
        else{
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                        array('state'=>'error','message'=>'代理账号修改失败')
                    )
                );
        }
    }

    public function details($id)
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $id = intval($id);
        $current_user_id = $this->session->userdata('current_user_id');
        $isParent = $this->Muser->isParent($id, $current_user_id);
        $query = $this->db->query("select pid from users where id = {$current_user_id}")->result()[0];
        $isGrandParent = $this->Muser->isParent($id, $query->pid);
        if ( $isParent || $isGrandParent ) {
            $data['v'] = $this->Muser->objGetUserInfo($id);
            $data['id'] = $id;
            $this->load->view('templates/header_simple', $data);
            $this->load->view('user/details_parent', $data);
            return false;
        }
        $check = $this->Muser->isAccessibleSons( $current_user_id, $id );
        if ( $check ) {
            $data['v'] = $this->Muser->objGetUserInfo($id);
            $data['id'] = $id;
            $this->load->view('templates/header_simple', $data);
            $this->load->view('user/details_son', $data);
            return false;
        }
        if (!$check && !$isParent && !$isGrandParent) {
            exit('You does not have access right to get details of this user');
        }
    }

    public function details_admin($id)
    {
        if($this->session->userdata('role') != 'admin'){
            $this->details($id);
        } else {
            $config = array(
                /*array(
                    'field'   => 'username',
                    'label'   => '代理账号',
                    //'rules'   => 'trim|required|xss_clean|is_unique[products.title]'
                    'rules'   => 'trim|required|xss_clean|min_length[5]|max_length[12]|is_unique[users.username]'
                ),*/
                /*array(
                    'field'   => 'password',
                    'label'   => '代理密码',
                    'rules'   => 'trim|xss_clean|required|min_length[8]|max_length[30]'
                ),*/
                array(
                    'field'   => 'name',
                    'label'   => '姓名',
                    'rules'   => 'trim|xss_clean|required|min_length[2]|max_length[10]'
                ),
                array(
                    'field'   => 'citizen_id',
                    'label'   => '身份证',
                    'rules'   => 'trim|xss_clean|min_length[10]|max_length[20]'
                ),
                array(
                    'field'   => 'mobile_no',
                    'label'   => '移动电话',
                    'rules'   => 'trim|xss_clean|required|min_length[10]|max_length[20]'
                ),
                array(
                    'field'   => 'wechat_id',
                    'label'   => '微信号',
                    'rules'   => 'trim|xss_clean|max_length[50]'
                ),
                array(
                    'field'   => 'qq_no',
                    'label'   => 'QQ号',
                    'rules'   => 'trim|xss_clean|required|min_length[5]|max_length[50]'
                ),
                array(
                    'field'   => 'is_valid',
                    'label'   => '是否生效',
                    'rules'   => 'trim|xss_clean|required|is_natural|less_than[2]'
                ),
            );
            $data = array();
            $data['id'] = $id;
            $this->form_validation->set_rules($config);
            if(isset($_POST) && !empty($_POST))
            {
                $data['v'] = $this->Muser->objGetUserInfo($id);

                if ($this->form_validation->run() == FALSE)
                {
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(
                                array('state'=>'error','message'=>'代理账号修改失败'.validation_errors())
                            )
                        );
                }else{
                    $main_data = array(
                        'username' => $this->input->post('username'),
                        'name' => $this->input->post('name'),
                        'citizen_id' => $this->input->post('citizen_id'),
                        'mobile_no' => $this->input->post('mobile_no'),
                        'wechat_id' => $this->input->post('wechat_id'),
                        'qq_no' => $this->input->post('qq_no'),
                        'is_valid' => $this->input->post('is_valid'),
                    );
                    $result = $this->Muser->update($main_data, $id);
                    if($result){
                        //$this->session->set_flashdata('flashdata', '代理账号修改成功');
                        $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(
                                    array('state'=>'success','message'=>'代理账号修改成功')
                                )
                            );
                    }
                    else{
                        //$this->session->set_flashdata('flashdata', '代理账号修改失败');
                        $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(
                                    array('state'=>'error','message'=>'代理账号修改失败')
                                )
                            );
                    }
                }
            }else{
                $data['v'] = $this->Muser->objGetUserInfo($id);
                $data['id'] = $id;
                $this->load->view('templates/header_simple', $data);
                $this->load->view('user/details_admin', $data);
            }
        }

    }

    public function withdraw()
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $volume = floatval($this->input->post('volume'));
        $id = intval($this->input->post('id'));
        $isEnough = $this->Muser->isEnough($volume, $id);
        if (!$isEnough) {
            //$this->session->set_flashdata('flashdata', '错误: 结算失败, 会员可提现余额不足');
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                        array('state'=>'error','message'=>'错误: 结算失败, 会员可提现余额不足')
                    )
                );
        } else {
            $result = $this->Muser->boolWithdraw($volume, $id);

            if ($result) {
                //$this->session->set_flashdata('flashdata', '结算成功');
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(
                            array('state'=>'success','message'=>'结算成功!')
                        )
                    );
            } else {
                //$this->session->set_flashdata('flashdata', '错误: 结算失败!');
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(
                            array('state'=>'error','message'=>'错误: 结算失败!')
                        )
                    );
            }
        }
    }


    public function my_superior()
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $data['v'] = $this->Muser->getSuperiorInfo($this->session->userdata('current_user_id'));
        $this->load->view('templates/header_user', $data);
        $this->load->view('user/my_superior', $data);
    }

    public function password($error = ''){
        $data = array();
        $data['error'] = $error;
        if($this->session->userdata('role') == 'admin'){

            $this->load->view('templates/header', $data);

        }
        else{
            $this->load->view('templates/header_user', $data);
        }
        $this->load->view('user/password', $data);
    }


    public function passwordupdate(){
        if(isset($_POST['password-original']) && $_POST['password-original'] != ""
            && isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] != "" && $_POST['password2'] != ""
            && $_POST['password'] == $_POST['password2']){
            $_POST['password'] = md5($_POST['password']);
            $_POST['password2'] = md5($_POST['password2']);
            $result = false;
            if ($this->session->userdata('role') == 'user') {
                if($this->Muser->boolVerify($this->session->userdata('user'), md5($_POST['password-original']))){
                    $result = $this->Muser->boolUpdatePassword($_POST['password'], $this->session->userdata('current_user_id'));
                }else{
                    $this->session->set_flashdata('flashdata', '原密码错误');
                    redirect('user/password');
                }
            } else {
                if($this->Muser->boolVerify($this->session->userdata('user'), md5($_POST['password-original']))){
                    $result = $this->Muser->boolUpdatePasswordAdmin($_POST['password'], $this->session->userdata('current_user_id'));
                }else{
                    $this->session->set_flashdata('flashdata', '原密码错误');
                    redirect('user/password');
                }
            }
            if($result === true)
                $this->session->set_flashdata('flashdata', '更改成功');
            else
                $this->session->set_flashdata('flashdata', '未知错误');
            redirect('user/password');
        }else{
            $this->session->set_flashdata('flashdata', '请输入完整信息並保证输入相同密码');
            redirect('user/password');
        }
    }

    public function treepage_admin()
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $data = array();
        $data['users'] = $this->Muser->getTree();
        $this->load->view('templates/header', $data);
        $this->load->view('user/treepage_admin', $data);
    }

    public function get_tree_admin() {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        if ($this->input->get('id', true) == '#') {
            $tree = $this->Muser->getTree('#', 3);
        } else {
            $id = filter_var($this->input->get('id', true), FILTER_VALIDATE_INT);
            $tree = $this->Muser->getTree($id);
        }
        if ($tree == null){
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(
                        $tree
                    )
                );
        }

    }

    private function __get_search_str($search = '')
    {
        $where = '';
        if($search != '')
            $where .= " and (u.username like '%{$search}%' or u.name like '%{$search}%' ) ";
        return $where;
    }
}

