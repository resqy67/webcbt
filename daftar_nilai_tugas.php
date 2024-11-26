<?php
$ac = dekripsi($ac);
echo $ac;
$tugas = mysqli_fetch_array(mysqli_query($koneksi, "select * from tugas where id_tugas='$ac'"));
$guru = fetch($koneksi, 'pengawas', ['id_pengawas' => $tugas['id_guru']]);
$telegram = fetch($koneksi, 'telegram_bot', ['tlIdGuru' => $tugas['id_guru']]);
?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit "></i> Daftar Nilai Tugas Siswa</h3>
      </div><!-- /.box-header -->
      <div class='box-body' id="loaddiv">
        <div style="padding-bottom: 10px;" >
         <a class="btn btn-warning" href='<?= $homeurl ?>/tugassiswa' ><i class="fa fa-arrow-left"></i> Kembali Lihat Tugas</a>
        </div>
        
          <div class="tab-content">
			   <div class="active" id="tab_5">
			                                        <table id='tableabsen' class='table table-bordered'>
                                                    <thead style="background-color: #337ab7;border-color:#337ab7;color:#fff;">
                                                        <tr>
                                                            <th width='5px'>NO</th>
                                                            <th width='10px'><center>NILAI</center></th>
                                                            <th width='25px'><center>CATATAN GURU</center></th>
                                                            <th>JUDUL TUGAS</th>
                                                            <th>NAMA MAPEL</th>
                                                            <th width='180px'>TANGGAL DIKERJAKAN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $tugasx = mysqli_query($koneksi, "SELECT * FROM jawaban_tugas WHERE id_siswa='$id_siswa' "); ?>
                                                        <?php while ($tugas = mysqli_fetch_array($tugasx)) : ?>
                                                            <?php
                                                            $nox++;
                                                            $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tugas WHERE id_tugas='$tugas[id_tugas]'"));
                                                            
                                                            ?>
                                                            <tr>
                                                                <td><center><?= $nox ?></center></td>
                                                                <td ><center><?= $tugas['nilai']?></center></td>
                                                                <td ><?php if(!empty($tugas['catatanGuru'])): ?>
                                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalcatatan<?= $no ?>"> Lihat Catatan Guru</button>
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="modalcatatan<?= $no ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                                </div>
                                                                            <?php $no++;
                                                                            $kondisi = array(
                                                                              'id_siswa' => $_SESSION['id_siswa'],
                                                                              'id_tugas' => $tugas['id_tugas']
                                                                            );
                                                                            $jawab_tugas = fetch($koneksi, 'jawaban_tugas', $kondisi);
                                                                            if ($jawab_tugas) {
                                                                              $jawaban = $jawab_tugas['catatanGuru'];
                                                                            } else {
                                                                              $jawaban = "";
                                                                            }
                                                                            ?>
                                                                            <div class="modal-body">
                                                                        <div class="row">
                                                                    <div class="col-md-12">
                                                                    <b> Komentar Guru:</b> <font color='green'> <p>"<?=$jawab_tugas['catatanGuru'] ?>"</p></font>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end modal -->
                                            <?php endif ?>
                                                                </td>
                                                                <td ><?= $mapel['judul'] ?></td>
                                                                <td><?= $mapel['mapel'] ?></td>
                                                                <td class='hidden-xs'><?= $tugas['tgl_update'] ?></td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
<script type="text/javascript">
  var tabel = $('#tableabsen').dataTable();
</script>