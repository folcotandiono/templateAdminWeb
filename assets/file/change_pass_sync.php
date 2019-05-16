<?php 
include('koneksi.php');
$idGuru = $_GET['id_guru'];
$characters = 'abcdefghijklmnopqrstuvwxyz';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < 4; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}
$result = mysqli_query($con, "UPDATE tabel_guru SET pass_sync = '$randomString' 
WHERE id_guru = '$idGuru'");
echo "UPDATE tabel_guru SET pass_sync = '$randomString' 
WHERE id_guru = '$idGuru'";
 ?>