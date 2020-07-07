<?php
defined('BASEPATH') OR exit('Access denied');

class AccountModel extends CI_Model {
        public function __construct()
        {
            $this->load->database();
         }




//------------------------------------------------------------------------------------
         public function review_login()
{
                 $this->load->helper('security');
                 $username = $this->input->post('username');
        $password = $this->input->post('password');

    $check = $this->db->select('*')->where('username', $username)->or_where('email', $username)->get('dbusers');
    $count = $check->num_rows();
  if($count > 0)
         {
foreach($check->result() as $result) {
$result_password = $result->password;
 }
if(password_verify($password, $result_password)) {
$session_array = array();
foreach($check->result() as $row) {
$session_array = array(
'id' => $row->uid, 'username' => $row->username
);
$this->session->set_userdata('logged_in', $session_array);

//Set cookies
setcookie('username', $row->username, time() + 3600 * 24 * 365, '/');
setcookie('id', $row->uid, time() +  3600 * 24* 365, '/');


          
//Get browser info
     if ($this->agent->is_browser()) {
     	 $agent = $this->agent->browser().' '.$this->agent->version(); 
     	 } 
   elseif ($this->agent->is_robot()) {
   	$agent = $this->agent->robot();
   	} 
   	elseif ($this->agent->is_mobile()) {
   		$agent = $this->agent->mobile();
   		} 
   		else { $agent = 'Unidentified User Agent';
   		}
   		
   		
 
//Set the user's lastlogin time
$this->db->set('lastLogin', time())->where('uid', $row->uid)->update('dbusers');

//Set the browser
$this->db->set('browser', $agent)->where('uid', $row->uid)->update('dbusers');

//Set the ip address
$this->db->set('ipAddress', $this->input->ip_address())->where('uid', $row->uid)->update('dbusers');




/*variable type
** 0 = admin
** 1 = advertizer
** 2 = publisher
*/
$type = $row->type;
$right = $row->right;
}
$adminDashboard = site_url('/dashboard');
$advertizerDashboard = site_url('/dashboard/advertiser');
$publisherDashboard = site_url('/dashboard/publisher');
if($type == 0 && $right == 1) {
	header("location: $adminDashboard");
} 
	elseif($type == 1) {
	header("location: $advertizerDashboard");
}
	elseif($type == 2) {
	header("location: $publisherDashboard");
}

}
}
   else {
  $this->session->set_flashdata('login_review', '<div class="alert alert-danger">The login credentials you have provided are incorrect</div>');
}
}

//------------------------------------------------------------------------------------
         public function reviewForgottenPassword()
{
                 $this->load->helper('security');
                 $email = $this->input->post('email');
    //Check if the email exists in the DB
    $check = $this->db->select('*')->where('email', $email)->get('dbusers');
    //Count the rows returned
    $count = $check->num_rows();
    //If the email exists
  if($count > 0) {
  	foreach($check->result() as $result) {
$uid = $result->uid;
$to = $email;
$from = 'no-reply@' . base_url();
$subject = "Password Reset";
$message = "Hello " . $result->fullname . ",\n You requested for a password reset for your account at AfriAdverts, please kindly follow the link below to complete the password reset process \n " . site_url('/account/chpass?fpv=' . md5($uid) . '&vsp=' . $uid . '&tnm=' . time());
   				$headers = "From: no-reply@afriadverts.com";

//Update his reset record in the DB
$this->db->set('reset', 1)->where('uid', $uid)->update('dbusers');

//send the mail
if(mail($to, $subject, $message, $headers)) {
	$this->session->set_flashdata('fpass_review', '<div class="alert alert-info">A mail containing instructions on how to reset your password has been sent to your email address, navigete to your inbox or your spam box to see the mail and complete your password reset process</div>');
} else {
	$this->session->set_flashdata('fpass_review', '<div class="alert alert-warning">Sorry, an unknown error had occured, please try again later!</div>');
	}
 }
}
   else {
  $this->session->set_flashdata('fpass_review', '<div class="alert alert-warning">Sorry, this email address is not registered with us and hence cannot be used to reset your password!</div>');
}
}



//------------------------------------------------------------------------------------
public function changeForgottenPassword($uid) {
	$pass = $this->input->post('password');
	
    //Check if the user actually requested for a change of password
    $check = $this->db->select('*')->where('reset', 1)->where('uid', $uid)->get('dbusers');
    //Count the rows returned
    $count = $check->num_rows();
    //If it is true
  if($count > 0) {
  	$password = password_hash($pass, PASSWORD_DEFAULT);
  	
  	//Update the DB record and change the password
if($this->db->set('reset', 0)->where('uid', $uid)->update('dbusers') && ($this->db->set('password', $password)->where('uid', $uid)->update('dbusers'))) {
	$this->session->set_flashdata('chpass_msg', '<div class="alert alert-success fade-in">Your password has been successfully changed, please <a href="' . site_url('/account/login') . '"><font color="#fff"><b>LOGIN NOW &rarr;</b></font></a></div>');
}
else {
$this->session->set_flashdata('chpass_msg', '<div class="alert alert-danger">We are sorry, there was a problem changing your password. Please try back some time else!</div>');
}
} else {
	$this->session->set_flashdata('chpass_msg', '<div class="alert alert-danger">We are sorry, your request to reset your password could not be found!</div>');
}
}



//------------------------------------------------------------------------------------
public function getNotifications($to) {
		$query = $this->db->select('*')->where('to', $to)->order_by('dateSent', 'DESC')->get('dbnotifications');
    		$res = $query->result_array();
    		return $res;
}


//------------------------------------------------------------------------------------

public function updateNotificationsToread($uid) {
	$query = $this->db->select('*')
	->where('read', 0)
	->where('to', $uid)
	->get('dbnotifications');
	$count = $query->num_rows();
	if($count > 0) {
		$results = $query->result_array();
		foreach($results as $res) {
			$this->db->set('read', 1)
			->where('to', $uid)
			->update('dbnotifications');
		}
	}
	else {
		//Do nothing
	}
}


//------------------------------------------------------------------------------------
public function getUser($username) {
	$query = $this->db->select('*')->where('username', $username)->get('dbusers');
	
	$count = $query->num_rows();
	if($count > 0) {
		$res = $query->row_array();
		return $res;
	}
	else {
		return false;
	}
}

//------------------------------------------------------------------------------------
public function activateUser($username) {
	$data = array(
	'activate' => 1,
	'lastLogin' => time()
	);
	
	if($this->db->where('username', $username)->update('dbusers', $data)) {
		$user = $this->getUser($username);
			$session_array = array(
'id' => $user['uid'], 'username' => $user['username']
);

//Set session
$this->session->set_userdata('logged_in', $session_array);

//Set cookies
setcookie('username', $user['username'], time() + 3600 * 24 * 365, '/');
setcookie('id', $user['uid'], time() +  3600 * 24* 365, '/');

  $this->session->set_flashdata('activateMsg', '<div class="alert alert-success">Your account has been successfully activated. ' . (($user['type'] == 2) ? '<a href="' . site_url('/publisher/sites?uid=' . $user['uid'] . '&sno=' . base64_encode($user['fullname'] . ', Please submit your website and select the appropriate category below, verify and wait for approval by our admins and only then can you be able to access the full account rights')) . '"><b><font color="#fff"><b>CONTINUE &rarr;</b></font></b></a>' : '<a href="' . site_url('/dashboard/advertiser?espv=' . $this->widgets->randomize(45)) . '" style="color: #fff;"><b>CONTINUE TO DASHBOARD &rarr;</b></a>') . '</div>');
	}
	else {
		  $this->session->set_flashdata('activateMsg', '<div class="alert alert-danger">Sorry, there was a problem activating your account. Please try again later! </div>');
	}
}


public function getImRefs($im) {
	$query = $this->db->select('referrer')->where('referrer', $im)->where('activate', 1)->where('approved', 1)->get('dbusers');
	$count = $query->num_rows();
	return $count;
}


public function checkActivatedUser($userId) {
	$query = $this->db->select('activate')->where('uid', $userId)->get('dbusers');
	$count = $query->num_rows();
	
	if($count > 0) {
		foreach($query->result() as $res) {
		$activate = $res->activate;
	}
	return $activate;
	}
	else {
		show_404();
	}
	
}



public function resendVerificationEmail($userId) {
		//Get user info
		$query = $this->db->select('uid, fullname, username, type, email')->where('uid', $userId)->get('dbusers');
		foreach($query->result() as $res) {
			$type = $res->type;
			$username = $res->username;
			$email = $res->email;
			$fullName = $res->fullname;
		}
		
		//FOR THE EMAIL
			$to = $email;
 	$headers = 'MIME-Version: 1.0' . "\r\n" ;
 	$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n" ;
	$headers .= "From: no-reply@afriadverts.com";
	
		$url = '<a href="https://www.afriadverts.com/717/account/activate?ssvp=' . md5(time()) . '&rvp=' . md5($to) . '&esn=' . $username . '&csv=activation_from_registration"><button style="padding: 5px;border-radius:5px;border:1px solid #fff; background: #2c3e50; color: #fff;">Activate My Account</button></a>';
		
		
		if($type == 2) {
		$subject = '[AfriAdverts] Publisher Account Activation';

  	$message = '<html>
    <head>
    <title>[AfriAdverts] Account Activation</title>
    </head>
    <body>';
    $message .= '<center><img src="https://afriadverts.com/assets/img/aaa1.png" height="50" width="210" alt="afriadverts"/></center>';
    $message .= '<center><b>Activate your account</b></center><br/>';
	$message .= "Hello <b>" . $fullName . "</b>, \n\r Your Registration for Afriadverts publishers account was successful, please follow the link provided below to activate your account:<br/>
	" . $url . " <br/>Thanks, Team Afri Adverts";
$message .= '</body></html>';
}
elseif($type == 1) {
	$subject = '[AfriAdverts] Advertiser Account Activation';

  	$message = '<html>
    <head>
    <title>[AfriAdverts] Account Activation</title>
    </head>
    <body>';
    $message .= '<center><img src="https://afriadverts.com/assets/img/aaa1.png" height="50" width="210" alt="afriadverts"/></center>';
    $message .= '<center><h3>Activate your account</h3></center><br/>';
	$message .= "Hello <b>" . $fullName . "</b>, \n\r Your Registration for Afriadverts Advertisers account was successful, please follow the link provided below to activate your account:<br/>
	" . $url . " <br/>Thanks, Team Afri Adverts";
$message .= '</body></html>';
}

//Send the email
if(mail($to, $subject, $message, $headers)) {
		$this->session->set_flashdata('resendEmailMsg', '<div class="alert alert-success fade-in">We have resent the activation mail to your e-mail address <b>' . $email . '</b>, find the message in your inbox or spam folder and follow the link to activate your account</div>');
}
else {
$this->session->set_flashdata('resendEmailMsg', '<div class="alert alert-danger">We are sorry, an unknown error had occured, please try again later!</div>');
}

}





}