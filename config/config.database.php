<?php
//konfigurasi server database
$host = 'localhost';
$user = 'elem1682_elearning';
$pass = 'elearning2023';
$debe = 'elem1682_cbt';


$koneksi = mysqli_connect($host, $user, $pass, "");
if ($koneksi) {
	$pilihdb = mysqli_select_db($koneksi, $debe);
	if ($pilihdb) {
		$query = mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'");
		if ($query) {
			$setting = mysqli_fetch_array($query);
			mysqli_set_charset($koneksi, 'utf8');
			$sess = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM session WHERE id='1'"));
			date_default_timezone_set($setting['waktu']);

		}
	}
}

//di setting juga ya
class Db{ //Pengaturan Database

    private $host1;
    private $user1;
    private $pass1;
    private $debe1;
    public $con;

    function __construct() {

        $this->host1     = 'localhost';
        $this->user1     = 'elem1682_elearning';
        $this->pass1     = 'elearning2023';
        $this->debe1     = 'elem1682_cbt';
        $this->con   = new mysqli($this->host1, $this->user1, $this->pass1, $this->debe1);
    }
    public function Koneksidb(){
        return $this->con;
    }
}