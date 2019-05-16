<?php 
include('koneksi.php');
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_guru where id_guru = '$id_guru'";
$query = "select * from tabel_guru";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array("id_guru"=>$row['id_guru'],
  "id_jenjang"=>$row['id_jenjang'],
  "nik"=>$row['nik'],
  "nama"=>$row['nama'],
  "no_ktp"=>$row['no_ktp'],
  "alias"=>$row['alias'],
  "jenis_kelamin"=>$row['jenis_kelamin'],
  "tempat_lahir"=>$row['tempat_lahir'],
  "tgl_lahir"=>$row['tgl_lahir'],
  "agama"=>$row['agama'],
  "no_hp"=>$row['no_hp'],
  "email"=>$row['email'],
  "ijazah"=>$row['ijazah'],
  "pend_terakhir"=>$row['pend_terakhir'],
  "gambar"=>$row['gambar'],
  "alamat"=>$row['alamat'],
  "unit_kerja"=>$row['unit_kerja'],
  "tmt"=>$row['tmt'],
  "status_guru_bk"=>$row['status_guru_bk'],
  "status_kepsek"=>$row['status_kepsek']);
}
echo json_encode($data);
?>