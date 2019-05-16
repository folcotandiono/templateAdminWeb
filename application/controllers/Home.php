<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{		
		parent::__construct();		
		date_default_timezone_set("Asia/Jakarta");
		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url');
		//===== Load Model =====
		$this->load->model('m_admin');
		$this->load->model('m_produk');
		//===== Load Library =====
		$this->load->library('upload');	
	}
	protected function template($page, $data)
	{
		//$this->load->view('t_setting/header',$data);		
		$this->load->view("panel/$page",$data);		
		//$this->load->view("t_setting/aside");
		//$this->load->view('t_setting/footer');
	}
	public function index()
	{		
		$data['judul']	= "Installation";				
		$data['isi']	= "setting";				
		$page			= "home";		
		$this->template($page,$data);
	}
	
}

