<?php 
include('koneksi.php');
$id_non_guru = $_GET['id_non_guru'];
$query = "select * from tabel_user 
          inner join tabel_non_guru on tabel_user.username = tabel_non_guru.nip 
          where tabel_non_guru.id_non_guru = '$id_non_guru'";
          $query = "select * from tabel_user ";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_user"=>$row['id_user'],
    "username"=>$row['username'],
    "password"=>$row['password'],
    "nama"=>$row['nama'],
    "level"=>$row['level'],
    "id_cabang"=>$row['id_cabang'],
    "avatar"=>$row['avatar'],
    "tgl_daftar"=>$row['tgl_daftar']
  );
}
echo json_encode($data);
?>