<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kategori extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function get_all()
	{
		$sql = "SELECT * FROM kategori
				ORDER BY kategori.id_kategori asc";
		return $this->db->query($sql);
	}

	public function get_one($id)
	{
		$sql = "SELECT * FROM kategori
				WHERE id_kategori = '$id'";
		return $this->db->query($sql);
	}	
	
	public function tambah($data)
	{
		$query=$this->db->insert('kategori',$data);
	}

	function edit($id, $data)
	{
		$this->db->where('id_kategori', $id);
		$this->db->update('kategori', $data); 
	}
	
	function hapus($id)
	{
		$this->db->where('id_kategori', $id);
		$this->db->delete('kategori'); 
	}
	public function delete($tables,$pk,$id){
        $this->db->where($pk,$id);
        $this->db->delete($tables);
    }
	function remove_checked() 
    {
	 	$delete = $this->input->post('item');
 		for ($i=0; $i < count($delete) ; $i++) 
 		{ 
 			$this->db->where('id_kategori', $delete[$i]);
 			$this->db->delete('kategori');
 		}
	}
	 
}