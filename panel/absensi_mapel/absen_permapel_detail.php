
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border '>
        <h3 class='box-title'>Daftar Absen Mapel Detail </h3>
        <div class='box-tools pull-right '>
          <?php if(!empty($_GET['tahun'])){?>
            <button onclick="frames['frameresult'].print()" target="_blank"  class="btn btn-sm btn-info"><i class="fa fa-download"></i> Print Absen Bulan</button>
          <button id="down_excel" class="btn btn-sm btn-warning"><i class="fa fa-download"></i> Download Excel Absen Detail</button>
          <?PHP } ?>
        </div>
      </div>
      <iframe id='loadframe' name='frameresult' src="cetak_absen_mapel_detail.php?tahun=<?=$_GET['tahun']?>&bulan=<?=$_GET['bulan']?>&mapel=<?=$_GET['mapel']?>" style='border:none;width:1px;height:1px;'></iframe>
      <div class='box-body'>
        <div  class='table-responsive' id='tabletugas2' style="">
          <div class='form-group'>
            <div class="form-group">
              <div class="row">
                <div class="col-md-3">
                  <select class="form-control select2 level" id="mapel" name="mapel">
                    <option value=""> Pilih Mapel</option>
                    <?php $db2 = $db->get_absen_mapel_by_id(); 
                      foreach ($db2 as $value) { ?>
                      <option <?= selectAktif($value['amIdMapel'],$_GET['mapel']) ?> value="<?= $value['amIdMapel']; ?>"><?= $value['amSlag']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-2" style="padding-bottom: 3px">
                  <select id="tahun" class="form-control select2 ">
                    <?php $kelas = $db->getTahun(); ?>
                    <option value="all"> Pilih Tahun</option>
                    <?php foreach ($kelas as $value) : ?>
                      <option <?= selectAktif($value['thKode'],$_GET['tahun']) ?> value="<?= $value['thKode'] ?>"><?= $value['thKode'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-2" style="padding-bottom: 3px">
                  <select id="bulan" class="form-control select2 ">
                    <option value="all"> Pilih Bulan</option>
                    <?php for ($i=1; $i <=12 ; $i++) { ?>
                      <option <?= selectAktif($i,$_GET['bulan']) ?> value="<?= $i ?>"><?= bulanIndo($i) ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-2" style="padding-bottom: 3px">
                  <select id="tgl" class="form-control select2 ">
                    <option value="all"> Pilih Tanggal</option>
                    <?php for ($i=1; $i <=31 ; $i++) { ?>
                      <option <?= selectAktif($i,$_GET['tgl']) ?> value="<?= $i ?>"><?= $i ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-2" style="padding-bottom: 3px">
                  <button id="cari_absen" class="btn btn-info"> Cari Data Absen</button>
                </div>
              </div>
            </div>
          </div>
          <table id='tableabsenmapel' class='table table-bordered table-hover'>
            <thead class="title_bar_table">
              <tr>
                <th width='5px'>#</th>
                <th >Nama Siswa</th>
                <th >Kelas</th>
                <th >Mata Pelajaran</th>
                <th style="text-align: center;">Hari Mapel</th>
                <th style="text-align: center;">Tanggal</th>
                <th style="text-align: center;">Jam Absen</th>
                <th style="text-align: center;">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($db->get_absen_siswa_mapel() as $vl) { ?>
                <tr>
                  <td><?= $no++;?></td>
                  <td><?= $vl['nama']?></td>
                  <td><?= $vl['id_kelas']?></td>
                  <td><?= $vl['amNamaMapel']?></td>
                  <td><?= HariIndo($vl['amHari'])?></td>
                  <td><?= buat_tanggal('d-m-Y',$vl['amaTgl']) ?></td>
                  
                  <td><?= $vl['amaJamIn']?></td>
                  <td><?= $vl['amaStatus']?></td>
                  
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
    $(document).on('click', '#cari_absen', function() {
      var tahun = $('#tahun').val();
      var bulan = $('#bulan').val();
      var mapel = $('#mapel').val();
      var tgl = $('#tgl').val();
      if(tahun=='' || mapel==''){
        alert('Silahkan Pilih Mapel. Tahun, Bulan Terlebih Dahulu');
      }
      else{
      location.replace("?pg=absen_permapel_detail&tahun="+tahun+"&bulan="+bulan+"&mapel="+mapel+"&tgl="+tgl);
      }
    });
    $('.editabsmapel').click(function() {
      var id = $(this).data('id');
      var mapel = $(this).data('nama');
      var jamin = $(this).data('jamin');
      var jamout = $(this).data('jamout');
      var hari = $(this).data('hari');
      $('#id').val(id);
      $('#jamin2').val(jamin);
      $('#jamout2').val(jamout);
      $('#mapel').val(mapel);
      $('#hari2').val(hari).change();
    });
    $('.hapusabsmapel').click(function() {
      var id = $(this).data('id');
      if (confirm("Yakin Akan Di Hapus Ini Absen Mapel ? Semua Absen Siswa dengan Mapel Ini Akan Terhapus Juga")) {
      $.ajax({
          type: 'POST',
           url: 'core/c_aksi.php?absen_mapel=delet',
          data: {id:id},
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Hapus Absen Mapel');
              setTimeout(function () { location.reload(1); }, 1500);
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
      }
    });

    $('#tableabsenmapel').DataTable({
      "lengthMenu": [[10,20,30,50, -1], [10,20,30,50, "All"]]
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
    $('#table_materi').DataTable({
        pageLength: 25,
      });
     $('.level').change(function() {
        var idlevel = $(this).val();
        $("#idmapel").empty();
        $("#idkelas").empty();
        $.ajax({
          url: 'core/c_aksi.php?absen_mapel=getmapel',
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
          url: 'core/c_aksi.php?absen_mapel=getkelas',
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
      var pesan ="absensi_mapel";
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: 'core/c_aksi.php?absen_mapel=insert',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Tambah Absen Mapel');
              setTimeout(function () { location.reload(1); }, 1000);
            }
            else if(respon==99){
              toastr.warning('Absen Mapel Dengna Kelas ini Sudah ada');
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
      var pesan ="absensi_mapel";
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: 'core/c_aksi.php?absen_mapel=update',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Update Absen Mapel');
              setTimeout(function () { location.reload(1); }, 1000);
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
        filename: "data_absen_permapel_detail.xls",
        fileext: ".xls",
        //preserveColors: preserveColors,
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
       // preserveColors:true

      });
    });


  } );
</script>


