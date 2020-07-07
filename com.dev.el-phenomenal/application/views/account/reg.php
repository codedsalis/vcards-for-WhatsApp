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
echo $this->widgets->breadcrumbs(array(array('label' => 'Registration'
)));
*/

$act = isset($_GET['act']) ? $_GET['act'] : 2;
if($act == 0) {
$who = 'Admin';
}
elseif($act == 1) {
$who = 'Advertiser';
}
elseif($act == 2) {
$who = 'Publisher';
}
else {
header('Location: /');
}

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
<div class="col-md-2 col-sm-2">
</div>


<div class="col-md-8 col-sm-8">

<span class="hidden-xs"><br/><br/><br/></span>

<div style="background: #fff; padding: 10px; border-radius: 5px;">

<?php
echo'
<fieldset><legend>Sign up for ' . $who . ' account</legend><br/>';
echo'<div id="msg"></div>';

echo'<div id="form">';

echo form_open();
echo'<div class="form-group">';
 echo'

<div class="row">
<div class="col-md-6 col-sm-6">
    <div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-edit"></span></span>
      <input type="text" class="form-control" id="fname" name="first_name" value="' . set_value('first_name') . '" placeholder="Your First name" required/></div>
      <span class="text text-danger">' . form_error('first_name') . '</span><br/>
</div>';
   echo'
    
<div class="col-md-6 col-sm-6">
<div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-edit"></span></span>
      <input type="text" class="form-control" id="lname" name="last_name" value="' . set_value('last_name') . '" placeholder="Your Last name" required/></div>
      <span class="text text-danger">' . form_error('last_name') . '</span></div>
</div><br/>';

 echo'

<div class="row">
<div class="col-md-6 col-sm-6">
<div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-lock"></span></span>
      <input type="password" class="form-control" id="password" name="password" value="' . set_value('password') . '" placeholder="password" required/></div>
      <span class="text text-danger">' . form_error('password') . '</span><br/>
</div>
<div class="col-md-6 col-sm-6">
<div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-lock"></span></span>
      <input type="password" id="passconf" name="passconf" class="form-control" value="' . set_value('passconf') . '" placeholder="Retype password" required/></div>
      <span class="text text-danger">' . form_error('passconf') . '</span>
</div></div>
<br/>';

   echo'
    <div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-envelope"></span></span>
      <input type="email" class="form-control" id="email" name="email" value="' . set_value('email') . '" placeholder="e-Mail address" required/></div>
      <span class="text text-danger">' . form_error('email') . '</span><br/>';
 echo'
   <div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-user"></span></span>
<input type="text" id="username" name="username" class="form-control" value="' . set_value('username') . '" placeholder="Choose a Username" required/></div>
      <span class="text text-danger">' . form_error('username') . '</span><br/>';
    
 echo'
   <div class="input-group">
      <span class="input-group-addon btn btn-default"><span class="glyphicon glyphicon-flag"></span></span>
      <select id="country" name="country" class="form-control" value="' . set_value('country') . '" placeholder="Country" required/>
<option value="Afghanistan"> Afghanistan</option>
    <option value="Albania"> Albania</option>
    <option value="Algeria">Algeria</option>
<option value="Andorra">Andorra </option>
<option value="Angola">Angola </option>
<option value="Argentina"> Argentina</option>
<option value="Armenia">Armenia </option>
<option value="Australia">Australia</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas"> Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh"> Bangladesh</option>
<option value="Barbados"> Barbados</option>
<option value="Belarus"> Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
    <option value="Bosnia and Herzegovina"> Bosnia and Herzegovina</option>
    <option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="Brunei">Brunei </option>
<option value="Bulgaria"> Bulgaria</option>
<option value="Burkina Faso"> Burkina Faso </option>
<option value="Burundi"> Burundi</option>
<option value="Cabo Verde"> Cabo Verde</option>
<option value="Cambodia"> Cambodia</option>
<option value="Cameroon"> Cameroon</option>
<option value="Canada"> Canada</option>
<option value="Chad"> Chad</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Columbia">Columbia</option>
<option value="Comoros">Comoros</option>
<option value="Congo">Congo</option>
<option value="Costa Rica"> Costa Rica</option>
<option value="Cote d\'Ivoire"> Cote d\'Ivoire</option>
<option value="Croatia"> Croatia</option>
    <option value="Cuba"> Cuba</option>
    <option value="Cyprus"> Cyprus</option>
<option value="Czech Republic"> Czech Republic</option>

<option value="Denmark"> Denmark</option>
<option value="Djibouti"> Djibouti</option>
<option value="Dominica"> Dominica</option>
<option value="Dominican Republic"> Dominican Republic</option>
<option value="Ecuador"> Ecuador</option>
<option value="Egypt"> Egypt</option>
<option value="El Salvador"> El Salvador</option>
<option value="Equatorial Guinea"> Equatorial Guinea</option>
<option value="Estonia"> Estonia</option>
<option value="Ethiopia"> Ethiopia</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
    <option value="Ghana">Ghana</option>
    <option value="Greece">Greece</option>
<option value="Grenada">Grenada </option>
<option value="Guatemala"> Guatemala </option>
<option value="Guinea"> Guinea</option>
<option value="Guyana"> Guyana</option>
<option value="Haiti"> Haiti</option>
<option value="Honduras">Honduras</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Ireland">Ireland</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
    <option value="Kiribati">Kiribati</option>
    <option value="Kosovo">Kosovo</option>
<option value="Kuwait">Kuwait </option>
<option value="Kyrgyzstan">Kyrgyzstan</option>


<option value="Laos">Laos</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Liechtenstein">Liechtenstein</option>

<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macedonia">Macedonia</option>
<option value="Madagascar">Madagascar</option>
<option value="Malawi">Malawi</option>
<option value="Malaysia">Malaysia</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
    <option value="Marshall Islands">Marshall Islands</option>
    <option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius </option>
<option value="Mexico">Mexico</option>
<option value="Micronesia">Micronesia</option>
<option value="Moldova">Moldova </option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montenegro">Montenegro</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar</option>
<option value="Namibia">Namibia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherlands">Netherlands</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
    <option value="North Korea">North Korea</option>
    <option value="Norway">Norway</option>
<option value="Oman">Oman </option>
<option value="Pakistan">Pakistan</option>
<option value="Palau">Palau</option>
<option value="Palestine">Palestine </option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Philippines">Philippines</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Qatar">Qatar</option>
<option value="Romania">Romania</option>
<option value="Russia">Russia</option>
<option value="Rwanda">Rwanda</option>
<option value="Saint Kitts and Nevis"> Saint Kitts and Nevis </option>
<option value="Saint Lucia"> Saint Lucia </option>
    <option value="Saint Vincent and the Grenadines"> Saint Vincent and the Grenadines </option>
<option value="Samoa"> Samoa </option>
<option value="San Marino"> San Marino </option>
<option value="Sao Tome and Principe"> Sao Tome and Principe </option>
<option value="Saudi Arabia"> Saudi Arabia </option>
<option value="Senegal"> Senegal </option>
<option value="Serbia"> Serbia </option>
<option value="Seychelles"> Seychelles </option>
<option value="Sierra Leone"> Sierra Leone </option>
<option value="Singapore"> Singapore </option>
<option value="Slovakia"> Slovakia </option>
<option value="Slovenia"> Slovenia </option>
<option value="Solomon Islands"> Solomon Islands </option>
<option value="Somalia"> Somalia </option>
<option value="South Africa"> South Africa </option>
<option value="South Korea"> South Korea </option>
<option value="South Sudan"> South Sudan </option>
<option value="Spain"> Spain </option>
<option value="Sri Lanka"> Sri Lanka </option>
    <option value="Sudan"> Sudan </option>
    <option value="Suriname"> Suriname </option>
<option value="Swaziland"> Swaziland </option>
<option value="Sweden"> Sweden </option>
<option value="Switzerland"> Switzerland </option>
<option value="Syria"> Syria </option>
<option value="Taiwan">Taiwan</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Timor-Leste">Timor-Leste</option>
<option value="Togo">Togo</option>
<option value="Tonga">Tonga</option>
<option value="Trinidad and Tobago">Trinidad and Tobago</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Tuvalu"> Tuvalu</option>
<option value="Uganda"> Uganda </option>
<option value="Ukraine"> Ukraine </option>
<option value="United Arab Emirates"> United Arab Emirates </option>
<option value="United Kingdom"> United Kingdom </option>
<option value="United States of America"> United States of America </option>
<option value="Uruguay"> Uruguay </option>
<option value="Uzbekistan"> Uzbekistan </option>
<option value="Vanuatu"> Vanuatu </option>
<option value="Vatican City"> Vatican City </option>
<option value="Venezuela"> Venezuela </option>
<option value="Vietnam"> Vietnam </option>
<option value="Yemen"> Yemen </option>
<option value="Zambia"> Zambia </option>
<option value="Zimbabwe"> Zimbabwe </option>
    </select></div>
   <span class="text text-danger">' . form_error('country') . '</span><br/>';
   echo'<input type="checkbox" name="chkbox" id="chkbox" value="1" checked> By clicking the registration button below, you agree to our <a href="' . (($_GET['act'] == 2) ? 'https://www.afriadverts.com/afriadverts-publishers-policies/' : 'https://www.afriadverts.com/afriadverts-advertisers-policies/') . '" target="_blank">Terms and Conditions</a><br/><br/>'; 
echo'<button type="submit" class="btn btn-info" name="submit" id="btn" onClick="return saveUser()" style="width:100%;"/>Register</button></form><br/><br/>
Already have an Account? <a href="' . site_url('/account/login') . '">Login to Dashboard</a><br/></div>
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
		var country = document.getElementById("country").value;
var chkbox = document.getElementById("chkbox").value;
var act = '<?php echo $_GET["act"]; ?>';
var im = '<?php echo (isset($_GET["im"]) ? $_GET['im'] : 'aa'); ?>';

		
var vars = "username=" + username + "&password=" + password + "&passconf=" + passconf + "&first_name=" + fname + "&last_name=" + lname + "&email=" + email + "&country=" + country + "&chkbox=" + chkbox + "&act=" + act + "&im=" + im;

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
		
	}
});
return false;
}

//Check box
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
             $('#btn').show();
          }
            else if($(this).prop("checked") == false){
             $('#btn').hide();
            }
        });
    });


</script>