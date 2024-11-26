<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");
//absen jenis pada tabel databse absensi
//1 untuk absen 
//2 untuk edit sakit izin alpah
if(!isset($_SESSION['id_siswa'])){
  header('location:logout.php');
}else{
  //print_r($_FILES);
  function UploadImageResize($new_name,$file,$dir,$width){
   //direktori gambar
   $vdir_upload = $dir;
   $vfile_upload = $vdir_upload . $_FILES[''.$file.'']["name"];

   //Simpan gambar dalam ukuran sebenarnya
   $upload = move_uploaded_file($_FILES[''.$file.'']["tmp_name"], $dir.$_FILES[''.$file.'']["name"]);

   //identitas file asli
   $im_src = imagecreatefromjpeg($vfile_upload);
   $src_width = imageSX($im_src);
   $src_height = imageSY($im_src);

   //Set ukuran gambar hasil perubahan
   $dst_width = $width;
   $dst_height = ($dst_width/$src_width)*$src_height;
  //$dst_height=200;

   //proses perubahan ukuran
   $im = imagecreatetruecolor($dst_width,$dst_height);
   imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

   //Simpan gambar
   imagejpeg($im,$vdir_upload . $new_name,100);
   
   //Hapus gambar di memori komputer
   imagedestroy($im_src);
   imagedestroy($im);
   $remove_small = unlink("$vfile_upload");
   if($upload){
    return true;
   }
   else{
    return false;
   }
   
 }


  $tgl = date("Y-m-d");
  $date = date('Y-m-d H:i:s');
  $datetime = strtotime($date);
  $bulan = date('n',$datetime);
  $id_siswa = $_SESSION['id_siswa'];
  $ektensi = ['jpg','png','jpeg','JPG','JPEG','PNG'];
  $path= 'guru/absen_siswa/'.$bulan.'/'.$id_siswa;
  if (!file_exists($path)) {
   mkdir($path, 0755, true);
  }
  if ($_FILES['file']['name'] <> '') {
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if (in_array($ext, $ektensi)) {
      $dest = 'guru/absen_siswa/'.$bulan.'/'.$id_siswa.'/';
      $file2 = $id_siswa.$datetime.'.'. $ext;
      $path = $dest . $file2;
      //$upload = move_uploaded_file($temp, $path);
      //--------------------------------------------
      $new_name=$file2;
      $file='file'; //name pada inputan type file
      $dir=$dest; //tutjuan file di letakan
      $width=400;//satuan dalam pixel / px
      
      //variabel array untuk di upload
      $where = array(
          'absIdSiswa' => $id_siswa,
          'absTgl' => $tgl,
        );
      $data = array(
          'absFoto' => $file2,
          'absUrlFoto' =>$path,
          'absCreated' => date("Y-m-d h:i:s")
        );
      $cek = rowcount($koneksi, 'absensi', $where);
        if ($cek == 0) {
          echo 0;
        } else {
          $upload = UploadImageResize($new_name,$file,$dir,$width);
          if($upload){
            update($koneksi, 'absensi', $data, $where);
            echo 1;
          }
          else{
            echo 'error';
          }
          
        }
        
    }
    else{
      echo 99;
    }
  }
}
