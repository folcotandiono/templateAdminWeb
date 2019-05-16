<?php 
include('koneksi.php');
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_siswakelas 
          inner join tabel_kelas on tabel_siswakelas.id_kelas = tabel_kelas.id_kelas 
          where tabel_kelas.id_guru = '$id_guru'";
          $query = "select * from tabel_siswakelas ";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_penempatan"=>$row['id_penempatan'],
    "id_ta"=>$row['id_ta'],
    "id_kelas"=>$row['id_kelas'],
    "id_siswa"=>$row['id_siswa']
  );
}
echo json_encode($data);
?>