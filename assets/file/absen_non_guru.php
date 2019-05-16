<?php 

include('koneksi.php');

$id_non_guru      = $_GET['id_non_guru'];
$tgl        = gmdate("d-m-Y", time()+60*60*7);    
$jam        = gmdate("H:i", time()+60*60*7);
$hari = date("l");
if ($hari == "Sunday") $hari = "Minggu";
else if ($hari == "Monday") $hari = "Senin";
else if ($hari == "Tuesday") $hari = "Selasa";
else if ($hari == "Wednesday") $hari = "Rabu";
else if ($hari == "Thursday") $hari = "Kamis";
else if ($hari == "Friday") $hari = "Jumat";
else if ($hari == "Saturday") $hari = "Sabtu";

$cek = mysqli_query($con,"SELECT * from tabel_absen_non_guru where id_non_guru = '$id_non_guru' and tgl = '$tgl'");
$c=mysqli_num_rows($cek);

$setting = mysqli_query($con,"SELECT * from tabel_setting");
$setting = mysqli_fetch_array($setting);
$jam_pulang_kerja = $setting['jam_pulang'];

$jam_masuk = mysqli_query($con, "select * from tabel_jam_masuk where substring(hari, 3) = '$hari'");
$jam_masuk = mysqli_fetch_array($jam_masuk);
$jam_masuk_kerja = $jam_masuk['jam'];

if ($c == 0) {
    $sampai = strtotime($jam_pulang_kerja) - 1800;
    $sampai = date('H:i', $sampai);
    if (strtotime($jam) <= strtotime($sampai)) {
        mysqli_query($con,"INSERT INTO tabel_absen_non_guru VALUES ('','$id_non_guru','$tgl','$jam','')");
        
        $jam_masuk_diff = ceil((strtotime($jam) - strtotime($jam_masuk_kerja)) / 60);
        $keterangan_jam_masuk = "";
        if ($jam_masuk_diff > 0) {
            $keterangan_jam_masuk .= "terlambat $jam_masuk_diff menit";
        }
        else {
            $keterangan_jam_masuk .= "absen sesuai";
        }

        echo json_encode(array("status"=>"ok", "keterangan"=>$keterangan_jam_masuk));
    }
    else {
        echo json_encode(array("status"=>"error", "keterangan"=>"tidak bisa absen masuk lagi"));
    }
}
else {
    $sampai = "17:00";
    if (strtotime($jam) >= strtotime($jam_pulang_kerja) && strtotime($jam) <= strtotime($sampai)) {
        mysqli_query($con,"INSERT INTO tabel_absen_non_guru VALUES ('','$id_non_guru','$tgl','$jam','')");
        echo json_encode(array("status"=>"ok", "keterangan"=>"absen sesuai"));
    }
    else if (strtotime($jam) < strtotime($jam_pulang_kerja)) {
        $tunggu = (strtotime($jam_pulang_kerja) - strtotime($jam));
        $jam = floor($tunggu / 3600);
        $menit = floor(($tunggu % 3600) / 60);
        $detik = ($tunggu % 3600) % 60;
        echo json_encode(array("status"=>"error", "keterangan"=>"belum waktunya absen pulang. 
        Tunggu $jam jam $menit menit"));
    }
    else {
        echo json_encode(array("status"=>"error", "keterangan"=>"absen sudah off"));
    }
}
?>
