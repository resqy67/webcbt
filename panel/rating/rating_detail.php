<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<div class='row'>
		<div class='col-md-12'>
			<div class='box box-solid '>
				<div class='box-header with-border '>
					<h3 class='box-title'><i class='fa fa-briefcase'></i> FILTER RATING </h3>
					<div class='box-tools pull-right '>
						
					</div>
				</div><!-- /.box-header -->

				<div class='box-body'>
					<label>Di Sarankan Untuk Filter Data </label><br>

					<small id="fileHelpId" class="form-text text-muted">Silhakan Pilih Berdasarkan Kelas Atau Nama Guru</small>
					<div class="row" style="padding-bottom: 10px">
					<div class="col-md-2" style="padding-bottom: 3px">
							<select id="tahun" class="form-control select2 ">
								<?php $kelas = $db->getTahun(); ?>
									<option value=""> Pilih Tahun</option>
									<?php foreach ($kelas as $value) : ?>
										<option <?= selectAktif($value['thKode'],$_GET['tahun']) ?> value="<?= $value['thKode'] ?>"><?= $value['thKode'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-2" style="padding-bottom: 3px">
							<select id="kelas" class="form-control select2 kelas">
								<?php $kelas = $db->v_kelas(); ?>
									<option value="null"> Pilih Kelas</option>
									<?php foreach ($kelas as $value) : ?>
										<option <?= selectAktif($value['idkls'],$_GET['kelas']) ?> value="<?= $value['idkls'] ?>"><?= $value['nama'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div class="col-md-2" style="padding-bottom: 3px">
							<select id="guru" class="form-control select2">
								<?php $kelas = $db->v_pengawass(); ?>
									<option value="null"> Pilih Guru</option>
									<?php foreach ($kelas as $value) : ?>
										<option <?= selectAktif($value['id_pengawas'],$_GET['guru']) ?> value="<?= $value['id_pengawas'] ?>"><?= $value['nama'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<!--<div class="col-md-2" style="padding-bottom: 3px">
							<select id="siswa" class="form-control select2 siswa">
								<option value="null">Pilih Siswa</option>
							</select>
						</div>-->
					</div>
					<div class="row" style="padding-bottom: 10px">
						<div class="col-md-6">
							<button id="cari_absen" class="btn btn-info"> Cari Rating</button>
							<?php 
							if(!empty($_GET['tahun'])){ ?>
							<button id="down_excel" class="btn btn-warning"><i class="fa fa-download"></i> Download Excel </button>
							<!--<button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button>-->
						<?php } ?>
						</div>
					</div>
					<div id='tablereload' class='table-responsive'>
						<table id='tableabsen' class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='5px'><input type='checkbox' id='ceksemua'></th>
									<th width='5px'>#</th>
									<th >Siswa</th>
									<th >Kelas</th>
									<th >Kepada</th>
									<th >Alasan</th>
									
									
								</tr>
							</thead>
							<tbody>
							<?php 
							$absen = $db->getRatDet();
							$no=1;
							foreach ($absen as $abs ) { 
							$ns=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM siswa where id_siswa='$abs[id_siswa]'"));
							$nku=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas INNER JOIN rating ON rating.id_kelas=kelas.idkls where idkls='$abs[id_kelas]'"));
							?>
								<tr>
									<td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-$no' value="<?= $abs['id_siswa'] ?>"></td>
									<td><?= $no++;?></td>
									<td><?= $ns['nama'] ?></td>
									<td><?= $nku['nama'] ?></td>
									<td><?= $abs['nama'] ?></td>
									<td><?= $abs['alasan'] ?></td>
									
									
								</tr>
							<?php } ?>
								
							</tbody>
						</table>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
</div>

<iframe id='loadframe' name='frameresult' src="cetak_rating_detail.php?tahun=<?= $_GET['tahun']; ?>&bulan=<?= $_GET['bulan']; ?>&guru=<?= $_GET['guru']; ?>&tgl=<?= $_GET['tgl']; ?>" style='border:none;width:1px;height:1px;'></iframe>

<script type="text/javascript">
	$(document).on('click', '.editabsen', function() {
		var idsiswa = $(this).data('idsiswa');
		$("#idsiswae").val(idsiswa);
		
	});
	$(document).on('click', '.hapusabsen', function() {
    var idabsen = $(this).data('idabsen');
    $.ajax({
				url: 'core/c_aksi.php?absen=delabsen',
				method : "POST",
				data : {idabsen:idabsen},
				beforeSend:function(){
     				return confirm("Apakah Yakin Akan di Hapus Absen Ini ?");
				},
				success: function(response){
					console.log(response);
					if(response ==1){
            toastr.success('Absensi Berhasil Di Hapus ');
            location.reload();
	        }
	        else if(response ==0){
	          toastr.error('Upss Gagal Hapus Absen');
	        }
	        else{
	          toastr.warning('eror sistem');
	        }
				}

			});
	});
	$(document).on('click', '#edit_absen', function() {
		var status_absen = $('#status_absen').val();
    var idsiswa = $('#idsiswae').val();
    $.ajax({
				url: 'core/c_aksi.php?absen=upabsen',
				method : "POST",
				data : {status_absen: status_absen,idsiswa:idsiswa},
				success: function(response){
					//console.log(data);
					if(response ==1){
            toastr.success('Absensi Berhasil Di Edit ');
            // $("#tablereload").load(" #tablereload > *");
            location.reload();
	        }
	        else if(response ==0){
	          toastr.error('Upss Gagal Edit Absen');
	        }
	        else{
	          toastr.warning('eror sistem');
	        }
				}

			});
	});

	$(document).on('click', '#cari_absen', function() {
    var tahun = $('#tahun').val();
    var kelas = $('#kelas').val();
    var guru = $('#guru').val();
   //if(tahun==''){
        //alert('Silahkan Pilih Tahun');
     // }
     // else{
	location.replace("?pg=detailrating&tahun="+tahun+"&kelas="+kelas+"&guru="+guru);
	
	//}
    //location.replace("?pg=detailjurnal&tahun="+tahun+"&bulan="+bulan+"&guru="+kelas+"&tgl="+tgl+"&siswa="+siswa);
  });
  
  var tabel = $('#tableabsen').dataTable({
  	"aLengthMenu": [[10,50,100,200,300,-1], [10,50,100,200,300,"All"]],
  });
  
  $(document).on('click','#down_excel',function(){
		$("#tableabsen").table2excel({
        filename: "data_jurnal_filter.xls",
        fileext: ".xls",
        //preserveColors: preserveColors,
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
       // preserveColors:true

      });
 
	});
	$('#kelas').change(function(){
			var id=$(this).val();
			//alert(id);
			$.ajax({
				url: 'core/c_aksi.php?absen=getsiswa',
				method : "POST",
				data : {id: id},
				async : false,
				dataType : 'json',
				success: function(data){
					//console.log(data);
					var html = '';
					var i;
					html +='<option value="null">Pilih Siswa</option>';
					for(i=0; i<data.length; i++){
						html += '<option value='+data[i].idsiswa+'>'+data[i].namasiswa+'</option>';
					}
					$('#siswa').html(html);
				}

			});
			return false;

		});
</script>
	