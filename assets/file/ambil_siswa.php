<?php
include('koneksi.php');
$id = $_GET['id'];

$result = mysqli_query($con,"SELECT *, tabel_siswa.gambar as gambar_siswa, tabel_siswa.jenis_kelamin as jenis_kelamin_siswa, 
							tabel_siswa.tempat_lahir as tempat_lahir_siswa, tabel_siswa.tgl_lahir as tgl_lahir_siswa, 
							tabel_siswa.alamat as alamat_siswa, tabel_siswa.agama as agama_siswa, 
							tabel_siswa.no_hp as no_hp_siswa, tabel_siswa.email as email_siswa FROM  tabel_siswa 
							inner join tabel_siswakelas on tabel_siswa.id_siswa = tabel_siswakelas.id_siswa 
							inner join tabel_kelas on tabel_siswakelas.id_kelas = tabel_kelas.id_kelas 
							inner join tabel_guru on tabel_kelas.id_guru = tabel_guru.id_guru 
							WHERE tabel_siswa.id_siswa='$id'");

$data = array();

$row = mysqli_fetch_array($result);
	
	$data= array("idsiswa" => $row['id_siswa'],
		"nama" => $row['nama_lengkap'],
		"nisn" => $row['nisn'],
		"jk" => $row['jenis_kelamin_siswa'],
		"tempat" => $row['tempat_lahir_siswa'],
		"tgl" => $row['tgl_lahir_siswa'],
		"alamat" => $row['alamat_siswa'],
		"agama" => $row['agama_siswa'],
		"hp" => $row['no_hp_siswa'],
		"email" => $row['email_siswa'],
		"ayah" => $row['nama_ayah'],
		"ibu" => $row['nama_ibu'],
		"gambar" => $row['gambar_siswa'],
		"kelas" => $row['kelas'],
		"wali_kelas" => $row['nama']);

echo json_encode($data);

?>