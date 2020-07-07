<?php
defined('BASEPATH') OR exit('No Authorized direct access');

$passKey = $this->input->get('pass_key');

$fileUrl = site_url('/files/vcard_' . date('Ymd') . '.vcf');

header("Location: $fileUrl");