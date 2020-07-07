<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$contactVar = $this->UserInfo->getContactByKey($key);

foreach($contactVar as $contact) {
	$name = $contact['name'];
}

echo '<div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3"></div>
            <div class="col-md-6 col-lg-6">
	<br/>
    <br/>
            <div class="card bg-light mb-7" data-aos="zoom-in" data-aos-easing="linear" data-aos-duration="1000">
                    
                    <div class="card-body">
                        <h2>Details saved successfully</h2>
                        Hello <b>' . $name . '</b> Your details has been saved successfully, your download password is <b>' . $key . '</b>, kindly write it down as you will need it to unlock the download when you\'re ready to do so. You will have to return to this site as from 9:00pm today till 11:59pm in order to download the compiled contacts list
                        <br/><br/>
                        
                    </div>
            </div>
            
			<br/><br/>
			
            <a href="' . site_url('/downloads') . '"><button class="btn btn-success btn-lg" role="button" style="width: 100%;">Download Page</button></a>



    </div>
    <div class="col-md-3 col-lg-3"></div>
    </div>
</div>
</div>';

?>


<script>
window.onload = function() {
Swal.fire(
		'Good job!',
		'Your details has been successfully saved.',
		'success'
	)}
</script>