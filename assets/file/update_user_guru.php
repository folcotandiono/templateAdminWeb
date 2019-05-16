<?php 
include('koneksi.php');
$username = $_GET['username'];
$nmlengkap = $_GET['nama'];
$pass = md5($_GET['pass']);

$update_user = mysqli_query($con, "UPDATE tabel_user set password='".$pass."',nama='".$nmlengkap."'
		WHERE username = '".$username."'");
 ?>