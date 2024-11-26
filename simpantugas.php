<?php
require("config/config.function.php");
require("config/functions.crud.php");
include("core/c_user.php"); 

if(!isset($_SESSION['id_siswa'])){
  header('location:logout.php');
}else{
  $id_tugas = $_POST['id_tugas'];
  $id_guru = $_POST['id_guru'];
  $mapel = $_POST['mapel2'];
  $id_siswa = $_SESSION['id_siswa'];
  $nama_depan = $_SESSION['nama_depan'];
  $jawaban = addslashes($_POST['jawaban']);
  $gdrive=$_POST['gdrive'];
  $youtube=$_POST['youtube'];
  $id_telegram = $_POST['id_telegram'];

  $datetime = date('Y-m-d H:i:s');
  $ektensi = ['jpg', 'png', 'docx', 'pdf', 'xlsx', 'xls','ppt','pptx','PNG','JPEG','doc'];
  $path= 'guru/tugas_siswa/'.$id_guru.'/'.$id_tugas;
  if (!file_exists($path)) {
   mkdir($path, 0755, true);
  }


  if ($_FILES['file']['name'] <> '') {
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if (in_array($ext, $ektensi)) {
      $dest = 'guru/tugas_siswa/'.$id_guru.'/'.$id_tugas.'/';
      $file = $id_tugas. '_' .$mapel . '_' . $id_siswa . '_' . $nama_depan . '.' . $ext;
      $path = $dest . $file;
      $upload = move_uploaded_file($temp, $path);
      if ($upload) {
        $data = array(
          'id_tugas' => $id_tugas,
          'id_siswa' => $id_siswa,
          'id_guru' => $id_guru,
          'jawaban' => $jawaban,
          'file' => $file,
          'url_gdrive' => $gdrive,
          'youtube' => $youtube,
          'tgl_dikerjakan' => date("Y-m-d h:i:s")
        );
        $data2 = array(
          'id_tugas' => $id_tugas,
          'id_siswa' => $id_siswa,
          'id_guru' => $id_guru,
          'jawaban' => $jawaban,
          'file' => $file,
          'url_gdrive' => $gdrive,
          'youtube' => $youtube,
        );
        $where = array(
          'id_siswa' => $id_siswa,
          'id_tugas' => $id_tugas,
          'id_guru' => $id_guru,
        );
        $cek = rowcount($koneksi, 'jawaban_tugas', $where);
        if ($cek == 0) {
          insert($koneksi, 'jawaban_tugas', $data);
        } else {
          update($koneksi, 'jawaban_tugas', $data2, $where);
        }
        
        echo "ok";
        if(!empty($id_telegram)){
        $pesan='---Tugas Sudah Di Kirim---';
        $dbb->KirimAbsenTelegram($pesan,$_SESSION['token_bot_telegram'],$id_telegram,$_SESSION['full_nama'],$_SESSION['id_kelas'],$_SESSION['nama_sekolah'],$mapel);
        }
      } else {
        echo "gagal";
      }
    }
  } else {
    $data = array(
      'id_tugas' => $id_tugas,
      'id_siswa' => $id_siswa,
      'id_guru' => $id_guru,
      'jawaban' => $jawaban,
      'url_gdrive' => $gdrive,
      'youtube' => $youtube,
      'tgl_dikerjakan' => date("Y-m-d h:i:s")

    );
    $data2 = array(
      'id_tugas' => $id_tugas,
      'id_siswa' => $id_siswa,
      'id_guru' => $id_guru,
      'jawaban' => $jawaban,
      'url_gdrive' => $gdrive,
      'youtube' => $youtube,
    );
    $where = array(
      'id_siswa' => $id_siswa,
      'id_tugas' => $id_tugas,
      'id_guru' => $id_guru,
    );
    $cek = rowcount($koneksi, 'jawaban_tugas', $where);
    if ($cek == 0) {
      insert($koneksi, 'jawaban_tugas', $data);
    } else {
      update($koneksi, 'jawaban_tugas', $data2, $where);
    }
    echo "ok";
    if(!empty($id_telegram)){
        $pesan='---Tugas Sudah DiKirim ---';
        $dbb->KirimAbsenTelegram($pesan,$_SESSION['token_bot_telegram'],$id_telegram,$_SESSION['full_nama'],$_SESSION['id_kelas'],$_SESSION['nama_sekolah'],$mapel);
        }
  }
}
