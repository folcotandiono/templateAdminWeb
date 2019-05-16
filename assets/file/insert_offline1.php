<?php 
include('koneksi.php');
$query = $_POST['query'];
if ($query != "") mysqli_query($con,$query);
$data["query"] = "haha";
echo json_encode($_POST['query']);
 ?>