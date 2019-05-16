<?php 

include('koneksi.php');
$tgl2 = gmdate("d-m-Y", time()+60*60*7);
$name = $_GET['name'];
$ambilUser = mysqli_query($con,"SELECT * FROM tabel_guru INNER JOIN tabel_kelas ON 
	tabel_guru.id_guru=tabel_kelas.id_guru WHERE tabel_guru.nik = '$name'");
$w = mysqli_fetch_assoc($ambilUser);
$cek = mysqli_query($con,"SELECT tabel_siswa.id_siswa,tabel_siswa.nama_lengkap,tabel_kelas.kelas,tabel_siswakelas.id_ta,
                    tabel_siswa.email,tabel_siswakelas.id_penempatan FROM tabel_siswakelas INNER JOIN tabel_siswa 
                    ON tabel_siswakelas.id_siswa=tabel_siswa.id_siswa INNER JOIN tabel_kelas ON tabel_siswakelas.id_kelas = tabel_kelas.id_kelas
                    WHERE tabel_siswakelas.id_kelas='".$w['id_kelas']."' AND tabel_siswakelas.id_penempatan IN (SELECT id_penempatan FROM tabel_absen
                    WHERE tabel_absen.tgl='".$tgl2."')");
$am = mysqli_fetch_array($cek,MYSQLI_ASSOC);

$cek2 = mysqli_query($con,"SELECT COUNT(id_penempatan) AS jum FROM tabel_siswakelas WHERE id_kelas = '".$w['id_kelas']."'
		AND id_ta = '".$am['id_ta']."'");
$am2 = mysqli_fetch_array($cek2,MYSQLI_ASSOC);

$valid2 = $am2['jum'];
$valid = mysqli_num_rows($cek);
if($valid>0){
	if($valid == $valid2){
		    while ($periksa = mysqli_fetch_array($cek,MYSQLI_ASSOC)) {
		  	
		  		$id_s = $periksa['id_penempatan'];
		  		mysqli_query($con,"UPDATE tabel_absen SET sms_pulang = '-',valid_pulang = 'valid' WHERE id_penempatan='$id_s' AND tgl='".$tgl2."'");
		  	}
		  	echo "sip";  	
	}else{
		echo "error";
	}
}else{
		echo "error";
	}

 ?>