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
  $this->load->model('PublisherModel');
  $this->load->model('AdminModel');
  $this->load->model('AdvertiserModel');  $this->load->model('AccountModel');
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
             $type = $this->input->post('act');
             
        if($type > 2 || $type < 1) {
        	header("location: /");
        }   
                   $this->form_validation->set_rules( 'username', 'Username', 'trim|alpha_numeric|strip_tags|required|min_length[4]|max_length[14]|is_unique[dbusers.username]', array( 'required' => 'You have not provided a %s.', 'is_unique' => 'This %s already exists.' ) ); 
                  $this->form_validation->set_rules('password', 'Password', 'required'); 
                  $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]'); 
                  $this->form_validation->set_rules('email', 'e-mail Address', 'required|valid_email|is_unique[dbusers.email]', array( 'required' => 'You have not provided an %s.', 'is_unique' => 'A user with this e-Mail address already exists.' ) );
                  
$this->form_validation->set_rules( 'first_name', 'First name', 'trim|alpha|strip_tags|required|min_length[3]|max_length[15]', array( 'required' => 'You have not provided your %s.') ); 

$this->form_validation->set_rules( 'last_name', 'Last name', 'trim|alpha|strip_tags|required|min_length[3]|max_length[15]', array( 'required' => 'You have not provided your %s.') );


//$this->form_validation->set_rules( 'website', 'Website URL', 'trim|strip_tags|min_length[9]|max_length[50]' );


$this->form_validation->set_rules( 'country', 'Country', 'trim|strip_tags|required|min_length[3]|max_length[35]', array( 'required' => 'You have not provided your %s.') );

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


	public function profile() {
		$data['title'] = 'Profile Settings';
		
		$uid = $this->input->get('uid');
		
    $this->form_validation->set_rules('password', 'Password'); 
    $this->form_validation->set_rules('passconf', 'Password Confirm');
    $this->form_validation->set_rules( 'fullname', 'Full Name', 'trim|strip_tags|required|min_length[7]|max_length[17]', array( 'required' => 'You have not provided your %s.') );
    $this->form_validation->set_rules( 'accountno', 'Account Number', 'trim|numeric|strip_tags|required|min_length[9]|max_length[15]', array( 'required' => 'You have not provided your %s.') );
    $this->form_validation->set_rules( 'bank', 'Bank Name', 'trim|strip_tags|required', array( 'required' => 'You have not provided your %s.') );
    $this->form_validation->set_rules( 'phone', 'Phone Number', 'trim|numeric|strip_tags|required|min_length[9]|max_length[15]', array( 'required' => 'You have not provided your %s.') );
    
    //$this->form_validation->set_rules( 'website', 'Website URL', 'trim|strip_tags|required|min_length[14]|max_length[50]', array( 'required' => 'You have not provided your %s.') );
   
    $this->form_validation->set_rules( 'country', 'Country', 'trim|alpha|strip_tags|required|min_length[3]|max_length[25]', array( 'required' => 'You have not provided your %s.') );

        if ($this->form_validation->run() === FALSE) {
    $this->load->view('inc/Glob');
    $this->load->view('inc/header', $data);
    $this->load->view('publisher/profile');
    $this->load->view('inc/footer');
   }
  else {
     $data['title'] = "Profile Updated";
    $this->Reg_model->updateUser($uid);
   $this->load->view('inc/Glob');
   $this->load->view('inc/header', $data);
   $this->load->view('publisher/profile');
   $this->load->view('inc/footer');
     	}
                 
		}
	
	
	
//-------------------------------------------------------------------------------

public function adunits() {
	$data['title'] = "Ad Units";
	
	$uid = $this->input->get('uid');
	
	
	$data['units'] = $this->PublisherModel->listAdUnits($uid);
   $this->load->view('inc/Glob');
   $this->load->view('inc/header', $data);
   $this->load->view('publisher/adunits');
   $this->load->view('inc/footer');
}
		
	
//-------------------------------------------------------------------------------

	public function newadunit() {
	$data['title'] = "Create new Ad Unit";
	
	$uid = $this->input->post('uid');
	
	//FORM VALIDATION BEGINS
	$this->form_validation->set_rules('title', 'Title of unit', 'trim|strip_tags|min_length[3]|required', array( 'required' => 'You have not provided your %s.') );
	$this->form_validation->set_rules('url', 'Website URL', 'required|min_length[5]', array( 'required' => 'You have not provided your %s, if you have not added your sites, <a href="' . site_url('/publisher/sites?uid=' . $uid) . '">Click here to get started</a>') );
    $this->form_validation->set_rules('type', 'Type of Ad', 'trim|strip_tags|required', array( 'required' => 'You have not selected any %s.') );
    
    //FORM VALIDATION ENDS
    
    
   if ($this->form_validation->run() === FALSE) {
   $this->load->view('ajax/newadunit', $data);
   }
  else {
     $data['title'] = "Ad Unit Created";
    $this->PublisherModel->saveNewAdUnit($uid);
   $this->load->view('ajax/newadunit', $data);
     	}
}
		
	
//-------------------------------------------------------------------------------

	public function editadunit() {
	$data['title'] = "Edit Ad Unit";
	
	$uid = $this->input->post('uid');
	
	//FORM VALIDATION BEGINS
	$this->form_validation->set_rules('title', 'Title of unit', 'trim|strip_tags|min_length[3]|required', array( 'required' => 'You have not provided your %s.') );
	$this->form_validation->set_rules('url', 'Website URL', 'required|min_length[5]', array( 'required' => 'You have not provided your %s, if you have not added your sites, <a href="' . site_url('/publisher/sites?uid=' . $uid) . '">Click here to get started</a>') );
    $this->form_validation->set_rules('type', 'Type of Ad', 'trim|strip_tags|required', array( 'required' => 'You have not selected any %s.') );
    
    //FORM VALIDATION ENDS
    
    
   if ($this->form_validation->run() === FALSE) {
   $this->load->view('ajax/editadunit', $data);
   }
  else {
     $data['title'] = "Changes Saved";
    $this->PublisherModel->editAdUnit($uid);
   $this->load->view('ajax/editadunit', $data);
     	}
}

	
//-------------------------------------------------------------------------------

public function delPublisher() {
	$pid = $this->input->post('pid');
	
	$this->PublisherModel->deletePublisherById($pid);
	
	$this->load->view('ajax/delpublisher');
}


	
//-------------------------------------------------------------------------------
public function listpublishers() {
	$data['publishers'] = $this->AdminModel->getAllPublishers();
    $this->load->view('ajax/listpublishers', $data);
}





	
//-------------------------------------------------------------------------------

public function deladvertiser() {
	$aid = $this->input->post('aid');
	
	$this->AdvertiserModel->deleteAdvertiserById($aid);
	
	$this->load->view('ajax/deladvertiser');
}


	
//-------------------------------------------------------------------------------
public function listadvertisers() {
	$data['advertisers'] = $this->AdminModel->getAllAdvertisers();
    $this->load->view('ajax/listadvertisers', $data);
}



//-------------------------------------------------------------------------------
public function requestpayment() {
	$uid = $this->input->post('uid');
	
     $data['title'] = "Request sent";
     
    $this->PublisherModel->sendPaymentRequest($uid);
   $this->load->view('ajax/requestpayment', $data);
}



//------------------------------------------------------------------------------------------
public function setcurrency() {
	$username = $this->input->post('adv');
	
	if(!$username) {
		show_404();
	}
	
	$this->AdvertiserModel->saveCurrency($username);
}


//------------------------------------------------------------------------------------------
  public function newadplacement() {  
  $username = $this->input->post('username');
  
  $format = $this->input->post('format');
  
  if(!$format) {
  	show_404();
  }
  
  $user = $this->UserInfo->getUserInfo($username);
  
  // $minBudget = $this->widgets->toCurrencyNoSign(5400, $user['country']);
  
   $this->form_validation->set_rules( 'title', 'Ad Title', 'trim|strip_tags|required|min_length[4]', array( 'required' => 'You have not provided an %s.') ); 
    $this->form_validation->set_rules('url', 'Destination Link', 'required|valid_url|strip_tags|trim');
    $this->form_validation->set_rules('description', 'Description', 'strip_tags|trim|required|max_length[100]', array( 'required' => 'You have not provided a %s of your ad' ) );
    $this->form_validation->set_rules('subtext', 'Sub Text', 'strip_tags|trim|required|max_length[30]', array( 'required' => 'You have not provided a %s for your ad configuration' ) );
    $this->form_validation->set_rules('actnbtn', 'Action Button', 'strip_tags|trim|required|max_length[12]', array( 'required' => 'You have not provided a text for your ad %s' ) );

                  
$this->form_validation->set_rules( 'country', 'Target Country', 'trim|strip_tags|required', array( 'required' => 'You have not provided your %s.') );
     	
     	
     	if($user['currency'] == 'NGN') {
     		$this->form_validation->set_rules('cpi', 'Cost Per Click', 'trim|strip_tags|required|min_length[1]|greater_than_equal_to[10]', array('required' => 'Please enter your budgetted %s.'));
     	}	
     	elseif($user['currency'] == 'USD') {
     		$this->form_validation->set_rules('cpi', 'Cost Per Click', 'trim|strip_tags|required|min_length[1]|greater_than_equal_to[0.028]', array('required' => 'Please enter your budgetted %s.'));
     	}
       
       if($user['currency'] == 'NGN') {
       $this->form_validation->set_rules('budget', 'Campaign Budget', 'trim|strip_tags|required|min_length[2]|greater_than_equal_to[500]', array('required' => 'Please enter your budget for this Campaign.', 'greater_than_equal_to' => 'The minimum budget for a campaign is &#8358;500'));	
       }	
       elseif($user['currency'] == 'USD') {
       $this->form_validation->set_rules('budget', 'Campaign Budget', 'trim|strip_tags|required|min_length[2]|greater_than_equal_to[1.39]', array('required' => 'Please enter your budget for this Campaign.', 'greater_than_equal_to' => 'The minimum budget for a campaign is $1.39'));	
       }	
       
       
       if($user['currency'] == 'NGN') {
       $this->form_validation->set_rules('dailybudget', 'Daily Budget', 'trim|strip_tags|required|min_length[2]|greater_than_equal_to[100]', array('required' => 'Please enter your daily budget for this Campaign.', 'greater_than_equal_to' => 'The minimum daily budget for a campaign is &#8358;100'));	
       }	
       elseif($user['currency'] == 'USD') {
       $this->form_validation->set_rules('dailybudget', 'Daily Budget', 'trim|strip_tags|required|min_length[2]|greater_than_equal_to[0.28]', array('required' => 'Please enter your daily budget for this Campaign.', 'greater_than_equal_to' => 'The minimum daily budget for a campaign is $0.28'));	
       }	
       
       

       if ($this->form_validation->run() === FALSE) 
                 {

                  $this->load->view('ajax/newadplacement');
                 
                 }
                 else
                  {
     $this->AdvertiserModel->saveNewAdPlacement($username);

   $this->load->view('ajax/newadplacement2');
                 
                 }
                 
	}

//....................................................................................................................................................
public function editcampaign() {
	$token = $this->input->post('token');
	$intent = $this->input->post('intent');

	if(!$token || !$intent) {
		show_404();
	}

	$this->form_validation->set_rules( 'title', 'Ad Title', 'trim|strip_tags|required|min_length[4]', array( 'required' => 'You have not provided an %s.') );
	$this->form_validation->set_rules( 'country', 'Target Country', 'trim|strip_tags|required', array( 'required' => 'You have not provided your %s.') );
	$this->form_validation->set_rules('budget', 'Campaign Budget', 'trim|strip_tags|required|min_length[2]|greater_than_equal_to[10]', array('required' => 'Please enter your budget for this Campaign.', 'greater_than_equal_to' => 'The minimum budget for a campaign is $10'));

	if($intent == 'ppc') {
		$this->form_validation->set_rules('cpi', 'Cost Per Click', 'trim|strip_tags|required|min_length[1]|greater_than_equal_to[0.1]', array('required' => 'Please enter your budgetted %s.'));
	}
	elseif($intent == 'ppm') {
		$this->form_validation->set_rules('cpi', 'Cost Per Thousand Impressuons', 'trim|strip_tags|required|min_length[1]|greater_than_equal_to[1.5]', array('required' => 'Please enter your budgetted %s.'));
	}
	elseif($intent == 'ppa') {
		$this->form_validation->set_rules('cpi', 'Cost Per Action', 'trim|strip_tags|required|min_length[1]|greater_than_equal_to[0.06]', array('required' => 'Please enter your budgetted %s.'));
	}


	if ($this->form_validation->run() === FALSE) 
                 {

                  $this->load->view('ajax/editcampaign');
                 
                 }
                 else
                  {
     $this->AdvertiserModel->saveEditedCampaign($token);

   $this->load->view('ajax/editcampaign');
                 
                 }
}


//....................................................................................................................................................
	public function editconf() {
		 $token = $this->input->post('token');

		if((!$token)) {
			show_404();
		}
		

		$this->form_validation->set_rules('url', 'Destination Link', 'required|valid_url|strip_tags|trim');
    $this->form_validation->set_rules('description', 'Description', 'strip_tags|trim|required|max_length[100]', array( 'required' => 'You have not provided a %s of your ad' ) );
    $this->form_validation->set_rules('subtext', 'Sub Text', 'strip_tags|trim|required|max_length[30]', array( 'required' => 'You have not provided a %s for your ad configuration' ) );
    $this->form_validation->set_rules('actnbtn', 'Action Button', 'strip_tags|trim|required|max_length[12]', array( 'required' => 'You have not provided a text for your ad %s' ) );

    if ($this->form_validation->run() === FALSE) 
                 {
                  $this->load->view('ajax/editconf');
                 }
                 else
                  {
     $this->AdvertiserModel->saveAdConfiguration($token);

   $this->load->view('ajax/editconf');
                 
                 }


	}
	
	
	
//....................................................................................................................................................
	public function updatead() {
		 $token = $this->input->post('token');
		 
		 $url = $this->input->post('url');
		 $field = $this->input->post('field');
		 
		if((!$token)) {
			show_404();
		}
		
		
		if($field == 'url') {
			$this->form_validation->set_rules('url', 'Destination Link', 'required|valid_url|strip_tags|trim');
		}
		elseif($field == 'title') {
			$this->form_validation->set_rules('title', 'Advert name/title', 'required|strip_tags|trim');
		}
		elseif($field == 'subtext') {
			$this->form_validation->set_rules('subtext', 'Sub Text', 'strip_tags|trim|required|max_length[30]', array( 'required' => 'You have not provided a %s for your ad configuration' ) );
		}
		elseif($field == 'actnbtn') {
			$this->form_validation->set_rules('actnbtn', 'Action Button', 'strip_tags|trim|required|max_length[12]', array( 'required' => 'You have not provided a text for your ad %s' ) );
		}
		elseif($field == 'description') {
			$this->form_validation->set_rules('description', 'Description', 'strip_tags|trim|required', array( 'required' => 'You have not provided a %s of your ad' ));
		}
		elseif($field == 'target_keywords') {
			$this->form_validation->set_rules('target_keywords', 'Target keywords', 'strip_tags|trim|required', array( 'required' => 'You have not provided any %s for your ad'));
		}
		elseif($field == 'targetCountry') {
			$this->form_validation->set_rules('targetCountry', 'Target Country', 'strip_tags|trim|required');
		}
		elseif($field == 'targetPlatform') {
			$this->form_validation->set_rules('targetPlatform', 'Target Platform', 'strip_tags|trim|required');
		}
		elseif($field == 'target_categories') {
			$this->form_validation->set_rules('target_categories', 'Target website categories', 'strip_tags|trim|required');
		}
		
    
    if ($this->form_validation->run() === FALSE) 
                 {
                  $this->load->view('ajax/editconf');
                 }
                 else
                  {
     $this->AdvertiserModel->saveAdConfiguration($token, $field);

   $this->load->view('ajax/editconf');
                 
                 }


	}
	
	
	


//------------------------------------------------------------------------------------------
public function savepayment() {
	$username = $this->input->post('advertiser');

	if(!$username) {
		show_404();
	}

	$this->form_validation->set_rules('amount', 'Amount', 'trim|strip_tags|required|min_length[1]|max_length[10]', array('required' => 'Please enter the %s you want to deposit!'));
  
  if ($this->form_validation->run() === FALSE) 
                 {

                  $this->load->view('ajax/savepayment');
                 
                 }
                 else
                  {
     $this->AdvertiserModel->savePayment($username);

   $this->load->view('ajax/savepayment');
                 }
}




//------------------------------------------------------------------------------------------
public function fundaccount() {
	$uid = $this->input->post('advertiser');

	if(!$uid) {
		show_404();
	}

	$this->form_validation->set_rules('amount', 'Amount', 'trim|strip_tags|required|min_length[1]|max_length[10]', array('required' => 'Please enter the %s you want to fund account with!'));
  
  if ($this->form_validation->run() === FALSE) 
                 {

                  $this->load->view('ajax/fundaccount');
                 
                 }
                 else
                  {
     $this->AdminModel->fundAccount($uid);

   $this->load->view('ajax/fundaccount');
                 }
}


//------------------------------------------------------------------------------------------
public function savetext() {
	$token = $this->input->post('token');
  
  if(!$token) {
  	show_404();
  }
  
  $this->form_validation->set_rules('text', 'Campaign text', 'trim|strip_tags|required|min_length[1]|max_length[120]', array('required' => 'Please enter your %s.'));
  
  if ($this->form_validation->run() === FALSE) 
                 {

                  $this->load->view('ajax/savetext');
                 
                 }
                 else
                  {
     $this->AdvertiserModel->saveCampaignText($token);

   $this->load->view('ajax/savetext');
                 }
  
  
}



//------------------------------------------------------------------------------------------
  public function campaignbudget() {  
  $token = $this->input->post('token');
  $vsp = $this->input->post('vsp');
  //$eck = $this->input->post('eck');
  
   $this->form_validation->set_rules( 'amount', 'Budget Amount', 'trim|strip_tags|required|min_length[4]', array( 'required' => 'Please enter %s.') ); 
    $this->form_validation->set_rules('duration', 'Campaign Duration', 'required');
    $this->form_validation->set_rules('audience', 'Audience reached', 'required');
    
       if ($this->form_validation->run() === FALSE) 
                 {

                  $this->load->view('ajax/campaignbudget');
                 
                 }
                 else
                  {
                   $data['title'] = "Success";
     $this->AdvertiserModel->saveCampaignPlan($token);

   $this->load->view('ajax/campaignbudget');
                 
                 }
                 
	}



//------------------------------------------------------------------------------------------
public function addjob() {
	
	$this->AdminModel->addJob();
	 $this->load->view('ajax/addjob');
}




//------------------------------------------------------------------------------------------
public function setstatus() {
	$act = $this->input->post('act');
	$aid = $this->input->post('aid');
	
	
	$this->AdminModel->setStatus($act, $aid);
	 $this->load->view('ajax/setstatus');
}


//------------------------------------------------------------------------------------------
public function compileearnings() {
	$pid = $this->input->post('pid');
	if(!$pid) {
		show_404();
	}
	
	
	$data['compiledEarnings'] = $this->AdminModel->getAffectedClickEarnings($pid);
	 $this->load->view('ajax/compiledearnings', $data);
}



//------------------------------------------------------------------------------------------
public function loadcurrentearnings() {
	$pid = $this->input->post('pid');
	$currency = $this->input->post('currency');
	
	if(!$pid || !$currency) {
		show_404();
	}
	
	$data['currentEarnings'] = $this->widgets->toCurrency($currency, $this->UserInfo->compileEarningAllCurrent($pid), 'NGN', 1);
	$this->load->view('ajax/currentearnings', $data);
}



//------------------------------------------------------------------------------------------
public function loadlastmonthearnings() {
	$pid = $this->input->post('pid');
	$currency = $this->input->post('currency');
	
	if(!$pid || !$currency) {
		show_404();
	}
	
	$data['lastMonthEarnings'] = $this->widgets->toCurrency($currency, $this->UserInfo->compileEarningLastMonth($pid), 'NGN', 1);
	$this->load->view('ajax/lastmonthearnings', $data);
}



//------------------------------------------------------------------------------------------
public function loadthismonthearnings() {
	$pid = $this->input->post('pid');
	$currency = $this->input->post('currency');
	
	if(!$pid || !$currency) {
		show_404();
	}
	
	
		$data['thisMonthEarnings'] = $this->widgets->toCurrency($currency, $this->UserInfo->compileEarningThisMonth($pid), 'NGN', 1);
	$this->load->view('ajax/thismonthearnings', $data);
}



//------------------------------------------------------------------------------------------
public function loadalltimeearnings() {
	$pid = $this->input->post('pid');
	$currency = $this->input->post('currency');
	
	if(!$pid || !$currency) {
		show_404();
	}
	
	$data['allTimeEarnings'] = $this->widgets->toCurrency($currency, $this->UserInfo->compileEarningAllTime($pid), 'NGN', 1);
	$this->load->view('ajax/alltimeearnings', $data);
}



//------------------------------------------------------------------------------------------
public function delSupport() {
	$sid = $this->input->post('sid');
	if(!$sid) {
		echo show_404();
	}
	else {
		$this->AdvertiserModel->deleteSupportById($sid);
		 $this->load->view('ajax/delsupport');
	}
}


//------------------------------------------------------------------------------------------
public function newsite() {
	$uid = $this->input->post('uid');
	
	/*if(!$uid) {
		echo show_404();
	}
	else {*/
		$this->form_validation->set_rules( 'url', 'Site URL', 'trim|strip_tags|required|min_length[7]|valid_url', array( 'required' => 'You have not provided any %s.') );

		if ($this->form_validation->run() === FALSE) 
                 {

                  $this->load->view('ajax/newsite');
                 }
                 else {
                 	$this->PublisherModel->newSite($uid);
	 $this->load->view('ajax/newsite');
	//}
                 }
		
	
}


//------------------------------------------------------------------------------------------
public function mysites() {
		$data['title'] = "My Sites";
		
		$uid = $this->input->get('uid');
		   $this->load->view('inc/Glob', $data);
   $data['sites'] = $this->PublisherModel->getSitesByUid($uid);
   $this->load->view('ajax/mysites', $data);
}

//-------------------------------------------------------------------------------

public function disapprovesite() {
	$sid = $this->input->post('sid');
	
	$this->AdminModel->disapproveSiteById($sid);
	
	$this->load->view('ajax/disapprovesite');
}
	
//-------------------------------------------------------------------------------
public function approvesite() {
	$sid = $this->input->post('sid');
	
	$this->AdminModel->approveSiteById($sid);
	
	$this->load->view('ajax/approvesite');
}


//------------------------------------------------------------------------------------------
public function editsite() {
	$uid = $this->input->post('uid');
		$sid = $this->input->post('sid');
	
	/*if(!$uid) {
		echo show_404();
	}
	else {*/
		$this->PublisherModel->editSite($uid, $sid);
	 $this->load->view('ajax/editsite');
	//}
	
}




//------------------------------------------------------------------------------------------
public function deletesite() {
	$uid = $this->input->post('uid');
		$sid = $this->input->post('sid');
	
	if(!$uid || !$sid) {
		echo show_404();
	}
	
		$this->PublisherModel->deleteSite($uid, $sid);
	 $this->load->view('ajax/deletesite');
	
}




//------------------------------------------------------------------------------------------
public function deleteadunit() {
	$uid = $this->input->post('uid');
		$auid = $this->input->post('auid');
	
	if(!$uid || !$auid) {
		echo show_404();
	}
	
		$this->PublisherModel->deleteAdUnit($uid, $auid);
	 $this->load->view('ajax/deleteadunit');
	
}



//-------------------------------------------------------------------------------

public function blockpublisher() {
	$uid = $this->input->post('uid');
	
	if(!$uid) {
		echo show_404();
	}
	
	$this->AdminModel->blockUser($uid);
	
	$this->load->view('ajax/blockpublisher');
}



//-------------------------------------------------------------------------------

public function unblockpublisher() {
	$uid = $this->input->post('uid');
	
	if(!$uid) {
		echo show_404();
	}
	
	$this->AdminModel->unblockUser($uid);
	
	$this->load->view('ajax/unblockpublisher');
}



//-------------------------------------------------------------------------------

public function setearning() {
	$uid = $this->input->post('uid');
	$amount = $this->input->post('amount');
	
	if(!$uid) {
		echo show_404();
	}
	
	$this->AdminModel->setEarning($uid, $amount);
	
	$this->load->view('ajax/setearning');
}



//-------------------------------------------------------------------------------

public function setcpc() {
	$aid = $this->input->post('aid');
	$cpc = $this->input->post('cpc');
	
	if((!$aid) || (!$cpc)) {
		echo show_404();
	}
	
	if($this->AdvertiserModel->setCpc($aid, $cpc) == 1) {
		$data['type'] = 1;
		$this->load->view('ajax/setcpc', $data);
	}
	else {
		$data['type'] = 0;
		$this->load->view('ajax/setcpc', $data);
	}
}


//-------------------------------------------------------------------------------

public function setduration() {
	$aid = $this->input->post('aid');
	$duration = $this->input->post('duration');
	
	if((!$aid) || (!$duration)) {
		echo show_404();
	}
	
	if($this->AdvertiserModel->setDuration($aid, $duration) == 1) {
		$data['type'] = 1;
		$this->load->view('ajax/setduration', $data);
	}
	else {
		$data['type'] = 0;
		$this->load->view('ajax/setduration', $data);
	}
}


//-------------------------------------------------------------------------------

public function setbudget() {
	$aid = $this->input->post('aid');
	$budget = $this->input->post('budget');
	$type = $this->input->post('type');
	
	if((!$aid) || (!$budget) || (!$type)) {
		echo show_404();
	}
	
	if($this->AdvertiserModel->setBudget($aid, $budget, $type) == 1) {
		$data['type'] = 1;
		$this->load->view('ajax/setbudget', $data);
	}
	else {
		$data['type'] = 0;
		$this->load->view('ajax/setbudget', $data);
	}
}


//---------------------------------------------------------------
public function getimrefs() {
	$im = $this->input->get('im');
	
	if(!$im) {
		show_404();
	}
	
	$data['refs'] = $this->AccountModel->getImRefs($im);
	
	$this->load->view('ajax/getimrefs', $data);
}

	
//------------------------------------------------------------------------------------------
public function upload() {
	$token = $this->input->get('token');
	$vsp = $this->input->get('vsp');
		$data['ads'] = $this->AdvertiserModel->getAdByToken($token);
		$bannerType = $this->input->get('bannertype'); //eg image_one, image_two, etc

	
	if(!$token || !$vsp || !$bannerType || ($this->AdvertiserModel->checkToken($token) === FALSE)) {
		show_404();
	}
  
   	
   	// 	$split = explode('_', $bannerType);
   	// $width = $split[0];
   	// $height = $split[1];
   	
   	// //Make the maximum width and height to be twice the ones of the actual image resolution type
   	// $maxWidth = $width*2;
	   // $maxHeight = $height*2;
	   

	//Set the file input field name
	switch($bannerType) {
		case 'image_one':
		$inputField = 'image-1';
		break;
		case 'image_two':
		$inputField = 'image-2';
		break;
		case 'image_three':
		$inputField = 'image-3';
		break;
		case 'image_four':
		$inputField = 'image-4';
		break;
		case 'image_five':
		$inputField = 'image-5';
		break;
		default:
		show_404();
	}

   	
	   //Banner Upload Configurations
	   //Create the upload path for the advert
	   if(!is_dir('adimg/' . $token)) {
		mkdir('adimg/' . $token);
	   }

	   	$config['upload_path'] = 'adimg/' . $token . '/';
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = 250;
		// $config['max_height'] = $maxHeight;
		// $config['max_width'] = $maxWidth;
		$config['file_name'] = substr($token, 0, 17) . '_' . $inputField;
		
		//Load the upload library with the configuration
		$this->load->library('upload', $config);
		
		//If uploaded
		if($this->upload->do_upload($inputField)) {
          $imgData = $this->upload->data();
          $data['imgData'] = $this->upload->data();
          $fileName = $imgData['file_name']; 

    	 $data['msg'] = '<div class="alert alert-success">Advert image has been uploaded successfully</div>';
		 $data['upload_error'] = $this->upload->display_errors(); 
		 $this->load->view('advertiser/banner', $data);
    	 
    	 //Save to database
    	 $this->AdvertiserModel->saveBanner($token, $fileName, $bannerType);
			} 
			else {
				$data['upload_error'] = $this->upload->display_errors();
    	 $this->load->view('advertiser/banner', $data);
 }
}




//------------------------------------------------------------------------------------------
public function deletecampaign() {
		$aid = $this->input->post('aid');
	
	if(!$aid) {
		show_404();
	}
	
		$this->AdvertiserModel->deleteCampaign($aid);
	 	$this->load->view('ajax/deletecampaign');
}




//------------------------------------------------------------------------------------------
public function pausecampaign() {
		$aid = $this->input->post('aid');
	
	if(!$aid) {
		show_404();
	}
	
		$this->AdvertiserModel->pauseCampaign($aid);
	 $this->load->view('ajax/pausecampaign');
}



//------------------------------------------------------------------------------------------
public function fundcampaign() {
	$aid = $this->input->post('aid');
	$token = $this->input->post('token');

 if(!$aid || !$token) {
	show_404();
}

	$this->AdvertiserModel->fundCampaign($aid, $token);
 $this->load->view('ajax/fundcampaign');
}


//------------------------------------------------------------------------------------------
public function resumecampaign() {
		$aid = $this->input->post('aid');
	
	if(!$aid) {
		show_404();
	}
	
		$this->AdvertiserModel->resumeCampaign($aid);
	 $this->load->view('ajax/resumecampaign');
}


//------------------------------------------------------------------------------------------
public function markpaid() {
	$pid = $this->input->post('pid');
	$amount = $this->input->post('amount');
	$reqId = $this->input->post('rid');
	
	if(!$pid || !$amount || !$reqId) {
		show_404();
	}
	
	$this->AdminModel->markAsPaid($pid, $amount, $reqId);
	$this->load->view('ajax/markpaid');
}





}