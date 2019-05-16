<?php 
include ('koneksi.php');
$idpen = $_POST['idpenem'];
$ketabsen = $_POST['absen'];
$tgl = gmdate("d-m-Y", time()+60*60*7);
$jam = gmdate("H:i", time()+60*60*7);
$cek = mysqli_query($con,"SELECT COUNT(id_absen) as jum from tabel_absen where id_penempatan = '".$idpen."' and tgl = '".$tgl."'");
$row = mysqli_fetch_assoc($cek);
$hasil = $row['jum'];
if ($hasil == 0) {
	$c= "input";
	echo $c;
	//$query1 = mysqli_query($con,"INSERT INTO tabel_absen values('','".$idpen."','".$tgl."','".$jam."','".$ketabsen."','','','','','','')");
}else{
	$c="update";
	mysqli_query($con,"UPDATE tabel_absen set absen_pulang = '".$ketabsen."', jam_pulang = '".$jam."' where id_penempatan='".$idpen."' and tgl='".$tgl."'");
}
?>