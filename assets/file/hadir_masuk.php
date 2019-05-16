<?php 

include('koneksi.php');
//$nik = $_GET['nik'];
$name      = $_GET['name'];
$tgl        = gmdate("d-m-Y", time()+60*60*7);    
$jam        = gmdate("H:i", time()+60*60*7);
$ambilUser = mysqli_query($con,"SELECT * FROM tabel_guru INNER JOIN tabel_kelas ON 
    tabel_guru.id_guru=tabel_kelas.id_guru WHERE tabel_guru.nik = '$name'");
$w = mysqli_fetch_assoc($ambilUser);
$kelas = $w['id_kelas'];

$cek        = mysqli_query($con,"SELECT tabel_siswa.id_siswa,tabel_siswa.nama_lengkap,tabel_kelas.kelas,
                    tabel_siswa.email,tabel_siswakelas.id_penempatan FROM tabel_siswakelas INNER JOIN tabel_siswa 
                    ON tabel_siswakelas.id_siswa=tabel_siswa.id_siswa INNER JOIN tabel_kelas ON tabel_siswakelas.id_kelas = tabel_kelas.id_kelas
                    WHERE tabel_siswakelas.id_kelas='$kelas'");
$c=mysqli_num_rows($cek);
  if($c>0){
    while ($periksa=mysqli_fetch_array($cek,MYSQLI_ASSOC)) {
      $id_penempatan = $periksa['id_penempatan'];
      $cek2 = mysqli_query($con,"SELECT * FROM tabel_absen WHERE id_penempatan ='$id_penempatan' AND tgl='$tgl'");
      if(mysqli_num_rows($cek2) == 0){
        $isi = mysqli_fetch_array($cek2,MYSQLI_ASSOC);
        mysqli_query($con,"INSERT INTO tabel_absen VALUES ('','$id_penempatan','$tgl','$jam','hadir','','','','','','')");
      }      
    }
  echo "ok";
}


?>
