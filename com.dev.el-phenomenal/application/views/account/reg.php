<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user =$this->UserInfo->getUserInfo(LOGGED_ID);

$Dashboard = site_url('/dashboard');
/*
if(LOGGED_IN) {
	if($user['right'] == 0) {
		header("location: $Dashboard");
	}
}*/



?>
<div class="container">
<div class="row">
<div class="col-md-2 col-sm-2">
</div>


<div class="col-md-8 col-sm-8">

<?php

echo'<br/>
<fieldset>';

echo'<div class="panel panel-default"  style="background:#fff; padding: 10px;">
<div class="panel-heading" style="background: #fff; font-weight: bold;"><h4><i class="fa fa-user fa-lg pull-right"></i> Sign up for ' . SITE_NAME . ' account</h4><br/></div>
<div class="panel-body">';

echo'<div id="msg"></div>';

echo'<div id="form">';

echo form_open();
echo'<div class="form-group">';
echo'

<div class="row">
<div class="col-md-6 col-sm-6">
      <input type="text" class="form-control" id="fname" name="first_name" value="' . set_value('first_name') . '" placeholder="Your First name" required/>
      <span class="text text-danger">' . form_error('first_name') . '</span><br/>
</div>';
   echo'
    
<div class="col-md-6 col-sm-6">
      <input type="text" class="form-control" id="lname" name="last_name" value="' . set_value('last_name') . '" placeholder="Your Last name" required/>
      <span class="text text-danger">' . form_error('last_name') . '</span></div>
</div><br/>';

echo'<div class="row">
<div class="col-md-6 col-sm-6">

      <input type="email" class="form-control" id="email" name="email" value="' . set_value('email') . '" placeholder="e-Mail address" required/>
      <span class="text text-danger">' . form_error('email') . '</span><br/></div>';
 echo'<div class="col-md-6 col-sm-6">
<input type="text" id="username" name="username" class="form-control" value="' . set_value('username') . '" placeholder="Username" required/>
      <span class="text text-danger">' . form_error('username') . '</span>
      </div></div><br/>';


 echo'
<div class="row">
<div class="col-md-6 col-sm-6">

      <input type="password" class="form-control" id="password" name="password" value="' . set_value('password') . '" placeholder="password" required/>
      <span class="text text-danger">' . form_error('password') . '</span><br/>
</div>
<div class="col-md-6 col-sm-6">

      <input type="password" id="passconf" name="passconf" class="form-control" value="' . set_value('passconf') . '" placeholder="Retype password" required/>
      <span class="text text-danger">' . form_error('passconf') . '</span>
</div></div>
<br/>';
      
echo'<button type="submit" class="btn btn-success" name="submit" id="btn" onClick="return saveUser()" style="width:100%;"/>Register</button></form><br/><br/>
</div>
</div>
</div>
</fieldset>';
?>


</div>
<div class="col-md-2 col-sm-2">
</div>



<script>
	function saveUser() {
		var username = document.getElementById("username").value;
		var fname = document.getElementById("fname").value;
		var lname = document.getElementById("lname").value;
		var password = document.getElementById("password").value;
		var passconf = document.getElementById("passconf").value;
		var email = document.getElementById("email").value;
		var fullName = fname + ' ' + lname;
		
var vars = "username=" + username + "&password=" + password + "&passconf=" + passconf + "&first_name=" + fname + "&last_name=" + lname + "&email=" + email;

$('#form').slideUp(2000);
		document.getElementById('msg').innerHTML = '<div class="loader"></div>';

$.ajax({
	type: "post",
	url: "<?php echo site_url('/ajax/newuser'); ?>",
	data: vars,
	cache: false,
	success: function(html) {
		setTimeout(function() {
			$("#msg").html(html).fadeIn();
		}, 2000);

if(html.indexOf('text-danger') != -1) {
$('#form').slideDown(3000);
}
		
		if(html.indexOf('success') != -1) {
			window.location.replace('<?php echo PREFIX; ?>/account/login?reg_success=1&fname='+fullName+'&user='+username+'&em='+email+'&pass='+password);
		}
		
		
	}
});
return false;
}

</script>