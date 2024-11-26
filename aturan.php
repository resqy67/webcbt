<?php

//defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');

$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));
$idmapel = $query['id_mapel'];

$acak_soale = $query['acak'];
$acak_opsi = $query['acak_opsi'];

$order = array(
    "nomor ASC",
    "nomor DESC",
    "soal ASC",
    "soal DESC",
    "pilA ASC",
    "pilA DESC",
    "pilB ASC",
    "pilB DESC",
    "pilC ASC",
    "pilC DESC",
    "pilD ASC",
    "pilD DESC",
    "pilE ASC",
    "pilE DESC",
    "jawaban ASC",
    "jawaban DESC",
    "file ASC",
    "file DESC"
);
$ordera = array(
    "nomor ASC",
    "nomor DESC",
    "soal ASC",
    "soal DESC",
    "file ASC",
    "file DESC"
);
$where = array(
    'id_mapel' => $idmapel, //mapel PG
    'jenis' => '1',
);
$where2 = array(
    'id_mapel' => $idmapel, //Mapel essai
    'jenis' => '2', 
);

$mapel = fetch($koneksi, 'ujian', array('id_mapel' => $idmapel, 'id_ujian' => $ac));
$r = ($mapel['acak'] == 1) ? mt_rand(0, 17) : 0;
$m = ($mapel['acak'] == 1) ? mt_rand(0, 17) : 0;

if($mapel['status_reset']==1){ $reset=1; }  //jika status reset di ujian aktif
else{ $reset=0; }

$soal = select($koneksi, 'soal', $where, $order[$r]);

$id_soal = '';
$id_esai = '';
$id_opsi = "";
foreach ($soal as $s) :
    if ($mapel['opsi'] == 5) :
        $acz = array("A", "B", "C", "D", "E");
    elseif ($mapel['opsi'] == 4) :
        $acz = array("A", "B", "C", "D");
    elseif ($mapel['opsi'] == 3) :
        $acz = array("A", "B", "C");
    endif;
    shuffle($acz);
    $ack1 = $acz[0];
    $ack2 = $acz[1];
    $ack3 = $acz[2];
    if ($mapel['opsi'] == 3) :
        $id_soal .= $s['id_soal'] . ',';

        //kondisi di acak atau tida asja
        if ($acak_opsi == 1): //CEK APAKAH PG di status 1 (acak)
            $id_opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',';
        endif;
        if ($acak_opsi == 0):
            $id_opsi .= 'A,B,C,';
        endif;
     

    elseif ($mapel['opsi'] == 4) :
        $ack4 = $acz[3];
        $id_soal .= $s['id_soal'] . ',';
        if ($acak_opsi == 1):
            $id_opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',';
        endif;
        if ($acak_opsi == 0):
            $id_opsi .= 'A,B,C,D,';
        endif;

    elseif ($mapel['opsi'] == 5) :
        $ack4 = $acz[3];
        $ack5 = $acz[4];
        $id_soal .= $s['id_soal'] . ',';
        if ($acak_opsi == 1):
            $id_opsi .= $ack1 . ',' . $ack2 . ',' . $ack3 . ',' . $ack4 . ',' . $ack5 . ',';
        endif;
        if ($acak_opsi == 0):
            $id_opsi .= 'A,B,C,D,E,';
        endif;

    endif;
endforeach;
if ($mapel['jml_esai'] <> 0) {
    $soalesai = select($koneksi, 'soal', $where2, $ordera[$m]);
    foreach ($soalesai as $m) :
        $id_esai .= $m['id_soal'] . ',';
    endforeach;
}



$dataku=array(
    'id_ujian' => $ac,
    'id_siswa' => $id_siswa,
    'id_mapel' => $idmapel,
    'id_soal' => $id_soal,
    'id_opsi' => $id_opsi,
    'id_esai' => $id_esai
);

// //untuk acak soal
// $acakdata = array(
//     'id_ujian' => $ac,
//     'id_siswa' => $id_siswa,
//     'id_mapel' => $idmapel,
//     'id_soal' => $id_soal,
//     'id_esai' => $id_esai
// );

// //untuk acak pg
// $acakdataopsi = array(
//     'id_ujian' => $ac,
//     'id_siswa' => $id_siswa,
//     'id_mapel' => $idmapel,
//     'id_soal' => $id_opsi,
//     'id_esai' => $id_esai
// );

$logdata = array(
    'id_siswa' => $id_siswa,
    'type' => 'testongoing',
    'text' => 'sedang ujian',
    'date' => $datetime
);
$nilaidata = array(
    'id_mapel' => $idmapel,
    'id_ujian' => $ac,
    'id_siswa' => $id_siswa,
    'kode_ujian' => $mapel['kode_ujian'],
    'ujian_mulai' => $datetime,
    'ipaddress' => $_SERVER['REMOTE_ADDR'],
    'hasil' => $query['hasil'],
    'online' => $reset,
    'id_soal' => $id_soal,
    'id_opsi' => $id_opsi,
    'id_esai' => $id_esai
);
$ref = "";


/*
------ asja
Tempat Aksekui Ketia Siswa memulai Ujian
Yang akan di Masukan Ke Dalam Database
Tabel Log
Tabel login
Tabel Nilai agar setatus siswa Lanjutkan Ujian
Tabel Pengacak Soal dan PG

*/ 


// $ceklog = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM log WHERE date='$datetime' "));
// if (!$ceklog <> 0) {
//insert($koneksi, 'log', $logdata);
// }
// $query = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_mapel='$idmapel' AND id_siswa='$id_siswa' AND id_ujian='$ac'");
// $ceknilai = mysqli_num_rows($query);
// if (!$ceknilai <> 0) {
$insertnilai = insert($koneksi, 'nilai', $nilaidata);
if ($insertnilai) {
    insert($koneksi, 'log', $logdata);
    insert($koneksi, 'pengacak', $dataku);
}

//insert($koneksi, 'pengacakopsi', $acakdataopsi);
//insert($koneksi, 'pengacak2', $acakdata);
// }
// $soal2 = select($koneksi, 'soal', $where, $order[$r]);
// foreach ($soal2 as $soalnya) :
//     $array[] = array(
//         'id_soal' =>$soalnya['id_soal'],
//         'id_mapel' =>$soalnya['id_mapel'],
//         'nomor' =>$soalnya['nomor'],
//         'soal' =>$soalnya['soal'],
//         'a' =>$soalnya['pilA'],
//         'b' =>$soalnya['pilB'],
//         'c' =>$soalnya['pilC'],
//         'd' =>$soalnya['pilD'],
//         'e' =>$soalnya['pilE'],
//     );
// endforeach;
// $acak2 = json_encode($array);


?>

<script>
    // var acak = <?= $acak2; ?>;
    // localStorage.setItem("soallokal", JSON.stringify(acak));

</script>