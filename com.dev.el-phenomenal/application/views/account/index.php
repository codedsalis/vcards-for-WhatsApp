<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = $this->UserInfo->getUserInfo(LOGGED_ID);

if((! LOGGED_IN) || ($user['right'] != 1)) {
header("location: /");
}


echo'<div class="well well-md"><h4>Logged in as <b>' . $user['name'] . '</b><h4></div><br/>';

echo'<a class="list-group-item" href="' . site_url('/apanel/cats') . '">Categories</a>';
echo'<a class="list-group-item" href="' . site_url('/apanel/urlupload') . '">Upload app via URL</a>';
echo'<a class="list-group-item" href="' . site_url('/apanel/diskupload') . '">Upload app via Local Disk</a>';
echo'<a class="list-group-item" href="' . site_url('/apanel/apps') . '">View uploaded apps</a>';
echo'<a class="list-group-item" href="' . site_url('/apanel/logout') . '">Logout</a>';


echo'<div class="alert alert-info">Contact the Developer: <a href="http://facebook.com/Dcyberlord">Salisu Kadiri</a> for support</div>';