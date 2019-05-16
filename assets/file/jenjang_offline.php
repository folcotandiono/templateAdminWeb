<?php 
include('koneksi.php');
$query = "select * from tabel_jenjang";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_jenjang"=>$row['id_jenjang'],
    "jenjang"=>$row['jenjang'],
    "jam_masuk"=>$row['jam_masuk'],
    "jam_pulang"=>$row['jam_pulang']
  );
}
echo json_encode($data);
?>