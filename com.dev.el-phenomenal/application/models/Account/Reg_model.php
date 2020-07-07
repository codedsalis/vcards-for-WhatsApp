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
                    
  $fullName = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
             
 	
    $data = array(
   'username' => strtolower($username),
   'email' => $email,
   'password' => $password,
    'fullname' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'), 
   'right' => 1,
   'date' => time(),
);

         if($this->db->insert('users', $data)) {
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

return $this->db->update('users', $data
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
         if($this->db->update('users', $data)) {
$this->session->set_flashdata('update_msg', '<div class="alert alert-success fade-in">Profile updated successfully!</div>');
}
else {
$this->session->set_flashdata('update_msg', '<div class="alert alert-danger">We are sorry, your account cannot be updated or modified at the moment. Please try back some time else!</div>');
}
        }









}