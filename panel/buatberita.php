<?php

require("../config/config.default.php");
require("../config/config.function.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;

$exec = mysqli_query($koneksi, "TRUNCATE berita");
$beritaQ = mysqli_query($koneksi, "SELECT * FROM ujian");
$sesiq = mysqli_query($koneksi, "SELECT * FROM ujian group by sesi ");

while ($berita = mysqli_fetch_array($beritaQ)) {

	while ($sesi = mysqli_fetch_array($sesiq)) {
		$ruangq = mysqli_query($koneksi, "SELECT * FROM ruang");
		while ($ruang = mysqli_fetch_array($ruangq)) {
			$exec = mysqli_query($koneksi, "INSERT INTO berita (id_mapel,sesi,ruang,jenis)VALUES('$berita[id_mapel]','$sesi[sesi]','$ruang[kode_ruang]','$berita[kode_ujian]')");
		}
	}
}
