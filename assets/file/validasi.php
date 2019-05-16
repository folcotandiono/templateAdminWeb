<?php 

include('koneksi.php');
//$nik = $_GET['nik'];
$kelas = $_GET['kelas'];
$jadwal = $_GET['jadwal'];
$status = $_GET['status'];
$sekarang = time()+60*60*7;
$tgl = gmdate("d-m-Y", $sekarang);
$queryKelas="SELECT tabel_siswa.id_siswa,tabel_siswa.nama_lengkap,tabel_kelas.kelas,tabel_siswakelas.id_ta,
                tabel_siswa.email,tabel_siswakelas.id_penempatan FROM tabel_siswakelas INNER JOIN tabel_siswa 
                ON tabel_siswakelas.id_siswa=tabel_siswa.id_siswa INNER JOIN tabel_kelas 
                ON tabel_siswakelas.id_kelas = tabel_kelas.id_kelas
                WHERE tabel_siswakelas.id_kelas='$kelas' AND tabel_siswakelas.id_penempatan IN (SELECT id_penempatan FROM tabel_absen_mapel 
                  WHERE tabel_absen_mapel.tgl='$tgl' AND tabel_absen_mapel.id_jadwal = '$jadwal') ORDER BY tabel_siswakelas.id_penempatan";
$result = mysqli_query($con,$queryKelas);

$ambil = mysqli_query($con,"SELECT * FROM tabel_jadwal WHERE id_jadwal = '$jadwal'");
$am = mysqli_fetch_array($ambil,MYSQLI_ASSOC);
$jamAwal = $am['jam_awal'];
$jamAkhir = $am['jam_akhir'];

$awal = new DateTime();
$haha = $awal->format('Y-m-d H:i:s');
// $awal->add(new DateInterval('PT7H'));
$awal->setTime(($jamAwal[0].$jamAwal[1]) + 0, ($jamAwal[3].$jamAwal[4]) + 0);
$awal = strtotime($awal->format('Y-m-d H:i:s'));

$akhir = new DateTime();
// $akhir->add(new DateInterval('PT7H'));
$akhir->setTime(($jamAkhir[0].$jamAkhir[1]) + 0,($jamAkhir[3].$jamAkhir[4]) + 0);
// $haha = $akhir->format('Y-m-d H:i:s');
$akhir = strtotime($akhir->format('Y-m-d H:i:s'));

$setting = mysqli_query($con,"select * from tabel_setting where id_setting = '1'");
$setting = mysqli_fetch_array($setting,MYSQLI_ASSOC);
$detik = $setting['toleransi_jam_akhir'] * 60;

// echo $tgl . ' ' . ($haha) . ' ' . ($akhir + $detik) . ' ';

$cek2 = mysqli_query($con,"SELECT COUNT(id_penempatan) AS jum FROM tabel_siswakelas WHERE id_kelas = '".$kelas."'
    AND id_ta = '".$am['id_ta']."'");
$am2 = mysqli_fetch_array($cek2,MYSQLI_ASSOC);
$valid2 = $am2['jum'];
$valid = mysqli_num_rows($result);
if($valid>0){
  if($valid == $valid2){
      $setting="select * from tabel_setting where id_setting = '1'";
      $setting = mysqli_query($con,$setting);
      $setting = mysqli_fetch_array($setting,MYSQLI_ASSOC);
      $menit = $setting['toleransi_jam_akhir'];
      while ($periksa = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $id_s = $periksa['id_penempatan'];
        if ($status == "") $eksekusi = mysqli_query($con,"UPDATE tabel_absen_mapel SET rekap = '-',valid = 'valid' 
          WHERE id_penempatan='$id_s' AND tgl='".$tgl."' AND tabel_absen_mapel.id_jadwal = '$jadwal'");
        else $eksekusi = mysqli_query($con,"UPDATE tabel_absen_mapel SET rekap = '-',valid = 'valid',keterangan = '$status'  
        WHERE id_penempatan='$id_s' AND tgl='".$tgl."' AND tabel_absen_mapel.id_jadwal = '$jadwal'");
      }    
      echo "sip";   
    
  }else{  
    echo "error";
  }
}else{ 
    echo "error";
  }
?>