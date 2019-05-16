<?php 
function hari(){
  $hari=$day=gmdate("l", time()+60*60*7);		
  switch($hari)
  {
    case"Sunday":$hari="Minggu"; break;
    case"Monday":$hari="Senin"; break;
    case"Tuesday":$hari="Selasa"; break;
    case"Wednesday":$hari="Rabu"; break;
    case"Thursday":$hari="Kamis"; break;
    case"Friday":$hari="Jumat"; break;
    case"Saturday":$hari="Sabtu"; break;
  }      
  $hariLengkap="$hari";
  return $hariLengkap;
}


include('koneksi.php');
//$nik = $_GET['nik'];
$getguru 	= $_GET['idguru'];
$tgl 			= gmdate("d-m-Y", time()+60*60*7);
$jam  		= gmdate("H:i", time()+60*60*7);
$hari 			= hari();
$queryKelas="SELECT DISTINCT(tabel_kelas.id_kelas),tabel_jenjang.jenjang,tabel_kelas.kelas, tabel_mapel.mapel, 
				tabel_jadwal.jam_awal, tabel_jadwal.jam_akhir, tabel_jadwal.status,tabel_jadwal.id_jadwal
				FROM tabel_jadwal INNER JOIN tabel_jenjang
				ON tabel_jadwal.id_jenjang = tabel_jenjang.id_jenjang INNER JOIN tabel_kelas
				ON tabel_jadwal.id_kelas = tabel_kelas.id_kelas INNER JOIN tabel_guru
				ON tabel_jadwal.id_guru = tabel_guru.id_guru INNER JOIN tabel_mapel
				ON tabel_jadwal.id_mapel = tabel_mapel.id_mapel
				WHERE tabel_guru.nik = '$getguru' AND SUBSTR(tabel_jadwal.hari,3) = '$hari' AND '$jam' BETWEEN tabel_jadwal.jam_awal AND tabel_jadwal.jam_akhir
				ORDER BY tabel_kelas.kelas,tabel_jadwal.jam_awal ASC";

$result = mysqli_query($con,$queryKelas);
$data = array();
while($row = mysqli_fetch_object($result)){
	$data[]= $row;
}
echo json_encode($data);
?>
