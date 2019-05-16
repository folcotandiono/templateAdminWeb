<?php 
include('koneksi.php');
$query = "select * from tabel_cabang";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_cabang"=>$row['id_cabang'],
    "cabang"=>$row['cabang']
  );
}
echo json_encode($data);
?>