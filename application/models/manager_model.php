<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manager_model extends CI_Model{
    
    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    function __construct() {
        parent::__construct();
    }

    function list_barang() {
        $uri = $this->uri->uri_to_assoc(3);

        $limit = 10;
        $offset = (isset($uri['page'])) ? ($uri['page'] * $limit) - $limit : FALSE;

        $pagination_url = 'manager/index/';
        $uri_segment = 4;

        $total_barang = $this->db->count_all('detail_barang');

        $query = $this->db->get('detail_barang', $limit, $offset);
        $this->data['list_barang'] = $query->result();

        $this->load->library('pagination');
        $config = array(
            'base_url' => base_url($pagination_url . 'page/'),
            'total_rows' => $total_barang,
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
        $this->data['pagination']['total_users'] = $total_barang;
    }
    
    function delete_barang() {
        if($list_barang = $this->input->post('delete_barang')) {
            $total = 0;
            foreach($list_barang as $id_barang => $status) {
                if($status === '1') {
                    $this->db->delete('detail_barang', array('id_barang' => $id_barang));
                }
            }
        }
        
        $this->session->set_flashdata('response', 'success');
        $this->session->set_flashdata('message', 'Data berhasil dihapus!!');
        
        redirect('manager');
    }
    
    function update_barang($id_barang) {
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama_barang', 'label' => 'Nama Barang', 'rules' => 'required'),
            array('field' => 'satuan', 'label' => 'Satuan', 'rules' => 'required'),
            array('field' => 'harga_beli', 'label' => 'Harga Beli', 'rules' => 'required|integer|min_length[3]'),
            array('field' => 'harga_jual_biasa', 'label' => 'Harga Jual Non-member', 'rules' => 'required|integer|min_length[3]'),
            array('field' => 'harga_jual_member', 'label' => 'Harga Jual Member', 'rules' => 'required|integer|min_length[3]')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<p style="color:#e51400">', '</p>');

        if ($this->form_validation->run()) {
            $data = array(
                'nama_barang' => $this->input->post('nama_barang'),
                'harga_beli' => $this->input->post('harga_beli'),
                'harga_jual_biasa' => $this->input->post('harga_jual_biasa'),
                'harga_jual_member' => $this->input->post('harga_jual_member'),
                'satuan' => $this->input->post('satuan')
            );
            
            $this->db->trans_start();
            $this->db->update('detail_barang', $data, array('id_barang' => $id_barang));
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === TRUE) {
                $this->session->set_flashdata('response', 'success');
                $this->session->set_flashdata('message', 'Update data berhasil!!');
            } else {
                $this->session->set_flashdata('response', 'error');
                $this->session->set_flashdata('message', 'Update data gagal!!');
            }

            redirect('manager');
        }

        return FALSE;
    }
    
    function input_barang() {
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama_barang', 'label' => 'Nama Barang', 'rules' => 'required'),
            array('field' => 'satuan', 'label' => 'Satuan', 'rules' => 'required'),
            array('field' => 'harga_beli', 'label' => 'Harga Beli', 'rules' => 'required|integer|min_length[3]'),
            array('field' => 'harga_jual_biasa', 'label' => 'Harga Jual Non-member', 'rules' => 'required|integer|min_length[3]'),
            array('field' => 'harga_jual_member', 'label' => 'Harga Jual Member', 'rules' => 'required|integer|min_length[3]')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<p style="color:#e51400">', '</p>');

        if ($this->form_validation->run()) {
            $data = array(
                'nama_barang' => $this->input->post('nama_barang'),
                'harga_beli' => $this->input->post('harga_beli'),
                'harga_jual_biasa' => $this->input->post('harga_jual_biasa'),
                'harga_jual_member' => $this->input->post('harga_jual_member'),
                'satuan' => $this->input->post('satuan')
            );
            
            $this->db->insert('detail_barang', $data);
            
            if($this->db->affected_rows() == 1) {
                $this->session->set_flashdata('response', 'success');
                $this->session->set_flashdata('message', 'Data berhasil ditambahkan!!');
            } else {
                $this->session->set_flashdata('response', 'error');
                $this->session->set_flashdata('message', 'Data gagal ditambahkan!!');
            }

            redirect('manager');
        }

        return FALSE;
    }
    
    function list_member() {
        $uri = $this->uri->uri_to_assoc(3);

        $limit = 10;
        $offset = (isset($uri['page'])) ? ($uri['page'] * $limit) - $limit : FALSE;

        $pagination_url = 'manager/member/';
        $uri_segment = 4;

        $total_member = $this->db->count_all('member');

        $this->db->order_by('waktu_daftar', 'desc'); 
        $query = $this->db->get('member', $limit, $offset);
        $this->data['list_member'] = $query->result();

        $this->load->library('pagination');
        $config = array(
            'base_url' => base_url($pagination_url . 'page/'),
            'total_rows' => $total_member,
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
        $this->data['pagination']['total_users'] = $total_member;
    }
    
    function input_member() {
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'required'),
            array('field' => 'identitas', 'label' => 'No Identitas', 'rules' => 'required'),
            array('field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required'),
            array('field' => 'no_telp', 'label' => 'Nomor Telepon', 'rules' => 'required'),
            array('field' => 'kota', 'label' => 'Kota', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<p style="color:#e51400">', '</p>');

        if ($this->form_validation->run()) {
            $data = array(
                'no_identitas' => $this->input->post('identitas'),
                'nama' => $this->input->post('nama'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'no_telp' => $this->input->post('no_telp'),
                'kota' => $this->input->post('kota'),
                'waktu_daftar' => date('Y-m-d H:i:s', time())
            );
            
            $this->db->insert('member', $data);
            
            if($this->db->affected_rows() == 1) {
                $this->session->set_flashdata('response', 'success');
                $this->session->set_flashdata('message', 'Data member berhasil ditambahkan!!');
            } else {
                $this->session->set_flashdata('response', 'error');
                $this->session->set_flashdata('message', 'Data member gagal ditambahkan!!');
            }

            redirect('manager/member');
        }

        return FALSE;
    }
    
    function update_member($id_member) {
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'required'),
            array('field' => 'identitas', 'label' => 'No Identitas', 'rules' => 'required'),
            array('field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required'),
            array('field' => 'no_telp', 'label' => 'Nomor Telepon', 'rules' => 'required'),
            array('field' => 'kota', 'label' => 'Kota', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<p style="color:#e51400">', '</p>');

        if ($this->form_validation->run()) {
            $data = array(
                'no_identitas' => $this->input->post('identitas'),
                'nama' => $this->input->post('nama'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'no_telp' => $this->input->post('no_telp'),
                'kota' => $this->input->post('kota')
            );
            
            $this->db->trans_start();
            $this->db->update('member', $data, array('id' => $id_member));
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === TRUE) {
                $this->session->set_flashdata('response', 'success');
                $this->session->set_flashdata('message', 'Update data member berhasil!!');
            } else {
                $this->session->set_flashdata('response', 'error');
                $this->session->set_flashdata('message', 'Update data member gagal!!');
            }

            redirect('manager/member');
        }

        return FALSE;
    }
    
    function delete_member() {
        if($list_member = $this->input->post('delete_member')) {
            $total = 0;
            foreach($list_member as $id_member => $status) {
                if($status === '1') {
                    $this->db->delete('member', array('id' => $id_member));
                }
            }
        }
        
        $this->session->set_flashdata('response', 'success');
        $this->session->set_flashdata('message', 'Data member berhasil dihapus!!');
        
        redirect('manager/member');
    }
    
    function list_kasir() {
        $uri = $this->uri->uri_to_assoc(3);

        $limit = 10;
        $offset = (isset($uri['page'])) ? ($uri['page'] * $limit) - $limit : FALSE;

        $pagination_url = 'manager/kasir/';
        $uri_segment = 4;

        $this->db->order_by('uacc_date_added', 'desc'); 
        $this->db->where('uacc_group_fk', 1);
        $query = $this->db->get('user_accounts', $limit, $offset);
        $this->data['list_kasir'] = $query->result();
        $total_kasir = $query->num_rows();

        $this->load->library('pagination');
        $config = array(
            'base_url' => base_url($pagination_url . 'page/'),
            'total_rows' => $total_kasir,
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
        $this->data['pagination']['total_users'] = $total_kasir;
    }
    
    function input_kasir() {
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'required'),
            array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email|email_available'),
            array('field' => 'identitas', 'label' => 'No Pegawai', 'rules' => 'required'),
            array('field' => 'no_telp', 'label' => 'Nomor Telepon', 'rules' => 'required'),
            array('field' => 'kota', 'label' => 'Kota', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<p style="color:#e51400">', '</p>');

        if ($this->form_validation->run()) {
            $data = array(
                'uacc_group_fk' => 1,
                'uacc_email' => $this->input->post('email'),
                'uacc_name' => $this->input->post('nama'),
                'uacc_password' => md5('printing'),
                'uacc_no_peg' => $this->input->post('identitas'),
                'uacc_phone' => $this->input->post('no_telp'),
                'uacc_kota' => $this->input->post('kota'),
                'uacc_date_added' => date('Y-m-d H:i:s', time())
            );
            
            $this->db->insert('user_accounts', $data);
            
            if($this->db->affected_rows() == 1) {
                $this->session->set_flashdata('response', 'success');
                $this->session->set_flashdata('message', 'Data kasir berhasil ditambahkan!!');
            } else {
                $this->session->set_flashdata('response', 'error');
                $this->session->set_flashdata('message', 'Data kasir gagal ditambahkan!!');
            }

            redirect('manager/kasir');
        }

        return FALSE;
    }
    
    function update_kasir($id_kasir) {
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'required'),
            array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email|email_available'),
            array('field' => 'identitas', 'label' => 'No Pegawai', 'rules' => 'required'),
            array('field' => 'no_telp', 'label' => 'Nomor Telepon', 'rules' => 'required'),
            array('field' => 'kota', 'label' => 'Kota', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<p style="color:#e51400">', '</p>');

        if ($this->form_validation->run()) {
            $data = array(
                'uacc_email' => $this->input->post('email'),
                'uacc_name' => $this->input->post('nama'),
                'uacc_no_peg' => $this->input->post('identitas'),
                'uacc_phone' => $this->input->post('no_telp'),
                'uacc_kota' => $this->input->post('kota')
            );
            
            $this->db->trans_start();
            $this->db->update('user_accounts', $data, array('uacc_id' => $id_kasir));
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === TRUE) {
                $this->session->set_flashdata('response', 'success');
                $this->session->set_flashdata('message', 'Update data kasir berhasil!!');
            } else {
                $this->session->set_flashdata('response', 'error');
                $this->session->set_flashdata('message', 'Update data kasir gagal!!');
            }

            redirect('manager/kasir');
        }

        return FALSE;
    }
    
    function delete_kasir() {
        if($list_kasir = $this->input->post('delete_kasir')) {
            $total = 0;
            foreach($list_kasir as $id_kasir => $status) {
                if($status === '1') {
                    $this->db->delete('user_accounts', array('uacc_id' => $id_kasir));
                }
            }
        }
        
        $this->session->set_flashdata('response', 'success');
        $this->session->set_flashdata('message', 'Data kasir berhasil dihapus!!');
        
        redirect('manager/kasir');
    }
    
    function profil() {
        $id_manager = $this->session->userdata('id');
        
        $this->db->select('*');
        $this->db->from('user_accounts');
        $this->db->join('user_groups', 'user_groups.ugrp_id = user_accounts.uacc_id');
        $this->db->where('uacc_id', $id_manager);
        $query = $this->db->get();
        
        $this->data['manager'] = $query->row();
    }
    
    function update_manager() {
//        $this->load->library('session');
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'nama', 'label' => 'Nama', 'rules' => 'required'),
            array('field' => 'password', 'label' => 'Password', 'rules' => 'required'),
            array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email|email_available'),
            array('field' => 'identitas', 'label' => 'No Pegawai', 'rules' => 'required'),
            array('field' => 'no_telp', 'label' => 'Nomor Telepon', 'rules' => 'required'),
            array('field' => 'kota', 'label' => 'Kota', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<p style="color:#e51400">', '</p>');

        if ($this->form_validation->run()) {
            $id_manager = $this->session->userdata('id');
            $nama = $this->input->post('nama');
            $no_peg = $this->input->post('identitas');
            
            $data = array(
                'uacc_email' => $this->input->post('email'),
                'uacc_name' => $nama,
                'uacc_no_peg' => $no_peg,
                'uacc_phone' => $this->input->post('no_telp'),
                'uacc_kota' => $this->input->post('kota')
            );
            
            $this->db->trans_start();
            $this->db->update('user_accounts', $data, array('uacc_id' => $id_manager));
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === TRUE) {
                $array_items = array('name' => '', 'no_peg' => '');
                $this->session->unset_userdata($array_items);
                
                $array_items = array('name' => $nama, 'no_peg' => $no_peg);
                $this->session->set_userdata($array_items);
                
                $this->session->set_flashdata('response', 'success');
                $this->session->set_flashdata('message', 'Update profil berhasil!!');
            } else {
                $this->session->set_flashdata('response', 'error');
                $this->session->set_flashdata('message', 'Update profil gagal!!');
            }

            redirect('manager/profil');
        }

        return FALSE;
    }
    
    function change_password() {
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'current_password', 'label' => 'Password lama', 'rules' => 'required|validate_current_password'),
            array('field' => 'new_password', 'label' => 'Password baru', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<p style="color:#e51400">', '</p>');

        if ($this->form_validation->run()) {
            $id_manager = $this->session->userdata('id');
            
            $data = array(
                'uacc_password' => md5($this->input->post('new_password'))
            );
            
            $this->db->trans_start();
            $this->db->update('user_accounts', $data, array('uacc_id' => $id_manager));
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === TRUE) {
                $this->session->set_flashdata('response', 'success');
                $this->session->set_flashdata('message', 'Ganti password berhasil!!');
            } else {
                $this->session->set_flashdata('response', 'error');
                $this->session->set_flashdata('message', 'Ganti password gagal!!');
            }

            redirect('manager/password');
        }

        return FALSE;
    }
}