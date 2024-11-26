<?php
error_reporting(0);
session_cache_expire(0);
session_cache_limiter(0);
session_start();
set_time_limit(0);

(isset($_SESSION['id_user'])) ? $id_user = $_SESSION['id_user'] : $id_user = 0;
//cek validasi tokenya untuk upload dan import
(isset($_SESSION['token'])) ? $token = $_SESSION['token'] : $token = 1;

(isset($_SESSION['token1'])) ? $token1 = $_SESSION['token1'] : $token1 = 2;

//-------------Jika di Localhost-----------------
// $uri = $_SERVER['REQUEST_URI'];
// $pageurl = explode("/", $uri);
// if ($uri == '/') {
//   $homeurl = "http://" . $_SERVER['HTTP_HOST'];
//   (isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
//   (isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
//   (isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
// } else {
//   $homeurl = "http://" . $_SERVER['HTTP_HOST'] . "/" . $pageurl[1];
//   (isset($pageurl[2])) ? $pg = $pageurl[2] : $pg = '';
//   (isset($pageurl[3])) ? $ac = $pageurl[3] : $ac = '';
//   (isset($pageurl[4])) ? $id = $pageurl[4] : $id = 0;
// }
//-------------Jika di Localhost-----------------
//---Matikan Salah Satu 

//-------------Jika di Hosting-----------------
$uri = $_SERVER['REQUEST_URI'];
$pageurl = explode("/",$uri);

$homeurl = "https://".$_SERVER['HTTP_HOST']; //---tambah s pada http jika web sudah mendukung https
(isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
(isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
(isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
//-------------Jika di Hosting-----------------

require "config.database.php";

//cek session token dan cek validasi token
if(isset($_SESSION['token']) and isset($_SESSION['token1'])){
$data22 = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting "));
$token = $data22['db_token'];

$token1 = $data22['db_token1'];

}
else{
  $token =2;
  $token1 =100;

}
$crew ='panel';
$linkguru = 'guru'; //untuk menuju ke folder guru

$no = $jam = $mnt = $dtk = 0;
$info = '';
$waktu = date('H:i:s');
$tanggal = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');

define("KEY", "76310EEFF2B5D3C887F238976A421B638CFEB0942AB8249CD0A29B125C91B3E5");

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
    $browser = 'Netscape';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
    $browser = 'Firefox';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
    $browser = 'Chrome';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
    $browser = 'Opera';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
    $browser = 'Internet Explorer';
} else $browser = 'Other';



class Budut extends Db{
    
    private $tabel_nilai_pindah = "nilai_pindah";

  //bagian siswa index.php
  function Status_sudah_ujian($id_siswa,$id_mapel,$id_ujian){
    $sql="SELECT selesai FROM nilai WHERE id_ujian='$id_ujian' AND id_mapel='$id_mapel' AND id_siswa='$id_siswa'";
    $log=$this->con->query($sql) or die($this->con->error);
    while ($data=$log->fetch_array()) {
        $hasil = $data['selesai'];
    }
    return $hasil;

  }
// funsi CRUD untuk all
  function insert($table,$data=null) {
        $command = 'INSERT INTO '.$table;
        $field = $value = null;
        foreach($data as $f => $v) {
            $field  .= ','.$f;
            $value  .= ", '".$v."'";
        }
        $command .=' ('.substr($field,1).')';
        $command .=' VALUES('.substr($value,1).')';
        //$exec = mysqli_query($koneksi, $command);
        $exec = $this->con->query($command) or die($this->con->error);
        ($exec) ? $status = 1 : $status = 0;
        return $status;
    }

    
    function update($table,$data=null,$where=null) {
        $command = 'UPDATE '.$table.' SET ';
        $field = $value = null;
        foreach($data as $f => $v) {
            $field  .= ",".$f."='".$v."'";
        }
        $command .= substr($field,1);
        if($where!=null) {
          foreach($where as $f => $v) {
            $value .= "#".$f."='".$v."'";
          }
          $command .= ' WHERE '.substr($value,1);
          $command = str_replace('#',' AND ',$command);
        }
            //$exec = mysqli_query($koneksi, $command);
        $exec = $this->con->query($command) or die($this->con->error);
            ($exec) ? $status = 1 : $status = 0;
            return $status;
    }
    function select($table,$where=null,$order=null,$limit=null) {
        $command = 'SELECT * FROM '.$table;
        if($where!=null) {
            $value = null;
            foreach($where as $f => $v) {
                $value .= "#".$f."='".$v."'";
            }
            $command .= ' WHERE '.substr($value,1);
            $command = str_replace('#',' AND ',$command);
        }
        ($order!=null) ? $command .= ' ORDER BY '.$order :null;
        ($limit!=null) ? $command .= ' LIMIT '.$limit :null;
        $result = array();
        $sql = $this->con->query($command) or die($this->con->error);
        while($field = mysqli_fetch_assoc($sql)) {
            $result[] = $field;
        }
        return $result;
    }

    

    function fetch($table,$where=null) {
    $command = 'SELECT * FROM '.$table;
    if($where!=null) {
      $value = null;
      foreach($where as $f => $v) {
        $value .= "#".$f."='".$v."'";
      }
      $command .= ' WHERE '.substr($value,1);
      $command = str_replace('#',' AND ',$command);
    }
        $sql = $this->con->query($command) or die($this->con->error);
        $exec = mysqli_fetch_array($sql);
        return $exec;
    }

    function truncate($table) { //kosongkan tabel
        $command = 'TRUNCATE '.$table;
        $exec = $this->con->query($command) or die($this->con->error);
            ($exec) ? $status = 1 : $status = 0;
            return $status;
    }
    function delete($table,$where=null) {
    $command = 'DELETE FROM '.$table;
    if($where!=null) {
      $value = null;
      foreach($where as $f => $v) {
        $value .= "#".$f."='".$v."'";
      }
      $command .= ' WHERE '.substr($value,1);
      $command = str_replace('#',' AND ',$command);
    }
        $exec = $this->con->query($command) or die($this->con->error);
        ($exec) ? $status = 'OK' : $status = 'NO';
        return $status;
    }
    

    private function guru(){ 
      $id_guru = $_SESSION['id_pengawas'];
      return $id_guru;
    }
    private function level(){ 
      $level = $_SESSION['level'];
      return $level;
    }
    private function jrs(){ 
      $jrs= $_SESSION['jrs'];
      return $jrs;
    }

    private function kls(){ 
      $kls= $_SESSION['kls'];
      return $kls;
    }
    private function jabatan(){ 
      $jataban= $_SESSION['jabatan'];
      return $jataban;
    }

//bagian Admin
  /*
    -&json
    -&index admin
    -&formnilai.php
    -&leger.php
    -&anso
    -&reset
    -&data info
    -&status2
    -&nilai
    -&esai
    -&berita_acara
    -&nilai_copy
    -&materi2
    -&tugassiswa
  */

//&json ----------json untuk sinkron
    function json_jadwal(){
     $sql = "SELECT * FROM ujian";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
    }
    function json_mapel(){
     $sql = "SELECT * FROM mapel";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
    }
    function json_mata_pelajaran(){
     $sql = "SELECT * FROM mata_pelajaran";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
    }
    function json_soal(){
     //$sql = "SELECT * FROM soal a LEFT JOIN mapel b ON a.id_mapel=b.id_mapel WHERE b.status='1'";
     $sql = "SELECT * FROM soal LEFT JOIN mapel ON soal.id_mapel=mapel.id_mapel WHERE mapel.status='1'";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
    }

  
//&index ----------index.php
  //setatuspeserta2.php
  function tombol_selesai_paksa(){ //skor IS NULL
    $sql="SELECT * FROM nilai WHERE skor=0";
    $log=$this->con->query($sql) or die($this->con->error);
    $cek = mysqli_num_rows($log);
    if($cek > 0){

    while ($selesai=$log->fetch_array()){
      $id_siswa=$selesai['id_siswa'];
      $sql2="UPDATE nilai SET cek_tombol_selesai=1 where id_siswa='$id_siswa'";
      $log2=$this->con->query($sql2) or die($this->con->error);
      
    }
    if($log2){
      return 1;
    }
    else{
      return 0;
    }
    }
    else{
      return 200;
    }
  }
  function kunci_tombol_selesai_paksa(){
    $sql="SELECT * FROM nilai WHERE skor=0";
    $log=$this->con->query($sql) or die($this->con->error);
    $cek = mysqli_num_rows($log);
    if($cek > 0){

    while ($selesai=$log->fetch_array()){
      $id_siswa=$selesai['id_siswa'];
      $sql2="UPDATE nilai SET cek_tombol_selesai=0 where id_siswa='$id_siswa'";
      $log2=$this->con->query($sql2) or die($this->con->error);
      
    }
    if($log2){
      return 1;
    }
    else{
      return 0;
    }
    }
    else{
      return 200;
    }
    
  }


//-------------View Tabel------------------
  function v_jurusan($id=null){
    if(!empty($id)){
      $sql="SELECT * FROM pk WHERE id_pk='$id'";
    }
    elseif(!empty($this->guru())){

      if($this->level()=='admin'){
        $sql="SELECT * FROM pk";
      }
      elseif($this->jabatan()=='guru'){
        $sql="SELECT * FROM pk";
      }
      else{
        $sql="SELECT * FROM pk INNER JOIN pengawas ON pengawas.id_jrs= pk.id_pk 
        WHERE id_pengawas=".$this->guru();
      }

    }
    else{
      $sql="SELECT * FROM pk";
    }
    
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
  
  //tampil mapel di menu select
  function v_mapel($id=null){
    if(!empty($id)){
      $sql="SELECT * FROM mapel WHERE id_mapel='$id'";
    }
    elseif(!empty($this->guru())){
      if($this->level()=='admin'){
        $sql="SELECT * FROM mapel";
      }
      elseif(!empty($this->jrs())){
        $sql="SELECT * FROM mapel";
      }
      elseif($this->jabatan()=='guru'){
        $sql="SELECT * FROM mapel WHERE mapel.idguru=".$this->guru();
      }
      else{
        $sql="SELECT * FROM mapel WHERE mapel.idguru=".$this->guru();
      }
      
    }
    else{
      $sql="SELECT * FROM mapel";
    }
    
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }

  function v_setting(){
    $sql="SELECT * FROM setting";
    $log=$this->con->query($sql) or die($this->con->error);
    $setting=mysqli_fetch_array($log);
    return $setting;
    
  }
  function v_sesi(){
    $sql="SELECT * FROM sesi";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
   function v_level(){
    $sql="SELECT * FROM level";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }

  function v_ruang(){
    $sql="SELECT * FROM ruang";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }

  function v_kelas($id=null){
    if(!empty($id)){
      $sql="SELECT * FROM kelas WHERE id_kelas='$id'";
    }
    elseif(!empty($this->guru())) {
      if($this->level()=='admin'){
        $sql="SELECT * FROM kelas";
      }
      elseif(!empty($this->jrs())){
        $sql="SELECT * FROM kelas";
      }
      elseif($this->jabatan()=='guru'){
        $sql="SELECT * FROM kelas";
      }
      else{
        $sql="SELECT *,kelas.nama as nama,pengawas.nama as nama_pengawas FROM kelas INNER JOIN pengawas ON pengawas.id_kls= kelas.id_kelas
        where pengawas.id_pengawas=".$this->guru();
      }
    }
    else{
      $sql="SELECT * FROM kelas";
    }
    
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
  function v_kelas2($id=null){
    if(!empty($id)){
      $sql="SELECT * FROM kelas WHERE idkls='$id'";
    }
    else{
      $sql="SELECT * FROM kelas";
    }
    
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
  function kelas_by_level($id=null){
    $sql="SELECT * FROM kelas WHERE id_level='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    foreach ($log as $value) {
      $data2[]=$value;
    }
    $json = json_encode($data2);
    echo $json;
  }

  
  function row($data=null){
    $cek = mysqli_num_rows($data);
    return $cek; 
  }

  function v_jadwal(){
    $session = $_SESSION['id_pengawas'];
    
    $cek = "SELECT * FROM pengawas WHERE id_pengawas='$session'";
    $guru=$this->con->query($cek) or die($this->con->error);
    $cek_guru=mysqli_fetch_array($guru);

    if($cek_guru['level']=='admin'){
      $sql_ujian ="SELECT * from ujian";
    }
    elseif(!empty($this->jrs())){
      $sql_ujian ="SELECT * from ujian";
    }
    elseif($this->jabatan()=='guru'){
       $sql_ujian ="SELECT * from ujian where id_guru='$session'";
    }
    else{
      $sql_ujian ="SELECT * from ujian where id_guru='$session'";
    }
    $log=$this->con->query($sql_ujian) or die($this->con->error);
    return $log;
  }
//------------- /View Tabel------------------

//&formnilai.php -------------------------------------
  function tgl_indo($tanggal){
  $bulan = array (
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
    $pecahkan = explode('-', $tanggal);
  
  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun
 
   return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
  }
  function form_nilai($id_mapel,$id_kelas,$id_sesi,$id_ruang){
      $tabel='nilai_pindah';

    //$limit = "limit $batas,$jumlah";
    $where_ruang = "AND siswa.ruang='$id_ruang'";
    $where_sesi = "AND siswa.sesi='$id_sesi'";
    $where ="WHERE nilai_pindah.id_mapel='$id_mapel' AND kelas.id_kelas='$id_kelas'";
    if ($id_sesi=='semua' and $id_ruang=='semua') {
      $kondisi = $where.$limit;
    }
    elseif($id_sesi=='semua'){
      $kondisi=$where.$where_ruang;
    }
    elseif($id_ruang=='semua'){
      $kondisi=$where.$where_sesi;
    }
    else{
      $kondisi = $where.$where_ruang.$where_sesi;
    }

    $sql="SELECT 
    sesi.kode_sesi AS sesi,
    kelas.id_kelas AS id_kelas,
    ruang.kode_ruang AS kode_ruang, 
    siswa.nama AS nama,nilai_esai,skor,no_peserta,kkm
    FROM nilai_pindah
      INNER JOIN siswa ON siswa.id_siswa=nilai_pindah.id_siswa
      INNER JOIN kelas ON kelas.id_kelas=siswa.id_kelas
      INNER JOIN ruang ON ruang.kode_ruang=siswa.ruang
      INNER JOIN sesi ON sesi.kode_sesi=siswa.sesi
      INNER JOIN ujian ON ujian.id_ujian = nilai_pindah.id_ujian
      INNER JOIN mapel ON mapel.id_mapel= nilai_pindah.id_mapel
      $kondisi
      ";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }

   function form_nilai2($id_mapel,$id_kelas,$id_sesi=null,$id_ruang=null,$batas,$batasakhir){
       $tabel='nilai_pindah';

    $order = " ORDER BY kelas.id_kelas,siswa.nama ASC ";
    $limite = " limit $batas,$batasakhir";
    $where_ruang = " AND siswa.ruang='$id_ruang' ";
    $where_sesi = " AND siswa.sesi='$id_sesi' ";
    $where =" WHERE nilai_pindah.id_mapel='$id_mapel' AND kelas.id_kelas='$id_kelas' ";
    if ($id_sesi=='semua' and $id_ruang=='semua') {
      $kondisi = $where.$limit.$order.$limite;
    }
    elseif($id_sesi=='semua'){
      $kondisi=$where.$where_ruang.$order.$limite;
    }
    elseif($id_ruang=='semua'){
      $kondisi=$where.$where_sesi.$order.$limite;
    }
    else{
      $kondisi = $where.$where_ruang.$where_sesi.$order.$limite;
    }

    $sql="SELECT 
    sesi.kode_sesi AS sesi,
    kelas.id_kelas AS id_kelas,
    ruang.kode_ruang AS kode_ruang, 
    siswa.nama AS nama,nilai_esai,skor,no_peserta,kkm,ruang
    FROM nilai
      INNER JOIN siswa ON siswa.id_siswa=nilai_pindah.id_siswa
      INNER JOIN kelas ON kelas.id_kelas=siswa.id_kelas
      INNER JOIN ruang ON ruang.kode_ruang=siswa.ruang
      INNER JOIN sesi ON sesi.kode_sesi=siswa.sesi
      INNER JOIN ujian ON ujian.id_ujian = nilai_pindah.id_ujian
      INNER JOIN mapel ON mapel.id_mapel= nilai_pindah.id_mapel
      $kondisi
      ";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function v_ujian_nilai($id){
   
    $sql="SELECT * FROM ujian where id_mapel='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
  function v_pengawas($id){ //tampilkan pengawas berdasakan id 
    $sql="SELECT * FROM pengawas WHERE id_pengawas='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    $guru=mysqli_fetch_array($log);
    return $guru;
  }
   function v_pengawass(){ //tampilkan pengawas berdasakan id 
    $sql="SELECT * FROM pengawas WHERE level='guru'";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
//------------------------------------------------------
//&leger.php ---------------------------------
  function id_mapel($id){ //tampilkan pengawas berdasakan id 
    $sql="SELECT DISTINCT id_mapel FROM nilai_pindah WHERE id_ujian='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    $id2=mysqli_fetch_array($log);
    return $id2;
  }
  function jawaban_soal($id,$nomor){
    $sql="SELECT * FROM soal WHERE id_mapel='$id' AND nomor='$nomor'";
    $log=$this->con->query($sql) or die($this->con->error);
    $id2=mysqli_fetch_array($log);
    return $id2;
  }
  function load_mapel_title(){
    $sql="SELECT * FROM mapel a INNER JOIN nilai_pindah b ON a.id_mapel=b.id_mapel GROUP BY b.id_ujian ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function v_nilai2($id,$id_mapel){
    $sql="SELECT nilai_esai,skor FROM nilai_pindah WHERE id_siswa='$id' AND id_mapel='$id_mapel'";
    $log=$this->con->query($sql) or die($this->con->error);
     $id2=mysqli_fetch_array($log);
    return $id2;
  }
  function v_siswa($idkls=null,$idjrs=null){
    if($idkls=='semua'){
      $where = " WHERE idpk='$idjrs' "; 
    }
    elseif($idjrs=='semua'){
      $where = " WHERE id_kelas='$idkls' "; 
      
    }
    else{

    }
    $sql = "SELECT id_siswa,no_peserta,nama,id_kelas  FROM siswa  $where ORDER BY nama ASC";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function wali_kelas($id=null){
    $sql="SELECT * FROM pengawas WHERE id_kls='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function kajur($id=null){
    $sql="SELECT * FROM pengawas WHERE id_jrs='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }

//------------------------------------------------------

//&anso ----------analisa soal
  //bar anso_nilai.php
  function v_nilai($id,$kls,$jrs){
    if(!empty($kls)){
      $where = "WHERE id_mapel='$id' and id_kelas='$kls'";
    }
    else{
      $where = "WHERE id_mapel='$id' and idpk='$jrs'";
    }
    $sql="SELECT id_nilai,id_mapel,nilai_pindah.id_siswa,id_ujian,kode_ujian,nilai_esai,skor,id_kelas,idpk FROM nilai_pindah INNER JOIN siswa ON nilai_pindah.id_siswa=siswa.id_siswa $where";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function v_nm_mapel($id){
    $sql="SELECT * FROM mapel where id_mapel='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    $nm_mapel=mysqli_fetch_array($log);
    return $nm_mapel;
  }

  function v_anso1($id_mapel){ //looping soal dan jawabanya
    $sql = "SELECT soal.id_soal,soal.nomor,soal.soal,soal.jawaban,soal.file,soal.file1,soal.pilA,soal.pilB,soal.pilC,soal.pilD,soal.pilE FROM mapel INNER JOIN soal ON mapel.id_mapel = soal.id_mapel WHERE mapel.id_mapel='$id_mapel' and soal.jenis = 1 order by soal.nomor ASC";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
  }
  function v_anso2($id_mapel){ //menampilkan nama mapel, leve, kelas
    $sql = "SELECT * FROM mapel WHERE id_mapel='$id_mapel'";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
  }
  function nilairata2($id_mapel){
    $sql = "SELECT ROUND(((SUM(skor)+SUM(nilai_esai))/COUNT(id_nilai)),2) AS jml_nilai FROM nilai_pindah WHERE id_mapel='$id_mapel'";
    $log=$this->con->query($sql) or die($this->con->error);
    $nilai=mysqli_fetch_array($log);
    return $nilai['jml_nilai'];

  }
  function v_anso_soal($id_mapel){ 
  //melakukan pencocokan jawaban benar pada semua siswa yg sudah ujian
    $sql = "SELECT id_siswa,id_soal,jawaban FROM nilai_pindah WHERE id_mapel='$id_mapel'";
    $log=$this->con->query($sql) or die($this->con->error);

    // tahap ke 1 -------------------------------
    while ($soal=mysqli_fetch_array($log)) { 
      //tampung semua data nilai di array
      $data[]= array(
        'id_siswa' =>$soal['id_siswa'],
        'id_soal'=>$soal['id_soal'],
        'jawaban'=>$soal['jawaban']
      );
    }

    // tahap ke 2 -------------------------------
    //tamnpung ke array semua dari looping 
    foreach ($data as $value) {  //data dari tabel nilai
      //$array[]=explode(',',$value['id_soal']);
      $id_siswa_array[]=$value['id_siswa'];
      $jawab[]=$value['jawaban'];
      
    }
    
    return $jawab;
  }
  function nilai_rata2($id_mapel){
    $sql = "SELECT ROUND(((SUM(skor)+SUM(nilai_esai))/COUNT(id_nilai)),2) AS jlh_siswa FROM nilai_pindah WHERE id_mapel='$id_mapel'";
    $log=$this->con->query($sql) or die($this->con->error);
    $data=$log->fetch_array();
    return  $data;
  }
  function nilai_ranking($idmapel,$kls,$jrs){
    if(!empty($kls)){
      $where = "WHERE nilai_pindah.id_mapel='$idmapel' and id_kelas='$kls'";
    }
    else{
      $where = "WHERE nilai_pindah.id_mapel='$idmapel' and idpk='$jrs'";
    }
    
    $sql = "SELECT *,siswa.nama AS nama_siswa FROM nilai_pindah INNER JOIN siswa ON nilai_pindah.id_siswa=siswa.id_siswa INNER JOIN ujian ON nilai_pindah.id_ujian=ujian.id_ujian $where  ORDER BY CAST((skor+nilai_esai) AS DECIMAL) DESC";
    $log=$this->con->query($sql) or die($this->con->error);
    
    return  $log;
    
  }
   function v_nilai_edit($id,$mapel){
     $slq ="SELECT * FROM nilai_pindah INNER JOIN siswa ON siswa.id_siswa = nilai_pindah.id_siswa WHERE nilai_pindah.id_siswa='$id' AND nilai_pindah.id_mapel='$mapel'";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
   }
  

//&reset ----------------------
  function v_user_login(){
    $sql="SELECT nama,date,login.id_siswa FROM login INNER JOIN siswa ON siswa.id_siswa = login.id_siswa";
    $log=$this->con->query($sql) or die($this->con->error);
    return  $log;
  }

//&data info --------------------
    // public function V_cek(){
    //     $post = $_POST;
    //     extract($post);
    //     print_r($nm);
    //     $sql="SELECT id_kelas, COUNT(id_siswa) AS jml_siswa FROM siswa GROUP BY id_kelas";
    //     $log=$this->con->query($sql) or die($this->con->error);
    //     while ($data=$log->fetch_array()) {
    //         $a[] = $data['id_kelas'];
    //     }
    //   return($a);
    // }
    function V_siswa_kls(){
        $sql="SELECT id_kelas, COUNT(id_siswa) AS jml_siswa FROM siswa GROUP BY id_kelas";
        $log=$this->con->query($sql) or die($this->con->error);
        return  $log;

    } 
    function V_siswa_jrs(){
        
        $sql="SELECT idpk, COUNT(id_siswa) AS jml_siswa FROM siswa GROUP BY idpk";
        $log=$this->con->query($sql) or die($this->con->error);
        return  $log;

    }
     function V_siswa_sesi(){
        
        $sql="SELECT sesi,COUNT(id_siswa) AS jml FROM siswa GROUP BY sesi";
        $log=$this->con->query($sql) or die($this->con->error);
        return  $log;

    }
    function V_siswa_ruang(){
      $sql="SELECT ruang,COUNT(id_siswa) AS jml FROM siswa GROUP BY ruang";
      $log=$this->con->query($sql) or die($this->con->error);
      return  $log;
    }
    function siswa_tidak_ujian($kls,$jrs,$ujian=null){

      if($ujian==null){
        return false;
      }
      else{
        if(!empty($kls)){
          $sql="SELECT * from siswa where id_kelas='$kls'";
        }
        else{
          $sql="SELECT * from siswa where idpk='$jrs'";
        }
        
        $log=$this->con->query($sql) or die($this->con->error);     
        foreach ($log as $value) {
          $idsiswa = $value['id_siswa'];
          $sql2="SELECT * from nilai_pindah INNER JOIN ujian ON ujian.id_ujian=nilai_pindah.id_ujian where nilai_pindah.id_siswa='$idsiswa' and nilai_pindah.id_mapel='$ujian'";
          $log2=$this->con->query($sql2) or die($this->con->error);
          $total = mysqli_num_rows($log2);
          if($total > 0){ }
          else{
            $array[] = array(
              'username' =>$value['username'],
              'id_siswa' =>$value['id_siswa'],
              'nama_siswa' =>$value['nama'],
              'kelas' => $value['id_kelas'],
              'jurusan' =>$value['idpk'],
              'status' =>1
            );
          }
        }
      }
      $json = json_encode($array);
      echo $json;
      
    }

//&status2 fucntion status2.php
    function lamaujian($seconds)
    {

      if ($seconds) {
        $gmdate = gmdate("z:H:i:s", $seconds);
        $data = explode(":", $gmdate);

        $string = isset($data[0]) && $data[0] > 0 ? $data[0] . " Hari" : "";
        $string .= isset($data[1]) && $data[1] > 0 ? $data[1] . " Jam " : "";
        $string .= isset($data[2]) && $data[2] > 0 ? $data[2] . " Menit " : "";
        // $string .= isset($data[3]) && $data[3] > 0 ? $data[3] . " Detik " : "";
      } else {
        $string = '--';
      }
      return $string;
    }

    function up_tombol_selesai($id_siswa,$id_mapel){
       $sql="UPDATE nilai SET cek_tombol_selesai=1 where id_siswa='$id_siswa' and id_mapel='$id_mapel'";
       $log=$this->con->query($sql) or die($this->con->error);
      return  $log;
    }

//&nilai function  Nilai2.php
    function Tampil_nilai2(){ //tampil siswa
      $id_jrs = $_GET['jrs'];
      $id_kls = $_GET['kelas'];
      $id_mapel = $_GET['id'];
      if(empty($id_jrs)){
        $sql = "SELECT * FROM siswa a join nilai_pindah b on a.id_siswa=b.id_siswa WHERE id_kelas='$id_kls' and id_ujian='$id_mapel'";
      }
      elseif(empty($id_kls)){
        $sql = "SELECT * FROM siswa a JOIN nilai_pindah b ON a.id_siswa=b.id_siswa WHERE idpk='$id_jrs' AND id_ujian='$id_mapel'";
      }
      else{
        $sql = "SELECT * FROM siswa a join nilai_pindah b on a.id_siswa=b.id_siswa";
      }
      $log=$this->con->query($sql) or die($this->con->error);
        return  $log; 
    }
    function Tampil_nilai_per_mapel(){
      $sql ="SELECT nama,id_mapel,id_ujian FROM ujian";
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;
    }

    function Tampil_nilai3($id_siswa){ //tampil siswa beserta nilai benar salah
      $id_jrs = $_GET['jrs'];
      $id_kls = $_GET['kelas'];
      $id_mapel = $_GET['id'];
      if(empty($id_jrs)){
        $sql ="SELECT * FROM nilai_pindah JOIN siswa ON siswa.id_siswa=nilai_pindah.id_siswa JOIN kelas ON siswa.id_kelas = kelas.id_kelas WHERE siswa.id_kelas='$id_kls' and id_ujian='$id_mapel' and siswa.id_siswa='$id_siswa'";
      }
      elseif(empty($id_kls)){
        $sql ="SELECT * FROM nilai_pindah JOIN siswa ON siswa.id_siswa=nilai_pindah.id_siswa JOIN kelas ON siswa.id_kelas = kelas.id_kelas WHERE siswa.idpk='$id_jrs' and id_ujian='$id_mapel' and siswa.id_siswa='$id_siswa'";
      }
      else{

      }
       $log=$this->con->query($sql) or die($this->con->error);
        return  $log;
    }
//&esai -------------------------
    function v_nilai_esai($id){
     $sql ="SELECT * FROM soal WHERE id_soal='$id'";
     $log=$this->con->query($sql) or die($this->con->error);
     $data=$log->fetch_array();
      return  $data;
    }
//&berita_acara -------------------------
    function berita_acara(){
     $sql ="SELECT * FROM ujian";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
    }
    function berita_acara_by_sesi(){
     $sql ="SELECT * FROM ujian group by sesi";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
    }
//&nilai_copy ------------------------------
    function v_nilai_copy(){
      $id_jrs = $_GET['jrs'];
      $id_kls = $_GET['kls'];
      $id_mapel = $_GET['id_mapel'];

      if(empty($id_jrs)){
        $where = " WHERE siswa.id_kelas='$id_kls' and ujian.id_mapel='$id_mapel' ";
      }
      elseif(empty($id_kls)){
        $where = " WHERE siswa.idpk='$id_jrs' and ujian.id_mapel='$id_mapel' ";
      }
      else{
        $where="";
      }
      $sql ="
      SELECT siswa.id_siswa,siswa.nis,ujian.id_ujian,ujian.id_mapel,siswa.nama AS nama_siswa,ujian.nama 
      FROM siswa
      INNER JOIN jawaban_copy ON jawaban_copy.id_siswa = siswa.id_siswa
      INNER JOIN ujian ON ujian.id_ujian = jawaban_copy.id_ujian
      $where
      GROUP BY siswa.id_siswa,jawaban_copy.id_ujian";
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;

    } 
    //get soal jawaban_copy----------
    function select_soal($idmapel){
    $where =" WHERE id_mapel='$idmapel' and jenis=1 ";
    $sql ="SELECT id_soal,nomor,jawaban,id_mapel,jenis FROM soal $where ";
    $log=$this->con->query($sql) or die($this->con->error);
      foreach ($log as $value) {
        $data[]=$value;
      }
    return $data;
    }
    function select_soal2($idmapel){
    $where =" WHERE id_mapel='$idmapel' and jenis=2 ";
    $sql ="SELECT id_soal,nomor,jawaban,id_mapel,jenis FROM soal $where ";
    $log=$this->con->query($sql) or die($this->con->error);
      foreach ($log as $value) {
        $data[]=$value;
      }
    return $data;
    }
    function select_jawaban_copy($data){
      extract($data);
      $sql ="SELECT * FROM jawaban_copy 
      WHERE id_ujian='$id_ujian'
      AND  id_mapel='$id_mapel' 
      AND  id_siswa ='$id_siswa' 
      AND id_soal='$id_soal' 
      AND jenis='1' ";
      $log=$this->con->query($sql) or die($this->con->error);
      $data=$log->fetch_array();
      return  $data;
    }
    function select_jawaban_copy2($data){
      extract($data);
      $sql ="SELECT * FROM jawaban_copy 
      WHERE id_ujian='$id_ujian'
      AND  id_mapel='$id_mapel' 
      AND  id_siswa ='$id_siswa' 
      AND id_soal='$id_soal' 
      AND jenis='2' ";
      $log=$this->con->query($sql) or die($this->con->error);
      $data=$log->fetch_array();
      return  $data;
    }
    //get soal jawaban_copy----------

    // random token 
    function create_random_token($length)
    {
      $data = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $string = '';
      for ($i = 0; $i < $length; $i++) {
        $pos = rand(0, strlen($data) - 1);
        $string .= $data[
          $pos];
      }
      return $string;
      
      
    }
//restore database
    function restore($data){
      $log=$this->con->query($data) or die($this->con->error);
      if($log==true){
        return 1;
      }
      else{
        return 0;
      }
    }
//&materi2
  function edit_materi2($id){
    $sql ="SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel WHERE materi2_id = $id";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function cari_data_byid($table,$where=null){
      $command = 'SELECT * FROM '.$table;
      if($where!=null) {
        $value = null;
        foreach($where as $f => $v) {
          $value .= "#".$f."='".$v."'";
        }
        $command .= ' WHERE '.substr($value,1);
        $command = str_replace('#',' AND ',$command);
      }
      $sql = $this->con->query($command) or die($this->con->error);
      
      foreach ($sql as $value) {
        $array[] = array(
          'kode_mapel' =>$value['kode_mapel'],
          'nama_mapel' => $value['nama_mapel'],
        );
      }
      $myJSON = json_encode($array);
      echo $myJSON;

    }
//&tugassiswa
  function edit_tugas($id){
    $sql ="SELECT * FROM tugas WHERE id_tugas = $id";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function getHasilTugas($id)
  {
    echo $batas;
     $sql3 ="SELECT * FROM tugas WHERE id_tugas = $id";
     $log3=$this->con->query($sql3) or die($this->con->error);
     foreach ($log3 as $tgs) {
      $tugas = $tgs;
     }

     $sql ="SELECT * FROM jawaban_tugas WHERE id_tugas = $id";
     $log=$this->con->query($sql) or die($this->con->error);
      foreach ($log as $jwb) {
        $sql2 ="SELECT * FROM siswa WHERE id_siswa = $jwb[id_siswa]";
        $log2=$this->con->query($sql2) or die($this->con->error);
        foreach ($log2 as $siswa) {
          $data = array(
            'namasiswa' =>$siswa['nama'],
            'mapel' =>$tugas['mapel'],
            'judultugas' =>$tugas['judul'],
            'kelas' =>$tugas['kelas'],
            'nilai' =>$jwb['nilai'],
          );
          $data2[]=$data;
        }
      }
      return $data2;
     
  }
  function getHasilTugas2($id,$batas,$batasakhir)
  {
     $sql3 ="SELECT * FROM tugas WHERE id_tugas = $id";
     $log3=$this->con->query($sql3) or die($this->con->error);
     foreach ($log3 as $tgs) {
      $tugas = $tgs;
     }

     $sql ="SELECT * FROM jawaban_tugas WHERE id_tugas = $id limit $batas,$batasakhir";
     $log=$this->con->query($sql) or die($this->con->error);
      foreach ($log as $jwb) {
        $sql2 ="SELECT * FROM siswa WHERE id_siswa = $jwb[id_siswa]";
        $log2=$this->con->query($sql2) or die($this->con->error);
        foreach ($log2 as $siswa) {
          $data = array(
            'namasiswa' =>$siswa['nama'],
            'mapel' =>$tugas['mapel'],
            'judultugas' =>$tugas['judul'],
            'kelas' =>$tugas['kelas'],
            'nilai' =>$jwb['nilai'],
          );
          $data2[]=$data;
        }
      }
      return $data2;
     
  }
  function getTugas($id=null)
  {
    if($id==null){
      $sql ="SELECT * FROM tugas";
    }
    else{
      $sql ="SELECT * FROM tugas WHERE id_tugas = $id";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
//&mata_pelajara ------------------------------
  function getMata_pelajaran_by_level($id)
  {
    $sql="SELECT * FROM mata_pelajaran WHERE kode_level='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    foreach ($log as $value) {
      $data2[]=$value;
    }
    $json = json_encode($data2);
    echo $json;
  }
  function getMata_pelajaran($id=null){
    if(!empty($id)){
      $sql="SELECT * FROM mata_pelajaran WHERE idmapel='$id'";
    }
    else{
      $sql="SELECT * FROM mata_pelajaran";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
//&absensi-----------------------------------------------------
  function getTahun()
  {
    $sql ="SELECT *  FROM tahun WHERE thAktif=1";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function getTahun2()
  {
    $sql ="SELECT *  FROM tahun";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function getBulan()
  {
    $sql ="SELECT DISTINCT MONTH(absTgl) AS bulan FROM absensi";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function getJamSkl()
  {
     $sql ="SELECT * FROM jam_skl";
     $log=$this->con->query($sql) or die($this->con->error);
     $data=$log->fetch_array();
     return $data;
  }
  function getAbsen()
  {
    $tahun=$_GET['tahun'];
    $bulan=$_GET['bulan'];
    $kelas=$_GET['kelas'];
    $idsiswa='';
    if(!empty($idsiswa)){
      //echo"asdasd";
    }
    else{

       $sql ="SELECT DISTINCT absIdsiswa,siswa.nama as namasiswa,kelas.nama,
        SUM(CASE WHEN absStatus='H' THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN absStatus='A' THEN 1 ELSE 0 END) AS alpa,
        SUM(CASE WHEN absStatus='B' THEN 1 ELSE 0 END) AS bolos,
        SUM(CASE WHEN absStatus='I' THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN absStatus='S' THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN absStatus='T' THEN 1 ELSE 0 END) AS terlambat
        FROM absensi
        INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
        INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas
        WHERE MONTH(absTgl)='$bulan' AND YEAR(absTgl)='$tahun' AND absIdKelas='$kelas'
        GROUP BY absIdSiswa
        ORDER BY siswa.nama ASC";
       $log=$this->con->query($sql) or die($this->con->error);
       return $log;
    }
  }
  function getAbsen2($batas,$batasakhir)
  {
    $tahun=$_GET['tahun'];
    $bulan=$_GET['bulan'];
    $kelas=$_GET['kelas'];
    $idsiswa='';
    if(!empty($idsiswa)){
      //echo"asdasd";
    }
    else{

       $sql ="SELECT DISTINCT absIdsiswa,siswa.nama as namasiswa,kelas.nama,
        SUM(CASE WHEN absStatus='H' THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN absStatus='A' THEN 1 ELSE 0 END) AS alpa,
        SUM(CASE WHEN absStatus='B' THEN 1 ELSE 0 END) AS bolos,
        SUM(CASE WHEN absStatus='I' THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN absStatus='S' THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN absStatus='T' THEN 1 ELSE 0 END) AS terlambat
        FROM absensi
        INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
        INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas
        WHERE MONTH(absTgl)='$bulan' AND YEAR(absTgl)='$tahun' AND absIdKelas='$kelas'
        GROUP BY absIdSiswa
        ORDER BY siswa.nama ASC
        limit $batas,$batasakhir
        ";
       $log=$this->con->query($sql) or die($this->con->error);
       return $log;
    }
  }
  function getAbsenDetail()
  {
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan'];
    @$tgl=$_GET['tgl'];
    @$kelas=$_GET['kelas'];
    @$idsiswa=$_GET['siswa'];
    if($idsiswa !='null' && $tgl !='null' ){
      $where = ' AND absIdSiswa='.$idsiswa.' AND DAY(absTgl)='.$tgl;
    }
    elseif($idsiswa !='null' && $tgl=='null'){
      $where = ' AND absIdSiswa='.$idsiswa;
    }
    
    elseif($idsiswa =='null' && $tgl!='null'){
      $where = ' AND DAY(absTgl)='.$tgl;
      
    }
   
    else{
      //$where=''; 
    }


    if(!empty($tahun)){
      $sql ="SELECT absId,absFoto,absUrlFoto,absIdSiswa,absTgl,absJamIn,absJamOut,absStatus,siswa.nama AS namasiswa,kelas.nama 
       FROM absensi 
       INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
       INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas 
       WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdKelas=$kelas $where";
   
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
  
  function getJurnalDetail()
  {
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan'];
    @$tgl=$_GET['tgl'];
    @$kelas=$_GET['guru'];
    @$idsiswa=$_GET['siswa'];
    if($kelas !='null' && $tgl !='null' ){
      $where = ' AND id_guru='.$kelas.' AND DAY(tgl)='.$tgl;
    }
    elseif($kelas !='null' && $tgl =='null'){
      $where = ' AND id_guru='.$kelas;
    }
    
    elseif($kelas =='null' && $tgl !='null'){
      $where = ' AND DAY(tgl)='.$tgl;
      
    }
	 elseif($kelas =='null' && $tgl=='null'){
      
      
    }
   
    else{
      //$where=''; 
    }


    if(!empty($tahun)){
      $sql ="SELECT * FROM jurnalguru 
       INNER JOIN kelas ON kelas.idkls=jurnalguru.id_kelas
	    INNER JOIN pengawas ON pengawas.id_pengawas=jurnalguru.id_guru
       WHERE MONTH(tgl)=$bulan AND YEAR(tgl)=$tahun $where";
   
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
  
  function getJurnalDetail2($batas,$batasakhir)
  {
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan'];
    @$tgl=$_GET['tgl'];
    @$kelas=$_GET['guru'];
    @$idsiswa=$_GET['siswa'];
    if($kelas !='null' && $tgl !='null' ){
      $where = ' AND id_guru='.$kelas.' AND DAY(tgl)='.$tgl;
    }
    elseif($kelas !='null' && $tgl =='null'){
      $where = ' AND id_guru='.$kelas;
    }
    
    elseif($kelas =='null' && $tgl !='null'){
      $where = ' AND DAY(tgl)='.$tgl;
      
    }
	 elseif($kelas =='null' && $tgl=='null'){
      
      
    }
   
    else{
      //$where=''; 
    }


    if(!empty($tahun)){
      $sql ="SELECT * FROM jurnalguru 
       INNER JOIN kelas ON kelas.idkls=jurnalguru.id_kelas
	    INNER JOIN pengawas ON pengawas.id_pengawas=jurnalguru.id_guru
       WHERE MONTH(tgl)=$bulan AND YEAR(tgl)=$tahun $where
	   limit $batas,$batasakhir
	   ";
   
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
  
  function getAbsenDetail2($batas,$batasakhir)
  {
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan'];
    @$tgl=$_GET['tgl'];
    @$kelas=$_GET['kelas'];
    @$idsiswa=$_GET['siswa'];
    if($idsiswa !='null' && $tgl !='null' ){
      $where = ' AND absIdSiswa='.$idsiswa.' AND DAY(absTgl)='.$tgl;
    }
    elseif($idsiswa !='null' && $tgl=='null'){
      $where = ' AND absIdSiswa='.$idsiswa;
    }
    
    elseif($idsiswa =='null' && $tgl!='null'){
      $where = ' AND DAY(absTgl)='.$tgl;
      
    }
   
    else{
      //$where=''; 
    }
    
    if(!empty($tahun)){
      $sql ="SELECT absId,absFoto,absUrlFoto,absIdSiswa,absTgl,absJamIn,absJamOut,absStatus,siswa.nama AS namasiswa,kelas.nama 
       FROM absensi 
       INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
       INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas 
       WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdKelas=$kelas $where
       ORDER BY siswa.nama ASC
       limit $batas,$batasakhir
       ";
   
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
  
  function getKelasId($id){
     $sql ="SELECT * FROM kelas WHERE idkls='$id'";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
   function getJurnalId($id){
     $sql ="SELECT * FROM jurnalguru 
	 INNER JOIN kelas ON kelas.idkls=jurnalguru.id_kelas
	INNER JOIN pengawas ON pengawas.id_pengawas=jurnalguru.id_guru
	WHERE id_guru='$id'";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
//&jurnal_guru------------------------
function getJurnalGuru($id=null)
  {
    if(!empty($id)){
      $where = ' AND id_jurnal='.$id;
    }
    $idguru = $this->guru();
    $sql ="SELECT * FROM jurnalguru 
    INNER JOIN kelas ON kelas.idkls=jurnalguru.id_kelas
    WHERE id_guru=$idguru
    $where
    ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  
function getDataJurnal($id=null)
  {

    $sql ="SELECT * FROM jurnalguru 
    INNER JOIN kelas ON kelas.idkls=jurnalguru.id_kelas
	INNER JOIN pengawas ON pengawas.id_pengawas=jurnalguru.id_guru
    ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
//&absensi_mapel------------------------
  function getMapelAbsen($id=null)
  {
    if(!empty($id)){
      $where = ' AND amIdMapel='.$id;
    }
    $idguru = $this->guru();
    $sql ="SELECT * FROM absensi_mapel 
    INNER JOIN kelas ON kelas.idkls=absensi_mapel.amKelas
    WHERE amIdGuru=$idguru
    $where
    ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function get_absen_mapel_by_id($idguru=null){
    $idguru = $this->guru();
    $sql ="SELECT * FROM absensi_mapel
    INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel = mata_pelajaran.idmapel
    INNER JOIN kelas ON absensi_mapel.amKelas = kelas.idkls
    WHERE amIdGuru= $idguru
    ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function get_absen_siswa_mapel(){
    $tahun = $_GET['tahun'];
    $bulan = $_GET['bulan'];
    $mapel = $_GET['mapel'];
    $tgl = @$_GET['tgl'];
    if(!empty($tgl)){
      if($tgl=='all'){ $where =''; }else{ $where = ' AND DAY(amaTgl)='.$tgl; }
       
    }
    if(!empty($tahun)){
      $sql ="SELECT * FROM absensi_mapel_anggota 
      INNER JOIN siswa ON siswa.id_siswa=absensi_mapel_anggota.amaIdSiswa
      INNER JOIN absensi_mapel ON absensi_mapel.amId=absensi_mapel_anggota.amaIdAbsenMapel
      WHERE amaIdMapel=$mapel
      AND YEAR(amaTgl)=$tahun
      AND MONTH(amaTgl)=$bulan
      $where
      ";
        $log=$this->con->query($sql) or die($this->con->error);
        return $log;
    }
    
    
  }

  
   
  function get_absen_siswa_mapel3(){
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan'];
    @$mapel=$_GET['mapel'];

    
     $sql ="SELECT amaIdSiswa,nama,id_kelas,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=1,amaStatus,NULL))) AS tgl1,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=2,amaStatus,NULL))) AS tgl2,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=3,amaStatus,NULL))) AS tgl3,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=4,amaStatus,NULL))) AS tgl4,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=5,amaStatus,NULL))) AS tgl5,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=6,amaStatus,NULL))) AS tgl6,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=7,amaStatus,NULL))) AS tgl7,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=8,amaStatus,NULL))) AS tgl8,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=9,amaStatus,NULL))) AS tgl9,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=10,amaStatus,NULL))) AS tgl10,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=11,amaStatus,NULL))) AS tgl11,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=12,amaStatus,NULL))) AS tgl12,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=13,amaStatus,NULL))) AS tgl13,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=14,amaStatus,NULL))) AS tgl14,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=15,amaStatus,NULL))) AS tgl15,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=16,amaStatus,NULL))) AS tgl16,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=17,amaStatus,NULL))) AS tgl17,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=18,amaStatus,NULL))) AS tgl18,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=19,amaStatus,NULL))) AS tgl19,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=20,amaStatus,NULL))) AS tgl20,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=21,amaStatus,NULL))) AS tgl21,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=22,amaStatus,NULL))) AS tgl22,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=23,amaStatus,NULL))) AS tgl23,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=24,amaStatus,NULL))) AS tgl24,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=25,amaStatus,NULL))) AS tgl25,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=26,amaStatus,NULL))) AS tgl26,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=27,amaStatus,NULL))) AS tgl27,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=28,amaStatus,NULL))) AS tgl28,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=29,amaStatus,NULL))) AS tgl29,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=30,amaStatus,NULL))) AS tgl30,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=31,amaStatus,NULL))) AS tgl31,
      SUM(CASE WHEN amaStatus='H' THEN 1 ELSE 0 END) AS hadir,
      SUM(CASE WHEN amaStatus='A' THEN 1 ELSE 0 END) AS alpha,
      SUM(CASE WHEN amaStatus='B' THEN 1 ELSE 0 END) AS bolos,
      SUM(CASE WHEN amaStatus='I' THEN 1 ELSE 0 END) AS izin,
      SUM(CASE WHEN amaStatus='T' THEN 1 ELSE 0 END) AS telat,
      SUM(CASE WHEN amaStatus='S' THEN 1 ELSE 0 END) AS sakit
      FROM absensi_mapel_anggota
      INNER JOIN siswa ON siswa.id_siswa=absensi_mapel_anggota.amaIdSiswa
      WHERE YEAR(amaTgl)=$tahun AND MONTH(amaTgl)=$bulan AND amaIdMapel=$mapel
      GROUP BY amaIdSiswa";
      // AND amaIdKelas=$kelas 
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
//Pengumuman --------------------------------
  function getPengumumanGuru(){
    $idguru =$this->guru();
    $sql ="SELECT * FROM pengumuman INNER JOIN pengawas ON pengawas.id_pengawas=pengumuman.user
    WHERE pengumuman.user=$idguru ORDER BY date DESC ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getPengumumanAdmin(){
    $sql ="SELECT * FROM pengumuman INNER JOIN pengawas ON pengawas.id_pengawas=pengumuman.user WHERE type='internal' ORDER BY date DESC ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getRatingGuru(){
  $idguru =$this->guru();
    $sql ="SELECT SUM(nilai) AS jumlah FROM rating WHERE id_guru='$idguru' ";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  function getHitungRat(){
  $idguru =$this->guru();
    $sql ="SELECT * FROM rating WHERE id_guru='$idguru' ";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_num_rows($log);
    return $exec;
  }
  function getThnRat(){
    $sql ="SELECT YEAR(dibuat) AS tahun FROM rating";
    $log=$this->con->query($sql) or die($this->con->error);
   // $exec = mysqli_fetch_array($log);
    return $log;
  }
  
  function getRatDet()
  {
    @$kelas=$_GET['kelas'];
	@$guru=$_GET['guru'];
	@$tahun=$_GET['tahun'];
    @$idsiswa=$_GET['siswa'];
    if($tahun !='' && $kelas !='null' && $guru !='null' ){
      $where = ' WHERE YEAR(dibuat)='.$tahun.' AND rating.id_kelas='.$kelas.' AND rating.id_guru='.$guru;
    }
    elseif($tahun !='' && $kelas !='null' && $guru =='null'){
      $where = ' WHERE YEAR(dibuat)='.$tahun.' AND id_kelas='.$kelas;
    }
    
    elseif($tahun !='' && $kelas =='null' && $guru !='null'){
      $where = ' WHERE YEAR(dibuat)='.$tahun.' AND id_guru='.$guru;
      
    }
	 elseif($tahun=='' && $kelas =='null' && $guru !='null'){
       $where = 'WHERE rating.id_guru='.$guru;
      
    }elseif($kelas =='null' && $guru =='null'){

      
    }
   
    else{
      
    }


  if($tahun !=null){
      $sql ="SELECT * FROM rating
	    INNER JOIN pengawas ON pengawas.id_pengawas=rating.id_guru
       $where ";
   }else{
   $sql ="SELECT * FROM rating
	    INNER JOIN pengawas ON pengawas.id_pengawas=rating.id_guru
       $where ";
   }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  
  }
//Bot Telegram --------------------------------
  function getGuru(){
    $idguru =$this->guru();
    if($this->level()=='admin'){
      $sql ="SELECT * FROM  pengawas ";
    }
    else{
      $sql ="SELECT * FROM  pengawas WHERE id_pengawas=$idguru";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getTelegramBotGuru(){
    $idguru =$this->guru();
    if($this->level()=='admin'){
      $sql ="SELECT * FROM  telegram_bot INNER JOIN pengawas ON id_pengawas=tlIdGuru ";
    }
    else{
      $sql ="SELECT * FROM  telegram_bot INNER JOIN pengawas ON id_pengawas=tlIdGuru  WHERE tlIdGuru=$idguru";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getTokenBot(){
    $sql ="SELECT * FROM  bot_telegram ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  

}

require "m_siswa.php";

