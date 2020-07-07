<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
@Package: Account Controller
@Author: Talitu Ali Kadiri
*/

class Home extends CI_Controller {
       public function __construct()
   {
       parent::__construct();
       $this->load->model('Account/Login_model');
       $this->load->model('Account/Reg_model');
       $this->load->model('AccountModel');
    }


    public function index() {
        $data['title'] = 'Welcome';
		
		
        $this->load->view('inc/Glob');
        $this->load->view('inc/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('inc/footer');
	}



}