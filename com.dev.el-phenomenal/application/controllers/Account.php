<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
@Package: Account Controller
@Author: Talitu Ali Kadiri
*/

class Account extends CI_Controller {
       public function __construct()
   {
               parent::__construct();
    $this->load->model('Account/Login_model');
    $this->load->model('Account/Reg_model');
        $this->load->model('AccountModel');
}


//The admin panel main page
public function index() {
	$data['title'] = 'Admin Panel';
	$this->load->view('inc/Glob');
	$this->load->view('inc/header', $data);
	$this->load->view('account/index');
	$this->load->view('inc/footer');
}

//------------------------------------------------------------------------------------------

//Login controller method
  public function login() {

                  $data['title'] = "Login to Dashboard";

$this->load->view('inc/Glob');
 $this->load->view('inc/header', $data);
                  $this->load->view('account/login');
                  //$this->load->view('inc/footer');
 }

//------------------------------------------------------------------------------------------

//Registration controller method
  public function signup() {
  	$data['title'] = 'Account Registration';
             $type = isset($_GET['act']) ? $_GET['act'] : 2;
             
             //Influebtial marketers URL
             $im = $this->input->get('im');
             
        if($type > 2 || $type < 1) {
        	header("location: /");
        }   
            
   $this->load->view('inc/Glob');
$this->load->view('inc/header', $data);
   $this->load->view('account/reg');
                  //$this->load->view('inc/footer');
                 
	}

//---------------------------------------------------------------
public function logout() {
$this->session->unset_userdata('logged_in');
session_destroy();
set_cookie('username', '', 1);
set_cookie('id', '', 1);
$url = site_url('/account/login');

header("location: $url");
}


    public function tos() {
        $data['title'] = "Terms of Service";

        $this->load->view('inc/Glob');
        $this->load->view('inc/header', $data);
        $this->load->view('account/tos', $data);
        // $this->load->view('inc/footer');
    }


//---------------------------------------------------------------
//For forgotten password retrieval
public function fpass() {
	 $data['title'] = "Retrieve forgotten password";
	 
   $this->form_validation->set_rules( 'email', 'e-Mail Address', 'trim|strip_tags|required'); 
   
   if ($this->form_validation->run() === FALSE) {
   	$this->load->view('inc/Glob');
   	$this->load->view('inc/header', $data);
   	$this->load->view('account/fpass');
   	$this->load->view('inc/footer');
   	} else {
   		$this->Login_model->reviewForgottenPassword();
    	$this->load->view('inc/Glob');
    	$this->load->view('inc/header', $data);
    	$this->load->view('account/fpass');
    	$this->load->view('inc/footer');
    	}
}




//---------------------------------------------------------------
//For Changing the forgotten password
public function chpass() {
	$data['title'] = "Change Password";
	$uid = $this->input->get('vsp');
	
	if(!$uid) {
		show_404();
	}
	
	 $this->form_validation->set_rules( 'password', 'Password', 'required');
	 $this->form_validation->set_rules( 'passconf', 'Passconf', 'required|matches[password]');
   
   if ($this->form_validation->run() === FALSE) {
   	$this->load->view('inc/Glob');
   	$this->load->view('inc/header', $data);
   	$this->load->view('account/chpass');
   	$this->load->view('inc/footer');
   	} else {
   		$this->Login_model->changeForgottenPassword($uid);
    	$this->load->view('inc/Glob');
    	$this->load->view('inc/header', $data);
    	$this->load->view('account/chpass');
    	$this->load->view('inc/footer');
    	}
	
}



//---------------------------------------------------------------
public function resendemail() {
	$uid = $this->input->get('uid');
	if((!$uid) || ($this->AccountModel->checkActivatedUser($uid) == 1)) {
		show_404();
	}
	
	$data['title'] = 'Resend Verification Email';
	
	//Send the email again
	$this->AccountModel->resendVerificationEmail($uid);
	
	$this->load->view('inc/Glob');
	$this->load->view('inc/header', $data);
	$this->load->view('account/resendemail');
	$this->load->view('inc/footer');
}




}