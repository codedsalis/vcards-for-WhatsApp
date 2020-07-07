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

echo $this->widgets->breadcrumbs(array(array('label' => 'Reset Password'
)));

$uid = (isset($_GET['vsp']) ? $_GET['vsp'] : NULL);
?>
<div class="container">
<div class="row">
<div class="col-md-3 col-sm-3">
</div>


<div class="col-md-6 col-sm-6">

<?php
echo form_open('account/chpass?vsp=' . $uid);
echo'<fieldset><legend>Change Password</legend><br/>
<span class="glyphicon glyphicon-info-sign"></span> Enter the new password you wish to use and submit the form below!<br/><br/>';
echo'<div class="form-group">';
echo $this->session->flashdata('chpass_msg');
echo'<div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-lock"></span></span>
           <input type="password" class="form-control" name="password" value="' . set_value('password') . '" placeholder="New Password" required/></div>
<span class="text text-danger">' . form_error('password') . '</span><br/>';
            echo'<div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-lock"></span></span>
           <input type="password" class="form-control" name="passconf" value="' . set_value('passconf') . '" placeholder="Retype Password" required/> <!--span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-eye-open"></span></span--></div>
<span class="text text-danger">' . form_error('passconf') . '</span>
           <br/>
<button type="submit" class="btn btn-success" name="submit" style="width:100%;"/><span class="glyphicon glyphicon-saved"></span> Save</button> </form><br/><br/>
</fieldset>';
?>
</div>
<div class="col-md-3 col-sm-3">
</div>
</div>