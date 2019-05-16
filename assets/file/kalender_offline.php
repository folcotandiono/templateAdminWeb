<?php 
include('koneksi.php');
$query = "select * from tabel_kalender";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_kalender"=>$row['id_kalender'],
    "tanggal"=>$row['tanggal'],
    "agenda"=>$row['agenda'],
    "keterangan"=>$row['keterangan']
  );
}
echo json_encode($data);
?>