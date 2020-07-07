<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = $this->UserInfo->getUserInfo(LOGGED_ID);

$adminDashboard = site_url('/dashboard');
$advertizerDashboard = site_url('/dashboard/advertiser');
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

/*
echo $this->widgets->breadcrumbs(array(array('label' => 'Login'
)));
*/

?>
<br/>
<style>
body {
	background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)), rgba(0, 0, 0, 0.65) url(/assets/img/bgcover.jpg) no-repeat center
center fixed;
	    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    opacity:0.9;
    padding: 10px;
    overflow-x:hidden;
    width: 100%;
    height: 100%;
	}
	</style>


<div class="row">
<div class="col-md-3 col-sm-3">
</div>

<div class="col-md-6 col-sm-6">

<span class="hidden-xs"><br/><br/><br/></span>

<div style="background: #fff; padding: 10px; border-radius: 5px;">

<?php
echo form_open();
echo'<fieldset><legend>Login</legend><br/>';
echo'<div id="msg"></div>';

echo'<div id="form" class="form-group">';

echo'<div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-user"></span></span>
           <input type="text" class="form-control" id="username" name="username" value="' . set_value('username') . '" placeholder="e-Mail or Username" required/></div>
<span class="text text-danger">' . form_error('username') . '</span><br/>';
            echo'<div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-lock"></span></span>
           <input type="password" class="form-control" id="password" name="password" value="' . set_value('password') . '" placeholder="Password" required/></div>
<span class="text text-danger">' . form_error('password') . '</span>
           <br/>
<button type="submit" class="btn btn-info" name="submit" onClick="return logUser()" style="width:100%;"/>Sign In</button> </form><br/><br/>
Retrieve your <a href="' . site_url('account/fpass') . '">Forgotten password</a><br/><br/>
<center>New to ' . $this->config->item('site_name') . '? <br/>

 <a href="' . site_url('account/signup?act=1') . '" class="btn btn-default btn-sm" style="margin-bottom: 5px; background: #fff; border: 2px solid #ccc; border-radius: 40px; color: #000; padding: 10px; font-weight: bold;">Register as Advertiser &rarr;</a> <a href="' . site_url('account/signup?act=2') . '" class="btn btn-default btn-sm" style="margin-bottom: 5px; background: #fff; border: 2px solid #ccc; border-radius: 40px; color: #000; padding: 10px; font-weight: bold;">Register as Publisher &rarr;</a>
</div>
</center>
</fieldset>
</div>
</div>';
?>

<div class="col-md-3 col-sm-3">
</div>
</div>
</div>

</div>
</div>
</div>
</div>


<script>
	function logUser() {
		var username = document.getElementById("username").value;
		var password = document.getElementById("password").value;

		
var vars = "username=" + username + "&password=" + password;

$('#form').slideUp(2000);
		document.getElementById('msg').innerHTML = '<div class="loader"></div>';

$.ajax({
	type: "post",
	url: "<?php echo site_url('/ajax/login'); ?>",
	data: vars,
	cache: false,
	success: function(html) {
		setTimeout(function() {
			$("#msg").html(html).fadeIn();
		}, 2000);

if(html.indexOf('danger') != -1) {
$('#form').slideDown(3000);
}
		
		if(html.indexOf('publisher') != -1) {
			setTimeout(function() {
			window.location.replace("<?php echo site_url('/dashboard/publisher'); ?>");
			}, 4000);
		}
		else if(html.indexOf('advertiser') != -1) {
			setTimeout(function() {
			window.location.replace("<?php echo site_url('/dashboard/advertiser'); ?>");
			}, 4000);
		}
		else if(html.indexOf('admin') != -1) {
			setTimeout(function() {
			window.location.replace("<?php echo site_url('/dashboard'); ?>");
			}, 4000);
		}
	}
});
return false;
}

</script>