<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends CI_Controller {

    public function __Construct() {
        parent::__Construct();
        $this->layout->debug['active'] = false;
        $this->load->model("authentication_model");
    }

    public function index() {

        $this->layout->title('Ocomon');
        $this->layout->company = 'Ocomon V3';
        $this->layout->meta(meta('Content-type','text/html; charset=utf-8'));
        $this->layout->meta(meta('content-language','pt-PT'));
        $this->layout->meta(meta('robots','noindex,nofollow'));
        $this->layout->meta(meta('Cache-control','no-cache'));
        $this->layout->meta(meta('pragma','no-cache'));

        $this->layout->css( array(
            'vendor/bootstrap/css/bootstrap.min',
            'vendor/metisMenu/metisMenu.min',
            'dist/sb-admin-2',
            'vendor/font-awesome/css/font-awesome.min'
        ));

        $this->layout->js(array(
            'css/vendor/jquery/jquery.min',
            'css/vendor/bootstrap/js/bootstrap.min',
            'css/vendor/metisMenu/metisMenu.min',
            'js/sb-admin-2'
        ));
        
        if($this->session->userdata('logged_in')) {
            redirect(base_url("dashboard"));
        }else {
            $this->layout->set(array('alert' => false));
            $this->layout->output();
        }
    }

    public function login(){
        $postData = $this->input->post();
        $validate = $this->authentication_model->validate_login($postData);
        if ($validate){
            $newdata = array(

                'email'     => $validate->email,
                'nome' => $validate->name,
                'perfil' => $validate->id_perfil,
                'telefone' => $validate->telefone,
                'id_user' => $validate->user_id,
                'logged_in' => TRUE,
              
            );
            $this->session->set_userdata($newdata);
            redirect(base_url("dashboard")); 
        }
        else{
            $this->layout->set(array('alert' => true));
            redirect(base_url());
        }
     
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }


}

/* End of file */
