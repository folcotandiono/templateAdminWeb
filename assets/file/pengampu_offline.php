<?php 
include('koneksi.php');
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_pengampu 
          inner join tabel_guru on tabel_pengampu.nik = tabel_guru.nik 
          where tabel_guru.id_guru = '$id_guru'";
          $query = "select * from tabel_pengampu ";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_pengampu"=>$row['id_pengampu'],
    "nik"=>$row['nik'],
    "id_mapel"=>$row['id_mapel']
  );
}
echo json_encode($data);
?>