<?php
require "../config/config.default.php";
require "../vendor/autoload.php";
require "../config/config.function.php";

if($token == $token1) {

    // $file_mimes = array('application/vnd.ms-excel', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');


    if (isset($_FILES['file']['name'])) {

        $arr_file = explode('.', $_FILES['file']['name']);
        $extension = end($arr_file);

        if ('xls' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }
        elseif ('xlsx' == $extension) {
          $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
         } 
        else {
          echo "Pilih file yang bertipe xlsx or xls";
        }

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);

        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $sukses = $gagal = 0;
        $exec = mysqli_query($koneksi, "DELETE FROM sesi");
        $exec = mysqli_query($koneksi, "ALTER TABLE sesi AUTO_INCREMENT =1");
        $exec = mysqli_query($koneksi, "DELETE FROM kelas");
        $exec = mysqli_query($koneksi, "ALTER TABLE kelas AUTO_INCREMENT =1");
        $exec = mysqli_query($koneksi, "DELETE FROM level");
        $exec = mysqli_query($koneksi, "ALTER TABLE level AUTO_INCREMENT =1");
        $exec = mysqli_query($koneksi, "DELETE FROM ruang");
        $exec = mysqli_query($koneksi, "ALTER TABLE ruang AUTO_INCREMENT =1");
        $exec = mysqli_query($koneksi, "DELETE FROM pk");
        $exec = mysqli_query($koneksi, "ALTER TABLE pk AUTO_INCREMENT =1");
        $exec = mysqli_query($koneksi, "DELETE FROM siswa");
        $exec = mysqli_query($koneksi, "ALTER TABLE siswa AUTO_INCREMENT =1");
        for ($i = 1; $i < count($sheetData); $i++) {
            $id_siswa = $sheetData[$i]['0'];
            $nis = $sheetData[$i]['1'];
            $no_peserta = $sheetData[$i]['2'];
            $nama = $sheetData[$i]['3'];
            //$nama = addslashes($nama);
            $level = $sheetData[$i]['4'];
            $kelas = $sheetData[$i]['5'];
            $pk = $sheetData[$i]['6'];
            if ($pk == "") {
                $pk = "semua";
            }
            $sesi = $sheetData[$i]['7'];
            $ruang = $sheetData[$i]['8'];
            $username = $sheetData[$i]['9'];
            $password = $sheetData[$i]['10'];
            $foto = $sheetData[$i]['11'];
            $server = $sheetData[$i]['12'];
            $agama = $sheetData[$i]['13'];
            $firt_nama = $sheetData[$i]['14'];
            $qkelas = mysqli_query($koneksi, "SELECT id_kelas FROM kelas WHERE id_kelas='$kelas'");
            $cekkelas = mysqli_num_rows($qkelas);
            if (!$cekkelas <> 0) {
                $exec = mysqli_query($koneksi, "INSERT INTO kelas (id_kelas,nama,id_level,id_pk)VALUES('$kelas','$kelas','$level','$pk')");
            }
            if ($setting['jenjang'] == 'SMK') {
                $qpk = mysqli_query($koneksi, "SELECT id_pk FROM pk WHERE id_pk='$pk'");
                $cekpk = mysqli_num_rows($qpk);
                if (!$cekpk <> 0) {
                    $exec = mysqli_query($koneksi, "INSERT INTO pk (id_pk,program_keahlian)VALUES('$pk','$pk')");
                }
            }
            $qlevel = mysqli_query($koneksi, "SELECT kode_level FROM level WHERE kode_level='$level'");
            $ceklevel = mysqli_num_rows($qlevel);
            if (!$ceklevel <> 0) {
                $exec = mysqli_query($koneksi, "INSERT INTO level (kode_level,keterangan)VALUES('$level','$level')");
            }
            $qruang = mysqli_query($koneksi, "SELECT kode_ruang FROM ruang WHERE kode_ruang='$ruang'");
            $cekruang = mysqli_num_rows($qruang);
            if (!$cekruang <> 0) {
                $exec = mysqli_query($koneksi, "INSERT INTO ruang (kode_ruang,keterangan)VALUES('$ruang','$ruang')");
            }
            $qsesi = mysqli_query($koneksi, "SELECT kode_sesi FROM sesi WHERE kode_sesi='$sesi'");
            $ceksesi = mysqli_num_rows($qsesi);
            if (!$ceksesi <> 0) {
                $exec = mysqli_query($koneksi, "INSERT INTO sesi (kode_sesi,nama_sesi)VALUES('$sesi','$sesi')");
            }
            $qserver = mysqli_query($koneksi, "SELECT kode_server FROM server WHERE kode_server='$server'");
            $cekserver = mysqli_num_rows($qserver);
            if (!$cekserver <> 0) {
                $exec = mysqli_query($koneksi, "INSERT INTO server (kode_server,nama_server,status)VALUES('$server','$server','aktif')");
            }
            if ($nama <> '') {
                $exec = mysqli_query($koneksi, "INSERT INTO siswa (id_siswa,id_kelas,idpk,nis,no_peserta,nama,level,sesi,ruang,username,password,foto,server,agama,firt_nama) VALUES ('$id_siswa','$kelas','$pk','$nis','$no_peserta','$nama','$level','$sesi','$ruang','$username','$password','$foto','$server','$agama','$firt_nama')");
                ($exec) ? $sukses++ : $gagal++;
            }
        }
        echo "Berhasil: $sukses | Gagal: $gagal ";
    } else {
        echo "Pilih file yang bertipe xlsx or xls";
    }

}

else{
  jump("$homeurl");
exit;
}
