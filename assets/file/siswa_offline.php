<?php 
include('koneksi.php');
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_siswa 
          inner join tabel_siswakelas on tabel_siswa.id_siswa = tabel_siswakelas.id_siswa 
          inner join tabel_kelas on tabel_siswakelas.id_kelas = tabel_kelas.id_kelas 
          where tabel_kelas.id_guru = '$id_guru'";
          $query = "select * from tabel_siswa ";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_siswa"=>$row['id_siswa'],
    "id_jenjang"=>$row['id_jenjang'],
    "nama_lengkap"=>$row['nama_lengkap'],
    "nisn"=>$row['nisn'],
    "jenis_kelamin"=>$row['jenis_kelamin'],
    "tempat_lahir"=>$row['tempat_lahir'],
    "tgl_lahir"=>$row['tgl_lahir'],
    "agama"=>$row['agama'],
    "alamat"=>$row['alamat'],
    "no_hp"=>$row['no_hp'],
    "email"=>$row['email'],
    "asal_sekolah"=>$row['asal_sekolah'],
    "ket_asal"=>$row['ket_asal'],
    "nama_ayah"=>$row['nama_ayah'],
    "nama_ibu"=>$row['nama_ibu'],
    "gambar"=>$row['gambar'],
    "tgl_daftar"=>$row['tgl_daftar']
  );
}
echo json_encode($data);
?>