<?php
include('koneksi.php');
$nik = $_GET['idguru'];
$cek = mysqli_query($con,"SELECT * FROM tabel_guru  
                        where tabel_guru.nik = '$nik'");
$cek = mysqli_fetch_array($cek);
echo $cek['status_kepsek'];
?>