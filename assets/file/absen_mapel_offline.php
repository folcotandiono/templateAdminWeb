<?php 
include('koneksi.php');
$tgl = gmdate("d-m-Y", time()+60*60*7); 
$id_guru = $_GET['id_guru'];
$query = "select * from tabel_absen_mapel 
          where tgl='$tgl'";
          // $query = "select * from tabel_absen_mapel";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_absen_mapel"=>$row['id_absen_mapel'],
    "id_penempatan"=>$row['id_penempatan'],
    "id_jadwal"=>$row['id_jadwal'],
    "tgl"=>$row['tgl'],
    "jam" => $row['jam'],
    "absen" => $row['absen'],
    "valid" => $row['valid'],
    "rekap" => $row['rekap'],
    "status" => $row['status'],
    "keterangan" => $row['keterangan']
  );
}
echo json_encode($data);
?>