<?php

// include "../config/config.default.php";
include("core/c_admin.php"); 
include "../config/config.function.php";
if($token == $token1) {
if (empty($_GET['kls']) and !empty($_GET['jrs'])) {
	$jrs = $_GET['jrs'];
	$get =" AND siswa.idpk='$jrs' ";
}
elseif(empty($_GET['jrs']) and !empty($_GET['kls'])){
	$kls = $_GET['kls'];
	$get =" AND siswa.id_kelas='$kls' ";
}
else{
	$get = '';

}

$pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$_SESSION[id_pengawas]'"));
$tglsekarang = date('Y-m-d');
if ($pengawas['level'] == 'admin') {
	$nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai LEFT JOIN ujian ON nilai.id_ujian=ujian.id_ujian LEFT JOIN siswa ON siswa.id_siswa=nilai.id_siswa WHERE ujian.status='1' AND nilai.id_siswa<>'' $get GROUP BY nilai.id_nilai DESC");
} else {
	$nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  where c.status='1' and s.id_siswa<>'' and c.id_guru='$_SESSION[id_pengawas]' GROUP by s.id_nilai DESC");
}

function waktu($waktu){
    if(($waktu>0) and ($waktu<60)){
        $lama=number_format($waktu,2)." detik";
        return $lama;
    }
    if(($waktu>60) and ($waktu<3600)){
        $detik=fmod($waktu,60);
        $menit=$waktu-$detik;
        $menit=$menit/60;
        $lama=$menit." Menit ".number_format($detik,2)." detik";
        return $lama;
    }
    elseif($waktu >3600){
        $detik=fmod($waktu,60);
        $tempmenit=($waktu-$detik)/60;
        $menit=fmod($tempmenit,60);
        $jam=($tempmenit-$menit)/60;    
        $lama=$jam." Jam ".$menit." Menit ".number_format($detik,2)." detik";
        return $lama;
    }
}
$data =array();
while ($nilai = mysqli_fetch_array($nilaiq)) {
	$tglx = strtotime($nilai['ujian_mulai']);
	$tgl = date('Y-m-d', $tglx);
	if ($tgl == $tglsekarang) {
		$no++;
		$ket = '';
		$lama = $jawaban = $skor = '--';
		$siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$nilai[id_siswa]'"));
		$kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$siswa[id_kelas]'"));
		$mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$nilai[id_mapel]'"));

		$nilaiQ = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$siswa[id_siswa]'");
		$nilaiC = mysqli_num_rows($nilaiQ);

		if ($nilaiC <> 0) {
			$lama = '';
			if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
				$selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);
				$jam = round((($selisih % 604800) % 86400) / 3600);
				$mnt = round((($selisih % 604800) % 3600) / 60);
				$dtk = round((($selisih % 604800) % 60));
				($jam <> 0) ? $lama .= "$jam jam " : null;
				($mnt <> 0) ? $lama .= "$mnt menit " : null;
				($dtk <> 0) ? $lama .= "$dtk detik " : null;
				$jawaban = "<small class='label bg-green'>$nilai[jml_benar] <i class='fa fa-check'></i></small>  <small class='label bg-red'>$nilai[jml_salah] <i class='fa fa-times'></i></small>";
				$skor = "<small class='label bg-green'>" . number_format($nilai['skor'], 2, '.', '') . "</small>";
				$ket = "<label class='label label-success'>Tes Selesai</label>";
				$btn = "<button onclick='ulang_ujian(" . $nilai['id_nilai'] . ")' class='ulang btn btn-xs btn-danger'>ulang</button>";
			} elseif ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] == '') {
				$selisih = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);
				$jam = round((($selisih % 604800) % 86400) / 3600);
				$mnt = round((($selisih % 604800) % 3600) / 60);
				$dtk = round((($selisih % 604800) % 60));
				($jam <> 0) ? $lama .= "$jam jam " : null;
				if($nilai['blok']==0){
				$btn2 = "<button data-aksi='1' data-nilai='$nilai[id_nilai]' data-id='$nilai[id_siswa]' class='block btn btn-xs btn-warning'>BLOK</button>";
				}
				else{
					$btn2 = "<button data-aksi='0' data-nilai='$nilai[id_nilai]' data-id='$nilai[id_siswa]' class='block btn btn-xs btn-primary'>BUKA</button>";
				}
				($mnt <> 0) ? $lama .= "$mnt menit " : null;
				($dtk <> 0) ? $lama .= "$dtk detik " : null;
				$ket = "<label class='label label-danger'><i class='fa fa-spin fa-spinner' title='Sedang ujian'></i>&nbsp;Masih Dikerjakan</label>";

				$btn = "<button onclick='selesaikan_ujian(" . $nilai['id_nilai'] . ")' class='btn btn-xs btn-danger'>selesai</button>";
					
			
			}
		}

		$waktu_sedang_ujian =lamaujian($selisih);
		
		
		//hitung lama tombol selesai munucl
		//$aturan = floor($nilai['lama_ujian'] / $nilai['tombol_selsai']);

		
		$ujian_berlangsung = strtotime($nilai['ujian_berlangsung']);
		$tombol_selsai = strtotime($nilai['tombol_selsai']);
		$waktu_sekarang = strtotime(date("Y-m-d h:i:sa"));

		
			if($nilai['cek_tombol_selesai'] ==1){
				$muncul = "<small class='label bg-blue'>Aktif</small>";
			}
			else{
					
					if(empty($tombol_selsai) or $tombol_selsai==null or $nilai['tombol_selsai']=="0000-00-00 00:00:00"){
						$muncul = '<span style="font-size:14px; color:red; padding-left:25px;" > No </span><span style="font-size:14px; color:red;" class="glyphicon glyphicon-remove"></span>';
					}
					else if($waktu_sekarang >= $tombol_selsai){
						$db->up_tombol_selesai($siswa['id_siswa'],$mapel['id_mapel']);
					}
					else{
						$muncul = '<span style="font-size:14px; color:red; padding-left:25px;" class="glyphicon glyphicon-remove"></span>';
					}
							
			}
			if($nilai['ujian_selesai'] !=""){  }else{ $btn2; }
		?>
<?php
	$nestedData = array();
	$nestedData[]=$no;
	$nestedData[]=$btn." | ".$btn2;
	$nestedData[]=$ket;
	$nestedData[]=$siswa['nama'];
	$nestedData[]=$kelas['nama'];
	$nestedData[]="<small class='label bg-red'>$nilai[kode_ujian]</small> <small class='label bg-purple'>$mapel[nama]</small> <small class='label bg-blue'>$mapel[level]</small>";
	$nestedData[]=$waktu_sedang_ujian;
	$nestedData[]=$jawaban;
	$nestedData[]=$skor;
	$nestedData[]=$nilai['ipaddress'];
	$nestedData[]=$muncul;
	$nestedData[]=$siswa['nis'];

	$data[]=$nestedData;
	}
}
$json_data = array(
		"data" => $data
	);
echo json_encode($json_data);

}else{
	jump("$homeurl");
	//exit;
}
?>

