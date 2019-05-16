<?php
include('koneksi.php');
$username = $_GET['username'];

$query = "select * from tabel_user where username='".$username."'";
$result = mysqli_query($con,$query);
$nonguru = mysqli_query($con, "select * from tabel_non_guru where nip='$username'");
$nonguru = mysqli_fetch_array($nonguru);

if (mysqli_num_rows($result)) {
$row = mysqli_fetch_array($result);
	$data= $row;
	$data['gambar'] = $nonguru['gambar'];
	$data['nama'] = $nonguru['nama'];
}
echo json_encode($data);
?>