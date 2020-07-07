<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
@Package: Ajax Controller
@Author: Talitu Ali Kadiri
*/

class Ajax extends CI_Controller {
    public function __construct()
   {
    parent::__construct();
	$this->load->model('ContactModel');
	$this->load->model('AccountModel');
	$this->load->model('Account/Reg_model');
	$this->load->model('Account/Login_model');
}


//-----------------------------------------------------------------

  public function login() {
                   $this->form_validation->set_rules( 'username', 'e-Mail or Username', 'trim|strip_tags|required');
                $this->form_validation->set_rules('password', 'Password', 'required'); 
                   if ($this->form_validation->run() === FALSE)
                 {
                  $this->load->view('ajax/signin');
}
           else
           {
         $this->Login_model->review_login();
                  $this->load->view('ajax/signin');
       }
 }
 
 
 //-----------------------------------------------------------------
//Registration controller method
  public function newuser() {
  	$data['title'] = 'New Account Registration';
                   $this->form_validation->set_rules( 'username', 'Username', 'trim|alpha_numeric|strip_tags|required|min_length[4]|max_length[14]|is_unique[users.username]', array( 'required' => 'You have not provided a %s.', 'is_unique' => 'This %s already exists.' ) ); 
                  $this->form_validation->set_rules('password', 'Password', 'required'); 
                  $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]'); 
                  $this->form_validation->set_rules('email', 'e-mail Address', 'required|valid_email|is_unique[users.email]', array( 'required' => 'You have not provided an %s.', 'is_unique' => 'A user with this e-Mail address already exists.' ) );
                  
$this->form_validation->set_rules( 'first_name', 'First name', 'trim|alpha|strip_tags|required|min_length[3]|max_length[15]', array( 'required' => 'You have not provided your %s.') ); 

$this->form_validation->set_rules( 'last_name', 'Last name', 'trim|alpha|strip_tags|required|min_length[3]|max_length[15]', array( 'required' => 'You have not provided your %s.') );


        if ($this->form_validation->run() === FALSE) 
                 {
                  $this->load->view('ajax/signup', $data);
                 }
                 else
                  {
                   $data['title'] = "Account created";
     $this->Reg_model->saveNewUser($type);
   $this->load->view('ajax/signup', $data);
                 }
                 
	}

//-------------------------------------------------------------------------------


public function entry() {
	$name = $this->input->post('name');
	$number = $this->input->post('number');
	$type = $this->input->post('type');
	$key = $this->input->post('key');

	if(!$name || !$number || !$type || !$key) {
		show_404();
	}

	$this
	->form_validation
	->set_rules('name', 'Name', 'trim|strip_tags|required', array( 'required' => 'You have not provided your %s.'));

	$this
	->form_validation
	->set_rules('number', 'Phone number', 'trim|strip_tags|numeric|required|max[11]', array( 'required' => 'You have not provided your %s.'));

	if ($this->form_validation->run() === FALSE) 
        {
        	$this->load->view('ajax/entry');
        }
        else
        {
            $data['title'] = "Success";
     		$this->ContactModel->saveNewContact();
   			$this->load->view('ajax/entry', $data);
        }

}


public function verifypayment() {
  $passKey = $this->input->post('key');

  if(!$passKey) {
    show_404();
  }

  $this->ContactModel->verifyPayment($passkey);
  $this->load->view('ajax/verifypayment');
}

}