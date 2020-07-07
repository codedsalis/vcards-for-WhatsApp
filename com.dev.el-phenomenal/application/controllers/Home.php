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
        $data['title'] = 'Wassapviews - Get more Whatsapp status views';
		
		
        $this->load->view('inc/Glob');
        $this->load->view('inc/header', $data);
        $this->load->view('home/index', $data);
        // $this->load->view('inc/footer');
    }
    

    public function entrysuccess() {
        $key = $this->input->get('key');

        if(!$key) {
            show_404();
        }

        $data['title'] = "Details successfully saved";
        $data['key'] = $key;

        $this->load->view('inc/Glob');
        $this->load->view('inc/header', $data);
        $this->load->view('home/entrysuccess', $data);
        $this->load->view('inc/footer');
    }



    public function payment() {
        $key = $this->input->get('key');

        if(!$key) {
            show_404();
        }

        $data['key'] = $key;
        $data['title'] = "Payment";

        $this->load->view('inc/Glob');
        $this->load->view('inc/header', $data);
        $this->load->view('home/payment', $data);
        $this->load->view('inc/footer');
    }

    public function installation() {
        $data['title'] = "How to install the VCF file";

        $this->load->view('inc/Glob');
        $this->load->view('inc/header', $data);
        $this->load->view('home/installation', $data);
        $this->load->view('inc/footer');
    }

}