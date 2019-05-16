<?php 
include('koneksi.php');
$query = "select * from tabel_tahunajaran";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_ta"=>$row['id_ta'],
    "tahun_ajaran"=>$row['tahun_ajaran'],
    "tgl_awal"=>$row['tgl_awal'],
    "tgl_akhir"=>$row['tgl_akhir']
  );
}
echo json_encode($data);
?>