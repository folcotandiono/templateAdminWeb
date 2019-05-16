<?php 

include('koneksi.php');
//$nik = $_GET['nik'];
$kelas      = $_GET['kelas'];
$jadwal     = $_GET['jadwal'];
$tgl        = gmdate("d-m-Y", time()+60*60*7);    
$jam        = gmdate("H:i", time()+60*60*7);
$cek = mysqli_query($con,"SELECT tabel_siswa.id_siswa,tabel_siswa.nama_lengkap,tabel_kelas.kelas,
            tabel_siswa.email,tabel_siswakelas.id_penempatan FROM tabel_siswakelas INNER JOIN tabel_siswa 
            ON tabel_siswakelas.id_siswa=tabel_siswa.id_siswa INNER JOIN tabel_kelas 
            ON tabel_siswakelas.id_kelas = tabel_kelas.id_kelas
            WHERE tabel_siswakelas.id_kelas='$kelas'");
$c=mysqli_num_rows($cek);
  if($c>0){
    while ($periksa=mysqli_fetch_array($cek,MYSQLI_ASSOC)) {
      $id_s = $periksa['id_penempatan'];
      $cek_absen = mysqli_query($con,"SELECT tabel_absen_mapel.*,tabel_jadwal.status 
          FROM tabel_absen_mapel INNER JOIN tabel_jadwal ON tabel_absen_mapel.id_jadwal=tabel_jadwal.id_jadwal 
          WHERE tabel_absen_mapel.id_penempatan = '$id_s' AND tabel_absen_mapel.tgl = '$tgl' 
          AND tabel_absen_mapel.id_jadwal = '$jadwal'");
      $is = mysqli_num_rows($cek_absen);
      if($is == 0){
        $amb = mysqli_query($con,"SELECT * FROM tabel_jadwal WHERE id_jadwal = '$jadwal'");
        $isi = mysqli_fetch_array($amb,MYSQLI_ASSOC);
        $status = $isi['status'];
        mysqli_query($con,"INSERT INTO tabel_absen_mapel VALUES ('','$id_s','$jadwal','$tgl','$jam','hadir','','','$status','')");  
      }
      echo "ok";
    }
}

?>
