<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
	public function __construct()
	{				
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		//---- cek session -------//		
		$name = $this->session->userdata('nama');
		if ($name=="")
		{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin'>";
		}

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url');
        //===== Load Model =====
        $this->load->model('m_admin');
		$this->load->model('m_kategori');		
		//===== Load Library =====
		$this->load->library('upload');		

	}
	protected function template($page, $data)
	{
		$this->load->view('t_panel/header',$data);
		$this->load->view("t_panel/aside");
		$this->load->view("panel/$page");		
		$this->load->view('t_panel/footer');
	}

	public function index()
	{		
		$page			= "kategori";	
		$data['isi']    = "kategori";	
		$data['title']	= "Kategori";			
		$data['judul1']	= "Kategori";			
		$data['judul2']	= "";					
		$data['set']	= "view";
		$data['dt_kategori']= $this->m_kategori->get_all();						
		$this->template($page, $data);	
	}

	public function add()
	{		
		$page			= "kategori";
		$data['isi']    = "kategori";			
		$data['title']	= "Kategori";			
		$data['judul1']	= "Tambah Data Kategori";			
		$data['judul2']	= "";					
		$data['set']	= "insert";			
		$data['dt_kategori']= $this->m_kategori->get_all();
		$this->template($page, $data);	
	}
	public function ajax_bulk_delete()
	{
		$tabel			= "kategori";
		$pk 				= "id_kategori";
		$list_id 		= $this->input->post('id');
		foreach ($list_id as $id) {
			$this->m_kategori->delete($tabel,$pk,$id);
		}
		echo json_encode(array("status" => TRUE));
	}
	function delete_multiple(){
		$this->m_kategori->remove_checked();
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/kategori'>";
	}	
	
	public function save()
	{
		if($this->input->post('save') == 'save')
		{
			

			$data['nama']			= $this->input->post('nama');			
			$data['remarks']		= $this->input->post('remarks');

			$this->m_kategori->tambah($data);
			$_SESSION['pesan'] 	= "Berhasil tersimpan!";
			$_SESSION['tipe'] 	= "info";
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/kategori'>";
		}			
	}
	
	public function process()
	{
		$id		= $this->input->post('id');
		$set	= $this->input->post('s_process');		
		//FORM EDIT KEGIATAN
		if ($set == 'ubah')
		{
			$page			= "kategori";		
			$data['one_post']= $this->m_kategori->get_one($id);
			$data['title']	= "Kategori";			
			$data['judul1']	= "Edit Data Kategori";			
			$data['isi']    = "kategori";				
			$data['judul2']	= "";						
			$data['set']	= "edit";	
			$data['dt_kategori']= $this->m_kategori->get_all();		
			$this->template($page, $data);	
		}
		//DETAIL DATA
		elseif ($set == 'detail')
		{
			$page			= "kategori";		
			$data['one_post']= $this->m_kategori->get_one($id);
			$data['title']	= "Kategori";			
			$data['judul1']	= "Detail Data Kategori";	
			$data['isi']    = "kategori";			
			$data['judul2']	= "";						
			$data['set']	= "detail";	
			$data['dt_kategori']= $this->m_kategori->get_all();
			$this->template($page, $data);	
		}
		//EDIT DATA KEGIATAN
		elseif ($set == 'edit' )
		{
			

			$data['nama']			= $this->input->post('nama');			
			$data['remarks']		= $this->input->post('remarks');				
							
			$this->m_kategori->edit($id, $data);
			$_SESSION['pesan'] 	= "Berhasil tersimpan!";
			$_SESSION['tipe'] 	= "info";
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/kategori'>";
		}
		//HAPUS DATA KEGIATAN
		elseif ($set == 'hapus' )
		{
			$this->m_kategori->hapus($id);		
			$_SESSION['pesan'] 	= "Berhasil dihapus!";
			$_SESSION['tipe'] 	= "danger";	
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/kategori'>";
		}
		else
		{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."admin/kategori'>";
		}
	}

}
