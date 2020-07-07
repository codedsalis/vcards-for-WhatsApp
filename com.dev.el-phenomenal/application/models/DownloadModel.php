<?php
defined('BASEPATH') OR exit('Access denied');

class DownloadModel extends CI_Model {
    public function __construct()
        {
            $this->load->database();
         }


         public function getDownloadsForToday() {
             $query = $this->db->select('*')
             ->where('date_created <=', strtotime('today'))
             ->get('vcf_files');

             $res = $query->result_array();
             return $res;
         }



        }
