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
$getnonguru 	= $_GET['idnonguru'];
$query = mysqli_query($con,"SELECT * FROM tabel_non_guru  
      WHERE tabel_non_guru.nip = '$getnonguru'");
$isi = mysqli_fetch_array($query,MYSQLI_ASSOC);
$nonguru = $isi['nama'];

$query2 = mysqli_query($con,"SELECT * FROM tabel_setting WHERE id_setting = '1'");
$isi2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);
$sekolah = $isi2['logo_besar'];
$logo = $isi2['logo_sekolah'];
$alamat = $isi2['alamat'];

$data = array();
$data= array("nonguru"=>$nonguru,"alamat"=>$alamat,"sekolah"=>$sekolah,"logo"=>$logo);
echo json_encode($data);
?>
