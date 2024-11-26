<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();

//print_r($_POST);
// print_r($_FILES);
$id = $_POST['id'];
//$mapel = addslashes($_POST['mapel']);
$id_guru = $_SESSION['id_pengawas'];
$isimateri = addslashes($_POST['isimateri']);
$judul = addslashes($_POST['judul_materi']);
$kelas = serialize($_POST['kelas']);

$gdrive=$_POST['gdrive']; 
$youtube=$_POST['youtube']; 
$idyoutube=$_POST['idyoutube'];

$path2= '../../'.$linkguru.'/berkas2/'.$id_guru;
if (!file_exists($path2)) {
   mkdir($path2, 0755, true);
}

$ektensi = ['jpg', 'png','xlsx','pdf','docx','doc','xls','ppt','pptx'];
if ($_FILES['file_materi']['name'] <> '') {
   $file = str_replace(" ","_",$_FILES['file_materi']['name']);
   $temp = $_FILES['file_materi']['tmp_name'];
   $ext = explode('.', $file);
   $ext = end($ext);
   if (in_array($ext, $ektensi)) {
      $dest = '../../'.$linkguru.'/berkas2/'.$id_guru.'/';
      $path = $dest . $file;
      $upload = move_uploaded_file($temp, $path);
      if ($upload) {
         $data = array(
            //'materi2_mapel' => $mapel,
            'kelas' => $kelas,
            'id_guru' => $id_guru,
            'materi2_judul' => $judul,
            'materi2_isi' => $isimateri,
            'materi2_file' => $file,
            'url_gdrive' => $gdrive,
            'url_youtube' => $youtube,
            'url_embed' =>$idyoutube,
         );
         $cek = update($koneksi, 'materi2', $data, ['materi2_id' => $id]);
         if($cek=='OK'){
             echo "ok";
         }
        
      } else {
         echo "gagal";
      }
   }
} else {
   $data = array(
      //'materi2_mapel' => $mapel,
      'kelas' => $kelas,
      'id_guru' => $id_guru,
      'materi2_judul' => $judul,
      'materi2_isi' => $isimateri,
      'url_gdrive' => $gdrive,
      'url_youtube' => $youtube,
      'url_embed' =>$idyoutube,
   );
    $cek = update($koneksi, 'materi2', $data, ['materi2_id' => $id]);
   if($cek=='OK'){
     echo "ok";
  }
   
}
