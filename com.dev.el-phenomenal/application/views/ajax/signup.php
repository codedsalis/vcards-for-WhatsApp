<?php
if(!empty(form_error('first_name')) || !empty(form_error('last_name')) || !empty(form_error('username')) || !empty(form_error('password')) || !empty(form_error('passconf')) || !empty(form_error('email'))) {

echo'<div id="myModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Message</h4>
        </div>
        <div class="modal-body">';

//Form Errors

echo(!empty(form_error('first_name')) ? '<span class="text text-danger"><span class="glyphicon glyphicon-info-sign"></span>' . form_error('first_name') . '</span>' : '');
echo(!empty(form_error('last_name')) ? '<span class="text text-danger"><span class="glyphicon glyphicon-info-sign"></span>' . form_error('last_name') . '</span>' : '');
echo(!empty(form_error('username')) ? '<span class="text text-danger"><span class="glyphicon glyphicon-info-sign"></span>' . form_error('username') . '</span>' : '');
echo(!empty(form_error('password')) ? '<span class="text text-danger"><span class="glyphicon glyphicon-info-sign"></span>' . form_error('password') . '</span>' : '');
echo(!empty(form_error('passconf')) ? '<span class="text text-danger"><span class="glyphicon glyphicon-info-sign"></span>' . form_error('passconf') . '</span>' : '');
echo(!empty(form_error('email')) ? '<span class="text text-danger"><span class="glyphicon glyphicon-info-sign"></span>' . form_error('email') . '</span>' : '');
echo'</p>';
       echo'</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
          </div>
          </div>
          </div>';
}
else {
	
}

if(!empty($this->session->flashdata('reg_msg'))) {
          echo'<p>';
echo $this->session->flashdata('reg_msg');
echo'</p>';

}

?>


<script>
$("#myModal").modal("show");
</script>