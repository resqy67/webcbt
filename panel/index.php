<?php
/*
bisa di cai dengan ctrl+f
$pg
aksi yang di $pg
	1.''
	2.dataserver
	3.sinkrondapo
	4.sinkron
	5.sinkronset
	6.informasi
	7.dataujian
	8.filemanager
	9.filemanager2
	10.matapelajaran
	11.token
	12.pengumuman
	13.guru
	14.beritaacara
	15.jadwal
	16.berita
	17.nilai
	18.nilai2
	19.semuanilai
	20.susulan
	21.status
	22.status2
	23.kartu
	24.dena
	25.absen
	26.siswa
	27.uplfotosiswa
	28.importmaster
	29.importguru
	30.pengawas
	31.pk
	32.jenisujian
	33.ruang
	34.level
	35.sesi
	36.kelas
	37.banksoal
	38.editguru
	39.reset
	40.pengacak
	41.pengaturan
	42.block
	43.siswa_kelas
	44.anso ->analisa soal
	45.anso_niali ->analisa nilai
*/

//require("../config/config.default.php");
require("../config/config.asja.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
require("../config/excel_reader2.php");
include("core/c_admin.php"); 
function selectAktif($data1=null,$data2=null)
{
    //untuk select option
    $selected = 'selected="selected"';
    if(!$data1==null){
        if($data1==$data2){ echo $selected;  }else{ echo"";}
    }
} 

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;
$pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$id_pengawas'"));

(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
(isset($_GET['ac'])) ? $ac = $_GET['ac'] : $ac = '';


if ($pg == 'banksoal' && $ac == 'input') :
	$sidebar = 'sidebar-collapse';
elseif ($pg == 'nilai' && $ac == 'lihat') :
	$sidebar = 'sidebar-collapse';
elseif ($pg == 'semuanilai' && $ac == 'lihat') :
	$sidebar = 'sidebar-collapse';
elseif ($pg == 'status2') :
	$sidebar = 'sidebar-collapse';
elseif ($pg == 'nilai2') :
	$sidebar = 'sidebar-collapse';
else :
	$sidebar = '';
endif;

$nilai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai"));
$nilaiPindahJum = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai_pindah"));
$bank_soal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mapel"));
$soal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal"));
$siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa"));
$ruang = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM ruang"));
$nilai_pindah = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai_pindah"));
$kelas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas"));
$mapel = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran"));
$tugas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas"));
$materi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM materi2"));

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<title><?= $setting['sekolah'] ?></title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link rel='shortcut icon' href='../<?php echo $setting['logo']; ?>' />
	<link rel='stylesheet' href='<?= $homeurl ?>/dist/bootstrap/css/bootstrap.min.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/fontawesome/css/all.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/select2/select2.min.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/dist/css/AdminLTE.css' />
	<link rel="icon" type="image/png" href="../favicon.ico" />
	<link rel='stylesheet' href='<?= $homeurl ?>/dist/css/skins/skin-green-light.min.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/jQueryUI/jquery-ui.css'>
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/iCheck/square/green.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/slidemenu/jquery-slide-menu-admin.css'>
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'>
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/datatables/extensions/Select/css/select.bootstrap.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/animate/animate.min.css'>
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/datetimepicker/jquery.datetimepicker.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/notify/css/notify-flat.css' />
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/sweetalert2/dist/sweetalert2.min.css'>
	<link rel='stylesheet' href='<?= $homeurl ?>/plugins/toastr/toastr.min.css'>
	<link rel='stylesheet' href='<?= $homeurl ?>/dist/css/costum.css' />
	<link href="<?= $homeurl ?>/plugins/summernote/summernote-bs4.css" rel="stylesheet">
	<script src='<?= $homeurl ?>/plugins/tinymce/tinymce.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/jQuery/jquery-3.1.1.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/datatables/jquery.dataTables.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/datatables/extensions/Select/js/dataTables.select.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/datatables/extensions/Select/js/select.bootstrap.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/jstoexcel/jquery.table2excel.js'></script>
	<script src="<?= $homeurl ?>/plugins/summernote/summernote-bs4.js"></script>
	<!-- <style type='text/css' media='print'>
		.page {
			-webkit-transform: rotate(-90deg);
			-moz-transform: rotate(-90deg);
			filter: 'progid:DXImageTransform.Microsoft.BasicImage(rotation=3)';
		}
	</style> -->
	<style type="text/css">
		.skin-green-light .sidebar-menu>li:hover>a, .skin-green-light .sidebar-menu>li.active>a{
			color: #fff;
			background:#0030a7;
			<?php 
			if($setting['jenjang'] =='SMK' ){
				echo "color: #000;";
				echo "background:#00a896;";
			}
			elseif($setting['jenjang'] =='SMP'){
				echo "color: #000;";
				echo "background:#00a896;";
			}
			elseif($setting['jenjang'] =='SD'){
				echo "color: #000;";
				echo "background:#00a896;";
			}
			else{
				echo "color: #fff;";
				echo "background:#00a896;";
			}
			?>
		}
		.loading {
	  position: absolute;
	  left: 50%;
	  top: 70%;
	  transform: translate(-50%,-50%);
	  font: 14px arial;
	  }
	</style>
</head>

<body class='hold-transition skin-green-light sidebar-mini fixed <?= $sidebar ?>'>
	<div id='pesan'></div>
	<div class='loader'>
		<div class="loading">
   	 <p id="pesanku" >Harap Tunggu</p>
  	</div>
	</div>
	<div class='wrapper'>
		<header class='main-header'>
			<?php include('tamplate_menu/header_menu.php'); ?>
		</header>

		<aside class='main-sidebar' >
			<?php include('tamplate_menu/sidebar_menu.php'); ?>
		</aside>
		<?php 
		if($setting['jenjang'] =='SMK' ){
			$style="height:85px;z-index:0; background: linear-gradient(to left, #05405a, #00a896)";
			// $style="background-color: #02305d; background-image: linear-gradient(141deg, #9fb8ad 0%, #02305d 51%, #02305d 75%);color: white;opacity: 0.95;";
		}
		elseif($setting['jenjang'] =='SMP'){
		$style="height:85px;z-index:0; background: linear-gradient(to left, #4169E1, #E6E6FA)";
		}
		elseif($setting['jenjang'] =='SD'){
			$style="height:85px;z-index:0; background:#c74230;";
		}
		else{
			$style="height:85px;z-index:0; background:#00a896;";
		}
		?>
		<div class='content-wrapper' style='background-image: url(backgroun.jpg);background-size: cover;'>
			<section class='content-header' style="<?= $style; ?>" >
				<h1 style='text-shadow: 2px 2px 4px #827e7e;color:#000'>
		<?php if($setting['kodesekolahid'] ==$setting['sekolah']){ ?>
				    <?php if($setting['izin_ujian']==0){ ?>
					&nbsp;<span class='hidden-xs'><?= $setting['namapjj'] ?> - <?=$setting['sekolah']?></span>
					<?php }else{ ?>
					&nbsp;<span class='hidden-xs'><?= $setting['aplikasi'] ?> - <?=$setting['sekolah']?></span>
					<?php } ?>
				</h1><?php }else{ ?> <span style="font-size: 20px;"><b><font color='red'>LISENSI TIDAK VALID</b></font><?php } ?><br>
				<div style='float:right; margin-top:-37px'>
					<button class='btn  btn-flat  bg-purple'><i class='fa fa-calendar'></i> <?= buat_tanggal('D, d M Y') ?></button>
					<button class='btn  btn-flat  bg-maroon'><span id='waktu'><?= $waktu ?></span></button>
				</div>
				<div class='breadcrumb'></div>
				<br><br><br>
			</section>
			<section class='content' style="margin-top:-65px">
				<?php if ($pg == '') : ?>
					<?php
					$testongoing = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai WHERE ujian_mulai!='' AND ujian_selesai=''"));
					$testdone = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai WHERE ujian_mulai!='' AND ujian_selesai!=''"));

					if ($siswa <> 0) {
						$testongoing_per = (1000 / $siswa) * $testongoing;
						$testongoing_per = number_format($testongoing_per, 2, '.', '');
						$testongoing_per = str_replace('.00', '', $testongoing_per);
						$testdone_per = (1000 / $siswa) * $testdone;
						$testdone_per = number_format($testdone_per, 2, '.', '');
						$testdone_per = str_replace('.00', '', $testdone_per);
					} else {
						$testongoing_per = $testdone_per = 0;
					}
					?>
					<?php if ($pengawas['level'] == 'admin') : ?>
    <div class='row'>
        <div class="col-md-9">
            <div class='row'>
                <div class="col-md-4">
                    <div class="small-box bg-blue ">
                        <div class="inner">
                            <h3><?= $siswa ?></h3>Data Peserta
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="?pg=siswa" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-red ">
                        <div class="inner">
                            <h3><?= $bank_soal ?></h3>Data Bank Soal
                        </div>
                        <div class="icon">
                            <i class="fa fa-file"></i>
                        </div>
                        <a href="?pg=banksoal" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-green ">
                        <div class="inner">
                            <h3><?= $kelas ?></h3>Data Kelas
                        </div>
                        <div class="icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <a href="?pg=kelas" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-yellow ">
                        <div class="inner">
                            <h3><?= $nilai ?></h3>Data Nilai
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-signature"></i>
                        </div>
                        <a href='?pg=nilai2' class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-purple ">
                        <div class="inner">
                            <h3><?= $nilai_pindah ?></h3>Nilai Pindah
                        </div>
                        <div class="icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <a href="?pg=nilai2" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        <!-- Button trigger modal -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-blue ">
                        <div class="inner">
                            <h3><?= $mapel ?></h3>Mata Pelajaran
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope-open-text"></i>
                        </div>
                        <a href="?pg=matapelajaran" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-body">
                    <div id='infoweb'></div>
                    <ul class="list-group">
                        <li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">
                            <a style="width: 120px;" href="https://api.whatsapp.com/send/?phone=<?= $setting['fax'] ?>&text=Assalamualaikum, Pak Bass. Minta info aplikasi" target="_blank" class="btn btn-success">
                                <i class="fab fa-whatsapp"></i> Whatsapp
                            </a></li>
                        <!--<li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">-->
                        <!--    <a style="width: 120px;" href="https://t.me/<?= $setting['web'] ?>" target="_blank" class="btn btn-primary">-->
                        <!--        <i class="fab fa-telegram-plane"></i> Telegram-->
                        <!--    </a></li>-->
                        <!--<li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">-->
                        <!--    <a style="width: 120px;" href="https://www.youtube.com/watch?v=MSL7rkrW5FY" target="_blank" class="btn btn-danger">-->
                        <!--        <i class="fab fa-youtube"></i> Tutorial-->
                        <!--    </a></li>-->
                    </ul>
                </div>
            </div>
        </div>
						<div class="row">
							<div class='animated flipInX col-md-8'>
								<div class="row">
									<?php if ($setting['server'] == 'lokal') : ?>
										<div class="col-lg-12">
											<div class="small-box ">
												<div class="inner">
													<img id='loading-image' src='../dist/img/ajax-loader.gif' style='display:none; width:50px;' />
													<p id='statusserver'></p>
													<p>Status Server</p>
												</div>
												<div class="icon">
													<i class="fa fa-desktop"></i>
												</div>
												<a  href="?pg=sinkronset" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
											</div>
										</div>
										<script>
											$.ajax({
												type: 'POST',
												url: 'statusserver.php',
												beforeSend: function() {
													$('#loading-image').show();
												},
												success: function(response) {
													$('#statusserver').html(response);
													$('#loading-image').hide();

												}
											});
										</script>
									<?php endif; ?>
									<div class="col-md-12">
									    <div class='box box-solid direct-chat direct-chat-warning'>
                                        <div class='box-header with-border'>
                            <h3 class='box-title'><i class='fas fa-bullhorn fa-fw'></i>
                                Pengumuman
                            </h3>
                            <div class='box-tools pull-right'>
                                <a href='?pg=<?= $pg ?>&ac=clearpengumuman' class='btn btn-default' title='Bersihkan Pengumuman'><i class='fa fa-trash'></i></a>
                            </div>
                        </div>
                        <div class='box-body'>
                            
                            <?php $logC = 0;
		echo "<ul class='timeline'><li class='time-label'><span class='bg-blue'>- Terbaru -</span></li>";
		$logQ = mysqli_query($koneksi, "SELECT * FROM pengumuman ORDER BY date DESC");

		while ($log = mysqli_fetch_array($logQ)) {
			$logC++;
			$user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas='$log[user]'"));
			if ($log['type'] == 'internal') {
				$bg = 'bg-green';
				$color = 'text-green';
			} else {
				$bg = 'bg-blue';
				$color = 'text-blue';
			}
			?>
                            <!-- timeline time label -->
						
						<li><i class='fa fa-envelope <?=$bg?>'></i>
						<div class='timeline-item'>
						<span class='time'> <i class='fa fa-calendar'></i> <?= buat_tanggal('d-m-Y', $log['date']) ?> <i class='fa fa-clock-o'></i> <?= buat_tanggal('h:i', $log['date']) ?></span>
						<h3 class='timeline-header' style='background-color:#f9f0d5'><a class='$color' href='#'><?=$log[judul]?></a> <small> <?=$user[nama]?></small>
						
						</h3>
						<div class='timeline-body'>
						<?= ucfirst($log['text']) ?>	
						</div>
						</li>
		<?php
		}
		if ($logC == 0) {
			echo "<p class='text-center'>Belum ada pengumuman terbaru.</p>
			";
		}
		?> </ul>
	</div>
											</div>
										</div>
									</div>

								</div>
								
							<div class='animated flipInX col-md-4'>
								<div class='box box-solid direct-chat direct-chat-warning'>
									<div class='box-header with-border'>
										<h3 class='box-title'><i class='fa fa-spinner fa-spin'></i> Log Aktifitas</h3>
										<div class='box-tools pull-right'>
											<a href='?pg=<?= $pg ?>&ac=clearlog' class='btn btn-default' title='Bersihkan Log'><i class='fa fa-trash'></i></a>
										</div>
									</div>
									<div class='box-body'>
										<div id='log-list'>
											<p class='text-center'>
												<br /><i class='fa fa-spin fa-circle-o-notch'></i> Loading....
											</p>
										</div>
									</div>
								</div>
							</div>

						</div> 
					
					<?php endif ?>
					<?php
					if ($ac == 'clearlog') {
						mysqli_query($koneksi, "TRUNCATE log");
						jump('?');
					}
					if ($ac == 'clearpengumuman') {
						mysqli_query($koneksi, "TRUNCATE pengumuman");
						jump('?');
					}
					?>
				<?php if ($pengawas['level'] == 'guru' or $pengawas['level']=='peng') : ?>
					<?php include 'pengumuman/pengumuman.php'; ?>
					<?php endif ?>
				<?php elseif ($pg == 'dataserver') : ?>
					<?php include 'serverlokal.php'; ?>
				<?php elseif ($pg == 'sinkrondapo') : ?>
					<?php include 'sinkron_dapodik/update_data.php'; ?>
				<?php elseif ($pg == 'sinkron') : ?>
					<?php include 'sinkronisasi.php'; ?>
				<?php elseif ($pg == 'sinkronset') : ?>
					<?php include 'sinkronsetting.php'; ?>
				<!--<?php elseif ($pg == 'informasi') : ?>-->
				<!--	<?php include 'konten/informasi.php'; ?>-->
				<?php elseif ($pg == 'dataujian') : ?>
					<?php include 'dataujian.php'; ?>
				<?php elseif ($pg == 'meeting') : ?>
					<?php include 'meet/list_meeting.php'; ?>
				<?php elseif ($pg == 'siswabinaan') : ?>
                    <?php cek_session_admin(); ?>
                    <?php include 'mod_walas/siswa_binaan.php'; ?>
				<?php elseif ($pg == 'filemanager') : ?>
					<!--<iframe width='100%' height='550' frameborder='0' src='ifm.php'>-->
					<!--</iframe>-->
				<?php elseif ($pg == 'filemanager2') : ?>
					<!--<iframe width='100%' height='550' frameborder='0' src='ifm2.php'>-->
					<!--</iframe>-->
				<!-- asja filmanager -->
				<?php elseif ($pg == 'matapelajaran') : ?>
					<?php include 'konten/mata_pelajaran.php'; ?>
				<?php elseif ($pg == 'token') : ?>
					<?php include 'konten/token.php'; ?>
				<?php elseif ($pg == 'pengumuman') : ?>
					<?php include 'pengumuman/add_list.php'; ?>
				<?php elseif ($pg == 'guru') : ?>
					<?php include 'konten/guru.php'; ?>
				<?php elseif ($pg == 'beritaacara') : ?>
					<?php include 'konten/berita_acara.php'; ?>
				<?php elseif ($pg == 'jadwal') : ?>
					<?php include "jadwal/jadwal_ujian.php"; ?>
				<?php elseif ($pg == 'absen_total') : ?>
					<?php include "absensi/absensi.php"; ?>
				<?php elseif ($pg == 'absen_jam') : ?>
					<?php include "absensi/absensi_jam.php"; ?>
				<?php elseif ($pg == 'absen_tahun') : ?>
					<?php include "absensi/absensi_tahun.php"; ?>
				<?php elseif ($pg == 'absen_detail') : ?>
					<?php include "absensi/absensi_detail.php"; ?>
				<?php elseif ($pg == 'absen_mapel') : ?>
					<?php include "absensi/absensi_mapel.php"; ?>
				<?php elseif ($pg == 'absen_permapel') : ?>
					<?php include "absensi_mapel/absen_permapel.php"; ?>
				<?php elseif ($pg == 'absen_permapel_detail') : ?>
					<?php include "absensi_mapel/absen_permapel_detail.php"; ?>
				<?php elseif ($pg == 'berita') : ?>
					<?php include 'konten/berita.php'; ?>
				<?php elseif ($pg == 'nilai') : ?>
					<?php include 'nilai.php'; ?>
				<!-- asja ini tempat pangil halaman nilai -->
				<?php elseif ($pg == 'nilai2') : ?>
					<?php include 'nilai2.php'; ?>
				<?php elseif ($pg == 'nilai_mapel') : ?>
					<?php include 'nilai/nilai_mapel.php'; ?>
				<?php elseif ($pg == 'nilai3') : ?>
					<?php include 'konten/nilai_copy.php'; ?>
				<?php elseif ($pg == 'pindah_nilai') : ?>
					<?php include 'nilai/pindah_nilai.php'; ?>
					<?php		
					//cetaklaporan
				elseif($pg=='laporan'):
							if($ac=='') {
								?>
									<div class='row'>
										
										<div class='col-md-3'></div>
										<div class='col-md-6'>
										
											<div class='box box-primary'>
												<div class='box-header with-border' style='background-color:white'>
													<h3 class='box-title'>Cetak Format Nilai</h3>
													<div class='box-tools pull-right btn-group'>
														<button id='btnlaporan' class="btn btn-sm btn-primary" 
														onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button>
													</div>
												</div><!-- /.box-header -->
												<div class='box-body'>
													<form action="form_nilai_excel.php"  method="GET">
													<div class='form-group'>
															<div class='form-group'>
															<label>Pilih Mapel</label>
															<select id='mapel' name="mapel" class='select2 form-control' onchange="printlaporan()">
																<option>Pilih Mapel</option>
															<?php $mp = $db->v_mapel(); 
															foreach ($mp as $key => $value) { ?>
																<option value="<?= $value['id_mapel'];?>"><?= $value['nama'];?></option>
															<?php } ?>
															?>
															</select>
															</div>	
															<div class='form-group'>
																<label>Pilih Kelas</label>
																<select id='kelas' name="kelas" class='select2 form-control' onchange="printlaporan()">
																	<option>Pilih Kelas</option>
																<?php $mp = $db->v_kelas(); 
																foreach ($mp as $key => $value) { ?>
																	<option value="<?= $value['id_kelas'];?>"><?= $value['nama'];?></option>
																<?php } ?>
																?>
																</select>
															</div>	
															<div class='form-group'>
																<label>Pilih Sesi</label>
																<select id='sesi' name="sesi" class='select2 form-control' onchange="printlaporan()">
																	<option value="semua">SEMUA</option>
																<?php $mp = $db->v_sesi(); 
																foreach ($mp as $key => $value) { ?>
																	<option value="<?= $value['kode_sesi'];?>"><?= $value['nama_sesi'];?></option>
																<?php } ?>
																?>
																</select>
															</div>	
															<div class='form-group'>
																<label>Pilih Ruang</label>
																<select id='ruang' name="ruang" class='select2 form-control' onchange="printlaporan()">
																	<option value="semua">SEMUA</option>
																<?php $mp = $db->v_ruang(); 
																foreach ($mp as $key => $value) { ?>
																	<option value="<?= $value['kode_ruang'];?>"><?= $value['kode_ruang'];?></option>
																<?php } ?>
																?>
																</select>
															</div>	
													</div>
													<button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
													
													</form>
												</div><!-- /.box-body -->
											</div><!-- /.box -->
										</div>
									</div>
									<iframe id='loadlaporan' name='frameresult' src='form_nilai.php' style='border:none;width:0px;height:0px;'></iframe>";
								
						<?php 	} ?>
				<?php elseif ($pg == 'leger') : ?>
					<?php if($ac=='') {
								?>
									<div class='row'>
										
										<div class='col-md-3'></div>
										<div class='col-md-6'>
										
											<div class='box box-primary'>
												<div class='box-header with-border' style='background-color:white'>
													<h3 class='box-title'>Cetak Leger Nilai</h3>
													<div class='box-tools pull-right btn-group'>
														
													</div>
												</div><!-- /.box-header -->
												<div class='box-body'>
													<form action="leger_nilai.php"  method="GET">
													<div class='form-group'>
															<div class='form-group'>
																<label>Pilih Jurusan</label>
																<select id='jrs' name="jrs" class='select2 form-control' onchange="printlaporan()">
																	<option>Pilih Jurusan</option>
																	<option value="semua">SEMUA</option>
																<?php $mp = $db->v_jurusan(); 
																foreach ($mp as $key => $value) { ?>
																	<option value="<?= $value['id_pk'];?>"><?= $value['id_pk'];?></option>
																<?php } ?>
																?>
																</select>
															</div>
															<div class='form-group'>
																<label>Pilih Kelas</label>
																<select id='kelas' name="kelas" class='select2 form-control' onchange="printlaporan()">
																	<option value="semua">SEMUA</option>
																<?php $mp = $db->v_kelas(); 
																foreach ($mp as $key => $value) { ?>
																	<option value="<?= $value['id_kelas'];?>"><?= $value['nama'];?></option>
																<?php } ?>
																?>
																</select>
															</div>	
															
													</div>
													<i>Pastikan Sudah Pilih Jurusan atau Kelas</i><br>
													<i>Jika Ingin Download Per Jurusan, Kelas Pilih Semua</i><br>
													<i>Jika Ingin Download Per Kelas, Jurusan Pilih Semua</i><br><br>
													<button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
													
													</form>
												</div><!-- /.box-body -->
											</div><!-- /.box -->
										</div>
									</div>
									<iframe id='loadlaporan' name='frameresult' src='form_nilai.php' style='border:none;width:0px;height:0px;'></iframe>
								
								
						<?php 	} ?> 

				<?php elseif ($pg == 'semuanilai') : ?>
					<?php include 'semuanilai.php'; ?>
				
				<?php elseif ($pg == 'susulan') : ?>
					<?php include 'konten/susulan.php'; ?>
				<?php elseif ($pg == 'status') : ?>
					<?php if ($ac == '') : ?>
						<div class='row'>
							<div class='col-md-12'>

								<div class='box box-solid'>
									<div class='box-header with-border'>
										<h3 class='box-title'>Status Peserta </h3>
										<div class='box-tools pull-right '>
										</div>
									</div><!-- /.box-header -->
									<div class='box-body'>
										<div class='alert alert-info'>
											<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
											<i class='icon fa fa-info'></i>
											Status peserta akan muncul saat ujian berlangsung dan refresh setiap 5 detik..
										</div>

										<div id="divstatus"></div>
										<!-- <div class='table-responsive'>
											<table id='tablestatus' class='table table-bordered table-striped'>
												<thead>
													<tr>
														<th width='5px'>#</th>
														<th>NIS</th>
														<th>Nama</th>
														<th>Kelas</th>
														<th>Mapel</th>
														<th>Lama Ujian</th>
														<th>Jawaban</th>
														<th>Nilai</th>
														<th>Ip Address</th>
														<th>Status</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody id='divstatu'>
												</tbody>
											</table>
										</div> -->
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>
					<?php endif ?>
				
				<!-- asja -->
				<?php elseif ($pg == 'status2') : ?>
					<?php if ($ac == '') : ?>
						<div class='row'>
							<div class='col-md-12'>
								<div class='alert alert-warning alert-dismissible'>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
									<i class='icon fa fa-info'></i>
									Status peserta akan muncul saat ujian berlangsung ..
								</div>

								<div class='box box-solid'>
									<div class='box-header with-border'>
										<h3 class='box-title'>Status Peserta </h3>
										<div class='box-tools pull-right '>
										    <?php if ($pengawas['level'] == 'admin') { ?>
										    <a href="?pg=pindah_nilai" class="btn btn-sm btn-flat btn-warning"> Pindah Nilai</a>
										    <?php } ?>
											<button class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infostatus'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Info Baca Dulu</span></button>
											<button id="tbl_selesai" class="btn btn-sm btn-flat btn-success"><i class="fa fa-check"></i> Tampilkan tombol selesai</button>
											<button id="tbl_selesai2" class="btn btn-sm btn-flat btn-danger"><i class="fa fa-times"></i> Kunci tombol selesai</button>
										</div>
									</div><!-- /.box-header -->
									<div class='modal fade' id='infostatus' style='display: none;'>
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header bg-maroon'>
													<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
													<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Status Peserta</h4>
												</div>
												<!-- tambah jadwal asja -->
												<div class='modal-body'>
													<p>
												    Pastikan Halaman Status Peserta Aktif
													<hr>
													Tombol Selesai Akan tampil jika waktu yang di setting Tombol Selesai >= dengan waktu server berjalan (Biar keluar secara serempak)
													<hr>
													Tampil tombol selesai dapat disetting secara manual<br>
													Labih optimal jika setting tombol selesainya di kosongkan,satatus akan null X (artinya manual semua)
													<hr>
													Jika waktu sudah memasukin tombol selesai tampil, maka kunci tombol selesai tidak akan berfungsi 
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class='box-body'>

										<div class="row" style="padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
											<div class="col-md-2">
												<select class="form-control select2 jurusan">
													<?php $jurusan = $db->v_jurusan(); ?>
													<option value=""> Pilih Jurusan</option>
													<?php foreach ($jurusan as $jrs) : ?>
														<option <?php if($idjrs==$jrs['id_pk']){ echo "selected";}else{} ?> value="<?= $jrs['id_pk'] ?>"><?= $jrs['id_pk'] ?></option>
													<?php endforeach; ?>
												</select>
											</div>

											<div class="col-md-2">
												<select class="form-control select2 kelas">
													<?php $kelas = $db->v_kelas(); ?>
													<option value=""> Pilih Kelas</option>
													<?php foreach ($kelas as $value) : ?>
														<option <?php if($idkls==$value['id_kelas']){ echo "selected";}else{} ?>  value="<?= $value['id_kelas'] ?>"><?= $value['nama'] ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-md-3">
													<button id="cari_nilai" class="btn btn-info"><i class="fa fa-search"></i> Cari Data</button>
													<?php if (!empty($_GET['kls']) or !empty($_GET['jrs'])) {
													?>
													<button id="show_all" class="btn btn-success"><i class="fa fa-search"></i> Tampil Semua</button>
												<?php } ?>
												</div>
										</div>
										<script type="text/javascript">
											$('#cari_nilai').click(function(){
													var kelas = $('.kelas').val();
													var jrs = $('.jurusan').val();
													if(kelas =="" && jrs != ""){
														location.replace("?pg=status2&jrs="+jrs);
													}
													else if(jrs =="" && kelas != ''){
														location.replace("?pg=status2&kls="+kelas);
													}
													else{
														alert("Uppps Pilih Kelas Atau Jurusan Salah Satu");
													}

												});
											$('#show_all').click(function(){
												location.replace("?pg=status2");
											});
										</script>
										

										<div class='table-responsive'>
											<table id='tablestatus2' class='table table-bordered table-striped'>
												<thead>
													<tr>
														<th width='5px'>#</th>
														
														<th width="120">Aksi</th>
														<th>Status</th>
														<th>Nama</th>
														<th>Kelas</th>
														<th width="200">Mapel</th>
														<th>Durasi</th>
														<th>Jawaban</th>
														<th>Nilai</th>
														<th>Ip Address</th>
														<th>Tombol</th>
														<th>NIS</th>
														
													</tr>
												</thead>
												<tbody id='divstatus2'>
												</tbody>
											</table>
										</div>
										<script type="text/javascript">
											$(document).ready(function() {
												$("#tbl_selesai").click(function() {
													var aksi=1;
														$.ajax({
														type: 'POST',
														url: 'core/c_aksi.php?adm=tombol_selesai',
														data:{id:aksi} ,
														success: function(data) {
															//alert(data);
															if(data==1){
																toastr.success("Berhasil");
															}
															else if(data==200){
																toastr.warning("Sudah Ujian Semua");
															}
															else{
																toastr.error("Upss Gagal");
															}
														}
														});
												});
												$("#tbl_selesai2").click(function() {
													
													var aksi=1;
														$.ajax({
														type: 'POST',
														url: 'core/c_aksi.php?adm=kunci_tombol_selesai',
														data:{id:aksi} ,
														success: function(data) {
															if(data==true){
																toastr.success("Berhasil");
															}
															else if(data==200){
																toastr.warning("Sudah Ujian Semua");
															}
															else{
																toastr.error("Upss Gagal");
															}
														}
														});
												});
											}); 
										</script>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>
					<?php endif ?>
				<!-- asja -->
				<?php elseif ($pg == 'kartu') : ?>
					<?php include"kartu_dena/kartu_ujian.php"; ?>
				<!-- asja -->
				<?php elseif ($pg == 'dena') : ?>
					<?php if ($ac == '') : ?>
						<div class='row'>
							<div class='col-md-3'></div>
							<div class='col-md-6'>
								<div class='box box-solid'>
									<div class='box-header with-border'>
										<h3 class='box-title'>Cetak Denah Lokasi Ujian</h3>
										<div class='box-tools pull-right '>
											<button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button>
											<a href='?pg=siswa' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
										</div>
									</div><!-- /.box-header -->
									<div class='box-body'>
										<select class='select2 form-control' name="sesi" id="sesi" onchange=dena_lokasi();>
											<option value="">SESI</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
										<br><br>
										<select class='select2 form-control' name="ruang" id="ruang" onchange=dena_lokasi();>
											<option value="">Ruang</option>
											<option value="R1">R1</option>
											<option value="R2">R2</option>
											<option value="R3">R3</option>
											<option value="R4">R4</option>
										</select>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>
						<iframe id='loaddena' name='frameresult' src='' style='border:none;width:1px;height:1px;'></iframe>
					<?php endif ?>
				<!-- asja -->
				<?php elseif ($pg == 'absen') : ?>
					<?php include "konten/daftar_hadir.php"; ?>
				<?php elseif ($pg == 'siswa') : ?>
					<?php include 'konten/master_siswa.php'; ?>
				<?php elseif ($pg == 'uplfotosiswa') : ?>
					<?php
					cek_session_admin();
					if (isset($_POST["uplod"])) {
						$output = '';
						if ($_FILES['zip_file']['name'] != '') {
							$file_name = $_FILES['zip_file']['name'];
							$array = explode(".", $file_name);
							$name = $array[0];
							$ext = $array[1];
							if ($ext == 'zip') {
								$path = '../foto/fotosiswa/';
								$location = $path . $file_name;
								if (move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)) {
									$zip = new ZipArchive;
									if ($zip->open($location)) {
										$zip->extractTo($path);
										$zip->close();
									}
									$files = scandir($path);
									foreach ($files as $file) {
										$file_ext = pathinfo($file, PATHINFO_EXTENSION);
										$allowed_ext = array('jpg', 'png', 'JPG');
										if (in_array($file_ext, $allowed_ext)) {
											$output .= '<div class="col-md-3"><div style="padding:16px; border:1px solid #CCC;"><img class="img img-responsive" style="height:150px;" src="../foto/fotosiswa/' . $file . '" /></div></div>';
										}
									}
									unlink($location);
									$pesan = "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Info</h4>Upload File zip berhasil</div>";
								}
							} else {
								$pesan = "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-info'></i> Gagal Upload</h4>Mohon Upload file zip</div>";
							}
						}
					}
					?>
					<?php
					if (isset($_POST['hapussemuafoto'])) {
						$files = glob('../foto/fotosiswa/*'); // Ambil semua file yang ada dalam folder
						foreach ($files as $file) { // Lakukan perulangan dari file yang kita ambil
							if (is_file($file)) // Cek apakah file tersebut benar-benar ada
								unlink($file); // Jika ada, hapus file tersebut
						}
					}
					?>
					<div class='box box-danger'>
						<div class='box-header with-border'>
							<h3 class='box-title'>Upload Foto Peserta Ujian</h3>
							<div class='box-tools pull-right '>
								<a href='?pg=siswa' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
							</div>
						</div><!-- /.box-header -->
						<div class='box-body'>
							<div class='alert alert-danger alert-dismissible'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
								<h4><i class='icon fa fa-info'></i> Info</h4>
								Upload gambar dalam berkas zip. Penamaan gambar sesuai dengan no peserta siswa ujian
							</div>
							<form action='' method='post' enctype='multipart/form-data'>
								<div class='col-md-6'>
									<input class='form-control' type='file' name='zip_file' accept='.zip' />
								</div>
								<div class='col-md-6'>
									<button class='btn bg-maroon' name='uplod' type='submit'>Upload Foto</button>
								</div>
							</form>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
					<div class='box box-solid'>
						<div class='box-header with-border'>
							<h3 class='box-title'>Daftar Foto Peserta</h3>
							<div class='box-tools pull-right '>
								<form action='' method='post'>
									<button class='btn btn-sm bg-maroon' name='hapussemuafoto'>hapus semua foto</button>
								</form>
							</div>
						</div><!-- /.box-header -->
						<div class='box-body'>
							<?php
							$folder = "../foto/fotosiswa/"; //Sesuaikan Folder nya
							if (!($buka_folder = opendir($folder))) die("eRorr... Tidak bisa membuka Folder");
							$file_array = array();
							while ($baca_folder = readdir($buka_folder)) :
								$file_array[] = $baca_folder;
							endwhile;
							$jumlah_array = count($file_array);
							for ($i = 2; $i < $jumlah_array; $i++) :
								$nama_file = $file_array;
								$nomor = $i - 1;
								echo "<div class='col-md-1'><img class='img-logo' src='$folder$nama_file[$i]' style='width:65px'/><br><br></div>";
							endfor;
							closedir($buka_folder);
							?>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				<?php elseif ($pg == 'importmaster') : ?>
					<?php
					cek_session_admin();

					$format = 'importdatamaster.xlsx';

					?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='box box-solid'>
								<div class='box-header with-border '>
									<h3 class='box-title'>Import Data Master</h3>
									<div class='box-tools pull-right '>
										<a href='templete/<?= $format ?>' class='btn btn-sm btn-flat btn-success'><i class='fa fa-file-excel-o'></i> Download Format</a>
										<a href='?pg=siswa' class='btn btn-sm btn-flat btn-success' title='Batal'><i class='fa fa-times'></i></a>
									</div>
								</div><!-- /.box-header -->
								<div class='box-body'>
									<?= $info ?>
									<div class='box box-solid'>
										<div class='box-body'>
											<div class='form-group'>
												<div class='row'>
													<form id='formsiswa' enctype='multipart/form-data'>
														<div class='col-md-4'>
															<label>Pilih File</label>
															<input type='file' name='file' class='form-control' required='true' />
														</div>
														<div class='col-md-4'>
															<label>&nbsp;</label><br>
															<button type='submit' name='submit' class='btn btn-flat btn-success'><i class='fa fa-check'></i> Import Data</button>
														</div>
													</form>
												</div>
											</div>
											<p>Pastikan file dalam bentuk Ms. Excel 97-2003 Workbook (.xls) dan format penulisan harus sesuai dengan yang telah ditentukan.</p>
											<div id='progressbox'></div>
											<div id='hasilimport'></div>
										</div>
									</div>
								</div><!-- /.box-body -->
								<div class='box-footer'></div>
							</div><!-- /.box -->
						</div>
					</div>
				<?php elseif ($pg == 'importguru') : ?>
					<?php
					cek_session_admin();
					if (isset($_POST['submit'])) :
						$file = $_FILES['file']['name'];
						$temp = $_FILES['file']['tmp_name'];
						$ext = explode('.', $file);
						$ext = end($ext);
						if ($ext <> 'xls') {
							$info = info('Gunakan file Ms. Excel 93-2007 Workbook (.xls)', 'NO');
						} else {
							$data = new Spreadsheet_Excel_Reader($temp);
							$hasildata = $data->rowcount($sheet_index = 0);
							$sukses = $gagal = 0;
							$exec = mysqli_query($koneksi, "delete from pengawas where level='guru'");
							for ($i = 2; $i <= $hasildata; $i++) :
								$nip = $data->val($i, 2);
								$nama = $data->val($i, 3);
								$nama = addslashes($nama);
								$username = $data->val($i, 4);
								$username = str_replace("'", "", $username);
								$password = $data->val($i, 5);
								$exec = mysqli_query($koneksi, "INSERT INTO pengawas (nip,nama,username,password,level) VALUES ('$nip','$nama','$username','$password','guru')");
								($exec) ? $sukses++ : $gagal++;
							endfor;
							$total = $hasildata - 1;
							$info = info("Berhasil: $sukses | Gagal: $gagal | Dari: $total", 'OK');
						}
					endif;
					?>
					<div class='row'>
						<div class='col-md-3'></div>
						<div class='col-md-6'>
							<form action='' method='post' enctype='multipart/form-data'>
								<div class='box box-solid'>
									<div class='box-header with-border'>
										<h3 class='box-title'>Import Guru</h3>
										<div class='box-tools pull-right '>
											<button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Import</button>
											<a href='?pg=guru' class='btn btn-sm btn-default' title='Batal'><i class='fa fa-times'></i></a>
										</div>
									</div><!-- /.box-header -->
									<div class='box-body'>
										<?= $info ?>
										<div class='form-group'>
											<label>Pilih File</label>
											<input type='file' name='file' class='form-control' required='true' />
										</div>
										<p>Pastikan file dalam bentuk Ms. Excel 97-2003 Workbook (.xls) dan format penulisan harus sesuai dengan yang telah ditentukan.</p>
									</div><!-- /.box-body -->
									<div class='box-footer'>
										<a href='templete/importdataguru.xls'><i class='fa fa-file-excel-o'></i> Download Format</a>
									</div>
								</div><!-- /.box -->
							</form>
						</div>
					</div>
				<?php elseif ($pg == 'pengawas') : ?>
					<?php include "konten/pengawas.php"; ?>
				<?php elseif ($pg == 'pk') : ?>
					<?php if ($setting['jenjang'] == 'SMK') : ?>
						<?php
						cek_session_admin();
						if (isset($_POST['tambahPK'])) :
							$idpk = str_replace(' ', '', $_POST['idpk']);
							$nama = $_POST['nama'];
							$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pk WHERE id_pk='$idpk'"));
							if ($cek > 0) {
								$info = info("Jurusan dengan kode $idpk sudah ada!", "NO");
							} else {
								$exec = mysqli_query($koneksi, "INSERT INTO pk (id_pk,program_keahlian) VALUES ('$idpk','$nama')");
								if (!$exec) :
									$info = info("Gagal menyimpan!", "NO");
								else :
									jump("?pg=$pg");
								endif;
							}
						endif;
						$info = '';
						?>
						<div class='row'>
							<div class='col-md-12'>
								<div class='box box-solid'>
									<div class='box-header with-border'>
										<h3 class='box-title'>Jurusan</h3>
										<div class='box-tools pull-right'>
											<button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahPK'><i class='fa fa-check'></i> Tambah Jurusan</button>
										</div>
									</div><!-- /.box-header -->
									<div class='box-body'>
										<?= $info ?>
										<table id='tablejurusan' class='table table-bordered table-striped'>
											<thead>
												<tr>
													<th width='5px'>#</th>
													<th>Kode Jurusan</th>
													<th>Nama Jurusan</th>
												</tr>
											</thead>
											<tbody>
												<?php $adminQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY id_pk ASC"); ?>
												<?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
													<?php $no++; ?>
													<tr>
														<td><?= $no ?></td>
														<td><?= $adm['id_pk'] ?></td>
														<td><?= $adm['program_keahlian'] ?></td>
													</tr>
												<?php endwhile; ?>
											</tbody>
										</table>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
							<div class='modal fade' id='tambahPK' style='display: none;'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header bg-blue'>
											<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
											<h3 class='modal-title'>Tambah Jurusan</h3>
										</div>
										<div class='modal-body'>
											<form action='' method='post'>
												<div class='form-group'>
													<label>Kode Jurusan</label>
													<input type='text' name='idpk' class='form-control' required='true' />
												</div>
												<div class='form-group'>
													<label>Nama Jurusan</label>
													<input type='text' name='nama' class='form-control' required='true' />
												</div>
												<div class='modal-footer'>
													<div class='box-tools pull-right '>
														<button type='submit' name='tambahPK' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
														<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php else : ?>
						<div class="panel panel-body panel-info">
							<h4>
								Untuk Jenjang SD (sederajat) sampai SMP (sederajat), tidak memiliki jurusan
							</h4>
						</div>
					<?php endif; ?>
				<?php elseif ($pg == 'jenisujian') : ?>
					<?php
					cek_session_admin();
					if (isset($_POST['tambahujian'])) :
						$id = str_replace(' ', '', $_POST['idujian']);
						$nama = $_POST['nama'];
						$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jenis WHERE id_jenis='$id'"));
						if ($cek > 0) {
							$info = info("Jenis Ujian dengan kode $id sudah ada!", "NO");
						} else {
							$exec = mysqli_query($koneksi, "INSERT INTO jenis (id_jenis,nama,status) VALUES ('$id','$nama','tidak')");
							if (!$exec) {
								$info = info("Gagal menyimpan!", "NO");
							} else {
								jump("?pg=$pg");
							}
						}
					endif;
					$info = '';
					?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='box box-solid'>
								<div class='box-header with-border'>
									<h3 class='box-title'>JENIS UJIAN</h3>
									<div class='box-tools pull-right'>
										<button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahujian'><i class='fa fa-check'></i> Tambah Ujian</button>
									</div>
								</div><!-- /.box-header -->
								<div class='box-body'>
									<?= $info ?>
									<table id='tablejenis' class='table table-bordered table-striped'>
										<thead>
											<tr>
												<th width='5px'>#</th>
												<th>Kode Ujian</th>
												<th>Nama Ujian</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php $adminQ = mysqli_query($koneksi, "SELECT * FROM jenis ORDER BY id_jenis ASC"); ?>
											<?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
												<?php $no++; ?>
												<tr>
													<td><?= $no ?></td>
													<td><?= $adm['id_jenis'] ?></td>
													<td><?= $adm['nama'] ?></td>
													<td><?= $adm['status'] ?></td>
												</tr>
											<?php endwhile; ?>
										</tbody>
									</table>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
						<div class='modal fade' id='tambahujian' style='display: none;'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header bg-blue'>
										<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
										<h3 class='modal-title'>Tambah Ujian</h3>
									</div>
									<div class='modal-body'>
										<form action='' method='post'>
											<div class='form-group'>
												<label>Kode Ujian</label>
												<input type='text' name='idujian' class='form-control' required='true' />
											</div>
											<div class='form-group'>
												<label>Nama Ujian</label>
												<input type='text' name='nama' class='form-control' required='true' />
											</div>
											<div class='modal-footer'>
												<div class='box-tools pull-right '>
													<button type='submit' name='tambahujian' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
													<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php elseif ($pg == 'ruang') : ?>
					<?php include 'master_ruang.php'; ?>
				<?php elseif ($pg == 'level') : ?>
					<?php
					cek_session_admin();
					if (isset($_POST['submit'])) :
						$level = str_replace(' ', '', $_POST['level']);
						$ket = $_POST['keterangan'];

						$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM level WHERE kode_level='$level'"));
						if ($cek > 0) {
							$info = info("Level atau tingkat $level sudah ada!", "NO");
						} else {
							$exec = mysqli_query($koneksi, "INSERT INTO level (kode_level,keterangan) VALUES ('$level','$ket')");
							if (!$exec) {
								$info = info("Gagal menyimpan!", "NO");
							} else {
								jump("?pg=$pg");
							}
						}
					endif;
					?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='box box-solid'>
								<div class='box-header with-border'>
									<h3 class='box-title'>Level atau Tingkat</h3>
									<div class='box-tools pull-right'>
										<button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahlevel'><i class='fa fa-check'></i> Tambah Level</button>
									</div>
								</div><!-- /.box-header -->
								<div class='box-body'>
									<table id='tablelevel' class='table table-bordered table-striped'>
										<thead>
											<tr>
												<th width='5px'>#</th>
												<th>Kode Level</th>
												<th>Nama Level</th>
											</tr>
										</thead>
										<tbody>
											<?php $adminQ = mysqli_query($koneksi, "SELECT * FROM level"); ?>
											<?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
												<?php $no++; ?>
												<tr>
													<td><?= $no ?></td>
													<td><?= $adm['kode_level'] ?></td>
													<td><?= $adm['keterangan'] ?></td>
												</tr>
											<?php endwhile ?>
										</tbody>
									</table>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
						<div class='modal fade' id='tambahlevel' style='display: none;'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header bg-blue'>
										<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
										<h3 class='modal-title'>Tambah Level</h3>
									</div>
									<div class='modal-body'>
										<form action='' method='post'>
											<div class='form-group'>
												<label>Kode Level</label>
												<input type='text' name='level' class='form-control' required='true' />
											</div>
											<div class='form-group'>
												<label>Nama Level</label>
												<input type='text' name='keterangan' class='form-control' required='true' />
											</div>
											<div class='modal-footer'>
												<div class='box-tools pull-right '>
													<button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
													<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php elseif ($pg == 'sesi') : ?>
					<?php
					cek_session_admin();
					if (isset($_POST['submit'])) {
						$sesi = str_replace(' ', '', $_POST['sesi']);
						$nama = $_POST['nama'];

						$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM sesi WHERE kode_sesi='$sesi'"));
						if ($cek > 0) {
							$info = info("Kelompok Test atau Sesi $sesi sudah ada!", "NO");
						} else {
							$exec = mysqli_query($koneksi, "INSERT INTO sesi (kode_sesi,nama_sesi) VALUES ('$sesi','$nama')");
							if (!$exec) {
								$info = info("Gagal menyimpan!", "NO");
							} else {
								jump("?pg=$pg");
							}
						}
					}
					?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='box box-solid'>
								<div class='box-header with-border'>
									<h3 class='box-title'>Sesi atau Kelompok Test</h3>
									<div class='box-tools pull-right'>
										<button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahsesi'><i class='fa fa-check'></i> Tambah Kelompok</button>
									</div>
								</div><!-- /.box-header -->
								<div class='box-body'>
									<table id='tablesesi' class='table table-bordered table-striped'>
										<thead>
											<tr>
												<th width='5px'>#</th>
												<th>Kode Sesi</th>
												<th>Nama Sesi</th>
											</tr>
										</thead>
										<tbody>
											<?php $adminQ = mysqli_query($koneksi, "SELECT * FROM sesi"); ?>
											<?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
												<?php $no++; ?>
												<tr>
													<td><?= $no ?></td>
													<td><?= $adm['kode_sesi'] ?></td>
													<td><?= $adm['nama_sesi'] ?></td>
												</tr>
											<?php endwhile; ?>
										</tbody>
									</table>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
						<div class='modal fade' id='tambahsesi' style='display: none;'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header bg-blue'>
										<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
										<h3 class='modal-title'>Tambah Sesi</h3>
									</div>
									<div class='modal-body'>
										<form action='' method='post'>
											<div class='form-group'>
												<label>Kode Sesi</label>
												<input type='text' name='sesi' class='form-control' required='true' />
											</div>
											<div class='form-group'>
												<label>Nama Sesi</label>
												<input type='text' name='nama' class='form-control' required='true' />
											</div>
											<div class='modal-footer'>
												<div class='box-tools pull-right '>
													<button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
													<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php elseif ($pg == 'kelas') : ?>
					<?php
					cek_session_admin();
					if (isset($_POST['submit'])) :
						$idkelas = str_replace(' ', '', $_POST['idkelas']);
						$nama = $_POST['nama'];
						$level = $_POST['level'];
						$pk = $_POST['pk'];
						$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$idkelas'"));
						if ($cek > 0) {
							$info = info("Kelas dengan kode $idkelas sudah ada!", "NO");
						} else {
							$exec = mysqli_query($koneksi, "INSERT INTO kelas (id_kelas,nama,id_level,id_pk)VALUES('$idkelas','$nama','$level','$pk')");
							if (!$exec) :
								$info = info("Gagal menyimpan!", "NO");
							else :
								jump("?pg=$pg");
							endif;
						}
					endif;
					?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='alert alert-warning '>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
								<i class='icon fa fa-info'></i>
								Level Kelas harus sama dengan Kode Level di data master
							</div>
							<div class='box box-solid'>
								<div class='box-header with-border'>
									<h3 class='box-title'>Kelas</h3>
									<div class='box-tools pull-right'>
										<button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahkelas'><i class='fa fa-check'></i> Tambah Kelas</button>
									</div>
								</div><!-- /.box-header -->
								<div class='box-body'>
									<table id='tablekelas' class='table table-bordered table-striped'>
										<thead>
											<tr>
												<th width='5px'>#</th>
												<th>Kode Kelas</th>
												<th>Level Kelas</th>
												<th>Nama Kelas</th>
												<th>Jurusan</th>
											</tr>
										</thead>
										<tbody>
											<?php $adminQ = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC"); ?>
											<?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
												<?php $no++; ?>
												<tr>
													<td><?= $no ?></td>
													<td><?= $adm['id_kelas'] ?></td>
													<td><?= $adm['id_level'] ?></td>
													<td><?= $adm['nama'] ?></td>
													<td><?= $adm['id_pk'] ?></td>
												</tr>
											<?php endwhile; ?>
										</tbody>
									</table>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
						<div class='modal fade' id='tambahkelas' style='display: none;'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header bg-blue'>
										<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
										<h3 class='modal-title'>Tambah Kelas</h3>
									</div>
									<div class='modal-body'>
										<form action='' method='post'>
											<div class='form-group'>
												<label>Kode Kelas</label>
												<input type='text' name='idkelas' class='form-control' required='true' />
											</div>
											<div class='form-group'>
												<label>Level</label>
												<select name='level' class='form-control' required='true'>
													<option value=''></option>
													<?php
													$levelQ = mysqli_query($koneksi, "SELECT * FROM level ");
													while ($level = mysqli_fetch_array($levelQ)) {
														echo "<option value='$level[kode_level]'>$level[kode_level]</option>";
													}
													?>
												</select>
											</div>
											<div class='form-group'>
												<label>Jurusan</label>
												<select name='pk' class='form-control' required='true'>
													<option value=''></option>
													<?php
													$levelQ = mysqli_query($koneksi, "SELECT * FROM pk ");
													while ($level = mysqli_fetch_array($levelQ)) {
														echo "<option value='$level[id_pk]'>$level[id_pk]</option>";
													}
													?>
												</select>
											</div>
											<div class='form-group'>
												<label>Nama Kelas</label>
												<input type='text' name='nama' class='form-control' required='true' />
											</div>
											<div class='modal-footer'>
												<div class='box-tools pull-right '>
													<button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
													<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php elseif ($pg == 'banksoal') : ?>
					<?php include "banksoal.php"; ?>
				<?php elseif ($pg == 'editguru') : ?>
					<?php include "profil_guru/profil.php"; ?>
				<?php elseif ($pg == 'jurnal') : ?>
					<?php include "jurnal_guru/jurnal.php"; ?>
				<?php elseif ($pg == 'datajurnal') : ?>
					<?php include "jurnal_guru/jurnaladmin.php"; ?>
				<?php elseif ($pg == 'detailjurnal') : ?>
					<?php include "jurnal_guru/jurnal_detail.php"; ?>
				<?php elseif ($pg == 'datarating') : ?>
					<?php include "rating/rating.php"; ?>
				<?php elseif ($pg == 'detailrating') : ?>
					<?php include "rating/rating_detail.php"; ?>
				<?php elseif ($pg == 'reset') : ?>
					<?php $info = ''; ?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='box box-solid'>
								<div class='box-header with-border'>
									<h3 class='box-title'>Reset Login Peserta</h3>&nbsp;&nbsp;&nbsp;<a class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infojadwal'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Info Reset</span></a>
									<div class='box-tools pull-right '>
										<button id='btnresetlogin' class='btn btn-sm btn-flat btn-success'><i class='fa fa-spinner fa-spin'></i> Reset Login</button>
									</div>
								</div><!-- /.box-header -->
								<div class='box-body'>
									<?= $info ?>
									<ul class="nav nav-pills">
									  <li class="active"><a data-toggle="pill" href="#home">Reset Login User</a></li>
									  <li><a data-toggle="pill" href="#menu1">User Yang Masih Login</a></li>
									  <li><a data-toggle="pill" href="#menu2">Akan Datang</a></li>
									</ul>

									<div class="tab-content" style="padding-top: 20px;">
									  <div id="home" class="tab-pane fade in active">
									  	<div class="row" style="padding-left: 10px;">
												<div class="col-md-12" >
													Pilih semua kemudian klik tombol Reset Login untuk meriset peserta ujian
												</div>
											</div>
										  <div id='tablereset' class='table-responsive'>
												<table id='example1' class='table table-bordered table-striped'>
													<thead>
														<tr>
															<th width='5px'>
																<input type='checkbox' id='ceksemua'></th>
															<th width='5px'>#</th>
															<th>No Peserta</th>
															<th>Nama Peserta</th>
															<th>Tanggal Login</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$loginQ = mysqli_query($koneksi, "SELECT * FROM nilai where online='1'"); ?>
														<?php while ($login = mysqli_fetch_array($loginQ)) : ?>
															<?php
															$siswa = mysqli_fetch_array(mysqli_query($koneksi, "select * from siswa where id_siswa='$login[id_siswa]'"));
															$no++;
															?>
															<tr>
																<td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $login['id_siswa'] ?>"></td>
																<td><?= $no ?></td>
																<td><?= $siswa['no_peserta'] ?></td>
																<td><?= $siswa['nama'] ?></td>
																<td><?= $login['ujian_mulai'] ?></td>
															</tr>
														<?php endwhile; ?>
													</tbody>
												</table>
											</div>
									  </div>
									  <div id="menu1" class="tab-pane fade">
									  	<div class="row" style="padding-left: 10px;">
												<div class="col-md-12" >
														Jika Sudah Di Reset Masih Tidak Bisa Masuk, Klik Tombol Ini <button id='btnresetlogin2' class='btn btn-sm btn-flat btn-danger'><i class='fa fa-trash'></i> Hapus Bersih Semua Login</button>
												</div>
											</div>
											<hr>
											<div class="row" style="padding-left: 10px; padding-bottom: 10px;">
												<div class="col-md-12" >
													Pilih Siswa Terlebih Dahulu<button id='btnresetlogin3' class='btn btn-sm btn-flat btn-warning'><i class='fa fa-trash'></i> Hapus Login Berdasrkan Siswa</button>
												</div>
											</div>
									    <div id='tablereset2' class='table-responsive'>
												<table id='example2' class='table table-bordered table-striped'>
													<thead>
														<tr>
															<th width='5px'>
																<input type='checkbox' id='ceksemua2'></th>
															<th width='5px'>#</th>
															<th>Id_Siswa</th>
															<th>Nama Peserta</th>
															<th>Tanggal Login</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$da2=$db->v_user_login();
													  foreach ($da2 as $value) { 
													  $no++;
													  ?>
															<tr>
																
																<td><input type='checkbox' name='cekpilih2[]' class='cekpilih2' id='cekpilih2-<?= $no ?>' value="<?= $value['id_siswa'] ?>"></td>
																<td><?= $no ?></td>
																<td><?= $value['id_siswa'] ?></td>
																<td><?= $value['nama'] ?></td>
																<td><?= $value['date'] ?></td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
									  </div>
									  <div id="menu2" class="tab-pane fade">
									    <h3>Belum ada data</h3>
									  </div>
									</div>

								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div>
						<div class='modal fade' id='infojadwal' style='display: none;'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header bg-maroon'>
										<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
										<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Menu Reset</h4>
									</div>
									<!-- tambah jadwal  -->
									<div class='modal-body'>
										<p>
											Reset Siswa yang<br>
											- Tidak Bisa Login<br>
											- Tidak Log out<br>
											- status tombol Lanjutkan Tidak bisa di klik<br>
											<hr>
											Silahkan Di Reset Satu per Satu sesuai Siswa yang mau di reset<br>
											Atau Bisa di Ceklis atau Pilih Semua dan Reset Masal
											<hr>
											User yang masih login
											Gunakan Fitur itu untuk mengatasi siswa yang masih login<br>
											atau tidak bisa login karna Siswa sudah aktif<br>
											Tekan tombol Hapus Bersih Login
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				
				<!--asja acak soal  -->
				<?php elseif ($pg == 'pengacak') : ?>
					<?php include "konten/acak_soal_opsi.php"; ?>
				<!-- /asja acak soal  -->

				<?php elseif ($pg == 'pengaturan') : ?>
					<?php include "konten/pengaturan.php"; ?>

				<?php elseif ($pg == 'block') : ?>
					<?php include "konten/atur_block.php"; ?>
				<?php elseif ($pg == 'siswa_kelas') : ?>
					<?php include "data_info/siswa_kelas.php"; ?>
				<?php elseif ($pg == 'siswa_jurusan') : ?>
					<?php include "data_info/siswa_jurusan.php"; ?>
				<?php elseif ($pg == 'siswa_sesi') : ?>
					<?php include "data_info/siswa_sesi.php"; ?>
				<?php elseif ($pg == 'siswa_ruang') : ?>
					<?php include "data_info/siswa_ruang.php"; ?>
				<?php elseif ($pg == 'siswa_tidak_ujian') : ?>
					<?php include "data_info/siswa_tidak_ujian.php"; ?>
				<?php elseif ($pg == 'anso') : ?>
					<?php include "anso/anso.php"; ?>
				<?php elseif ($pg == 'anso_nilai') : ?>
					<?php include "anso/anso_nilai.php"; ?>
				<?php elseif ($pg == 'anso_ranking') : ?>
					<?php include "anso/anso_rangking.php"; ?>
				<?php elseif ($pg == 'anso_perbaikan') : ?>
					<?php include "anso/anso_perbaikan.php"; ?>
				<!-- elerning -->
				<?php elseif ($pg == 'materi_pb') : ?>
					<?php include 'materi/materi_pembelajaran.php'; ?>
				<?php elseif ($pg == 'tugas_pb') : ?>
					<?php include 'tugas/tugas.php'; ?>
				<?php elseif ($pg == 'token_telegram') : ?>
					<?php include 'telegram/add_chat_id.php'; ?>
				<?php else : ?>
					<div class='error-page'>
						<h2 class='headline text-yellow'> 404</h2>
						<div class='error-content'>
							<br />
							<h3><i class='fa fa-warning text-yellow'></i> Upss! Halaman tidak ditemukan.</h3>
							<p>
								Halaman yang anda inginkan saat ini tidak tersedia.<br />
								Silahkan kembali ke <a href='?'><strong>dashboard</strong></a> dan coba lagi.<br />
								Hubungi <strong><i>Sir Asja</i></strong> jika ini adalah sebuah masalah.
							</p>
						</div><!-- /.error-content -->
					</div><!-- /.error-page -->
				<?php endif ?>
			</section><!-- /.content -->
		</div><!-- /.content-wrapper -->

		<?php include('tamplate_menu/sidebar_kanan.php'); ?>
		<footer class='main-footer hidden-xs'>
			<?php include('tamplate_menu/footer_menu.php'); ?>
		</footer>
	</div><!-- ./wrapper -->

	<!-- REQUIRED JS SCRIPTS -->
	<script src='<?= $homeurl ?>/dist/bootstrap/js/bootstrap.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/fastclick/fastclick.js'></script>
	<script src='<?= $homeurl ?>/dist/js/adminlte.min.js'></script>
	<script src='<?= $homeurl ?>/dist/js/app.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/datetimepicker/build/jquery.datetimepicker.full.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/slimScroll/jquery.slimscroll.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/iCheck/icheck.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/select2/select2.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/tableedit/jquery.tabledit.js'></script>
	<script src='<?= $homeurl ?>/plugins/toastr/toastr.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/notify/js/notify.js'></script>
	<script src='<?= $homeurl ?>/plugins/slidemenu/jquery-slide-menu-admin.js'></script>
	<script src='<?= $homeurl ?>/plugins/sweetalert2/dist/sweetalert2.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/MathJax-2.7.3/MathJax.js?config=TeX-AMS_HTML-full'></script>
	<!-- asja provinsi kabepaten -->
	<script src='<?= $homeurl?>/dist/js/ajax_kota.js'></script>
	
	<script>
		$('.loader').fadeOut('slow');
		$(function() {
			$('#textarea').wysihtml5()
		});
		$('.navs-slide').SlideMenu({
					expand: false,
					collapse: true
		});
		<?php if($setting['izin_ujian']==0 and $_SESSION['level']=='guru'){ ?>
		$('#pengumuman').load('<?= $homeurl ?>/panel/_load.php?pg=pengumuman');
		<?php }elseif ($_SESSION['level']=='guru') {?>
		$('#pengumuman').load('<?= $homeurl ?>/panel/_load.php?pg=pengumuman');
		<?php }else{ ?>
		var autoRefresh = setInterval(
			function() {
				$('#waktu').load('<?= $homeurl ?>/panel/_load.php?pg=waktu');
				$('#log-list').load('<?= $homeurl ?>/panel/_load.php?pg=log');
				$('#pengumuman').load('<?= $homeurl ?>/panel/_load.php?pg=pengumuman');
			}, 5000
		);
		<?php }?>

		<?php if ($pg == 'status') { ?>
			var autoRefresh = setInterval(
				function() {
					$('#divstatus').load("<?= $homeurl ?>/panel/statuspeserta.php?id=<?= $_GET['id'] ?>");
				}, 5000
			);
		<?php } ?>
		/*asja*/
		<?php if ($pg == 'status2') { 
			if (empty($_GET['kls']) and !empty($_GET['jrs'])) {
				$getkls = $_GET['jrs'];
				$a ="?jrs=".$getkls;
			}
			elseif(empty($_GET['jrs']) and !empty($_GET['kls'])){
				$getkls = $_GET['kls'];
				$a ="?kls=".$getkls;
			}
			else{
				$a = '';
			}
			?>
		// 	var autoRefresh = setInterval(
		// 	function() {
		// 		$('#divstatus2').load("<?= $homeurl ?>/<?= $crew; ?>/statuspeserta2.php<?= $a ?>");
		// 	}, 1000
		// );

		var autoRefresh = setInterval(
			function() {
				$('#isi_token').load('<?= $homeurl ?>/panel/_load.php?pg=token');
			}, 900000
		);
		let status_siswa=$('#tablestatus2').DataTable({
			"aLengthMenu": [[50,100,150,200,250,300,-1], [50,100,150,200,250,300,"All"]],
			"ajax": "<?= $homeurl ?>/panel/statuspeserta2.php<?= $a ?>",
			processing: true,
			deferLoading:0,

		});
		setInterval(function() {
			status_siswa.ajax.reload(null, false);
		}, 1000);
		<?php } ?>
		<?php /* fungksi untuk Aksi status peserta ujian*/ ?>
		function ulang_ujian(id){
			swal({
			title: 'Apa anda yakin?',
			text: "Akan Mengulang Ujian Ini ??",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
				confirmButtonText: 'Yes!'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url: 'resetstatus.php',
						method: "POST",
						data: 'id=' + id,
						success: function(data) {
							toastr.success("berhasil diulang");
						}
					});
				}
			})
		}
		function selesaikan_ujian(id){
		$('#htmlujianselesai').html('bbbbbbbbbbbbbbbbbbbbbbbbb');
		swal({
			title: 'Apa anda yakin?',
			text: "aksi ini akan menyelesaikan secara paksa ujian yang sedang berlangsung!",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: 'selesaikan.php',
					method: "POST",
					data: 'id=' + id,
					success: function(data) {
						$('#htmlujianselesai').html('1');
						toastr.success("berhasil Di Selesai Paksa");
					}
				});
			}
		});
		}
	$(document).on('click', '.block', function() {
		var id = $(this).data('id');
		var nilai = $(this).data('nilai');
		var aksi = $(this).data('aksi');
		if(aksi==0){ var pesan="Membuka Block"; }
			else{ var pesan="Block"; }
		console.log(id);
		swal({
			title: 'Apa anda yakin?',
			text: "Akan "+pesan+nilai+" Peserta Tersebut ??",

			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: 'blok_user.php',
					method: "POST",
					data: 'id=' + id+'&nilai='+nilai+'&aksi='+aksi,
					success: function(data) {
						toastr.success("berhasil");
					}
				});
			}
		});
	});
<?php /* //fungksi untuk Aksi status peserta ujian*/ ?>
		/*asja*/


		$('.datepicker').datetimepicker({
			timepicker: false,
			format: 'Y-m-d'
		});
		$('.tgl').datetimepicker();
		$('.timer').datetimepicker({
			datepicker: false,
			format: 'H:i'
		});

		$(function() {
			$('#jenis').change(function() {
				if ($('#jenis').val() == '2') {
					$('#jawabanpg').hide();
					$('input:radio[name=jawaban]').attr('disabled', true);
				} else {
					$('#jawabanpg').show();
					$('input:radio[name=jawaban]').attr('disabled', false);
				}
			});
		});

		function dena_lokasi() {
			var sesi = $('#sesi option:selected').val();
			var ruang = $('#ruang option:selected').val();
			$('#loaddena').attr('src', 'dena_lokasi_duduk.php?sesi=' +sesi+'&ruang='+ruang);
		}
		/*asja*/

		function printabsen() {
			var idsesi = $('#absensesi option:selected').val();
			var idmapel = $('#absenmapel option:selected').val();
			var idruang = $('#absenruang option:selected').val();
			var idkelas = $('#absenkelas option:selected').val();
			$('#loadabsen').attr('src', 'absen.php?id_sesi=' + idsesi + '&id_ruang=' + idruang + '&id_mapel=' + idmapel + '&id_kelas=' + idkelas);
		}

		function iCheckform() {
			$('input[type=checkbox].flat-check, input[type=radio].flat-check').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
				increaseArea: '20%' // optional
			});
		}

		$(document).ready(function() {
			$('#example1').DataTable({
				select: true
			});

			$('#example2').DataTable({
				select: true
			});

			$('#soalpg').keyup(function() {
				$('#tampilpg').val(this.value);
			});
			$('#soalesai').keyup(function() {
				$('#tampilesai').val(this.value);
			});
			$('#formsoal').submit(function(e) {
				e.preventDefault();
				var data = new FormData(this);
				$.ajax({
					type: 'POST',
					url: 'simpansoal.php',
					enctype: 'multipart/form-data',
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function() {

					},
					success: function(data) {
						toastr.success('soal berhasil disimpan');
					}
				})
				return false;
			});

			$('#ceksemua').change(function() {
				$(this).parents('#tablereset:eq(0)').
				find(':checkbox').attr('checked', this.checked);
			});
			$('#ceksemua2').change(function() {
				$(this).parents('#tablereset2:eq(0)').
				find(':checkbox').attr('checked', this.checked);
			});
			

			$('.idkel').change(function() {
				var thisval = $(this).val();
				var txt_id = $(this).attr('id').replace('me', 'txt');
				var idm = $('#' + txt_id).val();
				var idu = $('#iduj').val();
				console.log(thisval + idm);
				$('.linknilai').attr('href', '?pg=nilai&ac=lihat&idu=' + idu + '&idm=' + idm + '&idk=' + thisval);
			});
			$('.alert-dismissible').fadeTo(2000, 500).slideUp(500, function() {
				$('.alert-dismissible').alert('close');
			});
			$('.select2').select2();

			$('input:checkbox[name=masuksemua]').click(function() {
				if ($(this).is(':checked'))
					$('input:radio.absensi').attr('checked', 'checked');
				else
					$('input:radio.absensi').removeAttr('checked');
			});
			iCheckform()
			$('#btnbackup').click(function() {
				$('.notif').load('backup.php');
				console.log('sukses');
			});
			$('#mastersoal').click(function() {
				var mapel_id = $('#mapel_id').val();
				$('.notif_mapel').load('backup_excel.php?mapel_id=' + mapel_id);
				console.log('sukses');
			});
		});
		var url = window.location;
		// for sidebar menu entirely but not cover treeview
		$('ul.sidebar-menu a').filter(function() {
			return this.href == url;
		}).parent().addClass('active');

		// for treeview
		$('ul.treeview-menu a').filter(function() {
			return this.href == url;
		}).closest('.treeview').addClass('active');
	
		/*asja*/
		$(function() {
			$("#btnresetsoal").click(function() {
				id_array = new Array();
				i = 0;
				$("input.cekpilih:checked").each(function() {
					id_array[i] = $(this).val();
					i++;
				});
				$.ajax({
					url: "resetsoal.php",
					data: "id=" + id_array,
					type: "POST",
					success: function(respon) {
						if (respon == 1) {
							$("input.cekpilih:checked").each(function() {
								$(this).parent().parent().remove('.cekpilih').animate({
									opacity: "hide"
								}, "slow");
							})
						}
						//alert(respon);
					}
				});
				return false;
			})
		});
		$(function() {
			$("#btnresetlogin").click(function() {
				id_array = new Array();
				i = 0;
				$("input.cekpilih:checked").each(function() {
					id_array[i] = $(this).val();
					i++;
				});
				$.ajax({
					url: "resetlogin2.php",
					data: "kode=" + id_array,
					type: "POST",
					success: function(respon) {
						if (respon == 1) {
							$("input.cekpilih:checked").each(function() {
								$(this).parent().parent().remove('.cekpilih').animate({
									opacity: "hide"
								}, "slow");
							})
						}
					}
				});
				return false;
			})
		});
		// hapus tabel login
		$(document).ready(function() {
			$("#btnresetlogin2").click(function() {
				var name = 'Login';
				swal({
					title: 'Hapus Data '+name,
					text: 'Apakah kamu yakin akan menghapus Semua Data '+name+'? Data tidak dapat dikambelikan',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Hapus!'
				}).then((result) => {
					if (result.value) {
						var data = 'login';
						$.ajax({
							url: 'hapus_all.php',
							data: "id=" + data,
							type: "POST",
							success: function(respon) {
								toastr.success('Berhasil di Hapus Semua');
								location.reload();
							}
						});
					}
				});
			});
			$("#btnresetlogin3").click(function() {
				id_array = new Array();
				i = 0;
				$("input.cekpilih2:checked").each(function() {
					id_array[i] = $(this).val();
					i++;
				});

				swal({
					title: 'Hapus Data ',
					text: 'Apakah kamu yakin akan menghapusData ?',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Hapus!'
				}).then((result) => {
					if (result.value) {
						var data = 'login_id';
						$.ajax({
							url: 'hapus_all.php',
							data: "id=" + data+"&data="+id_array,
							type: "POST",
							success: function(respon) {
								// toastr.success('Berhasil di Hapus Semua');
								// location.reload();
								//console.log(respon);
								if (respon == 1) {
									$("input.cekpilih2:checked").each(function() {
										$(this).parent().parent().remove('.cekpilih').animate({
											opacity: "hide"
										}, "slow");
									})
								}
							}
						});
						return false;
					}
				});
			});
		});
		/*asja*/
		$(function() {
			$("#btnhapusbank").click(function() {
				i = 0;
				id_array = new Array();
				$("input.cekpilih:checked").each(function() {
					id_array[i] = $(this).val();
					i++;
				});
				swal({
					title: 'Bank Soal Terpilih ' + i,
					text: 'Apakah kamu yakin akan menghapus data bank soal yang sudah dipilih  ini ??',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Hapus!'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							url: 'hapusbanksoal.php',
							data: "kode=" + id_array,
							type: "POST",
							success: function(respon) {
								if (respon == 1) {
									$("input.cekpilih:checked").each(function() {
										$(this).parent().parent().remove('.cekpilih').animate({
											opacity: "hide"
										}, "slow");
									})
								}
							}
						})
					}
				});
				return false;
			});
		});
		$(function() {
			$("#btnhapusjadwal").click(function() {
				id_array = new Array();
				i = 0;
				$("input.cekpilih:checked").each(function() {
					id_array[i] = $(this).val();
					i++;
				})
				swal({
					title: 'Jadwal Terpilih ' + i,
					text: 'Apakah kamu yakin akan menghapus data jadwal yang sudah dipilih ini ??',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Hapus!'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							url: 'hapusjadwal.php',
							data: "kode=" + id_array,
							type: "POST",
							success: function(respon) {
								if (respon == 1) {
									$("input.cekpilih:checked").each(function() {
										$(this).parent().parent().remove('.cekpilih').animate({
											opacity: "hide"
										}, "slow");
									})
								}
							}
						})
					}
				});
				return false;
			});

			$("#btnserver").click(function() {

				swal({
					title: 'Ganti Status Server ',
					text: 'Apakah kamu yakin akan mengganti status server ini ??',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Ganti'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							url: 'gantiserver.php',
							type: "POST",
							success: function(respon) {
								location.reload();
							}
						})
					}
				});
				return false;
			})
		});
	</script>

	<script>
		$(function() {
			$("#buatberita").click(function() {
				swal({
					title: 'Generate Berita Acara',
					text: 'Pastikan pembuatan jadwal sudah fix ??',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Buat!'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							url: 'buatberita.php',
							type: "POST",
							beforeSend: function() {
								$('.loader').css('display', 'block');
							},
							success: function(respon) {
								$('.loader').css('display', 'none');
								location.reload();
							}
						})
					}
				});
				return false;
			})
		});
		/*BERITA ACARA ASJA*/
		$(document).ready(function() {
			$("#buatberita2").click(function() {
				var formData = new FormData($('#bc_post')[0]);
        event.preventDefault();
				//console.log(formData)yes;
					$.ajax({
				    url: "buatberita2.php", 
				    type: "POST",             
				    data: formData,
				    contentType: false,       
				    cache: false,             
				    processData:false,
				    
				    success: function(data) {
				        if(data=='oke'){
				        	swal({
	            title: "BERHASIL",
	            text: "Berita Acara Berhasil Di Tambah",
	            icon: "success",
	            button: "Oke",
	            }).then(function() {
	                var link = window.location.href;
	                window.location.replace(link);
	            });
				        }
				        else{
				        	swal({
	              title: "GAGAL !!!",
	              text: "Gagal Buat Berita Acara",
	              icon: "warning",
	              buttons: "No",
	              dangerMode: true,
            		}); 
				        }
				        
				    }
				});
				});

				$("#hapus_bc").click(function() {
							swal({
							title: 'Hapus Berita Acara',
							text: 'Kamu yakin akan menghapus semua berita acara? !!!',
							type: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Ya, Buat!'
						}).then((result) => {
							if (result.value) {
								$.ajax({
									url: 'hapus_beritaacara.php',
									type: "POST",
									beforeSend: function() {
										$('.loader').css('display', 'block');
									},
									success: function(respon) {
										$('.loader').css('display', 'none');
										location.reload();
									}
								})
							}
						});
						return false;
				});

		});
		/*BERITA ACARA ASJA*/

		function printlaporan() {
			var idsesi = $('#sesi option:selected').val();
			var idmapel = $('#mapel option:selected').val();
			var idruang = $('#ruang option:selected').val();
			var idkelas = $('#kelas option:selected').val();
			$('#loadlaporan').attr('src','form_nilai.php?id_sesi='+idsesi+'&id_ruang='+idruang+'&id_mapel='+idmapel+'&id_kelas='+idkelas);
			// alert(idsesi);

		}

		$(document).ready(function() {
			var messages = $('#pesan').notify({
				type: 'messages',
				removeIcon: '<i class="icon icon-remove"></i>'
			});
			$('#formreset').submit(function(e) {
				e.preventDefault();
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					success: function(data) {
						if (data == "ok") {
							messages.show("Reset Login Peserta Berhasil", {
								type: 'success',
								title: 'Berhasil',
								icon: '<i class="icon icon-check-sign"></i>'
							});
						}
						if (data == "pilihdulu") {
							swal({
								position: 'top-end',
								type: 'success',
								title: 'Data Berhasil disimpan',
								showConfirmButton: true
							});
						}
					}
				});
				return false;
			});

		});
	</script>
	<script>
		$('#formsiswa').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				type: 'post',
				url: 'import_siswa.php',
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				beforeSend: function() {
					$('#progressbox').html('<div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div>');
					$('.progress-bar').animate({
						width: "30%"
					}, 100);
				},
				success: function(response) {
					setTimeout(function() {
						$('.progress-bar').css({
							width: "100%"
						});
						setTimeout(function() {
							$('#hasilimport').html(response);
						}, 100);
					}, 500);
				}
			});
		});
	</script>

	<script>
		<?php if ($pg == 'jenisujian') : ?>
			$(document).ready(function() {
				$('#tablejenis').Tabledit({
					url: 'example.php?pg=jenisujian',
					restoreButton: false,
					columns: {
						identifier: [1, 'id'],
						editable: [
							[2, 'namajenis'],
							[3, 'status', '{"aktif": "aktif", "tidak": "tidak"}']
						]
					}
				});
			});
		<?php endif; ?>
		<?php if ($pg == 'pk') : ?>
			$(document).ready(function() {
				$('#tablejurusan').Tabledit({
					url: 'example.php?pg=jurusan',
					restoreButton: false,
					columns: {
						identifier: [1, 'id'],
						editable: [
							[2, 'namajurusan']
						]
					}
				});
			});
		<?php endif; ?>
		<?php if ($pg == 'level') : ?>
			$(document).ready(function() {
				$('#tablelevel').Tabledit({
					url: 'example.php?pg=level',
					restoreButton: false,
					columns: {
						identifier: [1, 'id'],
						editable: [
							[2, 'namalevel']
						]
					}
				});
			});
		<?php endif; ?>
		<?php if ($pg == 'kelas') : ?>
			$(document).ready(function() {
				$('#tablekelas').Tabledit({
					url: 'example.php?pg=kelas',
					restoreButton: false,
					columns: {
						identifier: [1, 'id'],
						editable: [
							[2, 'level'],
							[3, 'namakelas'],
							[4, 'id_pk']
						]
					}
				});
			});
		<?php endif; ?>
		<?php if ($pg == 'matapelajaran') : ?>
			$(document).ready(function() {
				$('#tablemapel').Tabledit({
					url: 'example.php?pg=mapel',
					restoreButton: false,
					columns: {
						identifier: [1, 'id'],
						editable: [
							[2, 'namamapel']
						]
					}
				});
			});
		<?php endif; ?>
		<?php if ($pg == 'ruang') : ?>
			$(document).ready(function() {
				$('#tableruang').Tabledit({
					url: 'example.php?pg=ruang',
					restoreButton: false,
					columns: {
						identifier: [1, 'id'],
						editable: [
							[2, 'namaruang']
						]
					}
				});
			});
		<?php endif; ?>
		<?php if ($pg == 'sesi') : ?>
			$(document).ready(function() {
				$('#tablesesi').Tabledit({
					url: 'example.php?pg=sesi',
					restoreButton: false,
					columns: {
						identifier: [1, 'id'],
						editable: [
							[2, 'namasesi']
						]
					}
				});
			});
		<?php endif; ?>
	</script>
	<script>
		$(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
			
			//asja
			//tampil kelas berdasarkan level pada tambah bank soal
			$("#soallevel").change(function() {
				var level = $(this).val();
				console.log(level);
				$.ajax({
					type: "POST", // Method pengiriman data bisa dengan GET atau POST
					url: "datakelas.php", // Isi dengan url/path file php yang dituju
					data: "level=" + level, // data yang akan dikirim ke file yang dituju
					success: function(response) { // Ketika proses pengiriman berhasil
						$("#soalkelas").html(response);
					}
				});
			});

			
			$(document).on('click', '.ambiljawaban', function() {
				var idmapel = $(this).data('id');
				console.log(idmapel);
				swal({
					title: 'Are you sure?',
					text: 'Fungsi ini akan memindahkan data jawaban dari temp_jawaban ke hasil jawaban',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Ambil!'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: 'ambiljawaban.php',
							data: 'id=' + idmapel,
							beforeSend: function() {
								swal({
									text: 'Proses memindahkan',
									timer: 1000,
									onOpen: () => {
										swal.showLoading()
									}
								});
							},
							success: function(response) {
								$(this).attr('disabled', 'disabled');
								swal({
									position: 'top-end',
									type: 'success',
									title: 'Data Berhasil diambil',
									showConfirmButton: false,
									timer: 1500
								});
							}
						});
					}
				})
			});

			// asja pengacak opsi dan soal
			$(document).on('click', '.btnresetacak', function() {
				var idacak = $(this).data('id');
				var idu = $(this).data('idu');
				console.log(idacak);
				swal({
					title: 'Are you sure?',
					text: 'Fungsi ini akan mengacak kembali soal dan opsi soal',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Ambil!'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: 'resetacak.php',
							data: 'id=' + idacak + '&idu=' + idu,
							beforeSend: function() {
								swal({
									text: 'Proses memindahkan',
									timer: 1000,
									onOpen: () => {
										swal.showLoading()
									}
								});
							},
							success: function(response) {
								location.reload();

							}
						});
					}
				})
			});
			$(document).on('click', '.btnresetacakpg', function() {
				var idacak = $(this).data('id');
				var idu = $(this).data('idu');
				console.log(idacak);
				swal({
					title: 'Apakah Yakin Ingin Di Acak Siwa Ini?',
					text: 'Fungsi ini akan mengacak kembali soal dan opsi soal',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Ambil!'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: 'resetacak_opsi.php',
							data: 'id=' + idacak + '&idu=' + idu,
							beforeSend: function() {
								swal({
									text: 'Proses memindahkan',
									timer: 1000,
									onOpen: () => {
										swal.showLoading()
									}
								});
							},
							success: function(response) {
								location.reload();
								//alert(response);

							}
						});
					}
				})
			});
		});
		$(document).on('click', '#hapus_history', function() {
			var id = 1;
			$.ajax({
				type: 'POST',
				url: 'core/c_aksi.php?hapus=history',
				data: {id:id},
				success: function(response) {
					//location.reload();
					if(response == 1){
						location.reload();
					}
					else if(response==100){
						alert("Upssss Perintah Tidak Sesuai");
					}
					else{
						alert('Gagal Hapus Tabel');
					}
				}
			});
		});
	</script>
</body>

</html>