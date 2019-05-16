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
      case"Sunday":$hari="0 Minggu"; break;
      case"Monday":$hari="1 Senin"; break;
      case"Tuesday":$hari="2 Selasa"; break;
      case"Wednesday":$hari="3 Rabu"; break;
      case"Thursday":$hari="4 Kamis"; break;
      case"Friday":$hari="5 Jumat"; break;
      case"Saturday":$hari="6 Sabtu"; break;
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
$id_non_guru = $_GET['id_non_guru'];
$tgl 			= gmdate("d-m-Y", time()+60*60*7);
$jam  		= gmdate("H:i", time()+60*60*7);
$tgl1  = date("l", strtotime($dari));
$hari  = cek_hari($tgl1);

$tgl = $dari;
$tgl_akhir = $ke;

$re  = mysqli_query($con, "SELECT * FROM tabel_setting WHERE id_setting = '1'");
$re = mysqli_fetch_array($re);
$jam_pulang_kerja = $re['jam_pulang'];

$no=1; 

$sql = "select * from tabel_non_guru ";
if ($id_non_guru != '') $sql .= " where id_non_guru = '$id_non_guru'";
$t = mysqli_query($con, $sql);

$data = array();

while($row = mysqli_fetch_array($t)) {
    $begin = new DateTime($tgl);
    $end = new DateTime($tgl_akhir);
    $end->modify('+1 day');

    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);

    $masuk_absen_sesuai = 0;
    $masuk_terlambat = 0;
    $masuk_tidak_absen = 0;

    $pulang_absen_sesuai = 0;
    $pulang_terlambat = 0;
    $pulang_tidak_absen = 0;

    foreach ($period as $dt) {
        $tgltgl = $dt->format("d-m-Y");
        $hari = cek_hari($dt->format("l"));
        if ($hari == "Minggu") continue;
        $re = mysqli_query($con, "SELECT * FROM tabel_jam_masuk where substring(hari, 3) = '$hari'");
        $re = mysqli_fetch_array($re);
        $jam_masuk_kerja = $re['jam'];

        $id_non_guru = $row['id_non_guru'];
        $cek = mysqli_query($con, "select * from tabel_absen_non_guru 
        where id_non_guru = '$id_non_guru' and tgl = '$tgltgl' order by jam");

        if (mysqli_num_rows($cek) == 0) {
            $masuk_tidak_absen++;
            $pulang_tidak_absen++;
        }
        else if (mysqli_num_rows($cek) == 1) {
            $cek = mysqli_fetch_array($cek);
            $validasi_jam_masuk = $cek['jam'];

            if (strtotime($validasi_jam_masuk) > strtotime($jam_masuk_kerja)) {
                $masuk_terlambat++;
            }
            else {
                $masuk_absen_sesuai++;
            }
            
            $pulang_tidak_absen++;
        }
        else {
            $cek = mysqli_fetch_array($cek);
            $validasi_jam_masuk = $cek['jam'];
            
            if (strtotime($validasi_jam_masuk) > strtotime($jam_masuk_kerja)) {
                $masuk_terlambat++;
            }
            else {
                $masuk_absen_sesuai++;
            }
            
            $cek = mysqli_query($con, "select * from tabel_absen_non_guru 
            where id_non_guru = '$id_non_guru' and tgl = '$tgl' order by jam desc");
            $cek = mysqli_fetch_array($cek);
            $sampai = "17:00";
            $validasi_jam_pulang = $cek['jam'];
            if (strtotime($validasi_jam_pulang) >= strtotime($jam_pulang_kerja) && 
                strtotime($validasi_jam_pulang) <= strtotime($sampai)) {
                if (strtotime($jam_pulang_kerja) > strtotime($validasi_jam_pulang)) {
                    $pulang_terlambat++;
                }
                else {
                    $pulang_absen_sesuai++;
                }
            }
            else {
                $pulang_tidak_absen++;
            }
        } 
    }
    

    $data[] = array(
        "nip" => $row['nip'],
        "nama"=>$row['nama'],
        "masuk_absen_sesuai" => $masuk_absen_sesuai,
        "masuk_terlambat" => $masuk_terlambat,
        "masuk_tidak_absen" => $masuk_tidak_absen,
        "pulang_absen_sesuai" => $pulang_absen_sesuai,
        "pulang_terlambat" => $pulang_terlambat,
        "pulang_tidak_absen" => $pulang_tidak_absen
    );   

    $no++;
    
}
echo json_encode($data);
?>
