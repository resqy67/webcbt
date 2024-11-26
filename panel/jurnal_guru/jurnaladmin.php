
<div class='row'>
  <div class='col-md-12'>
    <div id="info">

    </div>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'>Daftar Jurnal Guru</h3>
        <div class='box-tools pull-right '>
        </div>
      </div>
      <div class='box-body'>
        <div class="form-group">
         <!-- <a id="btn_tambah" type="button" class="btn btn-primary mb-5" style="">
            <i class="fas fa-plus-circle "></i> Buat Jurnal Baru
          </a>-->
          <a id="btn_tambah2" type="button" class="btn btn-default mb-5" style="display: none;" >
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
          <div class='box-tools '>
          <button id="down_excel" class="btn btn-warning"><i class="fa fa-download"></i> Download Excel </button>
          </div>
        </div>
        <div id="form_materi" class="row" style="display: none;">
          <div class="col-md-12">
            <form id="formtugas">
              <div class="modal-body">
			   <div class='form-group'>
                    <div class="form-group">
                    <label>Pilih Level Kelas</label>
                    <div class="row">
                      <div class="col-md-3">
                        <select class="form-control select2 level" id="level" name="level">
                          <option value=""> Pilih Kelas</option>
                         
                          <?php $db2 = $db->v_level(); 
                          foreach ($db2 as $value) { ?>
                            <option value="<?= $value['kode_level']; ?>"><?= $value['kode_level']; ?></option>
                          <?php } ?>
                    
                        </select>
                      </div>
                    </div>
                    </div>
                </div>
                 <div class='form-group'>
                    <label>Tanggal</label>
                       <input type='text' id='tanggal' name='tanggal' style="width: 300px" class='datepicker form-control' autocomplete='off' required='true' />
                  </div>
				   <div class='form-group'>
                    <label>Hari</label>
                    <div class="form-group">
                      <select id="hari" name="hari" class="form-control select2" style="width: 300px" required>
                        <option>Pilih Nama Hari</option>
                        <option value="Monday">Senin</option>
                        <option value="Tuesday">Selasa</option>
                        <option value="Wednesday">Rabu</option>
                        <option value="Thursday">Kamis</option>
                        <option value="Friday">Jumat</option>
                        <option value="Saturday">Sabtu</option>
                        <option value="Sunday">Minggu</option>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label>Pilih Kelas</label><br>
                    <div class="form-group">
                       <select id="idkelas" name="idkelas" class="form-control select2" style="width: 300px" required>
                    </select>
                    </div>
                  </div>
				  <div class='form-group'>
                    <label>Jam Ke</label>
                    <div class="form-group">
                      <select id="jamke" name="jamke" class="form-control select2" style="width: 300px" required>
                        <option>Pilih Jam</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        
                      </select>
                    </div>
                  </div>
				  <div class="form-group">
				  <label>KD/TEMA/KEGIATAN</label>
                    <textarea id="summernote" name='isijurnal'></textarea>
                  </div>
				   <div class="form-group">
				  <label>Keterangan</label>
                    <input type='text' id='keterangan' name='keterangan' style="width: 300px" class='form-control' autocomplete='off' required='true' />
                  </div>
                 
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
        <div  class='table-responsive' id='tabletugas2' style="">
          <table id='tableabsenmapel' class='table table-bordered table-hover'>
            <thead class="title_bar_table">
              <tr>
                <th width='5px'>#</th>
				<th >Guru</th>
				<th >Hari</th>
                <th >Tanggal</th>
                <th >Kelas</th>
                <th style="text-align: center;">Jam Ke</th>
                <th style="text-align: center;">KD/TEMA/KEGIATAN</th>
                <th style="text-align: center;">ket</th>
                <th width='200px' style="text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($db->getDataJurnal() as $vl) { ?>
                <tr>
                  <td><?= $no++;?></td>
				  <td><?= $vl['nama']?></td>
                  <td><?= HariIndo($vl['hari'])?></td>
                  <td><?= buat_tanggal('d-m-Y',$vl['tgl'])?></td>
                  <td><?= $vl['id_kelas']?></td>
                  <td><?= $vl['jamke']?></td>
                  <td><?= $vl['tema']?></td>
				  <td><?= $vl['ket']?></td>
                  <td>
                  <button 
                  data-hari="<?= $vl['hari'] ?>"
                  data-tanggal="<?= $vl['tgl'] ?>"
                  data-jamke="<?= $vl['jamke'] ?>"
                 
				  data-ket="<?= $vl['ket'] ?>"
                  data-toggle="modal" data-target="#myModal" data-id="<?= $vl['id_jurnal'] ?>" class="btn btn-info editjurnal"><i class="fa fa-edit"></i></button>
                  <button data-id="<?= $vl['id_jurnal'] ?>" class="btn btn-danger hapusjurnal"><i class="fa fa-trash"></i></button>
                  </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Jurnal</h4>
      </div>
      <div class="modal-body">
        <form id="formtugas2">
          <div class='form-group'>
                    <label>Tanggal</label>
                       <input type='text' id='tanggal2' name='tanggal2' style="width: 300px" class='datepicker form-control' autocomplete='off' required='true' />
                  </div>
				   <div class='form-group'>
                    <label>Hari</label>
                    <div class="form-group">
                      <select id="hari2" name="hari2" class="form-control select2" style="width: 300px" required>
                        <option>Pilih Nama Hari</option>
                        <option value="Monday">Senin</option>
                        <option value="Tuesday">Selasa</option>
                        <option value="Wednesday">Rabu</option>
                        <option value="Thursday">Kamis</option>
                        <option value="Friday">Jumat</option>
                        <option value="Saturday">Sabtu</option>
                        <option value="Sunday">Minggu</option>
                      </select>
                    </div>
                  </div>
            <div class='form-group'>
              <input id="id" type='hidden' name='id' class='form-control' required='true' />
                    <label>Jam Ke</label>
                    <div class="form-group">
                      <select id="jamke2" name="jamke2" class="form-control select2" style="width: 300px" required>
                        <option>Pilih Jam</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        
                      </select>
                    </div>
                  </div>
           <div class="form-group">
				  <label>KD/TEMA/KEGIATAN</label>
                     <textarea id="summernote_edit" name='isijurnal2'><?= $vl['tema'] ?></textarea>
                  </div>
				   <div class="form-group">
				  <label>Keterangan</label>
                    <input type='text' id='keterangan2' name='keterangan2' style="width: 300px" class='form-control' autocomplete='off' required='true' />
                  </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          
        </form>
      </div>
    </div>  
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.editjurnal').click(function() {
      var id = $(this).data('id');
      var hari = $(this).data('hari');
      var tanggal = $(this).data('tanggal');
      var jamke = $(this).data('jamke');
      //var tema = $(this).data('tema');
	  var ket = $(this).data('ket');
      $('#id').val(id);
      $('#hari2').val(hari).change();
      $('#tanggal2').val(tanggal);
      $('#jamke2').val(jamke).change();
	  //$('#isijurnal2').val(tema);
      $('#keterangan2').val(ket);
    });
    $('.hapusjurnal').click(function() {
      var id = $(this).data('id');
      if (confirm("Yakin Akan Di Hapus Jurnal Ini ?")) {
      $.ajax({
          type: 'POST',
           url: 'core/c_aksi.php?jurnal_guru=delet',
          data: {id:id},
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Hapus Jurnal Guru');
              setTimeout(function () { location.reload(1); }, 2000);
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
      }
    });

    $('#tabletugas').DataTable({
      "lengthMenu": [[50, -1], [50, "All"]]
     });
    $(document).on('click', '#btn_tambah', function() {
      $('#form_materi').slideDown(1000);
      $('#form_materi').removeAttr("style");
      $("#tabletugas2").css("display","none");
      $("#btn_tambah").css("display","none");
      $('#btn_tambah2').removeAttr("style");
    });
   $(document).on('click', '#btn_tambah2', function() {
      $('#form_materi').css("display","none");
      $("#tabletugas2").removeAttr("style");
      $("#btn_tambah2").css("display","none");
      $('#btn_tambah').removeAttr("style");
    });
    $('#tableabsenmapel').DataTable({
        pageLength: 25,
      });
     $('.level').change(function() {
        var idlevel = $(this).val();
        $("#idmapel").empty();
        $("#idkelas").empty();
        $.ajax({
          url: 'core/c_aksi.php?jurnal_guru=getmapel',
          data:{idlevel:idlevel},
          type: 'post',
          dataType: "json",
          success: function(data){
            //console.log(data);
            var dataMapel = [];
            $.each(data, function(index, objek){
             var option = '<option value="'+objek.idmapel+'">'+objek.nama_mapel+'</option>';
             dataMapel.push(option);
           });
            $('#idmapel').append('<option value="">Pilih Mapel</option>'+dataMapel);
          }
        });
        $.ajax({
          url: 'core/c_aksi.php?jurnal_guru=getkelas',
          data:{idlevel:idlevel},
          type: 'post',
          dataType: "json",
          success: function(data){
            //console.log(data);
            var dataMapel = [];
            $.each(data, function(index, objek){
             var option = '<option value="'+objek.idkls+'">'+objek.nama+'</option>';
             dataMapel.push(option);
           });
            $('#idkelas').append('<option value="">Pilih Kelas</option>'+dataMapel);
          }
        });
      });
    <?php //simpan materi ?>
    $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var pesan ="jurnal_guru";
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: 'core/c_aksi.php?jurnal_guru=insert',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Tambah jurnal');
              setTimeout(function () { location.reload(1); }, 2000);
            }
            else if(respon==99){
              toastr.warning('jurnal Kelas ini Sudah ada');
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
        return false;
      });

    $('#formtugas2').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var pesan ="jurnal_guru";
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: 'core/c_aksi.php?jurnal_guru=update',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Update jurnal');
              setTimeout(function () { location.reload(1); }, 2000);
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
        return false;
    });
    $(document).on('click','#down_excel',function(){
    $("#tableabsenmapel").table2excel({
        filename: "data_jurnal.xls",
        fileext: ".xls",
        //preserveColors: preserveColors,
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
       // preserveColors:true

      });
    });

	 $('#summernote').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });
	   $('#summernote2').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });
      $('#summernote_edit').summernote({
        codeviewFilter: false,
        codeviewIframeFilter: true,
        focus,
      });

  } );
</script>
 <script>
    tinymce.init({
      selector: '.editor1',
      plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save table contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
      ],

      toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
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


