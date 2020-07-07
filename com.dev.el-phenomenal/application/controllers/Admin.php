<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
@Package: Admin Controller
@Author: Talitu Ali Kadiri
*/

class Admin extends CI_Controller {
       public function __construct()
   {
               parent::__construct();
  $this->load->model('AdminModel');
  $this->load->model('Account/Reg_model');
  $this->load->model('PublisherModel');
$this->load->model('AdvertiserModel');
}

//-------------------------------------------------------------------------------

public function advertisers() {
		$data['title'] = 'All Registered Advertisers';
		
	$this->load->view('inc/Glob');
	$data['advertisers'] = $this->AdminModel->getAllAdvertisers();
    $this->load->view('inc/header', $data);
    $this->load->view('admin/advertisers');
    $this->load->view('inc/footer');
}



//-------------------------------------------------------------------------------

public function publishers() {
	$data['title'] = 'All Registered Publishers';
		
	$this->load->view('inc/Glob');
	$data['active'] = $this->AdminModel->getAllActivePublishers();
		$data['inactive'] = $this->AdminModel->getAllInactivePublishers();
			$data['blocked'] = $this->AdminModel->getAllBlockedPublishers();
			
    $this->load->view('inc/header', $data);
    $this->load->view('admin/publishers');
    $this->load->view('inc/footer');
}


//-------------------------------------------------------------------------------
public function blockedpubs() {
	$data['title'] = 'All Blocked Publishers';
	
	$this->load->view('inc/Glob', $data);
	
		$data['blocked'] = $this->AdminModel->getAllBlockedPublishers();
	
	$this->load->view('inc/header', $data);
    $this->load->view('admin/blockedpubs');
    $this->load->view('inc/footer');
}



//-------------------------------------------------------------------------------

public function affectedpubs() {
	$data['title'] = 'All Affected Publishers';
		
		
		//Pagination settings
$limit = 20;
$page = isset($_REQUEST['page']) && (ctype_digit($_REQUEST['page'])) && ($_REQUEST['page'] > 0) ? intval($_REQUEST['page']) : 1;
$start = isset($_REQUEST['page']) ? $page * $limit - $limit : (isset($_GET['start']) ? abs(intval($_GET['start'])) : 0);


$data['page'] = $page;
$data['limit'] = $limit;
$data['start'] = $start;
     
		
	$this->load->view('inc/Glob');
	
	     $data['rows'] = $this->AdminModel->getAllAffectedPublishers($start, $limit, TRUE);
      $data['affected'] = $this->AdminModel->getAllAffectedPublishers($start, $limit);
			
    $this->load->view('inc/header', $data);
    $this->load->view('admin/affectedpubs');
    $this->load->view('inc/footer');
}


//-------------------------------------------------------------------------------

public function viewpublisher() {
	$pid = $this->input->get('pid');
	
	$data['title'] = 'View Publisher stats';
		
	$this->load->view('inc/Glob');
	$data['stats'] = $this->PublisherModel->getPublisherById($pid);
    $this->load->view('inc/header', $data);
    $this->load->view('admin/viewpublisher');
    $this->load->view('inc/footer');
	
}



//-------------------------------------------------------------------------------

public function viewadvertiser() {
	$aid = $this->input->get('aid');
	
	$data['title'] = 'View Advertiser stats';
		
	$this->load->view('inc/Glob');
	$data['stats'] = $this->AdvertiserModel->getAdvertiserById($aid);
    $this->load->view('inc/header', $data);
    $this->load->view('admin/viewadvertiser');
    $this->load->view('inc/footer');
	
}


//-------------------------------------------------------------------------------

public function notifications() {
	
	$data['title'] = 'Notifications';
		
	
	$this->load->view('inc/Glob');
    $this->load->view('inc/header', $data);
    $this->load->view('admin/notifications');
    $this->load->view('inc/footer');
	
}


//-------------------------------------------------------------------------------
public function adverts() {
	
	$data['title'] = 'All Adverts/Campaigns';
		
	
	$this->load->view('inc/Glob');
    $this->load->view('inc/header', $data);
    $data['adverts'] = $this->AdminModel->getAllAdverts();
    $data['running'] = $this->AdminModel->getAllRunningAds();
      $data['pending'] = $this->AdminModel->getAllPendingApprovalAds();
        $data['suspended'] = $this->AdminModel->getAllSuspendedAds();
          $data['incomplete'] = $this->AdminModel->getAllIncompleteAds();
            $data['disapproved'] = $this->AdminModel->getAllDisapprovedAds();
    
    $this->load->view('admin/alladverts', $data);
    $this->load->view('inc/footer');
	
}

	
//------------------------------------------------------------------------------------------

public function supports() {
	$ticket = $this->input->get('ticket');
	$data['title'] = 'Support Tickets';
	
	
	
	if($ticket) {
		$data['support'] = $this->AdvertiserModel->getSupportById($ticket);
		$data['responses'] = $this->AdvertiserModel->getSupportResponsesById($ticket);
	}
	
	
	 $this->form_validation->set_rules( 'message', 'Message','required', array( 'required' => 'You have not provided the %s.') );
	 
	 if ($this->form_validation->run() === FALSE) {
    $this->load->view('inc/Glob');
    $data['supports'] = $this->AdminModel->getAllSupports();
    
    $this->load->view('inc/header', $data);
    $this->load->view('admin/supports');
    $this->load->view('inc/footer');
   }
  else {
     $data['title'] = "Ticket Responded to";
     $data['supports'] = $this->AdminModel->getAllSupports();
     
    $this->AdminModel->saveTicketResponse();
   $this->load->view('inc/Glob');
   $this->load->view('inc/header', $data);
   $this->load->view('admin/supports');
   $this->load->view('inc/footer');
     	}
	
}


	
//------------------------------------------------------------------------------------------
public function tasks() {
	  $data['title'] = "All Tasks";
     $data['tasks'] = $this->AdminModel->getAllTasks();
     
   $this->load->view('inc/Glob');
   $this->load->view('inc/header', $data);
   $this->load->view('admin/tasks');
   $this->load->view('inc/footer');
}


	
//------------------------------------------------------------------------------------------
public function sites() {
	  $data['title'] = "All Sites";
     $data['sites'] = $this->AdminModel->getAllSites();
     $data['pending'] = $this->AdminModel->getAllVerifiedSites();
     $data['approved'] = $this->AdminModel->getAllApprovedSites();
     $data['unverified'] = $this->AdminModel->getAllUnverifiedSites();
     $data['unapproved'] = $this->AdminModel->getAllUnapprovedSites();
     
   $this->load->view('inc/Glob');
   $this->load->view('inc/header', $data);
   $this->load->view('admin/sites');
   $this->load->view('inc/footer');
}







}