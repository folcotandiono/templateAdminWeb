<?php
include('koneksi.php');
$query = 'select * from  siswa';
$result = mysqli_query($con,$query);

$data = array();
while($row = mysqli_fetch_object($result)){
	$data[]= $row;
}
echo json_encode($data);

$tgl = gmdate("d-m-Y", time()+60*60*7);	
echo $tgl;
?>