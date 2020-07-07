<?php
defined('BASEPATH') OR exit('No Authorized direct access');

$passKey = $this->input->get('pass_key');


if(date('H') >= 9) {
    $downloadMessage = '<div class="alert alert-info">If you have been given a download password, kindly enter it in the box below for quick download, otherwise you\'ll have to share this link to ten different WhatsApp contacts before you can download this file</div>';
    
    $displayDownload = true;
}
else {
    $downloadMessage = '<br/><div class="alert alert-info">The download will be made available at around 9:00pm this evening (' . date('d M, Y') . '). Kindly exercise patience as all the contacts are being compiled for you to download</div>';
    
    $displayDownload = false;
}



echo
'<div class="container">
    <div class="row">
        <div class="col-md-3 col-lg-3"></div>
        <div class="col-md-6 col-lg-6">
	    <br/>
        <br/>
            <div class="" data-aos="zoom-in" data-aos-easing="linear" data-aos-duration="1000">
                    
                    <div class="card-body">
                        <h2><i class="fa fa-cloud"></i> Downloading Compiled Contacts</h2>
                        ' . (($passKey) ? '' : $downloadMessage) . '
                        <br/>
                        
                    </div>
            </div>
        ';


    if($passKey) {
    if($this->UserInfo->checkPassword($passKey) == true) {
        if($this->UserInfo->getPackageType($passKey) == 'free') {
            echo'<div class="alert alert-success">Your password is correct but you are not subscribed to the premium package, kindly click the button below to share the embedded message to <b>15</b> different whatsapp contacts before the download will begin</div>';

            echo'<br/><div class="row card-text align-items-center justify-content-center">
                    <div class="col-7 text-center">
                        <a href="https://wa.me?text=' . urlencode('Get more WhatsApp views for FREE.
             Visit https://wassapviews.com') . '" target="_blank"><button onclick="countClicks()" type="button" class="btn btn-success btn-lg animate__animated animate__shakeX"><i class="fa fa-whatsapp animate__animated animate__shakeY"></i> Share to WhatsApp</button></a>
                    </div>
                </div>
                <br/><h4 id="share_counts">Shared 0 times</h4>';
                
        }
        elseif($this->UserInfo->getPackageType($passKey) == 'premium') {
            if($this->UserInfo->checkPaymentStatus($passKey) == false) {
                echo '<div class="alert alert-warning">You have not paid for your premium package, kindly do so to be able to download the compiled contacts list. <a href="' . site_url('/home/payment?key=' . $passKey) . '">Follow here</a> to make payment</div>';
            }
            else {
                echo'<div class="alert alert-success">You are using a premium package, kindly click the download button to begin your download</div>';
                echo'<br/>
                <div class="row card-text align-items-center justify-content-center">
                    <div class="col-7 text-center">
                        <a href="' . site_url('/downloads/save?type=premium&key=' . $passKey) . '"><button type="button" class="btn btn-success btn-lg animate__animated animate__bounce animate__animated animate__shakeY" style="width: 100%;"><i class="fa fa-cloud"></i> Download</button></a>
                    </div>
                </div>';
            }
        }
    }
    else {
        echo '<div class="alert alert-danger animate__animated animate__bounce">Wrong password, go back and enter the right password to unlock the download</div>';
    }
}




    if($displayDownload && !$passKey) {
                echo'
                Enter your password to unlock the download<br/><br/>';
                echo '
                <form method="get" action="">
                <input type="password" name="pass_key" class="form-control" id="password" placeholder="Enter password"/>
                <br/>
                <button type="submit" class="btn btn-success" style="width: 100%;"><i class="fa fa-key"></i> Unlock Download</button>
                </form>';
            }


    echo'</div>
        <div class="col-md-3 col-lg-3"></div>
    </div>
</div>';



?>



<script>
var counter = 0;
function countClicks() {
    
    setTimeout(function() {
        counter++;
        $('#share_counts').html('Shared ' + counter + ' times');
    }, 20000);
    
    if(counter >= 16) {
        $('#share_counts').html('Sharing completed, Your download will now begin');
        window.location.replace('/files/vcard_<?php echo date("Ymd");?>.vcf');
    }
}

</script>