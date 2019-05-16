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

function cek_hari($hari){	
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
$nisn 	= $_GET['nisn'];
$kelas = $_GET['kelas'];
$dari = $_GET['dari'];
$ke = $_GET['ke'];
$id_jenjang = $_GET['id_jenjang'];
$id_ta = $_GET['id_ta'];
$tgl 			= gmdate("d-m-Y", time()+60*60*7);
$jam  		= gmdate("H:i", time()+60*60*7);
$hari 		= hari();

$query="SELECT DISTINCT(tabel_siswakelas.id_penempatan),tabel_siswa.nama_lengkap,tabel_siswa.id_siswa,tabel_siswa.nisn,
        tabel_jenjang.jenjang,tabel_kelas.kelas,tabel_siswa.jenis_kelamin,tabel_kelas.id_kelas,tabel_siswa.agama,
        tabel_tahunajaran.tahun_ajaran, tabel_jadwal.id_mapel, tabel_mapel.mapel, tabel_guru.nama, tabel_jadwal.hari   
        FROM tabel_siswakelas LEFT JOIN tabel_siswa
          ON (tabel_siswakelas.id_siswa = tabel_siswa.id_siswa) INNER JOIN tabel_kelas        
          ON (tabel_siswakelas.id_kelas = tabel_kelas.id_kelas) INNER JOIN tabel_jenjang
          ON (tabel_kelas.id_jenjang = tabel_jenjang.id_jenjang) INNER JOIN tabel_guru      	
          ON (tabel_kelas.id_guru = tabel_guru.id_guru) LEFT JOIN tabel_tahunajaran
          ON (tabel_siswakelas.id_ta = tabel_tahunajaran.id_ta)  INNER JOIN tabel_jadwal
          ON (tabel_kelas.id_kelas = tabel_jadwal.id_kelas)	inner join tabel_mapel
          on (tabel_jadwal.id_mapel = tabel_mapel.id_mapel)
        where tabel_kelas.kelas = '$kelas'
        and tabel_jenjang.id_jenjang = '$id_jenjang'
        and tabel_tahunajaran.id_ta = '$id_ta' ";

if ($nisn != "") $query .= " and tabel_siswa.nisn = '$nisn'";

$result = mysqli_query($con,$query);

$data = array();

while($row = mysqli_fetch_array($result)){
  $begin = new DateTime($dari);
  $end = new DateTime($ke);
  $end->modify('+1 day');

  $interval = DateInterval::createFromDateString('1 day');
  $period = new DatePeriod($begin, $interval, $end);

  $hadir = 0;
  $sakit = 0;
  $izin = 0;
  $alpha = 0;
  $nihil = 0;

  foreach ($period as $dt) {
      $tgltgl = $dt->format("d-m-Y");
      $day = $dt->format("l");
      $harihari = cek_hari($day);
      $id_mapel = $row['id_mapel'];
      $id_penempatan = $row['id_penempatan'];

      if (substr($row['hari'], 2) != $harihari) continue;

      $cek = mysqli_query($con, "SELECT COUNT(id_absen_mapel) as jum FROM tabel_absen_mapel INNER JOIN tabel_jadwal
              ON tabel_jadwal.id_jadwal = tabel_absen_mapel.id_jadwal
              WHERE tabel_jadwal.id_mapel = '$id_mapel' 
              AND tabel_absen_mapel.id_penempatan = '$id_penempatan' 
              AND tabel_absen_mapel.valid = 'valid'
              AND tabel_absen_mapel.tgl = '$tgltgl'
              AND tabel_absen_mapel.absen = 'hadir'");
      $isi = mysqli_fetch_array($cek);  
      $hadir += $isi['jum'];

      $hadirhadir = $isi['jum'];

      $cek = mysqli_query($con, "SELECT COUNT(id_absen_mapel) as jum FROM tabel_absen_mapel INNER JOIN tabel_jadwal
              ON tabel_jadwal.id_jadwal = tabel_absen_mapel.id_jadwal
              WHERE tabel_jadwal.id_mapel = '$id_mapel' 
              AND tabel_absen_mapel.id_penempatan = '$id_penempatan' 
              AND tabel_absen_mapel.valid = 'valid'
              AND tabel_absen_mapel.tgl = '$tgltgl'
              AND tabel_absen_mapel.absen = 'sakit'");
      $isi = mysqli_fetch_array($cek);  
      $sakit += $isi['jum'];

      $sakitsakit = $isi['jum'];

      $cek = mysqli_query($con, "SELECT COUNT(id_absen_mapel) as jum FROM tabel_absen_mapel INNER JOIN tabel_jadwal
              ON tabel_jadwal.id_jadwal = tabel_absen_mapel.id_jadwal
              WHERE tabel_jadwal.id_mapel = '$id_mapel' 
              AND tabel_absen_mapel.id_penempatan = '$id_penempatan' 
              AND tabel_absen_mapel.valid = 'valid'
              AND tabel_absen_mapel.tgl = '$tgltgl'
              AND tabel_absen_mapel.absen = 'izin'");
      $isi = mysqli_fetch_array($cek);  
      $izin += $isi['jum'];

      $izinizin = $isi['jum'];

      $cek = mysqli_query($con, "SELECT COUNT(id_absen_mapel) as jum FROM tabel_absen_mapel INNER JOIN tabel_jadwal
              ON tabel_jadwal.id_jadwal = tabel_absen_mapel.id_jadwal
              WHERE tabel_jadwal.id_mapel = '$id_mapel' 
              AND tabel_absen_mapel.id_penempatan = '$id_penempatan' 
              AND tabel_absen_mapel.valid = 'valid'
              AND tabel_absen_mapel.tgl = '$tgltgl'
              AND tabel_absen_mapel.absen = 'alpha'");
      $isi = mysqli_fetch_array($cek);  
      $alpha += $isi['jum'];

      $alphaalpha = $isi['jum'];

      if ($hadirhadir == 0 && $sakitsakit == 0 && $izinizin == 0 && $alphaalpha == 0) {
        $nihil++;
      }
  }
  $data[] = array("nisn" => $row['nisn'], "nama_lengkap" => $row['nama_lengkap'], 
                  "pelajaran"=>$row['mapel'],"hadir"=>$hadir, "sakit"=>$sakit, "izin"=>$izin, 
                  "alpha"=>$alpha, "wali_kelas" => $row['nama'], "nihil"=> $nihil);
}
echo json_encode($data);
?>
