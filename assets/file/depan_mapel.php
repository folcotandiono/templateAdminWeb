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
$getguru  = $_GET['idguru'];
$hari 	= $_GET['hari'];
$query = mysqli_query($con,"SELECT tabel_jadwal.*,tabel_mapel.mapel,tabel_guru.nama,tabel_kelas.kelas FROM tabel_jadwal 
      INNER JOIN tabel_tahunajaran ON tabel_jadwal.id_ta = tabel_tahunajaran.id_ta
      INNER JOIN tabel_kelas ON tabel_jadwal.id_kelas = tabel_kelas.id_kelas
      INNER JOIN tabel_jenjang ON tabel_jadwal.id_jenjang = tabel_jenjang.id_jenjang
      INNER JOIN tabel_mapel ON tabel_jadwal.id_mapel = tabel_mapel.id_mapel
      INNER JOIN tabel_guru ON tabel_jadwal.id_guru = tabel_guru.id_guru
      WHERE tabel_guru.nik = '$getguru' AND SUBSTR(tabel_jadwal.hari,3) = '$hari' 
      ORDER BY tabel_jadwal.id_kelas,tabel_jadwal.hari ASC");

$data = array();
while($rt = mysqli_fetch_array($query,MYSQLI_ASSOC)){
  $guru = $rt['nama'];
  $kelas = $rt['kelas'];
  $mapel = $rt['mapel'];
  $hari = SUBSTR($rt['hari'],2);
  //SUBSTR(tabel_jadwal.hari,3)

  $data[]= array("guru"=>$guru,"hari"=>$hari,"kelas"=>$kelas,"mapel"=>$mapel);  
}
echo json_encode($data);
?>
