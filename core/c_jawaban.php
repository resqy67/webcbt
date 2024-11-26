<?php
require("../config/m_admin.php");
$db= new Budut();
$dbb= new Siswa(); 
/*---------Catatan----------------*/

/*--------------------------------*/

if(isset($_GET['siswa'])){
	if($_GET['siswa']=="kirim_jawaban"){
		
		//$deco = json_decode($_POST['data']);
		print_r($_POST['data']);
	}
}
