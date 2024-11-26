<?php
class Siswa extends Db{
  /*
    -&materi
  */
  private function idsiswa(){ 
    $idsiswa = $_SESSION['id_siswa'];
    return $idsiswa;
   }
   private function idkelas(){ 
    $idkelas = $_SESSION['id_kelas'];
    return $idkelas;
   }

//&materi-----------------------------
  function v_siswa(){
  	$id = $this->idsiswa();
  	$sql="SELECT * FROM siswa WHERE id_siswa='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  function v_siswa2(){
    $sql="SELECT id_siswa,id_kelas,idpk,level,ruang,sesi FROM siswa WHERE status_siswa=1 ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  //----------------Pangging Materi----------------------
  function paging($halaman,$materi2_mapel,$kodelv){
    $kelas = $_SESSION['id_kelas'];
	  $result=$this->con->query("SELECT * FROM materi2 where materi2_mapel='$materi2_mapel' AND kode_level='$kodelv' ") or die($this->con->error);
    foreach ($result as $value) {
      $datakelas = unserialize($value['kelas']);
      if (in_array($kelas, $datakelas) or in_array('semua', $datakelas)){
        $array[]=$value;
      }
    } 
    $total = count($array);
	  $pages = ceil($total/$halaman);
	  return  $pages;
  }
  function halaman(){
  	$halaman = 5;
  	return $halaman;
  }
  function mulai($halaman){
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $halaman;
    return $start;
  }
  function get_materi($mulai,$halaman,$kelas,$guru, $level3, $idmapel3){
    $sql="SELECT *,materi2.kode_level AS kodelv FROM materi2 
    INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel 
    WHERE materi2.kode_level='$level3' AND materi2_mapel='$idmapel3' AND materi2.id_guru='$guru' ORDER BY materi2_tgl DESC LIMIT $mulai, $halaman";
	  $query = $this->con->query($sql) or die($this->con->error);
    foreach ($query as $value) {
      $datakelas = unserialize($value['kelas']);
      if (in_array($kelas, $datakelas) or in_array('semua', $datakelas)){
        $array[]=$value;
      }
    }
	  return  $array;
    
   
  }
  function get_materi2($guru,$level,$idmapel2){ //untuk menjumlhakan materi
    $sql="SELECT COUNT(materi2_id) AS jml FROM materi2 
    WHERE id_guru=$guru AND kode_level='$level' AND materi2_mapel='$idmapel2'";
    $query = $this->con->query($sql) or die($this->con->error);
    $exec =$query->fetch_array();
    return $exec;
  }
function randomHex() {
   $chars = 'ABCDEF0123456789';
   $color = '#';
   for ( $i = 0; $i < 6; $i++ ) {
      $color .= $chars[rand(0, strlen($chars) - 1)];
   }
   return $color;
}
  //---------------- / Pangging Materi----------------------
  function guru_materi($level){
    $sql="SELECT nama,jabatan,level,foto_pengawas,id_guru,kelas,materi2.kode_level as kodelevel,materi2.materi2_mapel as idmapel2,nama_mapel FROM pengawas 
    INNER JOIN materi2 ON materi2.id_guru = pengawas.id_pengawas 
    INNER JOIN mata_pelajaran ON mata_pelajaran.kode_mapel = materi2.materi2_mapel 
    WHERE materi2.kode_level='$level' 
    GROUP BY materi2.materi2_mapel,id_guru ORDER BY materi2.materi2_tgl DESC";
    $query = $this->con->query($sql) or die($this->con->error);
    // foreach ($query as $value) {
    //   $datakelas = unserialize($value['kelas']);
    //   if (in_array($this->idkelas(), $datakelas) or in_array('semua', $datakelas)){
    //     $array[]=$value;
    //     echo'asd';
    //   }
    // }
    
    return  $query;
  }
	function baca_materi(){
    $id =$_GET['id']; 
    $guru = dekripsi($id);
		$idm=$_GET['idmateri']; 
    $idmateri = dekripsi($idm);
	 	$sql="SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas WHERE materi2_id='$idmateri' and materi2.id_guru=$guru ";
  	$log=$this->con->query($sql) or die($this->con->error);
   	return $log;
	}
	function ratguru(){
    $id =$_GET['id']; 
    $guru = dekripsi($id);
		$idm=$_GET['idmapel']; 
    $idmapeld = dekripsi($idm);
	 	$sql="SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas WHERE materi2_mapel='$idmapeld' and materi2.id_guru=$guru ";
  	$log=$this->con->query($sql) or die($this->con->error);
   	$exec = mysqli_fetch_array($log);
    return $exec;
	}
	function cekratguru(){
    $id =$_GET['id']; 
    $guru = dekripsi($id);
	$id = $this->idsiswa();
    $idmapeld = dekripsi($idm);
	 	$sql="SELECT * FROM rating INNER JOIN pengawas ON rating.id_guru = pengawas.id_pengawas WHERE rating.id_siswa='$id' and rating.id_guru=$guru ";
  	$log=$this->con->query($sql) or die($this->con->error);
   	$exec = mysqli_num_rows($log);
    return $exec;
	}
	function editrating($id=null)
  {
    if(!empty($id)){
      $where = ' AND id_rating='.$id;
    }
	$id =$_GET['id']; 
    $guru = dekripsi($id);
    $idsiswa = $this->idsiswa();
    $sql ="SELECT * FROM rating 
    INNER JOIN pengawas ON pengawas.id_pengawas=rating.id_guru
    WHERE id_siswa=$idsiswa AND id_guru=$guru
    $where
    ";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  function video_materi($guru2){
    if(empty($_GET['idvideo'])){ $id2=null; }else{ $id2=$_GET['idvideo']; }
    $id = dekripsi($id2);
    $guru = dekripsi($guru2);
    $sql="SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas WHERE materi2_id='$id' and materi2.id_guru=$guru ";
    $log=$this->con->query($sql) or die($this->con->error);
   $exec = mysqli_fetch_array($log);
    return $exec;
  }
	function next_materi(){
		$sql="SELECT MAX(materi2_id)as max FROM materi2";
		$log=$this->con->query($sql) or die($this->con->error);
		$exec = mysqli_fetch_array($log);
    return $exec;
   	
	}
	function prev_materi(){
		$sql="SELECT MIN(materi2_id) as min FROM materi2";
		$log=$this->con->query($sql) or die($this->con->error);
   	$exec = mysqli_fetch_array($log);
    return $exec;
	}
//asbensi ---------------------------------------------- 
  function getJamSekolah(){
    $sql="SELECT * FROM jam_skl";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  //untuk ambil tahun di opsi pilihan
  function getTahun()
  {
    $sql ="SELECT DISTINCT YEAR(absTgl) AS tahun FROM absensi";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function getAbsenDetail()
  {
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan']; 
    @$idsiswa=$_GET['siswa'];
    

    if(!empty($tahun)){
      $sql ="SELECT absId,absFoto,absUrlFoto,absIdSiswa,absTgl,absJamIn,absJamOut,absStatus,siswa.nama AS namasiswa,kelas.nama 
       FROM absensi 
       INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
       INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas 
       WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdSiswa=$idsiswa";
   
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
  // //untuk cek absen cronjob
  // function getAbsenCronJob($idsiswa,$tgl)
  // {
   
  //   $sql ="SELECT * FROM absensi WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdSiswa=$idsiswa";
  //   $log=$this->con->query($sql) or die($this->con->error);
  //   return $log;
  //   }  
  // }
//asbensi Per Mapel ----------------------------------------
  function getAbsenMapel($idkelas=null,$hari=null)
  {
    if(empty($hari)){
      $where = " WHERE amKelas=$idkelas ";
    }
    else{
      $where=" WHERE amKelas=$idkelas AND amHari='$hari' ";
    }
      $sql ="SELECT * FROM absensi_mapel 
      INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel=mata_pelajaran.idmapel
      INNER JOIN pengawas ON absensi_mapel.amIdGuru=pengawas.id_pengawas
      INNER JOIN telegram_bot ON telegram_bot.tlIdGuru=pengawas.id_pengawas
      $where ";
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;
  }
  function getAbsenMapel_by_siswa(){
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan']; 
    @$idsiswa=$_GET['siswa'];
    @$mapel=$_GET['mapel'];
    //INNER JOIN mata_pelajaran ON mata_pelajaran.idmapel=absensi_mapel_anggota.amaIdMapel
    if(!empty($tahun)){
      $sql ="SELECT * FROM absensi_mapel_anggota
       INNER JOIN siswa ON siswa.id_siswa=absensi_mapel_anggota.amaIdSiswa
       WHERE MONTH(amaTgl)=$bulan AND YEAR(amaTgl)=$tahun AND amaIdSiswa=$idsiswa AND amaIdAbsenMapel=$mapel";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
//Pengumuman --------------------------------
  function getPengumuman($kelas){
    $sql ="SELECT * FROM pengumuman INNER JOIN pengawas ON pengawas.id_pengawas=pengumuman.user
    where type='eksternal' ORDER BY date DESC ";
    $log=$this->con->query($sql) or die($this->con->error);
    foreach ($log as $pen) {      
      $datakelas = unserialize($pen['pnKelas']);
      if (in_array($kelas, $datakelas) or in_array('semua', $datakelas)){
        $array[]=$pen;
      }
    }
    return  $array;
  }
//Bot Telegram --------------------------------
  //----send to bot telegram absensi ---------------
  function KirimAbsenTelegram($pesan,$idbot,$idgrub,$nama2,$kelas2,$sekolah2,$nama_mapel){
    //silahakan modifikasi di bagian ini
    $nama = $nama2;
    $kelas = $kelas2;
    $date = date("d-m-Y");
    $jam = date("H:i:s");
    $title = $pesan;
    $sekolah = $sekolah2;
    
    //-----------------------------------------
    $message="<b><i>".$title."</i></b>%0A";
    $message.="<b>".$sekolah."</b>%0A";
    $message.="Mapel : <b>".$nama_mapel."</b>%0A";
    $message.="Nama : <b>".$nama."</b>%0A";
    $message.="Kelas : <b>".$kelas."</b>%0A";
    $message.="Tgl : ".$date."%0A";
    $message.="Jam : ".$jam."%0A";
   
    //silahakan modifikasi di bagian ini

      
    //----------------------No Edit------------------------------------------------------
    $api = 'https://api.telegram.org/bot'.$idbot.'/sendMessage?chat_id='.$idgrub.'&text='.$message.'&parse_mode=HTML';

    $ch = curl_init($api);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    //----------------------No Edit------------------------------------------------------

    return $api;

  }
  function KirimAbsenTelegram2($pesan,$idbot,$idgrub,$nama2,$kelas2,$sekolah2){
    //silahakan modifikasi di bagian ini
    $nama = $nama2;
    $kelas = $kelas2;
    $date = date("d-m-Y");
    $jam = date("H:i:s");
    $title = $pesan;
    $sekolah = $sekolah2;
    $status = 'Hadir';
   
    //-----------------------------------------
    $message="<b><i>".$title."</i></b>%0A";
    $message.="<b>".$sekolah."</b>%0A";
    $message.="Nama : <b>".$nama."</b>%0A";
    $message.="Kelas : <b>".$kelas."</b>%0A";
    $message.="Status : <b>".$status."</b>%0A";
    $message.="Tgl : ".$date."%0A";
    $message.="Jam : ".$jam."%0A";
   
    //silahakan modifikasi di bagian ini

      
    //----------------------No Edit------------------------------------------------------
    $api = 'https://api.telegram.org/bot'.$idbot.'/sendMessage?chat_id='.$idgrub.'&text='.$message.'&parse_mode=HTML';

    $ch = curl_init($api);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    //----------------------No Edit------------------------------------------------------

    return $api;
  }
}