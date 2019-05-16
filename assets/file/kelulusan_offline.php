<?php 
include('koneksi.php');
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_kelulusan 
          inner join tabel_kelas on tabel_kelulusan.id_kelas = tabel_kelas.id_kelas 
          where id_guru = '$id_guru'";
          $query = "select * from tabel_kelulusan ";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_kelulusan"=>$row['id_kelulusan'],
    "id_siswa"=>$row['id_siswa'],
    "id_ta"=>$row['id_ta'],
    "id_kelas"=>$row['id_kelas'],
    "angkatan"=>$row['angkatan'],
    "tgl_lulus"=>$row['tgl_lulus']
  );
}
echo json_encode($data);
?>