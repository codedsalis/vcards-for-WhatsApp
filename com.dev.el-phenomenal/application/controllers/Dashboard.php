<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
@Package: Dashboard Controller
@Author: Talitu Ali Kadiri
*/

class Dashboard extends CI_Controller {
       public function __construct()
   {
               parent::__construct();
  $this->load->model('Account/Login_model');
  $this->load->model('Account/Reg_model');
  $this->load->model('AdminModel');
}

	public function index() {
    $data['title'] = 'Admin Dashboard';
    

    $data['contacts'] = $this->AdminModel->getContactsToday();
    $data['vcards'] = $this->AdminModel->getAllDownloads();
		
		
				$this->load->view('inc/Glob');
      $this->load->view('inc/header', $data);
				$this->load->view('dashboard/admin', $data);
      $this->load->view('inc/footer');
	}





}