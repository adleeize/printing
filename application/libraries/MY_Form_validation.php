<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
    public function __construct() {
            parent::__construct();
            log_message('debug', 'MY_Form_validation is loaded');
    }
  
    protected function email_available($email) {
        $query = $this->CI->db->get_where('user_accounts', array('uacc_email' => $email));
        if($query->num_rows() > 0) {
            $this->CI->form_validation->set_message('email_available', ' %s sudah terdaftar');
            return FALSE;
        }
        return TRUE;
    }

    protected function validate_current_password($current_password) {
        $pwd = md5($current_password);
        $query = $this->CI->db->get_where('user_accounts', array('uacc_password' => $pwd));
        if($query->num_rows() === 1) {
            $this->CI->form_validation->set_message('validate_current_password', ' salah');
            return FALSE;
        }
        return TRUE;
    }
    
    protected function identitas_available($identitas) {
        $query = $this->CI->db->get_where('member', array('no_identitas' => $identitas));
        if($query->num_rows() > 0) {
            $this->CI->form_validation->set_message('email_available', ' %s sudah terdaftar');
            return FALSE;
        }
        return TRUE;
    }
}

/* End of file MY_Form_validation.php */
/* Location: ./application/library/MY_Form_validation.php */ 	