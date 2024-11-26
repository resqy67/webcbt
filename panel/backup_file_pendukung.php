<?php 
// Create ZIP file Mryes
require("../config/config.default.php");
require "../config/config.function.php";
//cek session id_suer dan id_pengawas
if($token == $token1) {
    if(isset($_POST['id'])){
      if($_POST['id']==1){ //cek jiak aksi backup
        $zip = new ZipArchive();
        $filename = "backup_soal/file_pendukung.zip";
        $dir='../files/';
        
        $zip->open($filename, ZipArchive::CREATE);
        $file = scandir($dir); //scand isi folder

        unset($file[0],$file[1]);//hapus key array 0 dan 1

        foreach ($file as $value) { //looping hasil scand dan hapus array
          $zip->addFile($dir.$value,$value); //add file
        }
        $zip->close(); 
        echo"Berhasil Back File Pendukung";
       }
      elseif($_POST['id']==2){ //cek jika aksi cek fie
        $filename = "backup_soal/file_pendukung.zip";
        $cek_file = file_exists ($filename);
          if ($cek_file) {
            echo 1;
          } else {
              echo "File Pendukung Belum Di Backup ";
          }
        }
        else{
        echo 100;
       }
    }

    if(isset($_GET['restore'])){
      if(isset($_GET['restore'])=="yes"){ 
        $extensionList = array("zip");
        $file_name = $_FILES['dukung']['name']; //ambil file
        
        $path = 'upload_data/'; //lokasi di tempatkan   
        
        $location = $path . $file_name; //file di taruh

        $pecah = explode(".", $file_name);
        $ekstensi = $pecah[1];
        if(in_array($ekstensi, $extensionList)){
        //jika sudah di pindah pada lokasi yang di tentukan mryes ^_^
          if(move_uploaded_file($_FILES['dukung']['tmp_name'], $location))  
          {
            
            $zip = new ZipArchive;
            $res = $zip->open($location);
            if ($res === TRUE) {

             // Unzip lokasi
             $path = "../files/";

             // Extract file nya
             $zip->extractTo($path);
             $zip->close();

             echo 1;
             unlink($location);  
            } else {
             echo 'Gagal Upload';
            }
          }
        }
        else{
          echo 100;
        }  
      }
       else{
        echo 100;
       }
    }
}

else{
  jump("$homeurl");
exit;
}


?>