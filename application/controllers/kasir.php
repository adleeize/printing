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
    	$this->load->view('kasir/templates/header');
    	$this->load->view('kasir/transaksi');
    	$this->load->view('kasir/templates/footer');
    }

    function pesanan()
    {
        $this->load->view('kasir/templates/header');
        $this->load->view('kasir/order');
        $this->load->view('kasir/templates/footer');
    }

    function members()
    {
        $this->load->view('kasir/templates/header');
        $this->load->view('kasir/anggota');
        $this->load->view('kasir/templates/footer');   
    }

    function autocomplete_barang()
    {
    	$name = $this->input->get('q');
    	$res = $this->kasir_model->get_like_barang($name);
    	// if($res){
     //        foreach ($res as $result) {
     //            echo "$result->nama_barang\n";
     //        }
     //    }
        echo json_encode($res);
    }

    function barang_masuk()
    {
        $name = $this->input->get('name');
        $details = $this->kasir_model->get_barang($name);

        echo json_encode($details);
    }
}

/* End of file kasir.php */
/* Location: ./application/controllers/kasir.php */