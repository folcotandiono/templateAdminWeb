<?php 
include('koneksi.php');

$t = mysqli_query($con, "SELECT * FROM tabel_guru order by nama asc");

while ($row = mysqli_fetch_array($t)) {     
    $data[] = array("nik"=>$row['nik'],"nama"=>$row['nama'],"pass_sync"=>$row['pass_sync']);        
}

echo json_encode($data);
?>
