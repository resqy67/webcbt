<?php
require("config/config.function.php");
require("config/functions.crud.php");
include("core/c_user.php");

if(!isset($_SESSION['id_siswa'])){
    header('location:logout.php');
}else{
//$pass = $_POST['pass'];
 $jamin = date("Y-m-d H:i:s");
$id_siswa = $_SESSION['id_siswa'];
    $data = array(
    'nilai' =>$_POST['performag'],
    'alasan' =>$_POST['alasang'],
    'dibuat' =>$jamin,
    );
    $where = array(
        'id_rating' => $_POST['id'],
    );
        //insert($koneksi, 'jawaban_tugas', $data);
    $exc = update($koneksi, 'rating', $data, $where);
   if($exc =='OK'){
    echo 1;
   }
   else{
    echo 0;
   }
}
