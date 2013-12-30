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

    function insert_member($no_id,$nama,$pekerjaan,$telp,$kota)
    {
        $data = array(
                'id' => '',
                'no_identitas' => $no_id,
                'nama' => $nama,
                'pekerjaan' => $pekerjaan,
                'no_telp' => $telp,
                'kota' => $kota
                );
        $this->db->insert('member', $data);
    }

    function get_list_members()
    {
        $this->db->select('id,no_identitas,nama,pekerjaan,no_telp,kota,waktu_daftar');
        $sql = $this->db->get('member');
        if($sql->num_rows > 0)
        {
            return $sql->result();
        }
        else return FALSE;
    }

    function edit_member($id,$no_id,$nama,$pekerjaan,$telp,$kota)
    {
        $data = array(
                    'no_identitas' => $no_id,
                    'nama' => $nama,
                    'pekerjaan' => $pekerjaan,
                    'no_telp' => $telp,
                    'kota' => $kota
                );
        $this->db->where('id', $id);
        $this->db->update('member', $data);
    }

    function delete_member($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('member');
    }

    function get_member($no_identitas)
    {
        $this->db->select('id,no_identitas');
        $this->db->where('no_identitas', $no_identitas);
        $sql = $this->db->get('member');
        if($sql->num_rows() > 0)
        {
            return $sql->result();
        }
        else return FALSE;
    }

    function insert_pembelian($dp,$harga,$status,$id_member,$id_fk_account)
    {
        $data = array(
                    'id_pembelian' => '',
                    'dp' => $dp,
                    'total_harga' => $harga,
                    // 'order_date' => now(),
                    // 'pick_date' => $pick_date,
                    'status_pembayaran' => $status,
                    'id_member' => $id_member,
                    'id_fk_account' => $id_fk_account
                );
        $this->db->insert('pembelian', $data);
    }

    function get_id_pembelian_terakhir()
    {
        $this->db->select('id_pembelian');
        $this->db->order_by('id_pembelian', 'desc');
        $sql = $this->db->get('pembelian', 1);

        foreach ($sql->result() as $row) {
            $res = $row->id_pembelian;
        }
        return $res;
    }

    function insert_detail_pembelian($id_pembelian,$id_barang,$jumlah_barang,$luas_barang,$harga_barang)
    {
        $i=0;
        $z=sizeof($id_barang);
        for($i=0;$i<$z;$i++)
        {
            $data = array(
                        'id' => '', 
                        'id_fk_pembelian' => $id_pembelian,
                        'id_fk_detail_barang' => $id_barang[$i],
                        'ukuran_beli' => $luas_barang[$i],
                        'banyak_beli' => $jumlah_barang[$i],
                        'harga' => $harga_barang[$i]
                    );
            $this->db->insert('detail_pembelian', $data);
        }
    }

    function get_list_orders()
    {
        $this->db->select('id_pembelian,dp,total_harga,order_date,pick_date,status_pembayaran,status_pengambilan,id_member,id_fk_account');
        $sql = $this->db->get('pembelian');
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else return FALSE;
    }

    function get_list_orders_ambil()
    {
        $this->db->select('id_pembelian,dp,total_harga,order_date,pick_date,status_pembayaran,status_pengambilan,id_member,id_fk_account');
        $this->db->where('status_pengambilan', 1);
        $sql = $this->db->get('pembelian');
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else return FALSE;
    }

    function get_list_orders_belum()
    {
        $this->db->select('id_pembelian,dp,total_harga,order_date,pick_date,status_pembayaran,status_pengambilan,id_member,id_fk_account');
        $this->db->where('status_pengambilan', 0);
        $sql = $this->db->get('pembelian');
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else return FALSE;
    }

    function ubah_status_pembelian($id)
    {
        $this->db->set('pick_date', 'now()', FALSE);
        $data = array(
                    'status_pembayaran' => 1, 
                    'status_pengambilan' => 1,
                );
        $this->db->where('id_pembelian', $id);
        $this->db->update('pembelian', $data);
    }

    function delete_transaksi($id){
        $this->db->where('id_pembelian', $id);
        $this->db->delete('pembelian');
    }
}