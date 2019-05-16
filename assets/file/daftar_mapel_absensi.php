 <?php 
function hari(){
  $hari=$day=gmdate("l", time()+60*60*7);		
  switch($hari)
  {
    case"Sunday":$hari="Minggu"; break;
    case"Monday":$hari="Senin"; break;
    case"Tuesday":$hari="Selasa"; break;
    case"Wednesday":$hari="Rabu"; break;
    case"Thursday":$hari="Kamis"; break;
    case"Friday":$hari="Jumat"; break;
    case"Saturday":$hari="Sabtu"; break;
  }      
  $hariLengkap="$hari";
  return $hariLengkap;
}
include('koneksi.php');
//$nik = $_GET['nik'];
$kelas = $_GET['kelas'];
$jadwal = $_GET['jadwal'];
$jam  		= gmdate("H:i", time()+60*60*7);
$hari 			= hari();
$tgl = gmdate("d-m-Y", time()+60*60*7);

$sql = mysqli_query($con,"SELECT * FROM tabel_absen_mapel WHERE tgl = '$tgl' ANd id_jadwal='$jadwal'");
$cek = mysqli_num_rows($sql);

$sql2 = mysqli_query($con,"SELECT * FROM tabel_jadwal WHERE id_jadwal = '$jadwal'");
$cek2 = mysqli_num_rows($sql2);

$cek3 = mysqli_query($con,"SELECT COUNT(id_penempatan) AS jum FROM tabel_siswakelas WHERE id_kelas = '".$kelas."'
    AND id_ta = '".$cek2['id_ta']."'");
$am = mysqli_fetch_array($cek3,MYSQLI_ASSOC);
$valid2 = $am['jum'];

if($cek == 0){
  $queryKelas = "SELECT DISTINCT(tabel_siswakelas.id_penempatan),tabel_siswa.nama_lengkap,tabel_siswa.gambar,
      tabel_siswa.id_siswa,tabel_jenjang.jenjang,tabel_kelas.kelas,tabel_tahunajaran.tahun_ajaran,tabel_guru.nama,
      tabel_siswakelas.id_kelas
      FROM tabel_siswakelas LEFT JOIN tabel_siswa
          ON (tabel_siswakelas.id_siswa = tabel_siswa.id_siswa) INNER JOIN tabel_jenjang
          ON (tabel_siswa.id_jenjang = tabel_jenjang.id_jenjang) LEFT JOIN tabel_kelas 
          ON (tabel_siswakelas.id_kelas = tabel_kelas.id_kelas) INNER JOIN tabel_guru 
          ON (tabel_kelas.id_guru = tabel_guru.id_guru) LEFT JOIN tabel_tahunajaran
          ON (tabel_siswakelas.id_ta = tabel_tahunajaran.id_ta)       
          WHERE tabel_kelas.id_kelas = '$kelas'
          ORDER BY tabel_siswa.nama_lengkap ASC";
  $jad = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM tabel_jadwal WHERE id_jadwal = '$jadwal'"),MYSQLI_ASSOC);
  $status = $jad['status'];
  $valid = "";
  $absen = "";
  $result = mysqli_query($con,$queryKelas);
  $data = array();
  $no=1;
  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){  
    //$data[]= $row;  
    $data[]  = array("no"=>$no,"id_penempatan" => $row['id_penempatan'],"nama_lengkap" => $row['nama_lengkap'],
      "gambar" => $row['gambar'],"id_siswa" => $row['id_siswa'],"jenjang" => $row['jenjang'],
      "kelas" => $row['kelas'],"tahun_ajaran" => $row['tahun_ajaran'],"nama" => $row['nama'],
      "id_kelas" => $row['id_kelas'],"valid" => $valid,"status" => $status,"absen" => $absen,"cek" => $cek, "valid2" => $valid2);  
      $no++;             
  }
}elseif($cek <> $valid2){
  $queryKelas = "SELECT DISTINCT(tabel_siswakelas.id_penempatan),tabel_siswa.nama_lengkap,tabel_siswa.gambar,
      tabel_siswa.id_siswa,tabel_jenjang.jenjang,tabel_kelas.kelas,tabel_tahunajaran.tahun_ajaran,tabel_guru.nama,
      tabel_siswakelas.id_kelas
      FROM tabel_siswakelas LEFT JOIN tabel_siswa
          ON (tabel_siswakelas.id_siswa = tabel_siswa.id_siswa) INNER JOIN tabel_jenjang
          ON (tabel_siswa.id_jenjang = tabel_jenjang.id_jenjang) LEFT JOIN tabel_kelas 
          ON (tabel_siswakelas.id_kelas = tabel_kelas.id_kelas) INNER JOIN tabel_guru 
          ON (tabel_kelas.id_guru = tabel_guru.id_guru) LEFT JOIN tabel_tahunajaran
          ON (tabel_siswakelas.id_ta = tabel_tahunajaran.id_ta)       
          WHERE tabel_kelas.id_kelas = '$kelas'
          ORDER BY tabel_siswa.nama_lengkap ASC";
  $result = mysqli_query($con,$queryKelas);
  $data = array();
  $no=1;
  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
    $id_penempatan = $row['id_penempatan'];
    $jad = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM tabel_jadwal WHERE id_jadwal = '$jadwal'"),MYSQLI_ASSOC);  

    $c = mysqli_query($con,"SELECT * FROM tabel_absen_mapel WHERE tgl = '$tgl' AND id_jadwal = '$jadwal' 
          AND id_penempatan = '$id_penempatan'");
    $nm = mysqli_num_rows($c);
    $v = mysqli_fetch_array($c,MYSQLI_ASSOC);
    if($nm == 0){
      $status = $jad['status'];
      $valid = "";
      $absen = "";
    }else{
      $valid = $v['valid'];
      $status = $jad['status'];
      $absen = $v['absen'];
    }

    //$data[]= $row;    
    $data[]  = array("no"=>$no,"id_penempatan" => $row['id_penempatan'],"nama_lengkap" => $row['nama_lengkap'],
      "gambar" => $row['gambar'],"id_siswa" => $row['id_siswa'],"jenjang" => $row['jenjang'],
      "kelas" => $row['kelas'],"tahun_ajaran" => $row['tahun_ajaran'],"nama" => $row['nama'],
      "id_kelas" => $row['id_kelas'],"valid" => $valid,"status" => $status,"absen" => $absen,"cek" => $cek, "valid2" => $valid2, "id_ta" => $cek2['id_ta']);  
      $no++;  
  }
}else{
  $queryKelas="SELECT DISTINCT(tabel_siswakelas.id_penempatan),tabel_siswa.nama_lengkap,tabel_siswa.gambar,
      tabel_siswa.id_siswa,tabel_jenjang.jenjang,tabel_kelas.kelas,tabel_tahunajaran.tahun_ajaran,tabel_guru.nama,
      tabel_siswakelas.id_kelas,tabel_absen_mapel.valid,tabel_jadwal.status,tabel_absen_mapel.absen
      FROM tabel_siswakelas LEFT JOIN tabel_siswa
      ON (tabel_siswakelas.id_siswa = tabel_siswa.id_siswa) INNER JOIN tabel_jenjang
      ON (tabel_siswa.id_jenjang = tabel_jenjang.id_jenjang) LEFT JOIN tabel_kelas 
      ON (tabel_siswakelas.id_kelas = tabel_kelas.id_kelas) INNER JOIN tabel_guru 
      ON (tabel_kelas.id_guru = tabel_guru.id_guru) LEFT JOIN tabel_tahunajaran
      ON (tabel_siswakelas.id_ta = tabel_tahunajaran.id_ta) LEFT JOIN tabel_absen_mapel
      ON (tabel_siswakelas.id_penempatan = tabel_absen_mapel.id_penempatan) LEFT JOIN tabel_jadwal
      ON (tabel_absen_mapel.id_jadwal = tabel_jadwal.id_jadwal)          
      WHERE tabel_kelas.id_kelas = '$kelas' AND tabel_absen_mapel.tgl = '$tgl'
      ORDER BY tabel_siswa.nama_lengkap ASC";
  $result = mysqli_query($con,$queryKelas);
  $data = array();
  $no=1;
  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){  
    //$data[]= $row;    
    $data[]  = array("no"=>$no,"id_penempatan" => $row['id_penempatan'],"nama_lengkap" => $row['nama_lengkap'],
      "gambar" => $row['gambar'],"id_siswa" => $row['id_siswa'],"jenjang" => $row['jenjang'],
      "kelas" => $row['kelas'],"tahun_ajaran" => $row['tahun_ajaran'],"nama" => $row['nama'],
      "id_kelas" => $row['id_kelas'],"valid" => $row['valid'],"status" => $row['status'],"absen" => $row['absen'],"cek" => $cek, "valid2" => $valid2);  
      $no++;  
  }
}
echo json_encode($data);
?>
