<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include('application/libraries/MY_Controller.php');
class Forecast extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'user')
            redirect('login');
        $this->load->model('Mforecast', 'Mforecast');
        $this->load->model('Muser', 'Muser');
        $this->load->model('Mpayment', 'Mpayment');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = array();

        $config = array(
            /*array(
                'field'   => 'name',
                'label'   => '姓名',
                'rules'   => 'trim|xss_clean|required|min_length[2]|max_length[10]'
            ),
            array(
                'field'   => 'citizen_id',
                'label'   => '身份证',
                'rules'   => 'trim|xss_clean|min_length[10]|max_length[20]'
            ),*/
            array(
                'field'   => 'mobile_no',
                'label'   => '移动电话',
                'rules'   => 'trim|xss_clean|required|min_length[10]|max_length[20]|is_unique[users.mobile_no]'
            ),
            array(
                'field'   => 'wechat_id',
                'label'   => '微信号',
                'rules'   => 'trim|xss_clean|max_length[50]|'
            ),
            array(
                'field'   => 'qq_no',
                'label'   => 'QQ号',
                'rules'   => 'trim|xss_clean|required|min_length[5]|max_length[50]|is_unique[users.qq_no]'
            ),
        );

        $this->form_validation->set_rules($config);
        $id = $this->session->userdata('current_user_id');
        if ($_POST && $_POST != '') {
            if ($this->session->userdata('role')=='admin' && $this->input->post('forecast') != '') {
                if ($this->Mforecast->update($this->input->post('forecast'))) {
                    $this->session->set_flashdata('flashdata', '修改成功');
                    redirect('forecast/index');
                }
            }
            $main_data = array(
                //'name' => $this->input->post('name'),
                //'citizen_id' => $this->input->post('citizen_id'),
                'mobile_no' => $this->input->post('mobile_no'),
                'wechat_id' => $this->input->post('wechat_id'),
                'qq_no' => $this->input->post('qq_no'),
            );
            if ($this->Muser->update($main_data, $id)) {
                $this->session->set_flashdata('flashdata', '修改成功');
                redirect('forecast/index');
            }
        }
        $data = array();
        $data['forecast'] = $this->Mforecast->objGetForecastInfo()->content;
        $data['v'] = $this->Muser->objGetUserInfo($id);
        //$data['forecasts'] = $this->Mforecast->objGetForecastList();
        if ($this->session->userdata('role') == 'admin') {

            $this->load->view('templates/header', $data);

            $this->load->view('forecast/index', $data);
        } else {
            $tip = "";
            $paid = true;
            if (!$this->session->userdata('initiation')) {
                $user_id = $this->session->userdata('current_user_id');
                $count = $this->Mpayment->countPayments(" and user_id = $user_id and type = 'register' ");
                if ($count > 0) {
                    $tip .= '你已成功付款，系统核验中...';
                    $paid = true;
                } else {
                    $tip .= "马上成为正式代理";
                    $paid = false;
                }
            }
            $data['tip'] = $tip;
            $data['paid'] = $paid;
            //$data['tip'] = $this->_getTips($data);
            if (is_mobile()) {
                $this->load->view('mobile/forecast/index_user', $data);
                return;
            }
            $this->load->view('templates/header_user', $data);
            $this->load->view('forecast/index_user', $data);
        }
    }

}

