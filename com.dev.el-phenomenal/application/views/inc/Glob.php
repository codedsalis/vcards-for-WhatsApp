<?php
defined('BASEPATH') OR exit('No Authorized direct access');

//Session array
$sess = $this->session->userdata('logged_in');

//define username from session/cookie
define('LOGGED_IN', $this->session->userdata('logged_in') ? $sess['username'] : get_cookie('username'));

//define user id
define('LOGGED_ID', $this->session->userdata('logged_in') ? $sess['id'] : get_cookie('id'));

//Define Site's name
define('SITE_NAME', $this->config->item('site_name'));

//Define Site's url
define('SITE_URL', $this->config->item('site_url'));

//Define Site's url prefix for easy ajax calls
define('PREFIX', '/index.php');

//Define time lapse for new publishers
define('TIMELAPSE', 1522436171);


//A constant for URL for serving advert images
define('AD_IMG_URL', 'http://localhost/adimg');