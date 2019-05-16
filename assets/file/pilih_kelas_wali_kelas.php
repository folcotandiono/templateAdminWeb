<?php 
include('koneksi.php');
$id_jenjang = $_GET['id_jenjang'];
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_kelas 
          inner join tabel_guru on tabel_kelas.id_guru = tabel_guru.id_guru
          where tabel_kelas.id_jenjang = '$id_jenjang' and tabel_kelas.id_guru = '$id_guru'";

$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_kelas"=>$row['id_kelas'],
    "kelas"=>$row['kelas'],
    "id_guru"=>$row['id_guru'],
    "id_jenjang"=>$row['id_jenjang'], 
    "nama_guru" => $row['nama']
  );
}
echo json_encode($data);
?>