<?php
include('koneksi.php');
$guru = $_GET['guru'];

$result = mysqli_query($con,"SELECT *, tabel_siswa.gambar as gambar_siswa FROM  tabel_siswa 
							inner join tabel_siswakelas on tabel_siswa.id_siswa = tabel_siswakelas.id_siswa 
							inner join tabel_kelas on tabel_siswakelas.id_kelas = tabel_kelas.id_kelas 
							inner join tabel_guru on tabel_kelas.id_guru = tabel_guru.id_guru 
							WHERE tabel_guru.nik='$guru' order by tabel_siswa.nama_lengkap");

$data = array();
$no = 1;
while($row = mysqli_fetch_array($result)){
	$data[]= array(
		"no" => $no++,
		"id_siswa" => $row['id_siswa'],
		"nama_lengkap" => $row['nama_lengkap'],
		"nisn" => $row['nisn'],
		"id_penempatan" => $row['id_penempatan'],
		"jk" => $row['jenis_kelamin'],
		"tempat" => $row['tempat_lahir'],
		"tgl" => $row['tgl_lahir'],
		"alamat" => $row['alamat'],
		"agama" => $row['agama'],
		"hp" => $row['no_hp'],
		"email" => $row['email'],
		"ayah" => $row['nama_ayah'],
		"ibu" => $row['nama_ibu'],
		"gambar" => $row['gambar_siswa'],
		"id_kelas" => $row['id_kelas'],
		"kelas" => $row['kelas'],
		"wali_kelas" => $row['nama']);
}
echo json_encode($data);

?>