<?php
require("../config/config.default.php");
$id_mapel = $_POST['mapel_id'];
$ruang = $_POST['ruang'];
$sesi = $_POST['sesi'];
$sql = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"));
$dataArray = unserialize($sql['kelas']);

if (count($dataArray) == 1) {
    if ($dataArray[0] == "semua") {
        $status = 0;
        if ($sql['level'] == "semua") {
            $data = mysqli_query($koneksi, "SELECT * FROM siswa where ruang='$ruang' and sesi='$sesi' group by id_kelas");
        } else {
            $tingkat = $sql['level'];
            $jurusan = $sql['idpk'];
            if ($sql['idpk'] == "semua") {
                $data = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang='$ruang' and sesi='$sesi' and level='$tingkat' group by id_kelas");
            } else {
                $data = mysqli_query($koneksi, "SELECT * FROM kelas WHERE ruang='$ruang' and sesi='$sesi' and level='$tingkat' AND id_kelas LIKE '%$jurusan%'");
            }
        }
        echo "<option value='KLS'>Pilih Kelas</option>";
        echo "<option value='KLS'>Pilih Semua Kelas</option>";
        while ($kelas = mysqli_fetch_array($data)) {
            echo "<option value='$kelas[id_kelas]'>$kelas[id_kelas]</option>";
        }
    } else {
        echo "<option value='KLS'>Pilih Kelas</option>";
        echo "<option value='KLS'>Pilih Semua Kelas</option>";
        foreach ($dataArray as $key => $value) {
            echo "<option value='$value'>$value</option>";
        }
    }
} elseif (count($dataArray) > 1) {
    echo "<option value='KLS'>Pilih Kelas</option>";
    echo "<option value='KLS'>Pilih Semua Kelas</option>";
    foreach ($dataArray as $key => $value) {
        echo "<option value='$value'>$value</option>";
    }
};
