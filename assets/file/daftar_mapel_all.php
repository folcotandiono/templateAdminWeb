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
$hari 		= hari();

$queryGuru = mysqli_query($con,"select * from tabel_guru where nik = '$getguru'");
$queryGuru = mysqli_fetch_array($queryGuru,MYSQLI_ASSOC);
$statusGuruBK = $queryGuru['status_guru_bk'];


if ($statusGuruBK == "1") $queryKelas="SELECT DISTINCT(tabel_kelas.id_kelas),tabel_jenjang.jenjang,tabel_kelas.kelas, tabel_mapel.mapel, 
tabel_jadwal.jam_awal, tabel_jadwal.jam_akhir, tabel_jadwal.status,tabel_jadwal.id_jadwal, tabel_jadwal.status, tabel_guru.nama  
  FROM tabel_jadwal INNER JOIN tabel_jenjang
  ON tabel_jadwal.id_jenjang = tabel_jenjang.id_jenjang INNER JOIN tabel_kelas
  ON tabel_jadwal.id_kelas = tabel_kelas.id_kelas INNER JOIN tabel_guru
  ON tabel_jadwal.id_guru = tabel_guru.id_guru INNER JOIN tabel_mapel
  ON tabel_jadwal.id_mapel = tabel_mapel.id_mapel
  WHERE SUBSTR(tabel_jadwal.hari,3) = '$hari'
  ORDER BY tabel_kelas.kelas,tabel_jadwal.jam_awal ASC";
else $queryKelas="SELECT DISTINCT(tabel_kelas.id_kelas),tabel_jenjang.jenjang,tabel_kelas.kelas, tabel_mapel.mapel, 
  tabel_jadwal.jam_awal, tabel_jadwal.jam_akhir, tabel_jadwal.status,tabel_jadwal.id_jadwal, tabel_jadwal.status, tabel_guru.nama  
  FROM tabel_jadwal INNER JOIN tabel_jenjang
  ON tabel_jadwal.id_jenjang = tabel_jenjang.id_jenjang INNER JOIN tabel_kelas
  ON tabel_jadwal.id_kelas = tabel_kelas.id_kelas INNER JOIN tabel_guru
  ON tabel_jadwal.id_guru = tabel_guru.id_guru INNER JOIN tabel_mapel
  ON tabel_jadwal.id_mapel = tabel_mapel.id_mapel
  WHERE tabel_guru.nik = '$getguru' AND SUBSTR(tabel_jadwal.hari,3) = '$hari'
  ORDER BY tabel_kelas.kelas,tabel_jadwal.jam_awal ASC";
$result = mysqli_query($con,$queryKelas);
$data = array();

$setting = mysqli_query($con,"select * from tabel_setting where id_setting = '1'");
$setting = mysqli_fetch_array($setting,MYSQLI_ASSOC);
$detik = $setting['toleransi_jam_akhir'] * 60;

while($row = mysqli_fetch_array($result)){
//	$data[]= $row;
  $status = $row['status'];
  $id_jadwal = $row['id_jadwal'];
  $jam_awal = $row['jam_awal'];
  $jam_akhir = $row['jam_akhir'];
  $jam_akhir1 = strtotime($jam_akhir) + $detik;
  $jam_akhir1 = date('H:i', $jam_akhir1);
  $jam_akhir2 = strtotime($jam_akhir) - $detik;
  $jam_akhir2 = date('H:i', $jam_akhir2);
  if ($status == "pulang") $cek = mysqli_query($con,"SELECT * FROM tabel_jadwal WHERE id_jadwal = '$id_jadwal' AND 
                          '$jam' BETWEEN '$jam_akhir2' AND '$jam_akhir1'");
  else {
    $cek = mysqli_query($con,"SELECT * FROM tabel_jadwal WHERE id_jadwal = '$id_jadwal' AND 
                          '$jam' BETWEEN '$jam_awal' AND '$jam_akhir'");
  }
  $ac = mysqli_num_rows($cek);
  if($ac > 0){
    $waktu = "ada"; 
  }else{
    $waktu = "";
  }
  $data[] = array("id_kelas"=>$row['id_kelas'],"jenjang"=>$row['jenjang'],"kelas"=>$row['kelas'],
  "mapel"=>$row['mapel'],"jam_awal"=>$row['jam_awal'],"jam_akhir"=>$row['jam_akhir'],
  "status"=>$row['status'],"id_jadwal"=>$row['id_jadwal'],"waktu"=>$waktu, "jam"=>$jam, "nama"=>$row['nama'], "status_guru_bk" =>$statusGuruBK);
}
echo json_encode($data);
?>
