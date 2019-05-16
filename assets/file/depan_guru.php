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
$query = mysqli_query($con,"SELECT * FROM tabel_guru LEFT JOIN tabel_kelas ON tabel_guru.id_guru=tabel_kelas.id_guru 
      WHERE tabel_guru.nik = '$getguru'");
$isi = mysqli_fetch_array($query,MYSQLI_ASSOC);
$guru = $isi['nama'];
$kelas = $isi['kelas'];

$query2 = mysqli_query($con,"SELECT * FROM tabel_setting WHERE id_setting = '1'");
$isi2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);
$sekolah = $isi2['logo_besar'];
$logo = $isi2['logo_sekolah'];
$alamat = $isi2['alamat'];

$data = array();
$data= array("guru"=>$guru,"kelas"=>$kelas,"alamat"=>$alamat,"sekolah"=>$sekolah,"logo"=>$logo);
echo json_encode($data);
?>
