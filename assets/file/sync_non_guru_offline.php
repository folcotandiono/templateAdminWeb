<?php 
include('koneksi.php');
$pass = $_GET['pass'];
$idNonGuru = $_GET['id_non_guru'];
$res = mysqli_query($con, "select pass_sync from tabel_non_guru where id_non_guru = '$idNonGuru'");
$res = mysqli_fetch_array($res,MYSQLI_ASSOC);
$passSync = $res['pass_sync'];
if ($pass == $passSync) {
    echo "ok";
}
else {
    echo "error";
}
 ?>