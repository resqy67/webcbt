
<div class='row'>
  <div class='col-md-12'>
    <div id="info">

    </div>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'><b>DAFTAR RATING GURU</b></h3>
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
       
        <div  class='table-responsive' id='tabletugas2' style="">
          <table id='tableabsenmapel' class='table table-bordered table-hover'>
            <thead class="title_bar_table">
              <tr>
                <th width='5px'>#</th>
				<th >Guru</th>
				<th >Rating</th>
                <th >Jumlah Vote</th>
                <th >Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $guruku = mysqli_query($koneksi, "SELECT * FROM rating INNER JOIN pengawas ON pengawas.id_pengawas=rating.id_guru WHERE pengawas.level='guru' GROUP BY nama ORDER BY nama ASC");
					$no++;
					foreach ($guruku as $dtguru)	{ 
					$tt=mysqli_query($koneksi,"SELECT * FROM rating WHERE id_guru='$dtguru[id_guru]'");
					$hits=mysqli_num_rows($tt); 
					$jml=mysqli_query($koneksi,"SELECT SUM(nilai) AS jumlah FROM rating WHERE id_guru='$dtguru[id_guru]'");
					$jl=mysqli_fetch_array($jml);
					$jh=$jl['jumlah'];
					$jt=FLOOR($jh/$hits);
					?>
                <tr>
                  <td><?= $no++;?></td>
				  <td><?= $dtguru['nama']?></td>
                  <td>
				  <?php if ($jt > 0 && $jt <= 10) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:60px;height:19px'>"; ?>
				<?php }elseif ($jt > 10 && $jt <= 20) { ?>
				<?php echo "<img src='$homeurl/guru/rating/2.png' style='width:60px;height:19px'>"; ?>
				<?php }elseif ($jt > 20 && $jt <= 30) { ?>
				<?php echo "<img src='$homeurl/guru/rating/3.png' style='width:60px;height:19px'>"; ?>
				<?php }elseif ($jt > 30 && $jt <= 49) { ?>
				<?php echo "<img src='$homeurl/guru/rating/35.png' style='width:60px;height:19px'>"; ?>
				<?php }elseif ($jt >= 50 && $jt <= 74) { ?>
				<?php echo "<img src='$homeurl/guru/rating/4.png' style='width:60px;height:19px'>"; ?>
				<?php }elseif ($jt >= 75 && $jt <= 89) { ?>
				<?php echo "<img src='$homeurl/guru/rating/45.png' style='width:60px;height:19px'>"; ?>
				<?php }elseif ($jt >= 90 && $jt <= 100) { ?>
				<?php echo "<img src='$homeurl/guru/rating/5.png' style='width:60px;height:19px'>"; ?>
				<?php }else{ ?>
				<?php echo "<img src='$homeurl/guru/rating/0.png' style='width:60px;height:19px'>"; ?>
				<?php } ?>
				  </td>
                  <td><span class="badge"><strong><b><?= $hits ?></b></strong></span><sub> Siswa</sub></td>
                  <td>
				  <a href="?pg=detailrating&tahun=&kelas=null&guru=<?= $dtguru['id_guru']?>">
                  <button class="btn btn-info oke"><i class="fa fa-eye"></i></button>
				  </a>
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


