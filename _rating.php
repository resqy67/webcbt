<?php
require("config/config.function.php");
require("config/functions.crud.php");
include("core/c_user.php"); 
//absen jenis pada tabel databse absensi
//1 untuk absen 
//2 untuk edit sakit izin alpah
if(!isset($_SESSION['id_siswa'])){
  header('location:logout.php');
}else{
$id_siswa=$_SESSION['id_siswa'];
  $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id_siswa'"));
$kelasdb = fetch($koneksi, 'kelas', array('id_kelas' => $siswa['id_kelas']));
$idkelas = $kelasdb['idkls'];
  //print_r($_POST);
  $jamin = date("Y-m-d H:i:s");
  $tgl = date("Y-m-d",strtotime($_POST['tgl']));
  $data = array(
    'id_siswa' =>$_SESSION['id_siswa'],
    'id_kelas' =>$idkelas,
    'id_guru' =>$_POST['idguru'],
    'nilai' =>$_POST['performaa'],
    'alasan' =>$_POST['alasann'],
    'dibuat' =>$jamin,

  );
  $cek = fetch($koneksi, 'rating', array('id_siswa' => $_SESSION['id_siswa'], 'id_guru' =>$_POST['idguru']));
  if(count($cek) > 0){
    echo 99;
  }
  else{
   $exc = insert($koneksi,'rating',$data);
   if($exc =='OK'){
    echo 1;
   }
   else{
    echo 0;
   }
  }

 
 
 
}
