<?php 
include('koneksi.php');
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_jadwal where id_guru = '$id_guru'";
$query = "select * from tabel_jadwal";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_jadwal"=>$row['id_jadwal'],
    "id_ta"=>$row['id_ta'],
    "id_jenjang"=>$row['id_jenjang'],
    "id_kelas"=>$row['id_kelas'],
    "id_mapel"=>$row['id_mapel'],
    "id_guru"=>$row['id_guru'],
    "hari"=>$row['hari'],
    "jam_awal"=>$row['jam_awal'],
    "jam_akhir"=>$row['jam_akhir'],
    "status"=>$row['status']
  );
}
echo json_encode($data);
?>