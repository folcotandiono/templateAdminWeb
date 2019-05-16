<?php 
include('koneksi.php');
$idNonGuru = $_GET['id_non_guru'];
$characters = 'abcdefghijklmnopqrstuvwxyz';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < 4; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}
$result = mysqli_query($con, "UPDATE tabel_non_guru SET pass_sync = '$randomString' 
WHERE id_non_guru = '$idNonGuru'");
echo "UPDATE tabel_non_guru SET pass_sync = '$randomString' 
WHERE id_non_guru = '$idNonGuru'";
 ?>