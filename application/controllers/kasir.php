<?php

class Kasir extends CI_Controller {
	function __construct()
	{
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper(array('form', 'url','date'));
        $this->load->model('kasir_model','',TRUE);
    }

    function index()
    {
        if(!$this->session->userdata('id')) redirect('login');

    	$this->load->view('kasir/templates/header');
    	$this->load->view('kasir/transaksi');
    	$this->load->view('kasir/templates/footer');
    }

    function pesanan()
    {
        if(!$this->session->userdata('id')) redirect('login');

        if($this->uri->segment(3) == "all")
        {
            $details['list_orders'] = $this->kasir_model->get_list_orders();
        }
        else if($this->uri->segment(3) == "ambil")
        {
            $details['list_orders'] = $this->kasir_model->get_list_orders_ambil();   
        }
        else
        {
            $details['list_orders'] = $this->kasir_model->get_list_orders_belum();
        }
        $this->load->view('kasir/templates/header');
        $this->load->view('kasir/order',$details);
        $this->load->view('kasir/templates/footer');
    }

    function members()
    {
        if(!$this->session->userdata('id')) redirect('login');

        $details['list_members'] = $this->kasir_model->get_list_members() == FALSE ? '' : $this->kasir_model->get_list_members();
        $this->load->view('kasir/templates/header');
        $this->load->view('kasir/anggota',$details);
        $this->load->view('kasir/templates/footer');   
    }

    function autocomplete_barang()
    {
        if(!$this->session->userdata('id')) redirect('login');

    	$name = $this->input->get('q');
    	$res = $this->kasir_model->get_like_barang($name);
    	
        echo json_encode($res);
    }

    function barang_masuk()
    {
        if(!$this->session->userdata('id')) redirect('login');

        $name = $this->input->get('name');
        $details = $this->kasir_model->get_barang($name);

        echo json_encode($details);
    }

    function register_member()
    {
        if(!$this->session->userdata('id')) redirect('login');

        $no_id = $this->input->get('no_ktp');
        $nama = $this->input->get('nama');
        $pekerjaan = $this->input->get('pekerjaan');
        $telp = $this->input->get('telp');
        $kota = $this->input->get('kota');

        $this->kasir_model->insert_member($no_id,$nama,$pekerjaan,$telp,$kota);
        redirect(site_url('kasir/members'));
        // header("location:".site_url('kasir/members'));
    }

    function edit_member()
    {
        if(!$this->session->userdata('id')) redirect('login');

        $id = $this->input->get('edit-id');
        $no_id = $this->input->get('no_ktp');
        $nama = $this->input->get('nama');
        $pekerjaan = $this->input->get('pekerjaan');
        $telp = $this->input->get('telp');
        $kota = $this->input->get('kota');

        $this->kasir_model->edit_member($id,$no_id,$nama,$pekerjaan,$telp,$kota);
        redirect(site_url('kasir/members'));
    }

    function hapus_member()
    {
        if(!$this->session->userdata('id')) redirect('login');

        $id = $this->input->get('id');

        $this->kasir_model->delete_member($id);
        redirect(site_url('kasir/members'));
    }

    function cek_member()
    {
        if(!$this->session->userdata('id')) redirect('login');

        $no_ktp = $this->input->get('id');

        $res = $this->kasir_model->get_member($no_ktp);

        // $res = FALSE ? "false" : json_encode($res);
        echo json_encode($res);
    }

    function transaksi_pembelian()
    {
        if(!$this->session->userdata('id')) redirect('login');

        $dp = $this->input->post('dp');
        $harga = $this->input->post('tot_harga');
        // $pick_date = $this->input->post('tgl_ambil');
        $status = $this->input->post('status');
        $id_member = $this->input->post('member');
        $id_fk_account = 1;

        $this->kasir_model->insert_pembelian($dp,$harga,$status,$id_member,$id_fk_account);

        // get id_pembelian
        $res = $this->kasir_model->get_id_pembelian_terakhir();
        echo $res;
    }

    function detail_transaksi_pembelian()
    {
        if(!$this->session->userdata('id')) redirect('login');

        $id_pembelian = $this->input->post('id_trans');
        $id_barang = $this->input->post('id_barang');
        $jumlah_barang = $this->input->post('jumlah_brg');
        $luas_barang = $this->input->post('luas_barang');
        $harga_barang= $this->input->post('harga_barang');

        $this->kasir_model->insert_detail_pembelian($id_pembelian,$id_barang,$jumlah_barang,$luas_barang,$harga_barang);
        echo $id_pembelian;
    }

    function proses_transaksi()
    {
        if(!$this->session->userdata('id')) redirect('login');

        if(isset($_GET['id']))
        {
            $id = $this->input->get('id');
            $this->kasir_model->ubah_status_pembelian($id);
        }
    }

    function delete_transaksi()
    {
        if(!$this->session->userdata('id')) redirect('login');
        
        if(isset($_GET['id']))
        {
            $id = $this->input->get('id');
            $this->kasir_model->delete_transaksi($id);
        }
    }
}

/* End of file kasir.php */
/* Location: ./application/controllers/kasir.php */