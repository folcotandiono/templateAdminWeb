<?php 
include('koneksi.php');
$pass = $_GET['pass'];
$idGuru = $_GET['id_guru'];
$res = mysqli_query($con, "select pass_sync from tabel_guru where id_guru = '$idGuru'");
$res = mysqli_fetch_array($res,MYSQLI_ASSOC);
$passSync = $res['pass_sync'];
if ($pass == $passSync) {
    echo "ok";
}
else {
    echo "error";
}
 ?>