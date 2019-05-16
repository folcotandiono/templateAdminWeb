<?php 
include('koneksi.php');
$query = "select * from tabel_kat_mapel";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_kat_mapel"=>$row['id_kat_mapel'],
    "kategori_mapel"=>$row['kategori_mapel']
  );
}
echo json_encode($data);
?>