<?php 
include('koneksi.php');
//$nik = $_GET['nik'];
$getguru = $_GET['idguru'];
//$gettgl = $_GET['tgl'];

$tgl = gmdate("d-m-Y", time()+60*60*7);
//cek jadwal setiap guru
$queryJadwal = mysqli_query($con,"SELECT * FROM tabel_jadwal WHERE id_guru='".$getguru."' AND tgl='".$tgl."'");
if (mysqli_num_rows($queryJadwal)>0) {
	//echo "ketemu";
	$jadwal = mysqli_fetch_assoc($queryJadwal);
	$kelas =$jadwal['id_kelas'];
	$queryKelas="SELECT	tabel_siswakelas.`id_kelas`,tabel_siswa.`id_siswa`, tabel_siswa.`nama_lengkap`,tabel_siswakelas.`id_siswa`,tabel_siswakelas.`id_penempatan`
	FROM tabel_siswa, tabel_siswakelas,tabel_kelas
	WHERE tabel_siswa.`id_siswa` = tabel_siswakelas.`id_siswa` 
	AND tabel_siswakelas.`id_kelas` = tabel_kelas.`id_kelas`
	AND tabel_siswakelas.`id_kelas` = '".$kelas."'
	ORDER BY tabel_siswa.`nama_lengkap` ASC";

	$result = mysqli_query($con,$queryKelas);
	$data = array();
	while($row = mysqli_fetch_object($result)){
	$data[]= $row;
	}
	echo json_encode($data);
}else{
	echo "kosong";
}


 ?>