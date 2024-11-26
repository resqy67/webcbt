<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");

cek_session_admin();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';

$idujian = $_POST['id'];
$query = mysqli_query($koneksi, "select * from nilai where id_ujian='$idujian' and status is null");

if ($pg == 'pindah') {
    
       $exec =  mysqli_query($koneksi, "UPDATE nilai SET pindah='1' WHERE id_ujian='$idujian'");
       $exec =  mysqli_query($koneksi, "INSERT INTO `nilai_pindah`(`id_ujian`, `id_mapel`, `id_siswa`, `kode_ujian`, `ujian_mulai`, `ujian_berlangsung`, `ujian_selesai`, `jml_benar`, `jml_salah`, `nilai_esai`, `skor`, `total`, `status`, `ipaddress`, `hasil`, `jawaban`, `jawaban_esai`, `online`, `blok`, `id_soal`, `id_opsi`, `id_esai`, `nilai_esai2`, `selesai`, `cek_tombol_selesai`, `pindah`) SELECT `id_ujian`, `id_mapel`, `id_siswa`, `kode_ujian`, `ujian_mulai`, `ujian_berlangsung`, `ujian_selesai`, `jml_benar`, `jml_salah`, `nilai_esai`, `skor`, `total`, `status`, `ipaddress`, `hasil`, `jawaban`, `jawaban_esai`, `online`, `blok`, `id_soal`, `id_opsi`, `id_esai`, `nilai_esai2`, `selesai`, `cek_tombol_selesai`, `pindah` FROM `nilai` WHERE pindah='1' ");
       //$exec =  mysqli_query($koneksi, "INSERT INTO `nilai_pindah`(`id_ujian`, `id_bank`, `id_siswa`, `kode_ujian`, `ujian_mulai`, `ujian_berlangsung`, `ujian_selesai`, `jml_benar`, `benar_esai`, `benar_multi`, `benar_bs`, `benar_urut`, `jml_salah`, `salah_esai`, `salah_multi`, `salah_bs`, `salah_urut`, `skor`, `skor_esai`, `skor_multi`, `skor_bs`, `skor_urut`, `total`, `status`, `ipaddress`, `hasil`, `jawaban`, `jawaban_esai`, `jawaban_multi`, `jawaban_bs`, `jawaban_urut`, `nilai_esai`, `nilai_esai2`, `online`, `id_soal`, `id_opsi`, `id_esai`, `blok`, `server`) SELECT `id_ujian`, `id_bank`, `id_siswa`, `kode_ujian`, `ujian_mulai`, `ujian_berlangsung`, `ujian_selesai`, `jml_benar`, `benar_esai`, `benar_multi`, `benar_bs`, `benar_urut`, `jml_salah`, `salah_esai`, `salah_multi`, `salah_bs`, `salah_urut`, `skor`, `skor_esai`, `skor_multi`, `skor_bs`, `skor_urut`, `total`, `status`, `ipaddress`, `hasil`, `jawaban`, `jawaban_esai`, `jawaban_multi`, `jawaban_bs`, `jawaban_urut`, `nilai_esai`, `nilai_esai2`, `online`, `id_soal`, `id_opsi`, `id_esai`, `blok`, `server` FROM `nilai` WHERE pindah='1' ");
       $exec =  mysqli_query($koneksi, "DELETE FROM nilai WHERE pindah='1' AND selesai='1' ");
       $exec = mysqli_query($koneksi, "DELETE FROM jawaban WHERE 1");
}

if ($pg == 'hapus') {
    $exec = mysqli_query($koneksi, "DELETE FROM nilai_pindah WHERE id_ujian='$idujian'");
}
?>