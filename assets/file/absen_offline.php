<?php 
include('koneksi.php');
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_absen 
          inner join tabel_siswakelas on tabel_absen.id_penempatan = tabel_siswakelas.id_penempatan 
          inner join tabel_kelas on tabel_siswakelas.id_kelas = tabel_kelas.id_kelas 
          where tabel_kelas.id_guru = '$id_guru'";
          $query = "select * from tabel_absen ";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_absen"=>$row['id_absen'],
    "id_penempatan"=>$row['id_penempatan'],
    "tgl"=>$row['tgl'],
    "jam_masuk"=>$row['jam_masuk'],
    "absen_masuk"=>$row['absen_masuk'],
    "valid_masuk"=>$row['valid_masuk'],
    "sms_masuk"=>$row['sms_masuk'],
    "jam_pulang"=>$row['jam_pulang'],
    "absen_pulang"=>$row['absen_pulang'],
    "valid_pulang"=>$row['valid_pulang'],
    "sms_pulang"=>$row['sms_pulang']
  );
}
echo json_encode($data);
?>