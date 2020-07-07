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


public function getContactByKey(string $key) : array {
        $query = $this->db->select('*')
        ->where('pass_key', $key)
        ->get('contacts');

        $res = $query->result_array();
        return $res;
}


public function checkPassword($passKey) {
        $query = $this->db->select('pass_key')
        ->where('pass_key', $passKey)
        ->get('contacts');

        $count = $query->num_rows();

        if($count > 0) {
                return true;
        }
        else {
                return false;
        }
}


public function getPackageType(string $passKey) : string {
        $query = $this->db->select('account_type')
        ->where('pass_key', $passKey)
        ->get('contacts');

        foreach($query->result_array() as $res) {
                $accountType = $res['account_type'];
                return $accountType;
        }
}



public function checkPaymentStatus(string $passKey) : bool {
        $query = $this->db->select('paid')
        ->where('pass_key', $passKey)
        ->get('contacts');

        foreach($query->result_array() as $res) {
                $paymentStatus = $res['paid'];
                if($paymentStatus == 0) {
                        return false;
                }
                else {
                        return true;
                }
        }
}

}