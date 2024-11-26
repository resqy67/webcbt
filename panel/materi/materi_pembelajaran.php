<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
if($_GET['pg']=='materi_pb' and $_GET['aksi']==''){ ?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'> Daftar Materi Pembelajaran</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <!-- Button trigger modal -->
        <div class="form-group">
          <a id="btn_tambah" type="button" class="btn btn-primary mb-5" style="" >
            <i class="fas fa-plus-circle "></i> Tambah Materi
          </a>
          <a id="btn_tambah2" type="button" class="btn btn-default mb-5" style="display: none;" >
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
          <button class="btn btn-success" data-toggle="modal" data-target="#myModal" ><i class="fa fa-info"></i> Petunjuk</button>
          <!-- Modal -->
          <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Cara membagikan link materi</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <b><h3>Link Youtube yang akan dibagikan</h3></b><br>
                      1. Buka youtube yang ingin di bagikan<br> 
                      2. Copy URL nya atau alamat youtubenya<br>
                      Contoh URLnya &nbsp;<i style="color: blue;"><a href="https://youtu.be/sexnoBlIGn0" target="_blank">https://youtu.be/sexnoBlIGn0</a></i>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <b><h3>Link google drive yang akan dibagikan</h3></b><br>
                      1. Buka Google Drive<br>
                      2. Kemudian pilih (file atau folder juga bisa) yang ingin di bagikan<br> 
                      3. Klik icon titik 3 atau untuk ke menu bagikan <br>
                      4. Kemudian Pilih bagikan (nanti akan tampul url atau alamat)<br>
                      5. Copy URL atau alamatnya dikolom materi tambah link google drive <br>
                      Contoh URLnya &nbsp;<i style="color: blue;"><a href="https://docs.google.com/presentation/d/1K50Fi3NmF607qr5YwsGMIsI4i9w21uJ0-PTvmhHpWvU/edit?usp=sharing" target="_blank">https://docs.google.com/presentation/d/1K50Fi3NmF607qr5YwsGMIsI4i9w21uJ0-PTvmhHpWvU/edit?usp=sharing</a></i>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <b><h3>Link youtube ID</h3></b><br>
                      1. Buka Youtube yang ingin di bagikan<br> 
                      2. Copy URL nya atau alamat youtubenya<br>
                      Contoh URLnya &nbsp;<i style="color: blue;">
                        <br>1. <a>https://www.youtube.com/watch?v=<b style="color: red;">sexnoBlIGn0</b></a> &nbsp;atau
                        <br>2. <a>www.youtube.com/watch?v=<b style="color: red;">sexnoBlIGn0</b></a><br></i>
                        Nah dari link di atas yang kita ambil atau yang kita copy <br>
                        adalah yang <b style="color: red;">warna merah</b>
                      
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div id="form_materi" class="row" style="display: none;">
          <div class="col-md-12">
            <form id="formtugas">
                <div class="modal-body">
                  <div class="form-group">
                    <select id="idlevel" name="idlevel" class="form-control select2" style="width: 200px" required>
                      <option>Pilih Level Kelas</option>
                      <?php $db2 = $db->v_level(); 
                      foreach ($db2 as $value) { ?>
                        <option value="<?= $value['kode_level']; ?>"><?= $value['kode_level']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <select id="idmapel" name="mapel" class="form-control select2" style="width: 300px">
                    </select>
                  </div>
                  <input type="hidden" class="form-control" name="id_mapel" value="<?= $id_mapel ?>">
                  <div class="form-group">
                    <input type="text" class="form-control" name="judul_materi" aria-describedby="helpId" placeholder="Judul Materi" required>
                  </div>
                  <div class="form-group">
                    <!--<textarea id="summernote" name='isimateri'></textarea> -->
                    <textarea name='isimateri' class='editor1' rows='10' cols='80' style='width:100%;'></textarea> 
                  </div>
                  <div class="form-group" style="padding-top:10px;" >
                    <div class="row">
                      <div class="col-md-6">
                         <label>Link Youtube Yang Ingin Di Bagikan</label>
                      <input type="text" class="form-control" name="youtube" aria-describedby="helpId" placeholder="ulr_youtube">
                      </div>
                      <div class="col-md-6">
                         <label>Link Youtube ID</label><br>
                        <input type="text" class="form-control" name="idyoutube" placeholder="Youtube ID">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-12">
                      <label>Link Google Drive Yang Ingin Di Bagikan</label><br>
                        <input type="text" class="form-control" name="gdrive" aria-describedby="helpId" placeholder="Url Google Drive">
                      </div>
                    </div>
                  </div>
                  <div class='form-group'>
                    <div class='row'>
                      <div class='col-md-4'>
                        <label>Pilih Kelas</label><br>
                        <select id="kelas1" name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                        </select>
                      </div>

                    </div>
                  </div>
                  <div class="form-group" >
                      <?php if($setting['upload']==1){ ?>
                  <label for="file">File Pendukung</label> <font color="grey"></font>
                    <input type="file" class="form-control-file" name="file_materi" placeholder="" aria-describedby="fileHelpId"><br>
                    <font color='grey'>File pendukung dapat berupa dokumen atau gambar</font><br> 
                    <?php  } ?>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
          </div>
        </div>
       
        <div id='tabletugas' class='table-responsive' style="">
           <div class="row" style="padding-bottom: 10px;">
          <div class="col-md-2">
           <select name='kelas' id="pilihkelas" class='form-control select2' style='width:100%' >
            <option value='null'>Pilih Kelas</option>
            <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
            <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
              <option <?= selectAktif($kelas['id_kelas'],$_GET['kelas']) ?> value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
            <?php endwhile ?>
          </select>
        </div>
        </div>
          <table id="table_materi" class='table table-bordered table-striped  table-hover'>
            <thead>
              <tr>
                <th width='5px'>#</th>
                <th width='150px'>Mata Pelajaran</th>
                <th >Guru</th>
                <th width='300px'>Judul Tugas</th>
                <th>Kelas</th>
                <th>File</th>
                <th>gDrive</th>
                <th>Video</th>
                <th>Id_Video</th>
                <th width='200px'>Tgl Terbit</th>
                <th >Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(empty($_GET['kelas'])){

              }
              else{
                $kelas = $_GET['kelas'];
              if ($pengawas['level'] == 'guru') {
                $tugasQ = mysqli_query($koneksi, "SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel  INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas where id_guru='$_SESSION[id_pengawas]' ORDER BY materi2_tgl ");
              } else {
                $tugasQ = mysqli_query($koneksi, "SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel  INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas ORDER BY materi2_tgl");
              }
              foreach ($tugasQ as $value) {
                $datakelas = unserialize($value['kelas']);
                if (in_array($kelas, $datakelas)){
                  $data2[] = $value;
                } 
              }
              //while ($tugas = mysqli_fetch_array($data3)){
              ?>
              <?php foreach ($data2 as $tugas) {  ?>
                <?php
                $no++
                ?>
                <tr>
                  <td><?= $no ?></td>
                  <td>
                    <?= $tugas['nama_mapel'] ?>
                  </td>
                  <td>
                    <?= $tugas['nama'] ?>
                  </td>
                  <td>
                    <?= $tugas['materi2_judul'] ?>
                  </td>

                  <td style="text-align:center">
                    <?php $kelas = unserialize($tugas['kelas']);
                    foreach ($kelas as $kelas) {
                      echo $kelas . "  ";
                    }
                    ?>
                  </td>
                  <td>
                    <?php if ($tugas['materi2_file'] <> '') { ?>
                      <a href="<?= $homeurl?>/<?= $linkguru ?>/berkas2/<?= $tugas['id_guru'] ?>/<?= $tugas['materi2_file'] ?>" target="_blank">Lihat</a> || 
                      <a href="<?= $homeurl?>/<?= $linkguru ?>/berkas2/<?= $tugas['id_guru'] ?>/<?= $tugas['materi2_file'] ?>" download >Download</a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($tugas['url_gdrive'] != '') { ?>
                    <a href="<?= $tugas['url_gdrive'] ?>" target="_blank"> <center><i class='fab fa-google-drive fa-2x'></i></center></a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($tugas['url_youtube'] != '') { ?>
                    <a href="<?= $tugas['url_youtube'] ?>" target="_blank"> <center><font color='red'><i class='fab fa-youtube fa-2x'></i></font></center></a>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($tugas['url_embed'] != '') { ?>
                    <a href="https://www.youtube.com/watch?v=<?= $tugas['url_embed'] ?>" target="_blank"><center><font color='red'><i class='fab fa-youtube fa-2x'></i></font></center></a>
                    <?php } ?>
                  </td>
                  <td>
                    <?= $tugas['materi2_tgl'] ?>
                  </td>
                  <td style="text-align:center" width="75px">
                    <div class=''>
                      <!-- <a href='?pg=tugas&ac=jawaban&id=<?= $tugas['id_tugas'] ?>' class='btn btn-sm btn-success '><i class='fas fa-eye'></i> Lihat</a> -->
                      <!-- Button trigger modal -->
                      <a href="<?= $homeurl ?>/<?= $crew ?>/?pg=materi_pb&aksi=edit&id=<?= $tugas['materi2_id'] ?>" type="button" class="btn btn-primary btn-sm" >
                        <i class="fas fa-edit    "></i>
                      </a>
                      <button data-id='<?= $tugas['materi2_id'] ?>' class="hapus btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i></button>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
              <?php } ?>
            </table>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
<?php
}elseif($_GET['pg']=='materi_pb' and $_GET['aksi']=='edit'){ ?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
       <!--  <a href="<?= $homeurl ?>/<?= $crew ?>/?pg=materi_pb" type="button" class="btn btn-default" ><i class="fas fa-arrow-left"></i> Kembali</a> -->
       <button onclick="window.history.back();" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali </button>&nbsp;&nbsp;
        <h3 class='box-title'> Edit Materi Pembelajaran</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <div id="<?= $tugas['materi2_id'] ?>" class="row">
      <div class="col-md-12">
        <?php if(empty($_GET['id'])){ $id=null; }else{ $id=$_GET['id']; } 
        $db2 = $db->edit_materi2($id);
        foreach ($db2 as $tugas) {
        ?>
        <form id="formedittugas">
          <div class="modal-body">
            <input type="hidden" value="<?= $tugas['materi2_id'] ?>" name='id'>
            <div class="form-group">
              <label>Nama Mapel</label><br>
              <?= $tugas['nama_mapel'] ?>
            </div>
            <div class="form-group">
              <label>Judul Materi</label>
              <input type="text" class="form-control" name="judul_materi" aria-describedby="helpId" placeholder="Judul Tugas" value="<?= $tugas['materi2_judul'] ?>" required>
            </div>
            <div class="form-group">
              <label>Isi Materi</label>
              <textarea id="summernote_edit" name='isimateri'><?= $tugas['materi2_isi'] ?></textarea>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                 <label>Link Youtube Yang Ingin Di Bagikan</label>
                <input type="text" class="form-control" name="youtube" placeholder="ulr_youtube" value="<?= $tugas['url_youtube'] ?>">
               </div>
               <div class="col-md-6">
                <label>Link Youtube ID</label><br>
               <input type="text" class="form-control" name="idyoutube" placeholder="Youtube ID" value="<?= $tugas['url_embed'] ?>">
              </div>
            </div>
           </div>
           <div class="form-group">
            <div class="row">
              <div class="col-md-12">
               
               <label>Link Google Drive Yang Ingin Di Bagikan</label><br>
                 <input type="text" class="form-control" name="gdrive" placeholder="Url Google Drive" value="<?= $tugas['url_gdrive'] ?>">
             </div>
            </div>
            </div>
            <div class='form-group'>
              <div class='row'>
                <div class='col-md-4'>
                  <label>Pilih Kelas</label><br>
                  <select name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                    <option value='semua'>Semua</option>
                    <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas where id_level='$tugas[kode_level]'"); ?>
                    <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                      <?php if (in_array($kelas['id_kelas'], unserialize($tugas['kelas']))) : ?>
                        <option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>"
                        <?php else : ?>
                          <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
                        <?php endif; ?>
                      <?php endwhile ?>
                    </select>
                  </div> 
                  <div class="col-md-4">
                  <!--  <label for="file">File Pendukung</label>
                    <input type="file" class="form-control-file" name="file_materi" id="file_materi" placeholder="" aria-describedby="fileHelpId" value="">
                    Format file ( doc/docx/xls/xlsx/ppt/pdf )<br>
                    Format gambar ( jpg/png )<br> -->
                  </div>
                  <div class="col-md-4">
                    <label for="file">Nama File Pendukung</label><br>
                    <?php if($tugas['materi2_file'] == ""){ echo "Kosong";}else{  ?>
                      <b><a href="../<?= $linkguru ?>/berkas2/<?= $tugas['id_guru'] ?>/<?= $tugas['materi2_file'] ?>" download ><?= $tugas['materi2_file'] ?></a></b>
                    <?php } ?>
                  </div>

                </div>
              </div>

            </div>
            <div class="modal-footer">
              <a href="<?= $homeurl ?>/<?= $crew ?>/?pg=materi_pb" type="button" class="btn btn-default" data-dismiss="modal">Kembali</a>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
        <script type="text/javascript">
          $('#formedittugas').submit(function(e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
              type: 'POST',
              url: 'materi/edit_materi.php',
              enctype: 'multipart/form-data',
              data: data,
              cache: false,
              contentType: false,
              processData: false,
              beforeSend: function() {
                $("#pesanku").text("Sedang Proses ...!");
                $('.loader').show();
              },
              success: function(data) {
                if (data == "ok") {
                  toastr.success("Materi berhasil dirubah");
                } else {
                  toastr.error(data);
                }
                setTimeout(function() {
                  location.reload();
                }, 1000);

              }
            });
            return false;
          });
        </script>
        <?php } ?>
      </div>
    </div>
      </div>
    </div>
  </div>
</div>
<?php }
else{

}
?>
  <script type="text/javascript">
   $(document).on('click', '#btn_tambah', function() {
      $('#form_materi').slideDown(1000);
      $('#form_materi').removeAttr("style")
      $("#tabletugas").css("display","none");
      $("#btn_tambah").css("display","none");
      $('#btn_tambah2').removeAttr("style");
    });
   $(document).on('click', '#btn_tambah2', function() {
      $('#form_materi').css("display","none");
      $("#tabletugas").removeAttr("style");
      $("#btn_tambah2").css("display","none");
      $('#btn_tambah').removeAttr("style");
    });
  
   $(document).ready(function() {
    //Agar Video Summoner editor responsif
        jQuery('.note-video-clip').each(function(){
            var tmp = jQuery(this).wrap('<p/>').parent().html();
            jQuery(this).parent().html('<div class="embed-responsive embed-responsive-16by9">'+tmp+'</div>');
          });
    $('#pilihkelas').change(function() {
      var idkelas = $(this).val();
      location.replace("?pg=materi_pb&kelas="+idkelas);
    });
    $('#idlevel').change(function() {
      var idlevel = $('#idlevel').val();
      $("#idmapel").empty();
       $("#kelas1").empty();
      $.ajax({
        url: "<?php echo "core/c_aksi.php?materi=cari_mapel"; ?>",
        data:{id:idlevel},
        type: 'post',

        dataType: "json",
        success: function(data){
          var dataMapel = [];
          $.each(data, function(index, objek){
           var option = '<option value="'+objek.kode_mapel+'">'+objek.nama_mapel+'</option>';
           dataMapel.push(option);
         });
          $('#idmapel').append('<option value="">Pilih Mapel</option>'+dataMapel);
        //console.log(data);
        }
      });
      //get kelas json
      $.ajax({
        url: "<?php echo "core/c_aksi.php?kelas=getkelas"; ?>",
        data:{idlevel:idlevel},
        type: 'post',

        dataType: "json",
        success: function(data){
          var dataMapel = [];
          $.each(data, function(index, objek){
           var option = '<option value="'+objek.id_kelas+'">'+objek.nama+'</option>';
           dataMapel.push(option);
         });
          $('#kelas1').append('<option value="">Pilih Kelas</option>'+dataMapel);
        //console.log(data);
        }
      });
    });

    $('#table_materi').DataTable({
        pageLength: 10,
      });

      $('#summernote').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });
      $('#summernote_edit').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });
    });

    $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: 'materi/tambah_materi.php',
          enctype: 'multipart/form-data',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            $('#modaltugas').modal('hide');
            if (data ==1) {
              toastr.success("Materi berhasil disimpan");
              setTimeout(function() {
                location.reload();
              }, 1000);
            } else {
              toastr.error("Materi gagal dibuat");
            }
            //toastr.error(data);

           //alert(data);
          }

        });
        return false;
      });
    $('#tabletugas').on('click', '.hapus', function() {
      var id = $(this).data('id');
      console.log(id);
      swal({
        title: 'Apa anda yakin?',
        text: "akan menghapus Materi ini!",

        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'materi/hapus_materi2.php',
            method: "POST",
            data: 'id=' + id,
            success: function(data) {
              console.log(data);
              toastr.success('Materi berhasil dihapus');
              setTimeout(function () { location.reload(1); }, 1000);
            }
          });
        }
      })

    });
    // $('#tablejawaban').on('click', '.hapus', function() {
    //   var id = $(this).data('id');
    //   console.log(id);
    //   swal({
    //     title: 'Apa anda yakin?',
    //     text: "akan menghapus nilai ini!",

    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes!'
    //   }).then((result) => {
    //     if (result.value) {
    //       $.ajax({
    //         url: 'tugas/hapus_nilai.php',
    //         method: "POST",
    //         data: 'id=' + id,
    //         success: function(data) {
    //           toastr.success('Materi berhasil dihapus');
    //           $("#tablejawaban").load(window.location + " #tablejawaban");
    //         }
    //       });
    //     }
    //   })

    // });
  </script>
  <script>
    tinymce.init({
      selector: '.editor1',
      plugins: [
      'advlist autolink lists link charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime nonbreaking save table contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
      ],

      toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link paste ',
      fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
      paste_data_images: true,

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
  </script>