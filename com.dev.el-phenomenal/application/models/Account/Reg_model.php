<?php
defined('BASEPATH') OR exit('Access denied');

class Reg_model extends CI_Model {
        public function __construct()
        {
                   $this->load->database();
         }

         public function saveNewUser($type) {
       $username = $this->input->post('username');
                    $email = $this->input->post('email');
                    $password = $this->input->post('password');
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    
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
             
  $fullName = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
             
             
  //FOR EMAIL
 	$to = $this->input->post('email');
 	$headers = 'MIME-Version: 1.0' . "\r\n" ;
 	$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n" ;
	$headers .= "From: no-reply@afriadverts.com";
	
		$url = '<a href="https://www.afriadverts.com/717/account/activate?ssvp=' . md5(time()) . '&rvp=' . md5($to) . '&esn=' . $username . '&csv=activation_from_registration"><button style="padding: 5px;border-radius:5px;border:1px solid #fff; background: #2c3e50; color: #fff;">Activate My Account</button></a>';
 	
 	if($type == 2) {
 		//SET INITIAL EARNINGS TO 100
 		$earnings = 100;
 		
 		
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
	//SET ZERO(0) EARNINGS
	$earnings = 0;
	
	
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

	$approved = ($type == 2 ? 0 : 1);
	$activate = 1;
	
	
	//Get Affiliate referrer ID and parse it to your taste
	$referrer = (!empty($_SESSION['afp']) ? $_SESSION['afp'] : $_COOKIE['afp']);
	
	//The referrer ID is in the form: aaap.pid.ID and ID is the only thing we need, so lets parse the $referrer and get the real ID
	if(!empty($referrer)) {
		$split = explode('.', $referrer);
	$referrerId = $split[2]; //we have 0 = aaap, 1 = pid and 2 = ID
	}
	else {
		$referrerId = '';
	}
	
	
    $data = array(
   'username' => strtolower($username),
   'email' => $email,
   'password' => $password, 'fullname' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'), 
   'right' => 0,
   'country' => $this->input->post('country'),
   'type' => $type,
   'ipAddress' => $this->input->ip_address(),
   'browser' => $agent,
   'regDate' => time(),
   'activate' => $activate,
   'approved' => $approved,
   'earning' => $earnings,
   'referrer' => $referrerId
);

         if($this->db->insert('dbusers', $data)) {
         	//Clear the session and cookie containing the referrer ID
         	$_SESSION['afp'] = '';
         	setcookie('afp', '', time()-3600);
         	
         	
         	//Send welcome mail message
         @mail($to, $subject, $message, $headers);
         
         
         	$this->session->set_flashdata('reg_msg', '<div class="alert alert-success fade-in">Registration successful, please <a href="' . site_url('/account/login') . '">LOGIN</a> to activate your account</div>');
}
else {
$this->session->set_flashdata('reg_msg', '<div class="alert alert-danger">We are sorry, an unknown error had occured!</div>');
}
        }

//------------------------------------------------------------------------------------

//send a verification email to the new user
public function sendEmail($to_email) {
$from_email = 'no-reply@' . $this->config->item('site_name');
$subject = 'Account Created';
$message = 'Dear User, Please follow the below activation link to verify your email address:
' . site_url('account/verify/' . md5($to_email)) . '
Thanks.
Team ' . $this->config->item('site_name'); 

//configure email settings
$config['protocol '] = 'smtp';
$config['smtp_ user'] = $from_email;
$config['mailtype '] = 'text';
$config['charset '] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['newline '] = "\r \n"; 
$config['useragent'] = 'Gidibot';

//initialize configuration
$this->email->initialize($config);

//send mail
$this->email->from($from_email, $this->config->item('site_name'));
$this->email->to($to_email);
$this->email->subject($subject);
$this->email->message($message);
return $this->email->send();
}


//------------------------------------------------------------------------------------

//Verify the e-Mail address
public function verifyEmailHash($email_hash) {
$data = array(
'status' => 1
);

$this->db->where('md5(email)', $email_hash
);

return $this->db->update('dbusers', $data
);
}


//------------------------------------------------------------------------------------

         public function updateUser($uid) {
         	$username = $this->input->post('username');
         $email = $this->input->post('email');
         $password = $this->input->post('password');
   				 $password = password_hash($password, PASSWORD_DEFAULT);
                    
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
      if(empty($this->input->post('password'))) {
      		$data = array(
   'fullname' => $this->input->post('fullname'),
   'country' => $this->input->post('country'),
   'ipAddress' => $this->input->ip_address(),
   'browser' => $agent,
   'bankName' => $this->input->post('bank'),
   'phoneNo' => $this->input->post('phone'),
   'accountNumber' => $this->input->post('accountno'),
   'paypal_email' => $this->input->post('paypal'),
   'currency' => $this->input->post('currency')
);
      }
      else {
      	  		$data = array(
   'password' => $password,
   'fullname' => $this->input->post('fullname'),
   'country' => $this->input->post('country'),
   'ipAddress' => $this->input->ip_address(),
   'browser' => $agent,
   'bankName' => $this->input->post('bank'),
   'phoneNo' => $this->input->post('phone'),
   'accountNumber' => $this->input->post('accountno'),
   'paypal_email' => $this->input->post('paypal'),
   'currency' => $this->input->post('currency')
);
      }

				$this->db->where('uid', $uid);
         if($this->db->update('dbusers', $data)) {
$this->session->set_flashdata('update_msg', '<div class="alert alert-success fade-in">Profile updated successfully!</div>');
}
else {
$this->session->set_flashdata('update_msg', '<div class="alert alert-danger">We are sorry, your account cannot be updated or modified at the moment. Please try back some time else!</div>');
}
        }









}