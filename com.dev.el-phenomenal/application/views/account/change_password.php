<?php
   if(!LOGGED_IN) {
header("location: /");
}

echo form_open('account/settings/password');
echo'<div class="hdr"><legend>Change Password</legend><br/>';
echo'<div class="form-group">';

if(isset($_POST['submit'])) {
	echo $this->session->flashdata('password_update_msg');
}

echo'<label for="cur_password">Current Password</label>
           <input type="password" class="form-control" name="cur_password" value=""/><span class="text text-danger">' . form_error('cur_password') . '</span><br/>';
            echo'<label for="password">New Password</label>
           <input type="password" class="form-control" name="password"/><span class="text text-danger">' . form_error('password') . '</span><br/>';
           echo'<label for="passconf">Retype new Password</label>
           <input type="password" class="form-control" name="passconf"/><span class="text text-danger">' . form_error('passconf') . '</span><br/>
           <button type="submit" class="btn btn-primary" name="submit"/>Save Changes</button> </form></div></div>';
?>