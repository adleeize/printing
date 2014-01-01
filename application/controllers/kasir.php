<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kasir extends CI_Controller {
	function __construct()
	{
        parent::__construct();
        $this->load->helper(array('form', 'url','date'));
        $this->load->model('kasir_model','',TRUE);
        $this->data = NULL;
        
        if($this->session->userdata('role') != 1) redirect('login');
    }

    function index()
    {
    	$this->load->view('kasir/templates/header');
    	$this->load->view('kasir/transaksi');
    	$this->load->view('kasir/templates/footer');
    }

    function pesanan()
    {
        if($this->uri->segment(3) === "all")
        {
            $this->kasir_model->get_list_orders();
        }
        else if($this->uri->segment(3) === "ambil")
        {
            $this->kasir_model->get_list_orders_ambil();   
        }
        else
        {
            $this->kasir_model->get_list_orders_belum();
        }
        $this->load->view('kasir/templates/header');
        $this->load->view('kasir/order', $this->data);
        $this->load->view('kasir/templates/footer');
    }

    function members()
    {
        $details['list_members'] = $this->kasir_model->get_list_members() === FALSE ? '' : $this->kasir_model->get_list_members();
        $this->load->view('kasir/templates/header');
        $this->load->view('kasir/anggota',$details);
        $this->load->view('kasir/templates/footer');   
    }

    function autocomplete_barang()
    {
    	$name = $this->input->get('q');
    	$res = $this->kasir_model->get_like_barang($name);
    	
        echo $this->json_encode($res);
    }

    function barang_masuk()
    {
        $name = $this->input->get('name');
        $details = $this->kasir_model->get_barang($name);

        echo $this->json_encode($details);
    }

    function register_member()
    {
        $no_id = $this->input->get('no_ktp');
        $nama = $this->input->get('nama');
        $pekerjaan = $this->input->get('pekerjaan');
        $telp = $this->input->get('telp');
        $kota = $this->input->get('kota');

        $this->kasir_model->insert_member($no_id,$nama,$pekerjaan,$telp,$kota);
        redirect('kasir/members');
    }

    function edit_member()
    {
        $id = $this->input->get('edit-id');
        $no_id = $this->input->get('no_ktp');
        $nama = $this->input->get('nama');
        $pekerjaan = $this->input->get('pekerjaan');
        $telp = $this->input->get('telp');
        $kota = $this->input->get('kota');

        $this->kasir_model->edit_member($id,$no_id,$nama,$pekerjaan,$telp,$kota);
        redirect('kasir/members');
    }

    function hapus_member()
    {
        $id = $this->input->get('id');

        $this->kasir_model->delete_member($id);
        redirect('kasir/members');
    }

    function cek_member()
    {
        $no_ktp = $this->input->get('id');

        $res = $this->kasir_model->get_member($no_ktp);

        // $res = FALSE ? "false" : json_encode($res);
        echo $this->json_encode($res);
    }

    function transaksi_pembelian()
    {
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
        if(isset($_GET['id']))
        {
            $id = $this->input->get('id');
            $this->kasir_model->ubah_status_pembelian($id);
        }
    }

    function delete_transaksi()
    {
        if(isset($_GET['id']))
        {
            $id = $this->input->get('id');
            $this->kasir_model->delete_transaksi($id);
        }
    }
    
    function cetak_nota($id_pembelian = FALSE) {
        $data_beli = $this->kasir_model->get_pembelian($id_pembelian);
        
        $arr_beli = array();
        foreach($data_beli as $beli) {
            $order_date = $beli->order_date;
            $pick_date = $beli->pick_date;
            $id_beli = $beli->id_pembelian;
            $total_harga = $beli->total_harga;
            
            $arr_beli[] = array(
                $beli->nama_barang, 
                $beli->ukuran_beli, 
                $beli->satuan, 
                $beli->banyak_beli, 
                $beli->harga, 
                $beli->harga_jual
            );
        }
        
        $order_date = date('d-m-Y H:i', strtotime($order_date));
        $pick_date = date('d-m-Y H:i', strtotime($pick_date));
        
        $params = array('orientation' => 'L', 'unit' => 'mm', 'size' => 'A4');
        $this->load->library('pdf', $params);
        $this->pdf->fontpath = 'font/';
        
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 18);
        
        $this->pdf->SetX(15);
        $this->pdf->Write(5, 'INVOICE');
        
        $this->pdf->SetX(175);
        $this->pdf->Write(5, 'INDOPRINTING');
        
        $this->pdf->Ln();
        
        $this->pdf->SetFont('Arial', '', 12);
        
        $this->pdf->SetX(15);
        $this->pdf->Write(5, 'SM130529070');
        $this->pdf->SetX(180);
        $this->pdf->Write(5, 'Jl Durian Raya 100');
        $this->pdf->Ln();
        
        $this->pdf->SetX(15);
        $this->pdf->Write(5, 'No PO   X');
        $this->pdf->SetX(160);
        $this->pdf->Write(5, 'Telp: 024-33099555 - Fax: 024-7499555');
        $this->pdf->Ln();
        
        $this->pdf->SetX(15);
        $this->pdf->Write(5, 'To :');
        $this->pdf->SetX(171);
        $this->pdf->Write(5, 'e-mail : cs@indoprinting.co.id');
        $this->pdf->Ln();
        
        $this->pdf->SetFont('Arial', 'B', 12);
        
        $this->pdf->SetX(15);
        $this->pdf->Cell(90, 8, 'Garuda Digital Printing', 'LTR');
        
        $this->pdf->SetFont('Arial', '', 12);
        
        $this->pdf->SetX(115);
        $this->pdf->Cell(36, 8, 'Disc         0,00  %', 'LTR');
        
        $this->pdf->SetX(160);
        $this->pdf->Cell(87, 8, 'Order Date      '.$order_date, 'LTR');
        $this->pdf->Ln();
        
        $this->pdf->SetX(15);
        $this->pdf->Cell(90, 6, 'Semarang', 'LR');
        
        $this->pdf->SetX(115);
        $this->pdf->Cell(36, 6, 'PPN         0,00  %', 'LR');
        
        $this->pdf->SetX(160);
        $this->pdf->Cell(87, 6, 'Pick Date        '.$pick_date, 'LBR');
        $this->pdf->Ln();
        
        $this->pdf->SetX(15);
        $this->pdf->Cell(90, 6, 'Semarang, Telp. X', 'LRB');
        
        $this->pdf->SetX(115);
        $this->pdf->Cell(36, 6, '', 'LRB');
        
        $this->pdf->SetX(160);
        $this->pdf->Cell(87, 6, 'TOP                '.date('d-m-Y', time()), 'LRB');
        $this->pdf->Ln(15);
        
        $this->pdf->SetFont('Arial', 'B', 12);
        
        $this->pdf->SetX(15);
        $this->pdf->Cell(12, 10, 'No', 1, '', 'C');
        $this->pdf->Cell(110, 10, 'Description', 1, '', 'C');
        $this->pdf->Cell(20, 10, 'Qty', 1, '', 'C');
        $this->pdf->Cell(30, 10, 'Total Qty', 1, '', 'C');
        $this->pdf->Cell(30, 10, 'Price', 1, '', 'C');
        $this->pdf->Cell(30, 10, 'Amount', 1, '', 'C');
        $this->pdf->Ln();
        
        $this->pdf->SetFont('Arial', '', 12);
        
        $no = 1;
        foreach($arr_beli as $beli) {
            $this->pdf->SetX(15);
            $this->pdf->Cell(12, 8, $no++, 1, '', 'C');
            $this->pdf->CellFitScale(80, 8, $beli[0], 1);
            $this->pdf->CellFitScale(30, 8, '1,00 X '.$beli[1], 1);
            $this->pdf->Cell(20, 8, $beli[3], 1, '', 'R');
            $this->pdf->Cell(30, 8, $beli[3]*$beli[1].' '.$beli[2], 1, '', 'R');
            $this->pdf->Cell(30, 8, number_format($beli[5], 0, '', '.'), 1, '', 'R');
            $this->pdf->Cell(30, 8, number_format($beli[4], 0, '', '.'), 1, '', 'R');
            $this->pdf->Ln();
        }
        
        $this->pdf->SetX(15);
        $this->pdf->Cell(172, 8, 'Marketing Kantor', 1, '', 'C');
        $this->pdf->Cell(30, 8, 'Value', 1, '', 'R');
        $this->pdf->Cell(30, 8, number_format($total_harga, 0, '', '.'), 1, '', 'R');
        $this->pdf->Ln();
        
//        $this->pdf->SetFont('Arial', 'B', 6);
        $this->pdf->SetX(15);
        $this->pdf->Cell(122, 10, '', 'LT');
//        $this->pdf->Cell(122, 10, '        3 Keunggulan Indoprinting\n', 'LT');
        
//        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->Cell(20, 10, 'Cash', 'LTR', '', 'R');
        $this->pdf->Cell(30, 10, number_format($total_harga, 0, '', '.'), 'TR', '', 'R');
        $this->pdf->Cell(30, 10, 'Disc', 'TR', '', 'R');
        $this->pdf->Cell(30, 10, '0', 'TR', '', 'R');
        $this->pdf->Ln();
        
//        $this->pdf->SetFont('Arial', '', 6);
        $this->pdf->SetX(15);
        $this->pdf->Cell(122, 10, '', 'L');
//        $this->pdf->Cell(122, 5, '        1 Hasil Printing : kami hanya menggunakan mesin printing terbaik & maintenance secara rutin, sehingga', 'LT');
        
//        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->Cell(20, 10, 'Bank', 'LR', '', 'R');
        $this->pdf->Cell(30, 10, '0', 'R', '', 'R');
        $this->pdf->Cell(30, 10, 'PPN', 'R', '', 'R');
        $this->pdf->Cell(30, 10, '0', 'R', '', 'R');
        $this->pdf->Ln();
        
        $this->pdf->SetX(15);
        $this->pdf->Cell(122, 10, '', 'LB');
        $this->pdf->Cell(20, 10, 'Credit', 'LRB', '', 'R');
        $this->pdf->Cell(30, 10, '0', 'RB', '', 'R');
        $this->pdf->Cell(30, 10, 'Total Value', 'RB', '', 'R');
        $this->pdf->Cell(30, 10, number_format($total_harga, 0, '', '.'), 'RB', '', 'R');
        $this->pdf->Ln(10);
        
        $this->pdf->SetFont('Arial', '', 6);
        $this->pdf->SetX(15);
        $this->pdf->Write(5, 'Terima kasih telah menggunakan produk kami, kritik & saran silakan sms: 081 32704 3234');
        $this->pdf->Ln(20);
        
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->SetX(185);
        $this->pdf->Write(5, 'Trainee - '.date('H:i', time()));
        $this->pdf->Ln();
        
        $this->pdf->SetX(70);
        $this->pdf->Write(5, 'Customer');
        $this->pdf->SetX(183);
        $this->pdf->Write(5, 'Customer Service');
        
        $this->pdf->Output('Nota Order #'.$id_beli.'.pdf', 'D');
    }
    
    function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = $this->json_encode($value);
                    $output_associative[] = $this->json_encode($key) . ':' . $this->json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
}

/* End of file kasir.php */
/* Location: ./application/controllers/kasir.php */