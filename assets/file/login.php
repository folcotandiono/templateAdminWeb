<?php 
include('koneksi.php');
$username = $_GET['username'];
$password = $_GET['password'];
//$getguru = $_GET['idguru'];
//$gettgl = $_GET['tgl'];
//$jam = $_POST['jam'];
//$queryJadwal = "SELECT * FROM tabel_jadwal WHERE id_guru='".$getguru."' AND tgl='".$gettgl."'";
$queryUser = "SELECT * FROM tabel_user JOIN tabel_guru ON tabel_guru.nik = tabel_user.username WHERE username='".$username."' AND password=md5('".$password."') AND level='guru'";
// $queryUser = "SELECT * FROM tabel_user JOIN tabel_guru ON tabel_guru.nik = tabel_user.username WHERE username='".$username."' AND level='guru'";

$result = mysqli_query($con,$queryUser);
$data = array();
if (mysqli_num_rows($result)>0) {
	$row = mysqli_fetch_object($result);
	$data= $row;
	echo json_encode($data);

}else{
	$data=array("username" => "", "password" => "", "id_guru" => "", "status_guru_bk" => "");
	echo json_encode($data);
}
//$jadwal = mysqli_fetch_assoc($query);
//$kelas = $jadwal['id_kelas'];
//$guru = $jadwal['id_guru'];
//$mapel = $jadwal['id_mapel'];

//$qKelas = mysqli_query($con,"SELECT * FROM tabel_kelas WHERE id_kelas='".$kelas."'");

//$qGuru = mysqli_query($con,"SELECT * FROM tabel_guru WHERE id_kelas='".$guru."'");

//$qMapel = mysqli_query($con,"SELECT * FROM tabel_mapel WHERE id_mapel='".$kelas."'");


 ?>