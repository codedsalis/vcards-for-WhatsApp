<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = $this->UserInfo->getUserInfo(LOGGED_ID);

$adminDashboard = site_url('/dashboard');
$advertizerDashboard = site_url('/dashboard/advertiser');
$publisherDashboard = site_url('/dashboard/publisher');

$unlogged = site_url('/account/login');

if(LOGGED_IN) {
	if($user['type'] == 0 && $user['right'] == 1) {
		//Do nothing
	}
	elseif($user['type'] == 1) {
		header("location: $advertizerDashboard");
	}
	elseif($user['type'] == 2) {
		header("location: $publisherDashboard");
	}

}
else {
	header("Location: $unlogged");
}


/*

$cpc = $this->input->get('cpc');

if(isset($_GET['cpc'])) {
	if(file_put_contents('assets/cpc.txt', $cpc)) {
		echo'<div class="alert alert-success">CPC updated</div>';
	}
}


echo'<b>Adjust CPC</b><br/>
<form method="get" action="#"><input type="text" name="cpc" id="cpc" class="form-control" value="' . file_get_contents('assets/cpc.txt') . '"/><br/>
<button type="submit" class="btn btn-primary">Submit</button></form><br/><br/>';

*/

if(count($requests) > 0) {
	echo'<div class="list-group">';
	echo'<div class="list-group-item" style="background:#000;color:#fff;"> Payment Requests</div>';
	
	foreach($requests as $req) {
		$uid = $req['uid'];
		
		echo'<div class="list-group-item" style="border-color:#ccc;"><b>' . $req['title'] . '</b><br/>
		' . $req['message'] . '<br/>From <a href="' . site_url('/admin/viewpublisher?pid=' . $req['uid']) . '">' . $req['fullname'] . '</a>  ' . ($req['type'] != 'Affiliate Payment' ? '<b>Negative Earnings</b>: &#8358;' . $req['negEarning'] : '') . '<br/>
		<div class="table-responsive">
    <table class="table table-bordered">
		<thead>
		<tr class="alert-success">
		<th>Status</th>
		<th>Date sent</th>
		<th>Request type</th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td class="text-danger">' . $req['status'] . '</td>
		<td>' . date('d M, Y - h:i:A', $req['date']) . '</td>
		<td>' . $req['type'] . '</td>
		</tr>
		</tbody>
		</table>
		</div>
		<div id="msg-' . $uid . '"></div>
		<div class="pull-right">
		<button class="btn btn-primary" onclick="openMarkPaid()">Mark as paid</button>
		</div><br/><br/>
		</div>';
		
		
		
		echo'
  <div id="Modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to mark this publisher as \'paid\'? Please make sure you know what you are doing!</p>
          <br/>
          Enter the amount the publisher was paid so that it will be deducted from his account<br/>
          <input type="number" class="form-control" name="amount" id="amount" style="border-radius: 20px;" placeholder="Enter Amount Paid" required />
          <input id="rid" type="hidden" value="' . $req['rid'] . '"/>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success" id="delete" data-dismiss="modal" onclick="return markPaid(' . $uid . ')">Mark As Paid</button>
        </div>
      </div>
    </div>
  </div>';
		
	}

echo'</div>';
}


?>


<script>
function openMarkPaid() {
	$("#Modal").modal("show");
}


function markPaid(id) {
	var amount = document.getElementById('amount').value;
	var reqId = document.getElementById('rid').value;
	
	var vars = "pid=" + id + "&amount=" + amount + "&rid=" + reqId;

$.ajax({
	type: "post",
	url: "<?php echo site_url('/ajax/markpaid'); ?>",
	data: vars,
	cache: false,
	success: function(html) {	document.getElementById('msg-' + id).innerHTML = '<center><img src="/assets/img/ajax-loading.gif"/></center><br/>';
		setTimeout(function() {
			$("#msg-" + id).html(html).fadeIn();
		}, 2000);
		setTimeout(function() {
			window.location.reload(true);
		}, 3000);
	}
});
return false;
}

</script>