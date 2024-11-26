<?php
require "../config/config.koneksipusat.php";
 // $data =array(
 //            'id_ujian'          =>$get_data['id_ujian'],
 //            'id_mapel'          =>$get_data['id_mapel'],
 //            'id_siswa'          =>$get_data['id_siswa'],
 //            'kode_ujian'        =>$get_data['kode_ujian'],
 //           'ujian_mulai'        =>$get_data['ujian_mulai'],
 //           'ujian_berlangsung'  =>$get_data['ujian_berlangsung'],
 //           'ujian_selesai'      =>$get_data['ujian_selesai'],
 //           'jml_benar'          =>$get_data['jml_benar'],
 //           'jml_salah'          =>$get_data['jml_salah'],
 //           'nilai_esai'         =>$get_data['nilai_esai'],
 //            'skor'              =>$get_data['skor'],
 //            'total'             =>$get_data['total'],
 //            'status'            =>$get_data['status'],
 //            'ipaddress'         =>$get_data['ipaddress'],
 //            'hasil'             =>$get_data['hasil'],
 //            'jawaban'           =>$get_data['jawaban'],
 //            'jawaban_esai'      =>$get_data['jawaban_esai'],
 //            'online'            =>$get_data['online'],
 //            'id_soal'           =>$get_data['id_soal'],
 //            'id_esai'           =>$get_data['id_esai'],
 //            'nilai_esai2'       =>$get_data['nilai_esai2'],
 //          );

if ($koneksipusat) {
    $serverpusat = mysqli_fetch_array(mysqli_query($koneksipusat, "SELECT * from server where kode_server='$setting[id_server]'"));
    if ($serverpusat['status'] == 'aktif') {
        $idujian = $_POST['id'];
        //kirim nilai
        $sqlcek = mysqli_query($koneksi, "SELECT * from nilai where status is null and id_ujian='$idujian'");
        while ($r = mysqli_fetch_array($sqlcek)) {
            $status=2;
            $sql = mysqli_query($koneksipusat, "INSERT INTO
              nilai (id_mapel,id_ujian,id_siswa,kode_ujian,ujian_mulai,ujian_berlangsung,ujian_selesai,jml_benar,jml_salah,nilai_esai,skor,total,hasil,jawaban,jawaban_esai,status,ipaddress,id_soal,id_opsi,id_esai,nilai_esai2) 
              values ('$r[id_mapel]','$r[id_ujian]','$r[id_siswa]','$r[kode_ujian]','$r[ujian_mulai]','$r[ujian_berlangsung]','$r[ujian_selesai]','$r[jml_benar]','$r[jml_salah]','$r[nilai_esai]','$r[skor]','$r[total]','$r[hasil]','$r[jawaban]','$r[jawaban_esai]','$status','$r[ipaddress]','$r[id_soal]','$r[id_opsi]','$r[id_esai]','$r[nilai_esai2]')");
            if ($sql) {
                $sql = mysqli_query($koneksi, "update nilai set status = '1' where id_nilai='$r[id_nilai]'");
            }
        }
    } else {
        echo "server pusat tidak diaktifkan";
    }
} else {
    echo "server tidak terhubung";
}
