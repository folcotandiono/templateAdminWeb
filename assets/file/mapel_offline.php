<?php 
include('koneksi.php');
$query = "select * from tabel_mapel";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_mapel"=>$row['id_mapel'],
    "id_jenjang"=>$row['id_jenjang'],
    "id_kat_mapel"=>$row['id_kat_mapel'],
    "mapel"=>$row['mapel'],
    "kkm" => $row['kkm']
  );
}
echo json_encode($data);
?>