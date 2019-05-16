<?php 
include('koneksi.php');
$query = "select * from tabel_schedule";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_schedule"=>$row['id_schedule'],
    "tipe_sms"=>$row['tipe_sms'],
    "status"=>$row['status'],
    "aturan"=>$row['aturan']
  );
}
echo json_encode($data);
?>