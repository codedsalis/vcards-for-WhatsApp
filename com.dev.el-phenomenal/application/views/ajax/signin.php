<?php
echo (!empty(form_error('username')) ? '<span class="text-danger">' . form_error('username') . '</span>' : '');
echo (!empty(form_error('password')) ? '<span class="text-danger">' . form_error('password') . '</span>' : '');

if(!empty($this->session->flashdata('login_review'))) {
          echo'<p>';
echo $this->session->flashdata('login_review');
echo'</p>';
$this->session->flashdata('actMsg');
}
else {
	
}

