<?php
error_reporting(0);

session_cache_expire(0);
session_cache_limiter(0);
session_start();
set_time_limit(0);

(isset($_SESSION['id_user'])) ? $id_user = $_SESSION['id_user'] : $id_user = 0;

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

$crew ='crew';
$linkguru = 'guru';

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
