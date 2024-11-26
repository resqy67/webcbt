<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php
 
 if(!empty($_GET['id_mapel'])){
 		$id = $_GET['id_mapel'];
 }
 else{
 	$id="";
 }

 if(!empty($_GET['kls'])){
 		$idkls = $_GET['kls'];
 }
 else{
 	$idkls="";
 }
 if(!empty($_GET['jrs'])){
 		$idjrs = $_GET['jrs'];
 }
 else{
 	$idjrs="";
 }

$nm_mapel = $db->v_nm_mapel($id);
$nilai= $db->v_nilai($id,$idkls,$idjrs);

$no10=$no30=$no50=$no70=$no90=$no100=0;
while($data=mysqli_fetch_array($nilai)){
	$total = $data['skor']+$data['nilai_esai'];
	if($total <= 10){
		$no10++;
	}
	else if($total > 10 && $total <= 30){
		$no30++;
	}
	else if($total > 30 && $total<= 50){
		$no50++;
	}
	else if($total > 50 && $total <= 70){
		$no70++;
	}
	else if($total > 70 && $total <= 90){
		$no90++;
	}
	else if($total > 50 && $total <= 100){ 
		$no100++;
	}
	else{

	}
}

?> 
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid '>
			<div class='box-header with-border '>
				<h3 class='box-title'><i class='fa fa-briefcase'></i> Perbaikan</h3>
			</div><!-- /.box-header -->
			<div class="row" style="padding-left: 10px;">
				<div class="col-md-12">
					<legend style="font-size: 15px;">Pilih salah satu, Kelas atau Jurusan</legend>
				</div>
			</div>
			<div class="row" style="padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
				<?php if($setting['jenjang']=='SMK'): ?>
				<div class="col-md-3">
					<select class="form-control select2 jurusan">
						<?php $jurusan = $db->v_jurusan(); ?>
						<option value=""> Pilih Jurusan</option>
						<?php foreach ($jurusan as $jrs) : ?>
							<option <?php if($idjrs==$jrs['id_pk']){ echo "selected";}else{} ?> value="<?= $jrs['id_pk'] ?>"><?= $jrs['id_pk'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<?php else : ?>
							<select class="jurusan" style="display: none;">
								<option value="" selected="selected"></option>
							</select>
				<?php endif; ?>
				<div class="col-md-3">
					<select class="form-control select2 kelas">
						<?php $kelas = $db->v_kelas(); ?>
						<option value=""> Pilih Kelas</option>
						<?php foreach ($kelas as $value) : ?>
							<option <?php if($idkls==$value['id_kelas']){ echo "selected";}else{} ?>  value="<?= $value['id_kelas'] ?>"><?= $value['nama'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-3">
					<select class="form-control select2 ujian">
						<?php $ujian = $db->v_jadwal(); ?>
						<option> Pilih Jadwal</option>
						<?php foreach ($ujian as $uj) : ?>
							<option <?php if($id==$uj['id_mapel']){ echo "selected";}else{} ?> value="<?= $uj['id_mapel'] ?>"><?= $uj['nama'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-3">
					<button id="cari_nilai" class="btn btn-info"><i class="fa fa-search"></i> Cari Data</button>
				</div>
			</div>
			<div class='box-body'>
				<?php if(empty($id)){ }else{ ?>
				<div class="row" style="padding-bottom: 10px;">
					<div class="col-md-6">
						<a id="down_excel"  class='btn btn-sm btn-success' ><i class="fa fa-download"></i> Download to Excel</a>
					</div>
				</div>
				<?php }?>
				<div class="row">
					<div id="tbexcel" class="col-md-12">
						<div style="padding-bottom: 20px;">Mapel : &nbsp;&nbsp;<b><?= $nm_mapel['nama']?></b></div>
						<div class='table-responsive'>
						<table id='table_ranking' class='table table-striped'>
							<thead>
								<tr>
									<th>Peringkat</th>
									<th>Nama Siswa</th>
									<th>Kelas</th>
									<th>Jurusan</th>
									<th>Mapel</th>
									<th>Nilai PG</th>
									<th>Nilai Essai</th>
									<th>Total</th>
									<th>KKM</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=1; 
								$rangking = $db->nilai_ranking($id,$idkls,$idjrs);
								if(empty($rangking)){

								}
								else{
								foreach ($rangking as $key => $value) {
									$total = $value['skor']+$value['nilai_esai'];
									if($total >= $value['kkm']){
										$kkm = "<span>Lulus KKM</sapn>";
									}
									else{
										$kkm = "<span>Tidak Lulus KKM</sapn>";
									}
								?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= $value['nama_siswa'] ?></td>
									<td><?= $value['id_kelas'] ?></td>
									<td><?= $value['idpk'] ?></td>
									<td><?= $value['nama'] ?></td>
									<td><?= $value['skor'] ?></td>
									<td><?= $value['nilai_esai'] ?></td>
									<td><?= $total ?></td>
									<td><?= $value['kkm'] ?></td>
									<td><?= $kkm ?></td>
									<td><button data-nilai="<?= $value['id_nilai'] ?>" data-esai="<?= $value['nilai_esai'] ?>" data-skor="<?= $value['skor'] ?>" data-id="<?= $value['id_siswa'] ?>" data-mapel="<?= $_GET['id_mapel'] ?>" data-toggle='modal' data-target='#edit_nilai' class="fa fa-edit btn btn-success e_nilai"></button></td>
								</tr>
								
						
								<?php $no++; } } ?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='modal fade' id='edit_nilai' style='display: none;'>

	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header bg-maroon'>
				<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
				<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Perbaikan Nilai</h4>
			</div>
			<!-- tambah jadwal asja -->
			<div class='modal-body'>
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#table_ranking").DataTable({});

	// $('.simpan_nilai').click(function(){
			
	// 		var id = $(this).data('id');
	// 		var mapel= $(this).data('mapel');

	// 		var pg= $('.pg').val();

	// 		var esai= $('.esai').val();
			
	// 		$.ajax({
	// 		type: 'POST',
	// 		url: 'c_aksi.php?nilai=remidi',
	// 		data: {id:id,mapel:mapel,pg:pg,esai:esai},
	// 		success: function(data) {
	// 			alert(data);
	// 			// console.log(data);
	// 			// if (data == "OK") {
	// 			// 	toastr.success("jadwal berhasil dibuat");
	// 			// } else {
	// 			// 	toastr.error("jadwal gagal tersimpan");
	// 			// }
	// 			// $('#tambahjadwal').modal('hide');
	// 			// $('#bodyreset').load(location.href + ' #bodyreset');
	// 		}
	// 	});

	// });


	$('#cari_nilai').click(function(){
		var kelas = $('.kelas').val();
		var ujian = $('.ujian').val();
		var jrs = $('.jurusan').val();
	
		if(kelas =="" && jrs != ""){
			location.replace("?pg=anso_perbaikan&id_mapel="+ujian+"&jrs="+jrs);
		}
		else if(jrs =="" && kelas != ''){
			location.replace("?pg=anso_perbaikan&id_mapel="+ujian+"&kls="+kelas);
		}
		else{
			alert("Uppps Pilih Kelas Atau Jurusan Salah Satu");
		}

	});

	$(document).on('click','#down_excel',function(){
		$("#tbexcel").table2excel({
        //filename: "data_absen_<?php echo $bulan; ?>" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
        filename: "data_analisi_perbaiakan_<?php echo $d['nama']; ?>.xls",
        fileext: ".xls",
        //preserveColors: preserveColors,
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
        //preserveColors:true
      });
 
	});
	$(document).on("click", ".e_nilai", function (a){
    a.preventDefault();
    $.post('anso/anso_perbaikan_pop.php',{ 
        id:$(this).data('id'),
        id_mapel:$(this).data('mapel'),
        skor:$(this).data('skor'),
        esai:$(this).data('esai'),
        id_nilai:$(this).data('nilai')
      }, 
        function(cek){
        $(".modal-body").html(cek); 
        //alert(cek);
      } );
	});

</script>
                      


