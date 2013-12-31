<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{

	function __construct() 
	{
        parent::__construct();
        $this->db = $this->load->database('default',true);
    }

    function get_list_role()
    {
    	$this->db->select('ugrp_id,ugrp_name');
    	$sql = $this->db->get('user_groups');
    	if($sql->num_rows>0)
    	{
    		return $sql->result();
    	}
    	else
    	{
    		return FALSE;
    	}
    }

    function cek_login($email,$password,$role)
    {
    	$this->db->where('uacc_email', $email);
    	$this->db->where('uacc_password', MD5($password));
    	$this->db->where('uacc_group_fk', $role);
    	$sql = $this->db->get('user_accounts');
    	if($sql->num_rows()>0)
    	{
    		return $sql->result();
    	}
    	else return FALSE;

    }

}