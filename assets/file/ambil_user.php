<?php
include('koneksi.php');
$username = $_GET['username'];

$query = "select * from tabel_user where username='".$username."'";
$result = mysqli_query($con,$query);
$guru = mysqli_query($con, "select * from tabel_guru where nik='$username'");
$guru = mysqli_fetch_array($guru);

if (mysqli_num_rows($result)) {
$row = mysqli_fetch_array($result);
	$data= $row;
	$data['gambar'] = $guru['gambar'];
	$data['nama'] = $guru['nama'];
}
echo json_encode($data);
?>