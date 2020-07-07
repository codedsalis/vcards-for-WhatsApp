<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
@Package: Dashboard Controller
@Author: Talitu Ali Kadiri
*/

class Downloads extends CI_Controller {
       public function __construct()
   {
               parent::__construct();
  $this->load->model('Account/Login_model');
  $this->load->model('Account/Reg_model');
  $this->load->model('AdminModel');
  $this->load->model('DownloadModel');
}

	public function index() {
        $data['title'] = 'Downloads';
		
			$this->load->view('inc/Glob');
      $this->load->view('inc/header', $data);
			$this->load->view('downloads/index', $data);
      $this->load->view('inc/footer');
	}


  public function save() {
    $data['title'] = 'Save Download';

      $this->load->view('inc/Glob');
      $this->load->view('inc/header', $data);
			$this->load->view('downloads/save', $data);
      $this->load->view('inc/footer');
  }


}