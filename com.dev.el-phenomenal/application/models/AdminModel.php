<?php
defined('BASEPATH') OR exit('Access denied');

class AdminModel extends CI_Model {
        public function __construct()
        {
            $this->load->database();
         }


//------------------------------------------------------------------------------------
    public function getAllPublishers() {
    	$query = $this->db->select('*')->where('type', 2)->order_by('earning', 'DESC')->get('dbusers');
    	$count = $query->num_rows();
    	
    	if($count > 0 ) {
    		$result = $query->result_array();
    		return $result;
    	}
 }
    
    
    
 //------------------------------------------------------------------------------------
    public function getAllAdvertisers() {
    	$query = $this->db->select('*')->where('type', 1)->get('dbusers');
    	$count = $query->num_rows();
    	
    	if($count > 0 ) {
    		$result = $query->result_array();
    		return $result;
    	}
 }
    
    
    
//------------------------------------------------------------------------------------
	public function getPendingPaymentRequests() {
		$query = $this->db->select('*')->from('dbusers')->join('dbrequests', 'dbusers.uid = dbrequests.sender', 'left')->where('dbrequests.status', 'pending')->order_by('date', 'DESC')->get();
    	$count = $query->num_rows();
    	
    		$result = $query->result_array();
    		return $result;
}

    
//------------------------------------------------------------------------------------
public function getAllAdverts() {
	$query = $this->db->select('*')->order_by('dateCreated', 'DESC')->get('dbadverts');
	$res = $query->result_array();
	return $res;
}


    
//------------------------------------------------------------------------------------
public function addJob() {
	$data = array(
	'aid' => $this->input->post('aid'),
	'description' => $this->input->post('description'),
	'status' => 'Active',
	'url' => $this->input->post('url'),
	'date' => time()
	);
	
	if($this->db->insert('dbjobs', $data)) {
		$this->session->set_flashdata('jobMsg','<div class="alert alert-success">Advert successfully added to jobs</div>');
	}
}

    
//------------------------------------------------------------------------------------
public function getAllRunningAds() {
	$query = $this->db->select('*')->where('status', 'Running')->order_by('dateCreated', 'DESC')->get('dbadverts');
	$res = $query->result_array();
	return $res;
}


    
//------------------------------------------------------------------------------------
public function getAllPendingApprovalAds() {
	$query = $this->db->select('*')->where('status', 'PendingApproval')->order_by('dateCreated', 'DESC')->get('dbadverts');
	$res = $query->result_array();
	return $res;
}



    
//------------------------------------------------------------------------------------
public function getAllPendingPaymentAds() {
	$query = $this->db->select('*')->where('status', 'Pendingpayment')->order_by('dateCreated', 'DESC')->get('dbadverts');
	$res = $query->result_array();
	return $res;
}


    
//------------------------------------------------------------------------------------
public function getAllSuspendedAds() {
	$query = $this->db->select('*')->where('status', 'Suspended')->order_by('dateCreated', 'DESC')->get('dbadverts');
	$res = $query->result_array();
	return $res;
}


    
//------------------------------------------------------------------------------------
public function getAllIncompleteAds() {
	$query = $this->db->select('*')->where('status', 'Pending')->or_where('status', 'Pendingpayment')->order_by('dateCreated', 'DESC')->get('dbadverts');
	$res = $query->result_array();
	return $res;
}


    
//------------------------------------------------------------------------------------
public function getAllDisapprovedAds() {
	$query = $this->db->select('*')->where('status', 'Disapproved')->order_by('dateCreated', 'DESC')->get('dbadverts');
	$res = $query->result_array();
	return $res;
}


    
//------------------------------------------------------------------------------------
public function setStatus($act, $aid) {
	if($this->db->set('status', $act)->where('aid', $aid)->update('dbadverts')) {
		$this->session->set_flashdata('statusMsg', '<div class="alert alert-success">Successfully Modified</div>');
	}
}


//------------------------------------------------------------------------------------
public function getAllSupports() {
	$query = $this->db->select('*')->order_by('date', 'DESC')->get('dbsupports');
    		$res = $query->result_array();
    		return $res;
}


//------------------------------------------------------------------------------------
public function saveTicketResponse() {
	$data = array(
	'sid' => $this->input->post('sid'),
	'message' => $this->input->post('message'),
	'date' => time(),
	'read' => 0,
	'receiver' => $this->input->post('receiver')
	);
	
	if($this->db->insert('dbresponses', $data)) {
		//Message the publisher that his support has been responded to
		$to = $this->UserInfo->getUserInfo($this->input->post('receiver'))['email']; //Publisher email address
		
		$headers = 'MIME-Version: 1.0' . "\r\n" ;
 	$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n" ;
	$headers .= "From: no-reply@afriadverts.com";
		
		$subject = '[AfriAdverts] Response to your opened ticket';
		
		$url = '<center><a href="https://www.afriadverts.com/717/' . ($this->UserInfo->getUserInfo($this->input->post('receiver'))['type'] == 2 ? 'publisher' : 'advertiser') . '/support?ticket=' . $this->input->post('sid') . '&ssvp=' . md5(time()) . '&uid=' .$this->UserInfo->getUserInfo($this->input->post('receiver'))['uid'] . '&rvp=' . md5($to) . '&esn=' . $this->widgets->randomize(37) . '&csv=support_response"><button style="padding: 15px;border-radius:5px;border:1px solid #fff; background: #2c3e50; color: #fff; width: 100%;">View Support</button></a></center>';
		
		$message = 'The support ticket you opened at AfriAdverts has been responded to. Check it out here';
		
		$message = '<html>
    <head>
    <title>[AfriAdverts] Response to Support Ticket</title>
    </head>
    <body>';
    $message .= '<center><img src="https://afriadverts.com/assets/img/aaa1.png" height="50" width="210" alt="afriadverts"/></center>';
    $message .= '<center><h3><b>Response to Support Ticket</b></h3></center><br/>';
	$message .= "Hello <b>" . $this->UserInfo->getUserInfo($this->input->post('receiver'))['fullname'] . "</b>, \n\r The support ticket you opened at AfriAdverts has been responded to. Check the link below to see it <br/><br/>
	" . $url . " <br/><br/>Thanks, AfriNotifier";
$message .= '</body></html>';
		
		//send the mail
		mail($to, $subject, $message, $headers);
		$this->session->set_flashdata('respMsg', '<div class="alert alert-success fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Success!</strong><br/>
       A response has been successfully sent, please refresh your browser to see changes
  </div>');
	}
	else {
			$this->session->set_flashdata('respMsg', '<div class="alert alert-danger fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>ERROR!</strong><br/>
       An unknown error had occured
  </div>');
	}
}



//------------------------------------------------------------------------------------
public function getAllTasks() {
	$query = $this->db->select('*')->get('dbtasks');
	$res = $query->result_array();
	return $res;
}


//------------------------------------------------------------------------------------
public function getAllSites() {
		$query = $this->db->select('*')->from('dbsites')->join('dbusers', 'dbusers.uid = dbsites.owner', 'left')->order_by('date', 'DESC')->get();
	$res = $query->result_array();
	return $res;
}


//------------------------------------------------------------------------------------
public function getAllApprovedSites() {
		$query = $this->db->select('*')->from('dbsites')->join('dbusers', 'dbusers.uid = dbsites.owner', 'left')->where('dbsites.approve', 1)->where('dbsites.verify', 1)->order_by('date', 'DESC')->get();
	$res = $query->result_array();
	return $res;
}


//------------------------------------------------------------------------------------
public function getAllVerifiedSites() {
		$query = $this->db->select('*')->from('dbsites')->join('dbusers', 'dbusers.uid = dbsites.owner', 'left')->where('dbsites.verify', 1)->where('dbsites.approve', 0)->order_by('date', 'DESC')->get();
	$res = $query->result_array();
	return $res;
}


//------------------------------------------------------------------------------------
public function getAllUnverifiedSites() {
		$query = $this->db->select('*')->from('dbsites')->join('dbusers', 'dbusers.uid = dbsites.owner', 'left')->where('dbsites.verify', 0)->order_by('date', 'DESC')->get();
	$res = $query->result_array();
	return $res;
}


//------------------------------------------------------------------------------------
public function getAllUnapprovedSites() {
		$query = $this->db->select('*')->from('dbsites')->join('dbusers', 'dbusers.uid = dbsites.owner', 'left')->where('dbsites.approve', -1)->where('dbsites.verify', 1)->order_by('date', 'DESC')->get();
	$res = $query->result_array();
	return $res;
}



//------------------------------------------------------------------------------------
public function approveSiteById($sid) {
	//GET DETAILS OF SITE AND ITS OWNER
	$query = $this->db->select('*')->from('dbsites')->join('dbusers', 'dbusers.uid = dbsites.owner', 'left')->where('dbsites.sid', $sid)->get();
	foreach($query->result() as $res) {
		$uid = $res->uid;
		$email = $res->email;
		$siteUrl = $res->url;
		$fullName = $res->fullname;
		$approved = $res->approved;
		$referrer = $res->referrer;
	}
	
	
	$to = $email;
		$headers = "From: no-reply@afriadverts.com";
		
	if($approved > 0) {
			$subject = '[AfriAdverts] Website Approved';	
			$message = "Dear " . $fullName . ", \n\r Your website " . $siteUrl . " has been approved on Afriadverts and is ready for publishing ads, kindly create ad units for it in your publisher dashboard and start running ads. \n\r Thanks \n\r
Team Afri Adverts";
	}
	else {
		$subject = '[AfriAdverts] Publisher Account and website Approved';
			$message = "Dear " . $fullName . ", \n\r Congratulations! Your publisher account and your website " . $siteUrl . " has been approved on Afriadverts and is ready for publishing ads, kindly create ad units for it in your publisher dashboard and start running ads. Congratulations once more! \n\r Thanks \n\r
Team AfriAdverts";
	}

	if($this->db->set('approve', 1)->where('sid', $sid)->update('dbsites') && mail($to, $subject, $message, $headers)) {
		//SEND APPROVAL MESSAGE TO USER VIA NOTIFICATION
		$data = array(
		'to' => $uid,
		'from' => 'Admin',
		'title' => $subject,
		'message' => $message,
		'dateSent' => time(),
		'read' => 0
		);
		
				$this->db->insert('dbnotifications', $data);
		
		
		
		//If the publisher himself(not the site in this case) is not yet approved
		if($approved < 1) {
			//Set him as approved
			$this->db->set('approved', 1)->where('uid', $uid)->update('dbusers');
		
		
				//Check if the referrer is valid.
	//if the referrer's type == 2, then it is valid
	if($this->UserInfo->getUserInfo($referrer)['type'] == 2) {
		//Add the agreed 20 naira affiliate earning to the referrer's publisher affiliate earnings upon sign up
		$referrer = $referrer;
		$earning = 20;
		
		//Now get the referrer's affiliate earnings account balance and his all-time-earnings
		$referralEarning = $this->UserInfo->getUserInfo($referrer)['referral_earnings'];
		
		$referralAllTime = $this->UserInfo->getUserInfo($referrer)['referral_alltime_earnings'];
		
		//Add the 500 naira to his affiliate earnings account and his affiliate all-time-earnings account
		$newReferralEarning = $referralEarning + $earning;
		
		$newReferralAllTime = $referralAllTime + $earning;
		
		
		
		//Now Update his affiliate earnings account and all-time-earnings account
		$this->db->set('referral_earnings', $newReferralEarning)->where('uid', $referrer)->update('dbusers');
		
		$this->db->set('referral_alltime_earnings', $newReferralAllTime)->where('uid', $referrer)->update('dbusers');
		
		
		//Set the earning details for the earnings database
		$dataAff = array(
		'earning' => $earning,
		'type' => 'Publisher Referral',
		'earner' => $referrer,
		'date' => time()
		);
		
		//Enter the details into the database
		$this->db->insert('dbearnings', $dataAff);
	}
	else {
		//Otherwise set referrer and earning to 0
		$referrer = 0;
		$earning = '0.00';
	}
	}
		
					$this->session->set_flashdata('appMsg', '<div class="alert alert-success fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Success!</strong><br/>
       Site approved successfully
  </div>');
	}
	else {
					$this->session->set_flashdata('appMsg', '<div class="alert alert-danger fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Error!</strong><br/>
     An unknown error occured
  </div>');
	}
}



//------------------------------------------------------------------------------------
public function disapproveSiteById($sid) {
	//GET DETAILS OF SITE AND ITS OWNER
	$query = $this->db->select('*')->from('dbsites')->join('dbusers', 'dbusers.uid = dbsites.owner', 'left')->where('dbsites.sid', $sid)->get();
	foreach($query->result() as $res) {
		$uid = $res->uid;
		$email = $res->email;
		$siteUrl = $res->url;
		$fullName = $res->fullname;
	}
	
	$to = $email;
	$subject = '[AfriAdverts] Website Disapproved';
	$message = "Dear " . $fullName . ", \n\r Your website " . $siteUrl . " was disapproved on Afriadverts networks. If you have another website, do not hesitate to submit and verify it for possible approval. Below is the reason why your website was disapproved:\n\r
	" . $this->input->post('reason') . " \n\r Thanks \n\r
Team AfriAdverts";
	$headers = "From: no-reply@afriadverts.com";
	
		if($this->db->set('approve', -1)->where('sid', $sid)->update('dbsites') && $this->db->set('reason', $this->input->post('reason'))->where('sid', $sid)->update('dbsites') && mail($to, $subject, $message, $headers)) {
				//SEND DISAPPROVAL NESSAGE TO USER VIA NOTIFICATION
		$data = array(
		'to' => $uid,
		'from' => 'Admin',
		'title' => $subject,
		'message' => $message,
		'dateSent' => time(),
		'read' => 0
		);
		
		$this->db->insert('dbnotifications', $data);
		
			
					$this->session->set_flashdata('disappMsg', '<div class="alert alert-success fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Success!</strong><br/>
       Site disapproved successfully
  </div>');
	}
	else {
					$this->session->set_flashdata('disappMsg', '<div class="alert alert-danger fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Error!</strong><br/>
     An unknown error occured
  </div>');
	}
}



//------------------------------------------------------------------------------------
public function blockUser($uid) {
	//GET DETAILS OF USER
	$query = $this->db->select('*')->where('uid', $uid)->get('dbusers');
	
	foreach($query->result() as $res) {
		$email = $res->email;
		$fullName = $res->fullname;
	}
	
	$to = $email;
	$subject = '[AfriAdverts] Publisher Account Disabled';
	$message = $this->input->post('reason');
	$headers = "From: no-reply@afriadverts.com";
	
		if($this->db->set('blocked', 1)->where('uid', $uid)->update('dbusers') && mail($to, $subject, $message, $headers)) {
					$this->session->set_flashdata('blockMsg', '<div class="alert alert-success fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Success!</strong><br/>
      Publisher blocked successfully and email message sent to him/her
  </div>');
	}
	else {
					$this->session->set_flashdata('blockMsg', '<div class="alert alert-danger fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Error!</strong><br/>
     An unknown error occured
  </div>');
	}
}




//------------------------------------------------------------------------------------
public function unblockUser($uid) {
	//GET DETAILS OF USER
	$query = $this->db->select('*')->where('uid', $uid)->get('dbusers');
	
	foreach($query->result() as $res) {
		$email = $res->email;
		$fullName = $res->fullname;
		$earnings = $res->earning;
	}
	
//subtract earnings from account and convert to naira
$newEarnings = ($earnings - $this->widgets->toNaira($this->input->post('amount')));
// $toNaira = $this->widgets->toNaira($newEarnings);


	$to = $email;
	$subject = 'AfriAdverts Publisher Account Enabled';
	$message = $this->input->post('reason');
	$headers = "From: no-reply@afriadverts.com";

	$data = array(
		'blocked' => 0,
		'earning' => $newEarnings
	);
	
		if($this->db->where('uid', $uid)->update('dbusers', $data) && mail($to, $subject, $message, $headers)) {
					$this->session->set_flashdata('unblockMsg', '<div class="alert alert-success fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Success!</strong><br/>
      Publisher unblocked successfully and email message sent to him/her
  </div>');
	}
	else {
					$this->session->set_flashdata('unblockMsg', '<div class="alert alert-danger fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Error!</strong><br/>
     An unknown error occured
  </div>');
	}
}



//------------------------------------------------------------------------------------
    public function getAllActivePublishers() {
    	$query = $this->db->select('*')->where('type', 2)->where('lastLogin >=', strtotime('2 months ago'))->order_by('earning', 'DESC')->get('dbusers');
    	$count = $query->num_rows();
    	
    		$result = $query->result_array();
    		return $result;
 }
  




//------------------------------------------------------------------------------------
    public function getAllAffectedPublishers($start, $limit, $rows = NULL) {
    	if($rows) {
    		$query = $this->db->select('uid')->where('type', 2)->where('earning <=', 0)->where('blocked', 0)->where('clicks >=', 1)->get('dbusers');
    		$rows = $query->num_rows();
    		return $rows;
    	}
    	else {
    		$query = $this->db->select('*')->where('type', 2)->where('earning <=', 0)->where('blocked', 0)->where('clicks >=', 1)->limit($limit, $start)->order_by('earning', 'DESC')->get('dbusers');
    	$count = $query->num_rows();
    	
    		$result = $query->result_array();
    		return $result;
    	}
 }
  
  
  


//------------------------------------------------------------------------------------

	public function getAffectedClickEarnings($pid) {
		$query = $this->db->select('earning')->where('pid', $pid)->where('validity', 1)->get('dbclicks');
		
		$sum = 0;
		foreach($query->result() as $res) {
			$sum += $res->earning;
		}
		return '$' . $this->widgets->toUsd($sum);
}
  
  
  
  
//------------------------------------------------------------------------------------
    public function getAllInactivePublishers() {
    	$query = $this->db->select('*')->where('type', 2)->where('lastLogin <', strtotime('2 months ago'))->or_where('lastLogin', NULL)->order_by('earning', 'DESC')->get('dbusers');
    	$count = $query->num_rows();
    	
    		$result = $query->result_array();
    		return $result;
 }
   


//------------------------------------------------------------------------------------
    public function getAllBlockedPublishers() {
    	$query = $this->db->select('*')->where('type', 2)->where('blocked', 1)->order_by('earning', 'DESC')->get('dbusers');
    	$count = $query->num_rows();
    	
    		$result = $query->result_array();
    		return $result;
 }
   


//------------------------------------------------------------------------------------
public function setEarning($uid, $amount) {
//Convert earnings to naira
	$earnings = $this->widgets->toNaira($amount);

	if($this->db->set('earning', $earnings)->where('uid', $uid)->update('dbusers')) {
		
		//Send message to affected publishers whose earnings were deducted on 04/02/2019
		if($this->input->post('affected')) {
			$to = $this->UserInfo->getUserInfo($uid)['email']; //Publisher email address
		
		$headers = 'MIME-Version: 1.0' . "\r\n";
 	$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n" ;
	$headers .= "From: no-reply@afriadverts.com";
		
		$subject = '[AfriAdverts] Deducted Earnings Restored';
		
		$url = '<center><a href="https://www.afriadverts.com/717/dashboard/publisher?cspv&ssvp=' . md5(time()) . '&uid=' . $uid . '&rvp=' . md5($to) . '&esn=' . $this->widgets->randomize(37) . '&csv=earnings_restored"><button style="padding: 15px;border-radius:5px;border:1px solid #fff; background: #2c3e50; color: #fff; width: 100%;">View Earnings</button></a></center>';
		
		$message = '<html>
    <head>
    <title>[AfriAdverts] Deducted Earnings Restored</title>
    </head>
    <body>';
    $message .= '<center><img src="https://afriadverts.com/assets/img/aaa1.png" height="50" width="210" alt="afriadverts"/></center>';
    $message .= '<center><h3><b>Deducted Earnings Now Restored</b></h3></center><br/>';
	$message .= "Hello <b>" . $this->UserInfo->getUserInfo($uid)['fullname'] . "</b>, \n\r Your deducted earnings in your publisher account has been restored. We use this medium to apologise for all the inconveniences this might have caused you<br/><br/>
	" . $url . " <br/><br/>Thank you for your understanding, <br/>AfriAdverts Limited";
$message .= '</body></html>';
		
		//send the mail
		mail($to, $subject, $message, $headers);
		
		
		//Update All time earnings
		$this->db->set('allTimeEarning', $earnings)->where('uid', $uid)->update('dbusers');
		}
			$this->session->set_flashdata('setEarning', '<div class="alert alert-success fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Success!</strong><br/>
     Publisher\'s earnings successfully set
  </div>');
	}
	else {
		$this->session->set_flashdata('setEarning', '<div class="alert alert-danger fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Error!</strong><br/>
     An unknown error occured
  </div>');
	}
}


//------------------------------------------------------------------------------------
public function markAsPaid($pid, $amount, $reqId) {
	//Get user earning
	$query = $this->db->select('earning')->where('uid', $pid)->get('dbusers');
	
	foreach($query->result() as $res) {
		$earning = $res->earning;
	}
	
	$newEarning = ($earning - $amount);
	
	
	$data = array(
	'earning' => $newEarning,
	'lastPaid' => time()
	);
	
	if($this->db->where('uid', $pid)->update('dbusers', $data) && $this->db->set('status', 'Paid')->where('rid', $reqId)->update('dbrequests')) {
		$this->session->set_flashdata('markPaidMsg', '<div class="alert alert-success fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Success!</strong><br/>
     Publisher has been marked as paid
  </div>');
	}
	else {
		$this->session->set_flashdata('markPaidMsg', '<div class="alert alert-danger fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Error!</strong><br/>
     An unknown error occured
  </div>');
	}
}


//------------------------------------------------------------------------------------
public function getAllFundedAccounts() {
	$query = $this->db->select('uid,username,email,fullname,accountBalance')->where('accountBalance > ', 0)->get('dbusers');
	$res = $query->result_array();
	return $res;
}



public function fundAccount($uid) {
	//Get current account balance
	$getQuery = $this->db->select('accountBalance, uid, username, fullname, referrer')->where('uid', $uid)->get('dbusers');
	
	foreach($getQuery->result() as $res) {
		$accountBalance = $res->accountBalance;
		$uid = $res->uid;
		$username = $res->username;
		$fullname = $res->fullname;
		$referrer = $res->referrer;
	}


	//Check if the referrer is valid.
	//if the referrer's type == 1 or 2, then it is valid
	if($this->UserInfo->getUserInfo($referrer)['type'] == 1 || $this->UserInfo->getUserInfo($referrer)['type'] == 2) {
		//Add the agreed 500 naira affiliate earning to the referrer's affiliate earnings
		$referrer = $referrer;
		$earning = 500;
		
		//Now get the referrer's affiliate earnings account balance and his all-time-earnings
		$referralEarning = $this->UserInfo->getUserInfo($referrer)['referral_earnings'];
		
		$referralAllTime = $this->UserInfo->getUserInfo($referrer)['referral_alltime_earnings'];
		
		//Add the 500 naira to his affiliate earnings account and his affiliate all-time-earnings account
		$newReferralEarning = $referralEarning + $earning;
		
		$newReferralAllTime = $referralAllTime + $earning;
		
		
		
		//Now Update his affiliate earnings account and all-time-earnings account
		$this->db->set('referral_earnings', $newReferralEarning)->where('uid', $referrer)->update('dbusers');
		
		$this->db->set('referral_alltime_earnings', $newReferralAllTime)->where('uid', $referrer)->update('dbusers');
		
		
				//Set the earning details for the earnings database
		$dataAff = array(
		'earning' => $earning,
		'type' => 'Advertiser Referral',
		'earner' => $referrer,
		'date' => time()
		);
		
		//Enter the details into the database
		$this->db->insert('dbearnings', $dataAff);
		
		
		//Now Update his affiliate earnings account
		$this->db->set('referral_earnings', $newReferralEarning)->where('uid', $referrer)->update('dbusers');
		
	}
	else {
		//Otherwise set referrer and earning to 0
		$referrer = 0;
		$earning = '0.00';
	}


	// Generate a reference ID
	$referenceId = $this->widgets->randomize(10, '0123456789');

	$amount = $this->input->post('amount');

	//Data for dbaccountfunding table
	$data = array(
		'advertiser' => $username,
		'amount' => $amount,
		'reference' => $referenceId,
		'gateway' => $this->input->post('gateway'),
		'referrer' => $referrer,
		'earning' => $earning,
		'date' => time()
	);

	//Insert the account details to its table and update
	//  the user table to increment the advertiser account balance
	if($this->db->insert('dbaccountfunding', $data) && $this->db->set('accountBalance', ($accountBalance)+$amount)->where('username', $username)->update('dbusers')) {
		//Send the advertiser a notification that his account has been funded
			//and that he can now fund his unfunded campaigns
			$dataNotif = array(
				'to' => $uid,
				'from' => 'AfriAdverts',
				'title' => 'Account Successfully Funded',
				'message' => 'Hi ' . $fullname . ', Your Account has been successfully funded with <b>$' . number_format($amount, 2) . '</b>. You can now go ahead and fund your unfunded campaigns or start new ones. Thank you!',
				'read' => 0,
				'dateSent' => time()
			);
			//Send the notification
			$this->db->insert('dbnotifications', $dataNotif);

			//Output a Status message - Success/Error
		$this->session->set_flashdata('fundAcctMsg', '<div class="alert alert-success fade in" style="margin:5px; background: #fff; color: #009688; border: 2px solid #009688;">
				<strong>Success!</strong>
		You have successfully funded ' . $fullname . '\'s advertiser account with the sum of  $' . number_format($amount, 2) . '
	</div>');
		}
		else {
			$this->session->set_flashdata('fundAcctMsg', '<div class="alert alert-danger fade in" style="margin:20px;">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>Error!</strong>
		Sorry, an unknown error occured, try again
	</div>');
		}
}






}