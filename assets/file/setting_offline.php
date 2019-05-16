<?php 
include('koneksi.php');
$query = "select * from tabel_setting";
$result = mysqli_query($con,$query);
$data = array();
while($row = mysqli_fetch_array($result)){
  $data[] = array(
    "id_setting"=>$row['id_setting'],
    "logo_mini"=>$row['logo_mini'],
    "logo_gambar"=>$row['logo_gambar'],
    "logo_favicon"=>$row['logo_favicon'],
    "nik" => $row['nik'],
    "kartu_gsm" => $row['kartu_gsm'],
    "cek_pulsa" => $row['cek_pulsa'],
    "metode" => $row['metode'],
    "kode_aktivasi" => $row['kode_aktivasi'],
    "link_tujuan" => $row['link_tujuan'],
    "logo_besar" => $row['logo_besar'],
    "logo_sekolah" => $row['logo_sekolah'],
    "pimpinan" => $row['pimpinan'],
    "akun_gmail" => $row['akun_gmail'],
    "alamat" => $row['alamat'],
    "website" => $row['website'],
    "kop_surat" => $row['kop_surat'],
    "ttd" => $row['ttd'],
    "telat" => $row['telat'],
    "toleransi_jam_akhir" => $row['toleransi_jam_akhir'],
    "lat" => $row['lat'],
    "lng" => $row['lng'],
    "radius" => $row['radius'],
    "jam_pulang" => $row['jam_pulang'],
    "kota" => $row['kota']
  );
}
echo json_encode($data);
?>