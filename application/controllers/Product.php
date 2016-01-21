<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include('application/libraries/MY_Controller.php');
class Product extends MY_Controller {

    public $db;
    public function __construct(){
        parent::__construct();
        if($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'user')
            redirect('login');
        $this->load->model('Mproduct', 'Mproduct');
        $this->load->model('Muser', 'Muser');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->db = $this->load->database('default', true);
    }

    public function listpage_admin($offset = 0)
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $get_config = array(
            array(
                'field' =>  'search',
                'label' =>  '关键词',
                'rules' =>  'trim|xss_clean'
            ),
            array(
                'field' =>  'price_low',
                'label' =>  '价格区间(低)',
                'rules' =>  'trim|xss_clean|numeric'
            ),
            array(
                'field' =>  'price_high',
                'label' =>  '价格区间(高)',
                'rules' =>  'trim|xss_clean|numeric'
            ),
        );
        $this->form_validation->set_rules($get_config);
        if($this->input->get('search', true) != '' ||
            $this->input->get('price_low', true) != '' ||
            $this->input->get('price_high', true) != '' ||
            $this->input->get('category', true) != ''
        )
        {
            $search = $this->input->get('search', true);
            $search = $this->db->escape_like_str($search);
            $price_low = $this->input->get('price_low', true);
            $price_high = $this->input->get('price_high', true);
            $category = $this->input->get('category', true);
            $data = array();
            $config['base_url'] = base_url()."product/listpage_admin/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $where = '';
            $where .= ' and p.is_valid = true ';
            $where .= $this->__get_search_str($search, $price_low, $price_high, $category);
            $config['total_rows'] = $this->Mproduct->intGetProductsCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            //$where = '';
            $order = '';
            $data['products'] = $this->Mproduct->objGetProductList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('product/listpage_admin', $data);
        }else{
            $data = array();
            $config['base_url'] = base_url()."product/listpage_admin/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $where = '';
            $where .= ' and p.is_valid = true ';
            $config['total_rows'] = $this->Mproduct->intGetProductsCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            $order = '';
            $data['products'] = $this->Mproduct->objGetProductList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('product/listpage_admin', $data);
        }
    }

    public function listpage_admin_invalid($offset = 0)
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $get_config = array(
            array(
                'field' =>  'search',
                'label' =>  '关键词',
                'rules' =>  'trim|xss_clean'
            ),
            array(
                'field' =>  'price_low',
                'label' =>  '价格区间(低)',
                'rules' =>  'trim|xss_clean|numeric'
            ),
            array(
                'field' =>  'price_high',
                'label' =>  '价格区间(高)',
                'rules' =>  'trim|xss_clean|numeric'
            ),
        );
        $this->form_validation->set_rules($get_config);
        if($this->input->get('search', true) != '' ||
            $this->input->get('price_low', true) != '' ||
            $this->input->get('price_high', true) != '' ||
            $this->input->get('category', true) != ''
        )
        {
            $search = $this->input->get('search', true);
            $search = $this->db->escape_like_str($search);
            $price_low = $this->input->get('price_low', true);
            $price_high = $this->input->get('price_high', true);
            $category = $this->input->get('category', true);
            $data = array();
            $config['base_url'] = base_url()."product/listpage_admin_invalid/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $where = '';
            $where .= ' and p.is_valid = false ';
            $where .= $this->__get_search_str($search, $price_low, $price_high, $category);
            $config['total_rows'] = $this->Mproduct->intGetProductsCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            //$where = '';
            $order = '';
            $data['products'] = $this->Mproduct->objGetProductList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('product/listpage_admin', $data);
        }else{
            $data = array();
            $where = ' and p.is_valid = false ';
            $order = '';
            $config['base_url'] = base_url()."product/listpage_admin_invalid/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $config['total_rows'] = $this->Mproduct->intGetProductsCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            $data['products'] = $this->Mproduct->objGetProductList($where, $order, $limit);
            $this->load->view('templates/header', $data);
            $this->load->view('product/listpage_admin', $data);
        }
    }

    public function listpage($offset = 0)
    {
        if($this->session->userdata('role') != 'user')
            exit('You are the admin.');
        $get_config = array(
            array(
                'field' =>  'search',
                'label' =>  '关键词',
                'rules' =>  'trim|xss_clean'
            ),
            array(
                'field' =>  'price_low',
                'label' =>  '价格区间(低)',
                'rules' =>  'trim|xss_clean|numeric'
            ),
            array(
                'field' =>  'price_high',
                'label' =>  '价格区间(高)',
                'rules' =>  'trim|xss_clean|numeric'
            ),
        );
        $this->form_validation->set_rules($get_config);
        if($this->input->get('search', true) != '' ||
            $this->input->get('price_low', true) != '' ||
            $this->input->get('price_high', true) != '' ||
            $this->input->get('category', true) != ''
        )
        {
            $search = $this->input->get('search', true);
            $search = $this->db->escape_like_str($search);
            $price_low = $this->input->get('price_low', true);
            $price_high = $this->input->get('price_high', true);
            $category = $this->input->get('category', true);
            $data = array();
            $config['base_url'] = base_url()."product/listpage/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $where = '';
            $where .= ' and p.is_valid = true ';
            $where .= $this->__get_search_str($search, $price_low, $price_high, $category);
            $config['total_rows'] = $this->Mproduct->intGetProductsCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            //$where = '';
            $order = '';
            $data['products'] = $this->Mproduct->objGetProductList($where, $order, $limit);
            $this->load->view('templates/header_user', $data);
            $this->load->view('product/listpage', $data);
        }else{
            $data = array();
            $where = ' and p.is_valid = true ';
            $order = '';
            $config['base_url'] = base_url()."product/listpage/";
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
            $config['total_rows'] = $this->Mproduct->intGetProductsCount($where);
            $config['per_page'] = 30;
            $this->pagination->initialize($config);
            $data['page'] = $this->pagination->create_links();
            $limit = '';
            $limit .= " limit {$config['per_page']} offset {$offset} ";
            $data['products'] = $this->Mproduct->objGetProductList($where, $order, $limit);
            $this->load->view('templates/header_user', $data);
            $this->load->view('product/listpage', $data);
        }
    }

    public function details_admin($product_id)
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $data = array();
        $data['v'] = $this->Mproduct->objGetProductInfo($product_id);
        $config = array(
            array(
                'field'   => 'title',
                'label'   => '产品名称',
                //'rules'   => 'trim|required|xss_clean|is_unique[products.title]'
                'rules'   => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'category',
                'label' => '所属分类',
                'rules'   => 'trim|required|xss_clean|is_natural|less_than[5]',
            ),
            array(
                'field' => 'weight',
                'label' => '总重量',
                'rules'   => 'trim|required|xss_clean|is_natural',
            ),
        );

        $this->form_validation->set_rules($config);
        if(isset($_POST) && !empty($_POST))
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('templates/header', $data);
                $this->load->view('product/details_admin/'.$product_id, $data);
            }else{
                $main_data = array(
                    'title' => $this->input->post('title'),
                    'properties' => $this->input->post('properties'),
                    'feature' => $this->input->post('feature'),
                    'usage_method' => $this->input->post('usage_method'),
                    'ingredient' => $this->input->post('ingredient'),
                    'category' => $this->input->post('category'),
                    'weight' => $this->input->post('weight'),
                    'is_valid' => false,
                );
                $main_data['is_valid'] = $this->input->post('is_valid')=='1'?'true':'false';
                if($this->Mproduct->update($main_data, $product_id))
                {
                    $this->session->set_flashdata('flashdata', '产品更改成功');
                }else{
                    $this->session->set_flashdata('flashdata', '产品更改失败');
                }
                redirect('product/details_admin/'.$product_id);
            }

        }
        $this->load->view('templates/header', $data);
        $this->load->view('product/details_admin', $data);
    }

    public function details($product_id)
    {
        if($this->session->userdata('role') != 'user')
            exit('You are not admin.');
        $data = array();
        $data['v'] = $this->Mproduct->objGetProductInfo($product_id);
        if($data['v']->is_valid == false)
            exit('The product is invalid');
        $this->load->view('templates/header_user', $data);
        $this->load->view('product/details', $data);
    }

    public function add($error = '')
    {
        if($this->session->userdata('role') != 'admin')
            exit('You are not the admin.');
        $data = array();
        $data['error'] = $error;
        $config = array(
            array(
                'field'   => 'title',
                'label'   => '产品名称',
                //'rules'   => 'trim|required|xss_clean|is_unique[products.title]'
                'rules'   => 'trim|required|xss_clean'
            ),
            array(
                'field'   => 'price',
                'label'   => '单价',
                'rules'   => 'trim|xss_clean|numeric|required'
            ),
            array(
                'field' => 'weight',
                'label' => '总重量',
                'rules'   => 'trim|required|xss_clean|is_natural',
            ),
        );
        $this->form_validation->set_rules($config);
        if(isset($_POST) && !empty($_POST))
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('templates/header', $data);
                $this->load->view('product/add', $data);
            }else{
                $config['upload_path'] = './uploads/';
                $config['file_name'] = uniqid();
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']	= '500000';
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    echo $error['error'];
                    return false;
                }
                else
                {
                    $upload_data = array('upload_data' => $this->upload->data());
                    $upload_data = array('upload_data' => $this->upload->data());
                    $path = $upload_data['upload_data']['file_path'];
                    $fname = $upload_data['upload_data']['file_name'];
                    $fname = '/uploads/'.$fname;
                    $config['image_library'] = 'gd2';
                    $config['source_image']	= '.'.$fname;
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['height']	= 100;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $arr = explode('.', $fname);
                    $thumb = $arr[0].'_thumb.'.$arr[1];
                }
                $main_data = array(
                    'title' => $this->input->post('title'),
                    'category' => $this->input->post('category'),
                    'properties' => $this->input->post('properties'),
                    'feature' => $this->input->post('feature'),
                    'usage_method' => $this->input->post('usage_method'),
                    'ingredient' => $this->input->post('ingredient'),
                    'img' => $fname,
                    'weight' => $this->input->post('weight'),
                    'is_valid' => $this->input->post('is_valid'),
                    'price' => $this->input->post('price'),
                    'thumb' => $thumb,
                );
                $result = $this->Mproduct->add($main_data);
                if($result){
                    $this->session->set_flashdata('flashdata', '产品添加成功');
                    redirect('product/add');
                }
                else{
                    $this->session->set_flashdata('flashdata', '产品添加失败');
                    redirect('product/add');
                }
            }
        }else{
            $this->load->view('templates/header', $data);
            $this->load->view('product/add', $data);
        }
    }

    private function __get_search_str($search = '', $price_low = '', $price_high = '', $category = null)
    {
        $where = "";
        if($search != '' && $price_low != '' && $price_high != '') {
            $where .= " and (p.title like '%{$search}%' or p.feature like '%{$search}%' or
                            pr.price::decimal between {$price_low} and {$price_high} )
                            ) ";
        } elseif($search != '' && $price_low == '' && $price_high == '') {
            $where .= " and (p.title like '%{$search}%' or p.feature like '%{$search}%') ";
        } elseif($search != '' && $price_low != '' && $price_high == '') {
            $where .= " and (p.title like '%{$search}%' or p.feature like '%{$search}%' or
                            (cast(pr.price as decimal) > {$price_low} )
                            ) ";
        } elseif($search != '' && $price_low == '' && $price_high != '') {
            $where .= " and (p.title like '%{$search}%' or p.feature like '%{$search}%' or
                            (cast(pr.price as decimal) < {$price_high} )
                            ) ";
        } elseif($search == '' && $price_low != '' && $price_high != '') {
            $where .= " and (cast(pr.price as decimal) between {$price_low} and {$price_high}) ";
        } elseif($search == '' && $price_low != '' && $price_high == '') {
            $where .= " and (cast(pr.price as decimal) > {$price_low} )";
        } elseif($search == '' && $price_low == '' && $price_high != '') {
            $where .= " and (cast(pr.price as decimal) < {$price_high} )";
        }

        if($category != null) {
            $where .= " and p.category = {$category} ";
        }

        return $where;
    }

}

