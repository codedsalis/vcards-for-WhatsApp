<?php
defined('BASEPATH') OR exit('Access denied');

class ContactModel extends CI_Model {
    public function __construct()
        {
            $this->load->database();
         }

    public function saveNewContact() {
        $name = $this->input->post('name');
	    $number = $this->input->post('number');
        $type = $this->input->post('type');
        $key = $this->input->post('key');
    
        $data = array(
	        'name' => $name,
	        'phone_number' => $number,
            'account_type' => $type,
            'pass_key' => $key,
	        'date' => time()
        );
        
        if($this->db->insert('contacts', $data)) {

            if(file_exists('./files/vcard_' . date('Ymd') . '.vcf')) {
                
                // create the vcf file if it exists and append data to it
                $vFile = fopen('./files/vcard_' . date('Ymd') . '.vcf', 'a+');
                }
            else {
                //otherwise create a new file for write only
                $vFile = fopen('./files/vcard_' . date('Ymd') . '.vcf', 'w');
            }
                //write data to the file
                $txt = "BEGIN:VCARD\r\n";
                $txt .= "VERSION:2.1\r\n";
                $txt .= "FN:" . $name . "\r\n";
                $txt .= "TEL;CELL:" . $number . "\r\n";
                $txt .= "END;VCARD\r\n";

                //Save data and close the file
                fwrite($vFile, $txt);
                fclose($vFile);


                //Save the Vcard info to the database
                $dataVcf = array(
                    'name' => 'vcard_' . date('Ymd') . '.vcf',
                    'date_created' => time()
                );

                //check if the vcard info already exists in the db
                $check = $this->db->select('name')
                ->where('name', 'vcard_' . date('Ymd') . '.vcf')
                ->get('vcf_files');

                //Count the number of rows returned
                $count = $check->num_rows();

                if($count > 0) {
                    //Do nothing
                }
                else {
                    //save the data
                    $this->db->insert('vcf_files', $dataVcf);
                }
                
            

            $this->session->set_flashdata('entryMsg','<div class="alert alert-success">Contact details saved successfully</div>');
        }
    }


    public function verifyPayment($passkey) {
        if($this->db->set('paid', 1)
        ->where('pass_key', $passKey)
        ->update('contacts')) {
            return $this->session->set_flashdata('verifyPaymentMsg','<div class="alert alert-success">Payment successfully verified</div>');
        }
    }
         
}