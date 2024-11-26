<?php
require("config/m_admin.php");
$db= new Budut();
$dbb= new Siswa(); 
/*---------Catatan----------------*/

/*--------------------------------*/

if(isset($_GET['adm'])){
// &1.Tombol Selesai -------------------------------------
    if($_GET['adm']=="tombol_selesai"){
		
		//$post1 = $_POST;
		$cek = $db->tombol_selesai_paksa();
		if($cek==1){
			return true;
		}
		else{
			return false;
		}
	}
	else{
		echo 100;
	}
	
} //END isset($_GET['adm'])
if(isset($_GET['siswa'])){
	if($_GET['siswa']=="kirim_jawaban"){
		echo"yes";
	}
	if($_GET['siswa']=="absen"){
		print_r($_POST);
	}
}

