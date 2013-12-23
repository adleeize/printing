<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kasir_model extends CI_Model{

	function __construct() 
	{
        parent::__construct();
        $this->db = $this->load->database('default',true);
    }

    function get_like_barang($name)
    {
    	$this->db->select('nama_barang');
    	$this->db->like('nama_barang', $name, 'both'); 
    	$sql=$this->db->get('detail_barang');
        if($sql->num_rows>0){
            return $sql->result();
        }
        else return FALSE;
    }

    function get_barang($name)
    {
        $this->db->select('id_barang, nama_barang, harga_jual_biasa, harga_jual_member, satuan');
        $this->db->where('nama_barang', $name);
        $sql = $this->db->get('detail_barang');
        if($sql->num_rows>0){
            return $sql->result();
        }
        else return FALSE;
    }
}