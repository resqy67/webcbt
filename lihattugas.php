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

        <h3 class='box-title'><i class="fas fa-file-signature"></i> Detail Tugas Siswa</h3>
         <a class="btn btn-warning" href='<?= $homeurl ?>/tugassiswa' ><i class="fa fa-arrow-left"></i> Kembali</a>
      </div><!-- /.box-header -->
      <div class='box-body' id="loaddiv">
        <table class='table table-bordered table-striped'>
          <tr>
            <th width='150'>Mata Pelajaran</th>
            <td width='10'>:</td>
            <td><?= $tugas['mapel'] ?></td>

          </tr>
          <tr>
            <th width='150'>Topik</th>
            <td width='10'>:</td>
            <td><?= $tugas['judul'] ?></td>

          </tr>
          <tr>
            <th>Guru Pengampu</th>
            <td width='10'>:</td>
            <td><?= $guru['nama'] ?></td>
          </tr>
          <tr>
            <th>Hubungi Via</th>
            <td width='10'>:</td>
            <td><a class="label label-success" href="https://api.whatsapp.com/send/?phone=<?= $guru['whatsapp'] ?>&text=Assalamualaikum wr.wb, Maaf mengganggu bpk/ibu <?= $guru['nama'] ?>. Saya <?=$siswa['nama'] ?>" target="_blank">
            <i class="fab fa-whatsapp"></i> Whatsapp </a>  | <a class="label label-primary" href="https://t.me/<?= $guru['telegram'] ?>" target="_blank"> <i class="fab fa-telegram-plane"></i> Telegram</a></td>
          </tr>
          <tr>
            <th>Tgl Mulai</th>
            <td width='10'>:</td>
            <td><?= $tugas['tgl_mulai'] ?></td>
          </tr>
          <tr>
            <th>Tgl Tutup</th>
            <td width='10'>:</td>
            <td><?= $tugas['tgl_selesai'] ?></td>
          </tr>

        </table>
        <br>
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Lihat Soal</a></li>
             <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Kirim Jawaban</a></li>
			<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Lihat Nilai</a></li>
			<li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="true">Peringkat Nilai</a></li>
			<li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="true">Rekap Tugas</a></li>

          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
             <?php if ($tugas['file'] ==null or $tugas['file'] =="") { }else{ ?>
                Download Materi Pendukung<p>
                  <a download target="_blank" href='<?= $homeurl ?>/<?= $linkguru ?>/tugas/<?= $tugas['id_guru'] ?>/<?= $tugas['file'] ?>' class="btn btn-primary"><?= $tugas['file'] ?></a>
                <?php } ?>
                <center>
                  <h3><?= $tugas['judul'] ?></h3>
                  <?php if ($tugas['url_gdrive'] ==null or $tugas['url_gdrive'] =="") { }else{ ?>
                    <a class="btn btn-primary" target="_blank" href="<?= $tugas['url_gdrive'] ?>" ><i class="fab fa-google-drive"></i> Link Drive</a>
                 <?php } ?>
                 <?php if ($tugas['youtube'] ==null or $tugas['youtube'] =="") { }else{ ?>
                    <a class="btn btn-danger" target="_blank" href="<?= $tugas['youtube'] ?>" ><i class="fab fa-youtube"></i> Link Youtube</a>
                 <?php } ?>
                </center>
                <p class="text-justify"><?= $tugas['tugas'] ?></p>
              </div>
              <div class="tab-pane" id="tab_2">
                <?php
                $kondisi = array(
                  'id_siswa' => $_SESSION['id_siswa'],
                  'id_tugas' => $tugas['id_tugas']
                );
                $jawab_tugas = fetch($koneksi, 'jawaban_tugas', $kondisi);
                if ($jawab_tugas) {
                  $jawaban = $jawab_tugas['jawaban'];
                } else {
                  $jawaban = "";
                }
                ?>
				
                 <!--fungsi validasi form-->
				<?php if ($tugas['tgl_mulai'] > date('Y-m-d H:i:s') and $tugas['tgl_selesai'] > date('Y-m-d H:i:s')) { ?>
                   <div class="alert alert-danger" role="alert">
                    <strong>TUGAS BELUM MULAI</strong>
                  </div>
                  <?php } elseif ($tugas['tgl_mulai'] < date('Y-m-d H:i:s') and $tugas['tgl_selesai'] > date('Y-m-d H:i:s')) { ?>
				  <div class="alert alert-warning" role="alert">
                    <strong>Kerjakan dengan jujur dan benar, jawaban akan digunakan sebagai absen.</strong>
                  </div>

                  <form id='formjawaban'>
                    <input type="hidden" name="id_tugas" value="<?= $tugas['id_tugas'] ?>">
                    <input type="hidden" name="id_guru" value="<?= $tugas['id_guru'] ?>">
                    <input type="hidden" name="mapel2" value="<?= $tugas['mapel'] ?>">
                    <input type="hidden" name="id_telegram" value="<?= $telegram['tlChatId'] ?>">
                    <div class="form-group">
                      <label for="">Silakan tulis jawaban dibawah ini</label>
                       <textarea class="form-control" name="jawaban" id="txtjawaban" rows="10"><?= $jawaban ?></textarea> 
                     <!-- <textarea id="summernote" name='jawaban'><?= $jawaban ?></textarea> -->
                    </div>
                    <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                      <label><i class="fab fa-google-drive"> Link Google Drive dan Sejenisnya</i></label><br>
                        <input type="url" class="form-control" name="gdrive" value='<?= $jawaban_tugas['url_gdrive'] ?>' placeholder="Url Google Drive">
                      </div>
                    
                      <div class="col-md-6">
                      <label><i class="fab fa-youtube"> Link Youtube dan Sejenisnya</i></label><br>
                        <input type="url" class="form-control" name="youtube" value='<?= $jawaban_tugas['youtube'] ?>' placeholder="Link video atau youtube">
                      </div>
                    </div>
                  </div>

                    <?php if($setting['upload']==1){ ?>
                    <?php if ($jawab_tugas['file'] == '') { ?>
                      <div class="form-group">
                        <label for="">Jika jawaban berupa foto silakan upload dibawah</label>
                        <input type="file" class="form-control-file" name="file" aria-describedby="fileHelpId">
                        <small id="fileHelpId" class="form-text text-muted">Ukuran file maksimal 2 MB</small>
                      </div>
                    <?php } else { ?>

                      <div class="alert alert-success" role="alert">
                        <strong>file jawaban berhasil dikirim</strong>
                        <a href='<?= $homeurl ?>/guru/tugas_siswa/<?= $tugas['id_guru'] ?>/<?= $tugas['id_tugas'] ?>/<?= $jawab_tugas['file'] ?>' target="_blank">Lihat file</a>
                      </div>
                    <?php  } ?>
                    <?php  } ?>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                    </div>
                  </form>
                 <?php } else { ?>
						<div class="alert alert-danger" role="alert">
                    <i class='fas fa-lock' style='font-size:24px;color:white'></i><strong>  TUGAS SUDAH DITUTUP</strong>
                  </div>
                  <?php } ?>
				  <!-- akhir fungsi validasi form -->
              </div>
			  <!--------------------------------------------------------------------------------------------------------------------------->
			 <div class="tab-pane" id="tab_3">
			    <?php if ($jawab_tugas['nilai'] != '' && $jawab_tugas['jawaban'] != '' or $jawab_tugas['nilai'] != '' && $jawab_tugas['url_gdrive'] != '' || $jawab_tugas['nilai'] != '' && $jawab_tugas['file'] != '') { ?>
                  <div class="alert alert-success" role="alert">
                    <strong>Jawaban telah dikoreksi dan dinilai</strong>
                  </div>
                  <h1>Nilai Kamu : <?= $jawab_tugas['nilai'] ?></h1>
                  <?php if(!empty($jawab_tugas['catatanGuru'])): ?>
                    <font color='black'><h4>Catatan Guru : <?= $jawab_tugas['catatanGuru'] ?></h4></font>
                  <?php endif ?>
                <?php } elseif ($jawab_tugas['nilai'] == '' && $jawab_tugas['jawaban'] != '' or $jawab_tugas['nilai'] == '' && $jawab_tugas['url_gdrive'] != '' || $jawab_tugas['nilai'] != '' && $jawab_tugas['file'] != ''){ ?>
				<div class="alert alert-warning" role="alert">
                    <strong>BELUM DIKOREKSI</strong>
                  </div>
				<?php }else{ ?>
				<div class="alert alert-danger" role="alert">
                    <strong>BELUM MENGERJAKAN</strong>
                  </div>
				  <?php } ?>
			   </div>
			   <!--------------------------------------------------------------------------------------------------------------------------->
			   <div class="tab-pane" id="tab_3">
			    <?php if ($jawab_tugas['nilai'] != '' && $jawab_tugas['youtube'] != '') { ?>
                  <div class="alert alert-success" role="alert">
                    <strong>Jawaban telah dikoreksi dan dinilai</strong>
                  </div>
                  <h1>Nilai Kamu : <?= $jawab_tugas['nilai'] ?></h1>
                  <?php if(!empty($jawab_tugas['catatanGuru'])): ?>
                    <h4>Catatan Guru : <?= $jawab_tugas['catatanGuru'] ?></h4>
                  <?php endif ?>
                <?php } elseif ($jawab_tugas['nilai'] == '' && $jawab_tugas['youtube'] != ''){ ?>
				<div class="alert alert-warning" role="alert">
                    <strong>BELUM DIKOREKSI</strong>
                  </div>
				<?php }else{ ?>
				<div class="alert alert-danger" role="alert">
                    <strong>BELUM MENGERJAKAN</strong>
                  </div>
				  <?php } ?>
			   </div>
			   <div class="tab-pane" id="tab_5">
			    <div class="alert alert-success" role="alert">
                                                    <strong>Daftar Tugas yang sudah dikerjakan</strong>
                                                </div>
                                                <table id='example1' class='table table-bordered table-striped'>
                                                    <thead>
                                                        <tr>
                                                            <th width='5px'>No</th>
                                                            <th>Nama Mapel</th>
                                                            
                                                            <th class='hidden-xs'>Update Dikerjakan</th>
                                                            <th>Nilai</th>
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
                                                                <td><?= $nox ?></td>
                                                                <td><?= $mapel['mapel'] ?> - <?= $mapel['judul'] ?> </td>
                                                                <td class='hidden-xs'><?= $tugas['tgl_update'] ?></td>
                                                                <td ><label class='label label-primary'><?= $tugas['nilai']?></label></td>
                                                                
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                    <div class="tab-pane" id="tab_4">
                  <table class='table-responsive'>
                    <table id='example1' class='table table-striped'>
                      <thead>
                        <tr>
                          <th style='text-align:center' width='5px'>Peringkat</th>
                          <th>Nama Siswa</th>
                          <th>Catatan</th>
                          <th style='text-align:center'>Hasil</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $tugasx = mysqli_query($koneksi, "SELECT * FROM jawaban_tugas WHERE  id_tugas='$ac' order by cast(nilai as decimal) DESC"); ?>
                        <?php $no = 0; ?>
                        <?php while ($peringkat = mysqli_fetch_array($tugasx)) : ?>
                          <?php
                          $no++;
                          $siswa = mysqli_fetch_array(mysqli_query($koneksi, "select * from siswa where id_siswa='$peringkat[id_siswa]'"));
                          if ($peringkat['id_siswa'] == $id_siswa) {
                            $style = "style='background:yellow;font-size:20px;'";
                          } else {
                            $style = "";
                          }
                          ?>
                          <tr <?= $style ?>>
                            <td style='text-align:center'><?= $no ?></td>
                            <td><?= $siswa['nama'] ?></td>
                            <td><?= $peringkat['catatanGuru'] ?></td>
                            <td style='text-align:center'><?= $peringkat['nilai'] ?></td>
                          </tr>
                        <?php endwhile; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<script type="text/javascript">
$(document).ready(function() {
  //Agar Video Summoner editor responsif
        jQuery('.note-video-clip').each(function(){
            var tmp = jQuery(this).wrap('<p/>').parent().html();
            jQuery(this).parent().html('<div class="embed-responsive embed-responsive-16by9">'+tmp+'</div>');
          });
     $('#summernote').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });

    $('#formjawaban').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var homeurl = '<?= $homeurl ?>';

      $.ajax({
        type: 'POST',
        url: homeurl + '/simpantugas.php',
        enctype: 'multipart/form-data',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
        $("#pesanku").text("Sedang Di Proses !!!");
        $('.loader').show();
        },
        success: function(data) {
          console.log(data);
          if (data == 'ok') {
            toastr.success("jawaban berhasil dikirim");
            $("#loaddiv").load(window.location + " #loaddiv");
            location.reload(true);

          } else {
            toastr.error("jawaban gagal dikirim");
          }
        }
      });
      return false;
    });
});
  </script>
<script type="text/javascript">
$(document).ready(function() {
    tinymce.init({
      selector: '#txtjawaban',
      plugins: [
      'advlist autolink lists charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      //'insertdatetime media nonbreaking save table contextmenu directionality',
      //'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste'
      ],

      toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | emoticons | imagetools image paste ',
      fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
      paste_data_images: false,
      paste_as_text: true,
      images_upload_handler: function(blobInfo, success, failure) {
        success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
      },
      image_class_list: [{
        title: 'Responsive',
        value: 'img-responsive'
      }],
      setup: function(editor) {
        editor.on('change', function() {
          tinymce.triggerSave();
        });
      }
    });
  });
  </script>