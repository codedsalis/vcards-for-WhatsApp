<?php
defined('BASEPATH') OR exit('Access denied');

class Login_model extends CI_Model {
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

    $check = $this->db->select('*')->where('username', $username)->or_where('email', $username)->get('users');
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
    'id' => $row->id, 'username' => $row->username
  );

//Set session
$this->session->set_userdata('logged_in', $session_array);

//Set cookies
setcookie('username', $row->username, time() + 3600 * 24 * 365, '/');
setcookie('id', $row->id, time() +  3600 * 24* 365, '/');
// }



$right = $row->right;
}

$adminDashboard = site_url('/dashboard');

if($right == 1) {
	$this->session->set_flashdata('login_review', '<div class="alert alert-success fade in" style="margin:20px;">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Success!</strong><br/>
       Redirection to admin panel in progress
  </div>');
}
}  else {
  $this->session->set_flashdata('login_review', '<div class="alert alert-danger">The login credentials you have provided are incorrect, please double-check your password</div>');
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
    $check = $this->db->select('*')->where('email', $email)->get('users');
    //Count the rows returned
    $count = $check->num_rows();
    //If the email exists
  if($count > 0) {
  	foreach($check->result() as $result) {
$id = $result->id;
$to = $email;
$from = 'no-reply@' . base_url();
$subject = "Password Reset";
$message = "Hello " . $result->fullname . ",\n You requested for a password reset for your account at AfriAdverts Ad network, please kindly follow the link below to complete the password reset process \n " . site_url('/account/chpass?fpv=' . md5($id) . '&vsp=' . $id . '&tnm=' . time());

//Update his reset record in the DB
$this->db->set('reset', 1)->where('id', $id)->update('users');

//send the mail
if(mail($to, $subject, $message)) {
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
public function changeForgottenPassword($id) {
	$pass = $this->input->post('password');
	
    //Check if the user actually requested for a change of password
    $check = $this->db->select('*')->where('reset', 1)->where('id', $id)->get('users');
    //Count the rows returned
    $count = $check->num_rows();
    //If it is true
  if($count > 0) {
  	$password = password_hash($pass, PASSWORD_DEFAULT);
  	
  	//Update the DB record and change the password
if($this->db->set('reset', 0)->where('id', $id)->update('users') && ($this->db->set('password', $password)->where('id', $id)->update('users'))) {
	$this->session->set_flashdata('chpass_msg', '<div class="alert alert-success fade-in">Your password has successfully been changed, please <a href="' . site_url('/account/login') . '"><font color="#fff"><b>LOGIN NOW &rarr;</b></font></a></div>');
}
else {
$this->session->set_flashdata('chpass_msg', '<div class="alert alert-danger">We are sorry, there was a problem changing your password. Please try back some time else!</div>');
}
} else {
	$this->session->set_flashdata('chpass_msg', '<div class="alert alert-danger">We are sorry, your request to reset your password could not be found!</div>');
}
}



}