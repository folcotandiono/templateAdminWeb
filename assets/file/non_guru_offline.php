<?php 
include('koneksi.php');
$id_non_guru = $_GET['id_non_guru'];
$query = "select * from tabel_non_guru where id_non_guru = '$id_non_guru'";
$query = "select * from tabel_non_guru";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array("id_non_guru"=>$row['id_non_guru'],
  "nip"=>$row['nip'],
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
  "jabatan"=>$row['jabatan']);
}
echo json_encode($data);
?>