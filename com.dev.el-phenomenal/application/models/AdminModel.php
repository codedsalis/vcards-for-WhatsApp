<?php
defined('BASEPATH') OR exit('Access denied');

class AdminModel extends CI_Model {
        public function __construct()
        {
            $this->load->database();
         }

public function getAllDownloads() {
	$query = $this->db->select('*')
	->get('vcf_files');

	$res = $query->result_array();
	return $res;
}

public function getContactsToday() {
	$query = $this->db->select('*')
	->where('date >= ', strtotime('today'))
	->get('contacts');

	$res = $query->result_array();
	return $res;
}






}