<?php
if(empty($_GET['tahun'])){
  $akti1 = 'class="active"';
  $akti2 = 'in active';
}
else{
  $akti3 = 'class="active"';
  $akti4 = 'in active';
}

?>

<div class='row'>
  <div class="col-md-12"> 
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit"></i>Absen Sekolah</h3>
      </div>
      <div class='box-body'>
      <ul class="nav nav-tabs">
        <li <?= $akti1 ?>><a data-toggle="tab" href="#home"><i class="fa fa-plus"></i> Menu Absen Sekolah</a></li>
        <li <?= $akti3 ?>><a data-toggle="tab" href="#menu1"><i class="fa fa-check"></i> Rekap Absensi</a></li>
      </ul>
      <div class="tab-content">
        <div id="home" class="tab-pane fade <?= $akti2 ?>">
          <?php 
             $jamsekolah2 = $dbb->getJamSekolah();
             $jam_masuk = strtotime($jamsekolah2['jamIn']); 
             $jam_pulang = strtotime($jamsekolah2['jamOut']); 
              $jamsekarang = strtotime(date("H:i"));
              //$jamsekarang = strtotime(date("H:i","06:00:00"));
             if($jamsekarang >= $jam_masuk){
             ?>
            <div class="row">
              <div class="col-md-12"> 
              <div class="form-group">
                  <label for="email">Tanggal Absen Hari Ini</label>
                  <input data-idkelas="<?= $kelasdb['idkls']?>" data-idsiswa="<?= $siswa['id_siswa']?>" id="tgl" type="text" readonly="readonly" value="<?php  echo date("d-m-Y") ?>" class="form-control" id="tgl">
                </div>
                <?php if($siswa['id_siswa'] == $_SESSION['id_siswa'] AND $siswa['status_siswa'] ==1) {?>
                <button id="absen" class="btn btn-primary"><i class="fa fa-check"></i> Klik untuk mengisi absen</button>
                <?php } else { ?>
                <button disabled class="btn btn-danger"> <marquee> <b>Maaf !!</b> Menu absen terkunci, ada tugas belum diselesaikan. Silakan menghubungi admin</marquee></button>
	            <?php } ?>
              </div>
            </div>
           <br>
           <?php if($setting['izi_foto_absen']==1){ ?>
           <div class="row">
             <div class="col-md-12"> 
                <div class="alert alert-info">
                Klik absen terlebih dahulu sebelum upload foto
                </div>
               <form id='formjawaban'>    
                  <div class="form-group">
                    <label for="">Pastikan foto dengan posisi HP landscape/miring</label><br>
                    <input type="file" class="form-control-file" name="file" aria-describedby="fileHelpId">
                    <small id="fileHelpId" class="form-text text-muted">Klik Pilih File Untuk Upload Foto</small>
                  </div>
                    <button class="btn btn-info"><i class="fa fa-upload"></i> Klik Untuk Upload Foto Absen</button>
                </form>
              </div>
            </div> 
         <?php } }
         
         else{ ?>
          <div class="row" style="padding-top: 10px;">
            <div class="col-md-12">
              <div class="alert alert-info">
                  <?php if($siswa['id_siswa'] == $_SESSION['id_siswa'] AND $siswa['status_siswa'] ==1) {?>
                  Belum Waktunya Absen, Silakan Periksa Kembali Jadwal Pelajaran Hari Ini <br>
                  <?php } else { ?>
                  <marquee><b> Maaf !!</b> Menu absen terkunci, ada tugas belum diselesaikan. Silakan menghubungi admin</marquee>
	            <?php } ?>
                </div>
            </div>
          </div>
         <?php }?>
        </div>
        <div id="menu1" class="tab-pane fade <?= $akti4 ?>" >
          <br>
          <div class="row" style="padding-bottom: 10px ">
            <div class="col-md-2" style="padding-bottom: 3px">
              <select id="tahun" class="form-control select2 ">
                <?php $kelas = $dbb->getTahun(); ?>
                  <option value=""> Pilih Tahun</option>
                  <?php foreach ($kelas as $value) : ?>
                    <option <?= selectAktif($value['tahun'],$_GET['tahun']) ?> value="<?= $value['tahun'] ?>"><?= $value['tahun'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2" style="padding-bottom: 3px">
              <select id="bulan" class="form-control select2 ">
                  <option value=""> Pilih Bulan</option>
                  <?php for ($i=1; $i <=12 ; $i++) { ?>
                    <option <?= selectAktif($i,$_GET['bulan']) ?> value="<?= $i ?>"><?= bulanIndo($i) ?></option>
                    <?php } ?>
              </select>
            </div>
            <div class="col-md-2" style="padding-bottom: 3px">
              <button id="cari_absen" class="btn btn-info"> Cari Data Absen</button>
            </div>

          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="tableabsen">
              <thead>
                  <tr>
                    <th>NO</th>
                    <?php if($setting['izi_foto_absen']==1){ ?>
                    <th>FOTO</th>
                    <?php } ?>
                    <th>NAMA SISWA</th>
                    <th>KELAS</th>
                    <th>TANGGAL</th>
                    <th>JAM MASUK</th>
                    <th>JAM PULANG</th>
                    <th>STATUS ABSEN</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $absen = $dbb->getAbsenDetail();
                  $no=1;
                  foreach ($absen as $abs ) { ?>
                  <tr>
                    <td><?= $no++;?></td>
                    <?php if($setting['izi_foto_absen']==1){ ?>
                    <td><a href="<?= $homeurl.'/'.$abs['absUrlFoto'] ?>" target="_blank"><img width="50" src="<?= $homeurl.'/'.$abs['absUrlFoto'] ?>" class="img-thumbnail img-responsive" alt="Kosong"></a></td> 
                    <?php } ?>
                    <td><?= $abs['namasiswa'] ?></td>
                    <td><?= $abs['nama'] ?></td>
                    <td><?= date('d-m-Y',strtotime($abs['absTgl'])) ?></td>
                    <td><?= JamNull($abs['absJamIn']) ?></td>
                    <td><?= JamNull($abs['absJamOut']) ?></td>
                    <td><?= $abs['absStatus'] ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
       
      </div>
     
</div>
</div>
<script type="text/javascript">
  var tabel = $('#tableabsen').dataTable();
$(document).on('click', '#cari_absen', function() {
    var tahun = $('#tahun').val();
    var bulan = $('#bulan').val();
    var siswa = "<?= $_SESSION['id_siswa'] ?>";
	if(tahun=='' || bulan==''){
	alert('Silahkan Pilih Tahun, bulan Terlebih Dahulu');
	}else{
    location.replace("?tahun="+tahun+"&bulan="+bulan+"&siswa="+siswa);
	}
  });
  $(document).on('click', '#absen', function() {
    var tgl = $('#tgl').val();
    var siswa = $('#tgl').data('idsiswa');
    var kelas = $('#tgl').data('idkelas');
    $.ajax({
      type: 'POST',
      url: '../_absen.php',
      data: 'tgl='+tgl+'&idsiswa='+siswa+'&idkls='+kelas,
      success: function(response) {
        console.log(response);
        if(response ==1){
            toastr.success('Absensi Berhasil Hari Ini <br>'+tgl);
        }
        else if(response ==0){
          toastr.error('Upss Gagal Absen');
        }
        else{
          toastr.warning('Kamu sudah Absen Hari Ini <br> '+tgl);
        }
      }
    });
  });
  $('#formjawaban').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var homeurl = '<?= $homeurl ?>';

      $.ajax({
        type: 'POST',
        url: homeurl + '/_absen_foto.php',
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
          if (data == 1) {
            //$('.loader').hide();
            toastr.success("Berhasil Upload Foto Absen Sekolah");
            setTimeout(function () { location.reload(1); }, 2000);
          } 
          else if(data == 0){
            $('.loader').hide();
            toastr.warning("Klik Absen Sekolah Terlebih Dahulu");
          }
          else if(data == 99){
            $('.loader').hide();
            toastr.error("Pastikan File Bertipe Gambar");
          }
          else {
            $('.loader').hide();
            toastr.error("Gagal Upload Foto Absen Sekolah");
          }
           }
      });
      return false;
    });

</script>
