<?php 
include('koneksi.php');
$query = "select * from tabel_kategori";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_kategori"=>$row['id_kategori'],
    "kategori"=>$row['kategori'],
    "link"=>$row['link']
  );
}
echo json_encode($data);
?>