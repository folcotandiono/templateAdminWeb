<?php 
include ('koneksi.php');
$idpen 		= $_GET['idpenem'];
$ketabsen = $_GET['absen'];
$jadwal 	= $_GET['jadwal'];

$sql = mysqli_query($con,"SELECT * FROM tabel_jadwal WHERE id_jadwal = '$jadwal'");
$am = mysqli_fetch_assoc($sql);
$status = $am['status'];

$valid		= "";
$rekap		= "";

$tgl = gmdate("d-m-Y", time()+60*60*7);
$jam = gmdate("H:i", time()+60*60*7);

$cek = mysqli_query($con,"SELECT COUNT(id_absen_mapel) as jum from tabel_absen_mapel where id_penempatan = '".$idpen."' AND 
				tgl = '".$tgl."' AND id_jadwal = '".$jadwal."'");
$row = mysqli_fetch_assoc($cek);
$hasil = $row['jum'];
if ($hasil == 0) {
	$c= "input";
	echo $c;
	$query1 = mysqli_query($con,"INSERT INTO tabel_absen_mapel values('','".$idpen."','".$jadwal."','".$tgl."','".$jam."','".$ketabsen."','".$valid."','".$rekap."','".$status."','')");
}else{
	$c="update";
	mysqli_query($con,"UPDATE tabel_absen_mapel set absen = '".$ketabsen."' where id_penempatan='".$idpen."' and tgl='".$tgl."' AND id_jadwal = '".$jadwal."'");
}
?>