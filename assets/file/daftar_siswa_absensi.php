<?php 
include('koneksi.php');
error_reporting(0);
//$nik = $_GET['nik'];
$getguru = $_GET['idguru'];
//$gettgl = $_GET['tgl'];
$tgl = gmdate("d-m-Y", time()+60*60*7);
$queryKelas="SELECT tabel_siswakelas.id_penempatan,tabel_siswa.nama_lengkap,tabel_siswa.gambar,
			tabel_siswa.id_siswa,tabel_jenjang.jenjang,tabel_kelas.kelas,
			tabel_tahunajaran.tahun_ajaran,tabel_guru.nama,tabel_siswakelas.id_kelas
			FROM tabel_siswakelas LEFT JOIN tabel_siswa
	        ON (tabel_siswakelas.id_siswa = tabel_siswa.id_siswa) INNER JOIN tabel_jenjang
        	ON (tabel_siswa.id_jenjang = tabel_jenjang.id_jenjang) LEFT JOIN tabel_kelas 
	        ON (tabel_siswakelas.id_kelas = tabel_kelas.id_kelas) INNER JOIN tabel_guru 
	        ON (tabel_kelas.id_guru = tabel_guru.id_guru) LEFT JOIN tabel_tahunajaran
	        ON (tabel_siswakelas.id_ta = tabel_tahunajaran.id_ta)
	        WHERE tabel_guru.nik = '".$getguru."'
	        ORDER BY tabel_siswa.nama_lengkap ASC";
$result = mysqli_query($con,$queryKelas);
$data = array();
$no=1;
while($row = mysqli_fetch_array($result)){
	$s = mysqli_query($con,"SELECT tabel_absen.* FROM tabel_absen INNER JOIN tabel_siswakelas 
					ON tabel_absen.id_penempatan = tabel_siswakelas.id_penempatan
	       	WHERE tabel_siswakelas.id_penempatan='$row[id_penempatan]' and tabel_absen.tgl = '$tgl'");  

	 $ambil = mysqli_num_rows($s);
	 if($ambil > 0){
	 		$isi = mysqli_fetch_array($s);
		   if($isi['absen_masuk'] == ''){
		   	$absen_masuk = "-";
		   }else{
		   	$absen_masuk = $isi['absen_masuk']; 
		   }
		   if($isi['absen_pulang'] == ''){
		   	$absen_pulang = "-";
		   }else{
		   	$absen_pulang = $isi['absen_pulang'];     	
		   }		
		   if($isi['valid'] == ''){
		   	$valid = "-";
		   }else{
		   	$valid = $isi['valid'];
		   }
	}	
	$id_penempatan 	= $row['id_penempatan'];
	$nama_lengkap 	= $row['nama_lengkap'];
	$gambar 				= $row['gambar'];
	$id_siswa 			= $row['id_siswa'];
	$jenjang 				= $row['jenjang'];
	$kelas 					= $row['kelas'];
	$tahun_ajaran 	= $row['tahun_ajaran'];
	$nama 					= $row['nama'];
	$id_kelas 			= $row['id_kelas'];

	$data[]= array("no"=>$no,"id_penempatan"=>$id_penempatan,"nama_lengkap"=>$nama_lengkap,"gambar"=>$gambar,
		"id_siswa"=>$id_siswa,"jenjang"=>$jenjang,"kelas"=>$kelas,"tahun_ajaran"=>$tahun_ajaran,"nama"=>$nama,
		"id_kelas"=>$id_kelas,"absen_masuk"=>$absen_masuk,"absen_pulang"=>$absen_pulang,"valid"=>$valid);
	$no++;
	$absen_masuk= "-";
	$absen_pulang= "-";
}
echo json_encode($data);
?>
