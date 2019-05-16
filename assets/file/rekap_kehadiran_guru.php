<?php 
function cek_hari($tgl){  
  $hari=$day= $tgl;
  switch($hari){
      case"Sunday":$hari="Minggu"; break;
      case"Monday":$hari="Senin"; break;
      case"Tuesday":$hari="Selasa"; break;
      case"Wednesday":$hari="Rabu"; break;
      case"Thursday":$hari="Kamis"; break;
      case"Friday":$hari="Jumat"; break;
      case"Saturday":$hari="Sabtu"; break;
  }  
  return $hari;
}

function hari(){  
  $hari=$day= gmdate("l", time()+60*60*7);
  switch($hari){
      case"Sunday":$hari="Minggu"; break;
      case"Monday":$hari="Senin"; break;
      case"Tuesday":$hari="Selasa"; break;
      case"Wednesday":$hari="Rabu"; break;
      case"Thursday":$hari="Kamis"; break;
      case"Friday":$hari="Jumat"; break;
      case"Saturday":$hari="Sabtu"; break;
  }  
  return $hari;
}

function datediff($tgl1, $tgl2){
  $tgl1 = strtotime($tgl1);
  $tgl2 = strtotime($tgl2);
  $diff_secs = abs($tgl1 - $tgl2);
  $base_year = min(date("Y", $tgl1), date("Y", $tgl2));
  $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
  return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
}


include('koneksi.php');
//$nik = $_GET['nik'];
$dari = $_GET['dari'];
$ke = $_GET['ke'];
$id_jenjang = $_GET['id_jenjang'];
$id_ta = $_GET['id_ta'];
$id_guru = $_GET['id_guru'];
$tgl 			= gmdate("d-m-Y", time()+60*60*7);
$jam  		= gmdate("H:i", time()+60*60*7);
$tgl1  = date("l", strtotime($dari));
$hari  = cek_hari($tgl1);

$sql = "SELECT * FROM tabel_kelas 
        INNER JOIN tabel_jadwal ON (tabel_kelas.id_kelas = tabel_jadwal.id_kelas) 
        INNER JOIN tabel_jenjang ON (tabel_jenjang.id_jenjang = tabel_jadwal.id_jenjang) 
        INNER JOIN tabel_guru ON (tabel_guru.id_guru = tabel_jadwal.id_guru) 
        INNER JOIN tabel_mapel ON (tabel_mapel.id_mapel = tabel_jadwal.id_mapel) 
        INNER JOIN tabel_tahunajaran on (tabel_jadwal.id_ta = tabel_tahunajaran.id_ta) 
        where tabel_jenjang.id_jenjang = '$id_jenjang' and tabel_tahunajaran.id_ta = '$id_ta'";
if ($id_guru != "") $sql .= " and tabel_guru.id_guru = '$id_guru'";
$sql .= " ORDER BY hari,jam_awal ASC";
$t = mysqli_query($con, $sql);
// $data = array();
// $data[] = array("banyak"=>mysqli_num_rows($t));
// echo json_encode($data);
$data = array();
while ($row = mysqli_fetch_array($t)) { 
    $hadir = 0;
    $tidak_absen = 0;
    $sakit = 0;
    $izin = 0;
    $tanpa_keterangan = 0;
    $id_jadwal = $row['id_jadwal'];

    $begin = new DateTime($dari);
    $end = new DateTime($ke);
    $end->modify('+1 day');
    
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);

    foreach ($period as $dt) {
        $tgltgl = $dt->format("d-m-Y");
        $day = $dt->format("l");
        $harihari = cek_hari($day);

        if ($harihari != substr($row['hari'], 2)) {
            continue;
        }
        if ($day == "Sunday") continue;

        $cek = mysqli_query($con, "SELECT * FROM tabel_absen_mapel WHERE tgl = '$tgltgl' 
                                    AND id_jadwal = '$id_jadwal' AND valid = 'valid'");

        if(mysqli_num_rows($cek) > 0){
            $cek = mysqli_fetch_array($cek);
            $keterangan = $cek['keterangan'];
            if ($keterangan == "") $hadir++;
            else if ($keterangan == "Sakit") $sakit++;
            else if ($keterangan == "Izin") $izin++;
            else if ($keterangan == "Tanpa keterangan") $tanpa_keterangan++;
        }else{
            $tidak_absen++;
        }
    }
    $data[] = array("nama"=>$row['nama'],"jenjang"=>$row['jenjang'],"kelas"=>$row['kelas'],
                    "mapel"=>$row['mapel'], "hadir"=>$hadir, "tidak_absen" => $tidak_absen, 
                    "sakit" => $sakit, "izin" => $izin, "tanpa_keterangan" => $tanpa_keterangan, 
                    "nik" => $row['nik']);      
}
// $data[] = array("namma" => "haha");
echo json_encode($data);
?>
