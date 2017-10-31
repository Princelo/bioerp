<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//error_reporting(E_ERROR);

require_once "application/lib/WxPay.Api.php";
require_once 'application/lib/WxPay.Notify.php';
require_once 'application/views/mobile/user/log.php';
//初始化日志
$logHandler= new CLogFileHandler("application/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);


require_once "application/third_party/PayNotifyCallBack.php";
require_once "application/services/InitiationService.php";
class Wxpay_notify extends CI_Controller
{

    public $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->load->model('Muser', 'Muser');
    }


    public function index()
    {
        Log::DEBUG("begin notify");
        $notify = new PayNotifyCallBack();
        $notify->setService(new InitiationService($this->Muser));
        $notify->Handle(false);
    }


}

