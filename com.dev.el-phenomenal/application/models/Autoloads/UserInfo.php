<?php
defined('BASEPATH') OR exit('Access denied');

class UserInfo extends CI_Model {
        public function __construct()
        {
                  $this->load->database();
         }


//------------------------------------------------------------------------------------

public function getUserInfo($id) {
$query = $this->db->select('*')
->where('id', $id)
->or_where('username', $id)->get('users');
$count = $query->num_rows();
if($count > 0)
   {
   	$result = $query->row_array();
return $result;
}

}







}