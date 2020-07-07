<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = $this->UserInfo->getUserInfo(LOGGED_ID);

$adminDashboard = site_url('/dashboard');

$unlogged = site_url('/account/login');

if(LOGGED_IN && $user['right'] == 1) {
	//Do nothing
}
else {
	header("Location: $unlogged");
}


echo'
<div class="container">';

echo'<br/><br/><a class="float-right" href="' . site_url('/account/logout') . '"><button class="btn btn-danger"><i class="fa fa-sign-out"></i> Log out</button></a><br/><br/>

	<div class="row">
		<div class="col-md-6 col-lg-6">
			<h3>All Vcards</h3>';
			
			if(count($vcards) > 0) {
				echo'<div class="list-group">';
				foreach($vcards as $vcf) {
					echo'
					<a href="' . site_url('/files/' . $vcf['name']) . '" class="list-group-item"><b>' . $vcf['name'] . '</b><br/>
					<font color="#000">Size: ' . $this->library->formatSize(filesize('./files/' . $vcf['name'])) . '<br/>Created: ' . date('d M, Y', $vcf['date_created']) . '</font></a>';

				}
				echo'Total: ' . count($vcards) . '</div><br/>';
			}
			else {
				echo '<div class="well">
				No VCards available yet</div>';
			}
        echo'</div>
		<div class="col-md-6 col-lg-6">
		<h3>All Contacts submitted today</h3>';

			if(count($contacts) > 0) {
				echo'<div class="list-group">';
				foreach($contacts as $contact) {
					$paid = (($contact['paid'] > 0) ? 'Yes' : 'No');

					echo'
					<div class="list-group-item">
					<b>Name:</b> ' . $contact['name'] . '<br/>
					<b>Number:</b> ' . $contact['phone_number'] . '<br/>
					<b>Package:</b> ' . $contact['account_type'] . '<br/>
					' . (($contact['account_type'] == 'premium') ? '<b>Paid: </b> ' . $paid : '') . '
					</div>';

				}
				echo'Total: ' . count($contacts) . '</div';
			}
			else {
				echo '<div class="well">
				No VCards available yet</div>';
			}
		echo'</div>
	</div>
</div>';