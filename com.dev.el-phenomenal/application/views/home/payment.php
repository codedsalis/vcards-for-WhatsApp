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
                        Hello <b>' . $name . '</b> Your details has been saved successfully, your download password is <b>' . $key . '</b>, please write it down as you will need it to unlock the download when you\'re ready to do so. kindly make your payment below to complete the process. <br/>
                         Enter your email address below and make the payment.
                        <br/><br/>
                        
                    </div>
            </div>
            
            <br/><br/>
            <div class="row card-text align-items-center justify-content-center">
                <div class="col-3 text-center">
                    <h1>&#8358;200.00</h1>
                </div>
            </div>';

            ?>

            <form id="paymentForm">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email-address" required />
                </div>
                <input type="hidden" id="amount" value="200" required />
                <div class="form-submit">
                <script src="https://js.paystack.co/v2/inline.js"></script>
                    <button type="submit" name="submit" onclick="payWithPaystack()" class="btn btn-success btn-lg" style="width:100%;">Make Payment</button>
                </div>
            </form>
            



    </div>
    <div class="col-md-3 col-lg-3"></div>
    </div>
</div>
</div>



<script>
//pk_test_355efefa986ff589eac95339ccc4b79bd282ef47
// pk_live_abc4a60577484ed2af6cf31e05318aa936d1842d
var paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener("submit", payWithPaystack, false);
function payWithPaystack(e) {
  e.preventDefault();
  var handler = PaystackPop.setup({
    key: 'pk_live_abc4a60577484ed2af6cf31e05318aa936d1842d', // Replace with your public key
    email: document.getElementById("email-address").value,
    amount: document.getElementById("amount").value * 100,
    currency: "NGN",
    reference: '<?php echo $key; ?>',
    callback: function(response) {
      //Hide the form
      $('#paymentForm').hide();

      var vars = "key=" + reference;
      var url = '/ajax/verifypayment';

      $.ajax({
				type: "post",
				url: url ,
				data: vars,
				cache: false,
				success: function (data) {
					if (data.indexOf('success') != -1) {
              Swal.fire(
		            'Good job!',
		            'Payment is successfully completed, ',
		            'success'
              );
              setTimeout(function() {
                window.location.replace('/downloads');
              }, 5000);
					}
				}
      });
      
      // var reference = response.reference;
      // alert('Payment complete! Reference: ' + reference);
      // Make an AJAX call to your server with the reference to verify the transaction
    },
    onClose: function() {
      alert('Transaction was not completed, window closed.');
    },
  });
  handler.openIframe();
}




// window.onload = function() {
// Swal.fire(
// 		'Good job!',
// 		'Your details has been successfully saved.',
// 		'success'
// 	)}
</script>