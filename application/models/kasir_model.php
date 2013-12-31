<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kasir_model extends CI_Model{
    
    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
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
        $uri = $this->uri->uri_to_assoc(4);

        $limit = 10;
        $offset = (isset($uri['page']) && $uri['page'] > 0) ? ($uri['page'] * $limit) - $limit : FALSE;

        $pagination_url = 'kasir/pesanan/all/';
        $uri_segment = 5;

        $total_pembelian = $this->db->count_all('pembelian');

        $this->db->select('id_pembelian,dp,total_harga,order_date,pick_date,status_pembayaran,status_pengambilan,id_member,id_fk_account');
        $query = $this->db->get('pembelian', $limit, $offset);
        $this->data['list_orders'] = $query->result();

        $this->load->library('pagination');
        $config = array(
            'base_url' => base_url($pagination_url . 'page/'),
            'total_rows' => $total_pembelian,
            'per_page' => $limit,
            'uri_segment' => $uri_segment,
            'num_links' => 2,
            'use_page_numbers' => TRUE,
            'full_tag_open' => '<div class="pagination"><ul>',
            'full_tag_close' => '</ul></div>',
            'first_link' => '<i class="icon-first-2"></i>',
            'first_tag_open' => '<li class="first">',
            'first_tag_close' => '</li>',
            'last_link' => '<i class="icon-last-2"></i>',
            'last_tag_open' => '<li class="last">',
            'last_tag_close' => '</li>',
            'next_link' => '<i class="icon-next"></i>',
            'next_tag_open' => '<li class="next">',
            'next_tag_close' => '</li>',
            'prev_link' => '<i class="icon-previous"></i>',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a>',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        );
        $this->pagination->initialize($config);

        $this->data['pagination']['links'] = $this->pagination->create_links();
        $this->data['pagination']['total_pembelian'] = $total_pembelian;
        $this->data['number'] = $offset+1;
    }

    function get_list_orders_ambil()
    {
        $uri = $this->uri->uri_to_assoc(4);

        $limit = 10;
        $offset = (isset($uri['page']) && $uri['page'] > 0) ? ($uri['page'] * $limit) - $limit : FALSE;

        $pagination_url = 'kasir/pesanan/ambil/';
        $uri_segment = 5;
        
        $this->db->select('id_pembelian');
        $this->db->where('status_pengambilan', 1);
        $this->db->from('pembelian');
        $total_pembelian = $this->db->count_all_results();

        $this->db->select('id_pembelian,dp,total_harga,order_date,pick_date,status_pembayaran,status_pengambilan,id_member,id_fk_account');
        $this->db->order_by('pick_date', 'desc');
        $this->db->where('status_pengambilan', 1);
        $query = $this->db->get('pembelian', $limit, $offset);
        $this->data['list_orders'] = $query->result();

        $this->load->library('pagination');
        $config = array(
            'base_url' => base_url($pagination_url . 'page/'),
            'total_rows' => $total_pembelian,
            'per_page' => $limit,
            'uri_segment' => $uri_segment,
            'num_links' => 2,
            'use_page_numbers' => TRUE,
            'full_tag_open' => '<div class="pagination"><ul>',
            'full_tag_close' => '</ul></div>',
            'first_link' => '<i class="icon-first-2"></i>',
            'first_tag_open' => '<li class="first">',
            'first_tag_close' => '</li>',
            'last_link' => '<i class="icon-last-2"></i>',
            'last_tag_open' => '<li class="last">',
            'last_tag_close' => '</li>',
            'next_link' => '<i class="icon-next"></i>',
            'next_tag_open' => '<li class="next">',
            'next_tag_close' => '</li>',
            'prev_link' => '<i class="icon-previous"></i>',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a>',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        );
        $this->pagination->initialize($config);

        $this->data['pagination']['links'] = $this->pagination->create_links();
        $this->data['pagination']['total_pembelian'] = $total_pembelian;
        $this->data['number'] = $offset+1;
    }

    function get_list_orders_belum()
    {
        $uri = $this->uri->uri_to_assoc(3);

        $limit = 10;
        $offset = (isset($uri['page']) && $uri['page'] > 0) ? ($uri['page'] * $limit) - $limit : FALSE;

        $pagination_url = 'kasir/pesanan/';
        $uri_segment = 4;
        
        $this->db->select('id_pembelian');
        $this->db->where('status_pengambilan', 0);
        $this->db->from('pembelian');
        $total_pembelian = $this->db->count_all_results();

        $this->db->select('id_pembelian,dp,total_harga,order_date,pick_date,status_pembayaran,status_pengambilan,id_member,id_fk_account');
        $this->db->order_by('order_date', 'desc');
        $this->db->where('status_pengambilan', 0);
        $query = $this->db->get('pembelian', $limit, $offset);
        $this->data['list_orders'] = $query->result();

        $this->load->library('pagination');
        $config = array(
            'base_url' => base_url($pagination_url . 'page/'),
            'total_rows' => $total_pembelian,
            'per_page' => $limit,
            'uri_segment' => $uri_segment,
            'num_links' => 2,
            'use_page_numbers' => TRUE,
            'full_tag_open' => '<div class="pagination"><ul>',
            'full_tag_close' => '</ul></div>',
            'first_link' => '<i class="icon-first-2"></i>',
            'first_tag_open' => '<li class="first">',
            'first_tag_close' => '</li>',
            'last_link' => '<i class="icon-last-2"></i>',
            'last_tag_open' => '<li class="last">',
            'last_tag_close' => '</li>',
            'next_link' => '<i class="icon-next"></i>',
            'next_tag_open' => '<li class="next">',
            'next_tag_close' => '</li>',
            'prev_link' => '<i class="icon-previous"></i>',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a>',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        );
        $this->pagination->initialize($config);

        $this->data['pagination']['links'] = $this->pagination->create_links();
        $this->data['pagination']['total_pembelian'] = $total_pembelian;
        $this->data['number'] = $offset+1;
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
    
    function get_pembelian($id_pembelian) {
        $this->db->select('pembelian.id_member');
        $this->db->from('pembelian');
        $this->db->join('detail_pembelian', 'detail_pembelian.id_fk_pembelian = pembelian.id_pembelian');
        $this->db->join('detail_barang', 'detail_barang.id_barang = detail_pembelian.id_fk_detail_barang');
        $this->db->where('pembelian.id_pembelian', $id_pembelian);
        $query = $this->db->get();
        
        $id_member = $query->row()->id_member;
        
        if($id_member != 0) {
            $this->db->select("pembelian.id_pembelian,
                               pembelian.order_date, 
                               pembelian.pick_date, 
                               detail_barang.nama_barang, 
                               detail_pembelian.ukuran_beli, 
                               detail_barang.satuan,
                               detail_barang.harga_jual_member AS harga_jual,
                               detail_pembelian.banyak_beli, 
                               detail_pembelian.harga, 
                               pembelian.total_harga");
        } else {
            $this->db->select("pembelian.id_pembelian,
                               pembelian.order_date, 
                               pembelian.pick_date, 
                               detail_barang.nama_barang, 
                               detail_pembelian.ukuran_beli, 
                               detail_barang.satuan,
                               detail_barang.harga_jual_biasa AS harga_jual,
                               detail_pembelian.banyak_beli, 
                               detail_pembelian.harga, 
                               pembelian.total_harga");
        }
        $this->db->from('pembelian');
        $this->db->join('detail_pembelian', 'detail_pembelian.id_fk_pembelian = pembelian.id_pembelian');
        $this->db->join('detail_barang', 'detail_barang.id_barang = detail_pembelian.id_fk_detail_barang');
        $this->db->where('pembelian.id_pembelian', $id_pembelian);
        $query = $this->db->get();
            
        return $query->result();
    }
}