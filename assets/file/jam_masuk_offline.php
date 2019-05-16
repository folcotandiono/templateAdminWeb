<?php 
include('koneksi.php');
$query = "select * from tabel_jam_masuk";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_jam_masuk"=>$row['id_jam_masuk'],
    "hari"=>$row['hari'],
    "jam"=>$row['jam']
  );
}
echo json_encode($data);
?>