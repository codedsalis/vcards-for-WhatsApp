<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = $this->UserInfo->getUserInfo(LOGGED_ID);

$adminDashboard = site_url('/dashboard');
$advertizerDashboard = site_url('/dashboard/advertizer');
$publisherDashboard = site_url('/dashboard/publisher');

if(LOGGED_IN) {
	if($user['type'] == 0 && $user['right'] == 1) {
		header("location: $adminDashboard");
	}
	elseif($user['type'] == 1) {
		header("location: $advertizerDashboard");
	}
	elseif($user['type'] == 2) {
		header("location: $publisherDashboard");
	}

}

echo $this->widgets->breadcrumbs(array(array('label' => 'Retrieve Forgotten Password'
)));

?>
<div class="container">
<div class="row">
<div class="col-md-3 col-sm-3">
</div>


<div class="col-md-6 col-sm-6">

<?php
echo form_open('account/fpass');
echo'<fieldset><legend>Retrieve Forgotten Password</legend><br/>';
echo'If you have forgotten the password you created to login to your account, kindly enter the e-mail address you submitted while creating the account. A link will be sent to this e-mail address to help you reset your password!<br/><br/>';
echo'<div class="form-group">';
echo $this->session->flashdata('fpass_review');
echo'<div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-envelope"></span></span>
           <input type="email" class="form-control" name="email" value="' . set_value('email') . '" placeholder="e-Mail Address" required/></div>
<span class="text text-danger">' . form_error('username') . '</span><br/>
<button type="submit" class="btn btn-success" name="submit" style="width:100%;"/>Send Link</button> </form><br/><br/>
Remembered your password? <a href="' . site_url('account/login') . '">Login to Dashboard</a><br/>
<center>New to ' . $this->config->item('site_name') . '? 
<div class="row">
<div class="col-md-3">
</div>
<div class="col-md-6">
 <a href="' . site_url('account/signup?act=1') . '" class="btn btn-primary btn-sm" style="margin-bottom: 5px;">Register as Advertiser &rarr;</a> <a href="' . site_url('account/signup?act=2') . '" class="btn btn-primary btn-sm" style="margin-bottom: 5px;">Register as Publisher &rarr;</a> 
</div>
<div class="col-md-3">
</div>
</div>
</center>
</fieldset>';
?>
</div>
<div class="col-md-3 col-sm-3">
</div>
</div>