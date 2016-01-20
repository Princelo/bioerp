<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include('application/libraries/MY_Controller.php');
class Forecast extends MY_Controller {

    public function __construct(){
        parent::__construct();
        if($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'user')
            redirect('login');
        $this->load->model('MForecast', 'MForecast');
        $this->load->model('MUser', 'MUser');
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
        if($_POST && $_POST != '')
        {
            if($this->session->userdata('role')=='admin' && $this->input->post('forecast') != '')
            {
                if($this->MForecast->update($this->input->post('forecast'))){
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
            if($this->MUser->update($main_data, $id))
            {
                $this->session->set_flashdata('flashdata', '修改成功');
                redirect('forecast/index');
            }
        }
        $data = array();
        $data['forecast'] = $this->MForecast->objGetForecastInfo()->content;
        $data['v'] = $this->MUser->objGetUserInfo($id);
        //$data['forecasts'] = $this->MForecast->objGetForecastList();
        if($this->session->userdata('role') == 'admin'){

            $this->load->view('templates/header', $data);

            $this->load->view('forecast/index', $data);
        }
        else{
            //$data['tip'] = $this->_getTips($data);
            $this->load->view('templates/header_user', $data);
            $this->load->view('forecast/index_user', $data);
        }
    }

}
