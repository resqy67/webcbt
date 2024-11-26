<?php
// mryes
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");




$sesi = $_POST['sesi'];
$tglujian = $_POST['mulaiujian'];
$tglselesai = $_POST['selesaiujian'];
$lama = $_POST['lama_ujian'];

//pecah ke array hilangkan spasi
$waktu = explode(" ", $tglujian);

$acak = $_POST['acak_soal'];
$opsipg =$_POST['acak_pg'];
$token = $_POST['token'];
$hasil = $_POST['hasil'];

$status_reset = $_POST['status_reset'];

$level = $_POST['level'];

$idpk = $_POST['id_pk'];

$kkm = $_POST['kkm'];
$history = $_POST['history'];

if($_POST['kelas']==null){ $kelas=null; }
else{ $kelas = serialize($_POST['kelas']); }

if($_POST['siswa']==null){ $siswa=null; }
else{ $siswa = serialize($_POST['siswa']); }

if($_POST['tombol_selsai']==null){ $tombol_selsai="0000-00-00 00:00:00"; }
else{ $tombol_selsai = $_POST['tombol_selsai']; }

$waktu = $waktu[1]; //ambil array ke 1 (jam)

	// data untuk tabel nilai
	$data = array(
		'sesi' => $sesi,
		'tgl_ujian' => $tglujian,
		'tgl_selesai' => $tglselesai,
		'waktu_ujian' => $waktu,
		'lama_ujian' => $lama,
		'tombol_selsai' => $tombol_selsai,
		'acak'=>$acak,
		'acak_opsi'=>$opsipg,
		'token'=>$token,
		'hasil'=>$hasil,
		'id_pk' =>$idpk,
		'level' =>$level,
		'kelas' =>$kelas,
		'siswa' =>$siswa,
		'kkm' =>$kkm,
		'history' =>$history,
		'status_reset' => $status_reset,

	);
	//data untuk tabel mapel
	$data2 = array(
		'idpk' =>$idpk,
		'level' =>$level,
		'kelas' =>$kelas,
		'siswa' =>$siswa,

	);

	$idujian = $_POST['idm'];
	$idmapel = $_POST['idmapel'];
	
	$where = array(
			'id_ujian' => $idujian
	);

	$where2 = array(
			'id_mapel' => $idmapel
	);
	
	$table='ujian';
	$table2='mapel';

$exec = update($koneksi, $table,$data,$where);
if ($exec=='OK') {
    $exec2 = update($koneksi, $table2,$data2,$where2);
    if($exec2=='OK'){
    	echo 1;
    }
    else{
    	echo"gagal edit mapelnya";
    }
}else{
    echo"gagal edit Jadwal Ujian";
	//die ('ERROR: Data gagal dimasukkan pada tabel '. mysqli_error($koneksi));
    }

//print_r($data);
