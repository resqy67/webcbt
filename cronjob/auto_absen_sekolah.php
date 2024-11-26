<?php

require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/m_admin.php");
$dbb= new Siswa(); 


  
  // $jamsekolah2 = $dbb->getJamSekolah();
  // //date_default_timezone_set('Asia/Jakarta');
  // $tgl = date("Y-m-d",strtotime($_POST['tgl']));
  // $jamsekolah2['jamAlpah'];


  // $data = array(
  //   'absIdSiswa' => $idsiswa,
  //   'absIdKelas' => $idkls,
  //   'absTgl' => $tgl,
  //   'absJamIn' => $jamin,
  //   'absJamOut' => $jamout,
  //   'absStatus' => $status_absen,
  //   'absJenis' => 1,
  // );
  // $cek = fetch($koneksi, 'absensi', array('absTgl' => $tgl, 'absIdSiswa' =>$idsiswa));
  // if(count($cek) > 0){
  //   echo 99;
  // }
  // else{
  //  $exc = insert($koneksi,'absensi',$data);
  //  if($exc =='OK'){
  //   echo 1;
  //  }
  //  else{
  //   echo 0;
  //  }
  // }
  $tgl = date("Y-m-d");
  $jamAlpah = date("00:00");

  $getSiswa = $dbb->v_siswa2();
  foreach ($getSiswa as $siswa) {
    $idsiswa = $siswa['id_siswa'];
    $cekKelas = fetch($koneksi, 'kelas', array('id_kelas' => $siswa['id_kelas']));
    $cekAbsen = fetch($koneksi, 'absensi', array('absTgl' => $tgl, 'absIdSiswa' =>$idsiswa));
    if(count($cekAbsen) > 0){ }
    else{
      $data = array(
        'absIdSiswa' => $idsiswa,
        'absIdKelas' => $cekKelas['idkls'],
        'absTgl' => $tgl,
        'absJamIn' => $jamAlpah,
        'absJamOut' => $jamAlpah,
        'absStatus' =>'A',
        'absJenis' => 3,
      );
      $exc = insert($koneksi,'absensi',$data);
    }

  }
 
 
