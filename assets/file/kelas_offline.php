<?php 
include('koneksi.php');
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_kelas where id_guru = '$id_guru'";
$query = "select * from tabel_kelas";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_kelas"=>$row['id_kelas'],
    "kelas"=>$row['kelas'],
    "id_guru"=>$row['id_guru'],
    "id_jenjang"=>$row['id_jenjang']
  );
}
echo json_encode($data);
?>