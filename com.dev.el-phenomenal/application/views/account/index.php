<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = $this->UserInfo->getUserInfo(LOGGED_ID);

if((! LOGGED_IN) || ($user['right'] != 1)) {
header("location: /");
}
header("location: /");