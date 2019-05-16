<?php 
include('koneksi.php');
$query = $_GET['query'];
if ($query != "") mysqli_query($con,$query);
$data[] = array("query" => "haha");
echo json_encode($data);
 ?>