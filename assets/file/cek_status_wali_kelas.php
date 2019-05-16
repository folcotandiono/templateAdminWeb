<?php
include('koneksi.php');
$nik = $_GET['idguru'];
$id_kelas = $_GET['idkelas'];
$cek = mysqli_query($con,"SELECT * FROM tabel_kelas inner join tabel_guru on tabel_kelas.id_guru = tabel_guru.id_guru 
                        where tabel_guru.nik = '$nik' and tabel_kelas.id_kelas = '$id_kelas'");
$ac = mysqli_num_rows($cek);
if ($ac > 0) {
    echo "ya";
}
else echo "tidak";
?>