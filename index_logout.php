<?php
// require("config/config.default.php");
include("core/c_user.php"); 
require("config/config.function.php");
require("config/functions.crud.php");
require("config/config.asja.php");

(isset($_SESSION['id_siswa'])) ? $id_siswa = $_SESSION['id_siswa'] : $id_siswa = 0;
($id_siswa == 0) ?  header("Location:$homeurl/login.php") : null;
($pg == 'testongoing') ? $sidebar = 'sidebar-collapse' : $sidebar = '';
($pg == 'testongoing') ? $disa = '' : $disa = 'offcanvas';
$siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id_siswa'"));
$kelasdb = fetch($koneksi, 'kelas', array('id_kelas' => $siswa['id_kelas']));
$idkelas = $kelasdb['idkls'];

$idsesi = $siswa['sesi'];
$idpk = $siswa['idpk'];
$level = $siswa['level'];
$pk = fetch($koneksi, 'pk', array('id_pk' => $idpk));
$tglsekarang = time();
function selectAktif($data1=null,$data2=null)
{
    //untuk select option
    $selected = 'selected="selected"';
    if(!$data1==null){
        if($data1==$data2){ echo $selected;  }else{ echo"";}
    }
}
?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv='X-UA-Compatible' content='IE=edge' />
  <title><?= $setting['sekolah'] ?></title>
  <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' />
  <link rel='shortcut icon' href='<?= $homeurl ?>/<?php echo $setting['logo']; ?>' />
  <link rel='stylesheet' href='<?= $homeurl ?>/dist/bootstrap/css/bootstrap.min.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/fontawesome/css/all.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/dist/css/AdminLTE.min.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/dist/css/skins/skin-green-light.min.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/iCheck/square/green.css' />
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/animate/animate.min.css'>
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/sweetalert2/dist/sweetalert2.min.css'>
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/slidemenu/jquery-slide-menu.css'>
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/toastr/toastr.min.css'>
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/radio/css/style.css'>
  <link rel='stylesheet' href='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.css' />
  <script src='<?= $homeurl ?>/plugins/datatables/jquery.dataTables.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/jQuery/jquery-2.2.3.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/tinymce/tinymce.min.js'></script>
  <link href="<?= $homeurl ?>/plugins/summernote/summernote-bs4.css" rel="stylesheet">
  <script src="<?= $homeurl ?>/plugins/summernote/summernote-bs4.js"></script>
  <script src='<?= $homeurl ?>/plugins/datatables/jquery.dataTables.min.js'></script>
  <script src='<?= $homeurl ?>/plugins/datatables/dataTables.bootstrap.min.js'></script>
  <script src="<?= $homeurl ?>/JICC.min.js" type="text/javascript"></script>
  <style type="text/css">
  .rapih{
      position: relative;
      display: inline-block;
      width: 20rem;
    }     
  	.btn {
  		display: inline-block;
  		/*padding: 6px 12px;*/
  		margin-bottom: 3px;
  		font-size: 14px;
  		font-weight: 400;
  		line-height: 1.42857143;
  		text-align: center;
  		white-space: nowrap;
  		vertical-align: middle;
  		-ms-touch-action: manipulation;
  		touch-action: manipulation;
  		cursor: pointer;
  		-webkit-user-select: none;
  		-moz-user-select: none;
  		-ms-user-select: none;
  		user-select: none;
  		background-image: none;
  		border: 1px solid transparent;
  		border-radius: 15px;
  	}
  	.btn-app>.badge {
  		position: absolute;
  		top: -3px;
  		right: -10px;
  		font-size: 10px;
  		font-weight: 400;
  	}
  	.btn .badge {
  		top: -1px;
  	}
  	.badge {
  		display: inline-block;
  		min-width: 10px;
  		padding: 3px 7px;
  		font-size: 12px;
  		font-weight: 700;
  		line-height: 1;
  		color: #fff;
  		text-align: center;
  		white-space: nowrap;
  		vertical-align: middle;
  		background-color: #777;
  		border-radius: 10px;
  	}
		.soal img {
			max-width: 100%;
			height: auto;
		}
		.main-header .sidebar-baru {
			float: left;
			color: white;
			padding: 15px 15px;
			cursor: pointer;
		}
		.callout {
			border-left: 0px;
		}

		.btn {
			border-radius: 20em;
		}

		.btn.btn-flat {
			border-radius: 20em;
		}

		.skin-red-light .sidebar-menu>li:hover>a,
		.skin-red-light .sidebar-menu>li.active>a {
			color: #fff;
			background: #e111e8;
		}
		$('.soaltanya > p > span').css({
          fontSize: fontSize + 'pt'
        });

		.wrapper-page {
			margin: 7.5% auto;
			width: 360px;
		}
		.wrapper-page .form-control-feedback {
			left: 15px;
			top: 3px;
			color: rgba(76, 86, 103, 0.4);
			font-size: 20px;
		}
		.logo {
			color: #3bafda !important;
			font-size: 18px;
			font-weight: 700;
			letter-spacing: .02em;
			line-height: 70px;
		}
		.logo-lg {
			font-size: 28px !important;
		}
		.logo i {
			color: red;
		}
		.skin-green-light .sidebar-menu>li:hover>a, .skin-green-light .sidebar-menu>li.active>a{
			color: #fff;
			background:#0030a7;
			<?php 
			if($setting['jenjang'] =='SMK' ){
				echo "color: #fff;";
				//echo "background:#00a896;";
				echo"background-color: #1fc8db;background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);color: white;opacity: 0.95;";
			}
			elseif($setting['jenjang'] =='SMP'){
				echo "color: #fff;";
				echo "background:#0030a7;";
			}
			elseif($setting['jenjang'] =='SD'){
				echo "color: #fff;";
				echo "background:#c74230;";
			}
			else{
				echo "color: #fff;";
				echo "background:#00a896;";
			}
			?>
		}
		/*Mode Gelap*/
		.theme-switch-wrapper {
			display: flex;
			margin-top: 0;
			/*margin-left: 2em;*/
		}
		em {
			margin-top: 0.5em;
			margin-left: 1em;
			font-size: 1rem;
		}
		.theme-switch {
		  display: inline-block;
		  height: 34px;
		  position: relative;
		  width: 60px;
		}

		.theme-switch input {
		  display:none;
		}

		.slider {
		  background-color: #ccc;
		  bottom: 0;
		  cursor: pointer;
		  left: 0;
		  position: absolute;
		  right: 0;
		  top: 0;
		  transition: .4s;
		}

		.slider:before {
		  background-color: #fff;
		  bottom: 4px;
		  content: "";
		  height: 26px;
		  left: 4px;
		  position: absolute;
		  transition: .4s;
		  width: 26px;
		}

		input:checked + .slider {
		  background-color: #66bb6a;
		}

		input:checked + .slider:before {
		  transform: translateX(26px);
		}

		.slider.round {
		  border-radius: 34px;
		}

		.slider.round:before {
		  border-radius: 50%;
		}
		.footer {
		   position: fixed;
		   left: 0;
		   bottom: 0;
		   width: 100%;
		   text-align: center;
		}
		.loading {
		  position: absolute;
		  left: 50%;
		  top: 70%;
		  transform: translate(-50%,-50%);
		  font: 14px arial;
		  }
		</style>
		<link rel='stylesheet' href='<?= $homeurl ?>/dist/css/costum.css' />
		 <script type="text/javascript">
		   $(document).ready(function(){
		    $('.loader').fadeOut('slow');
		  });
		</script>
</head>

<body class='hold-transition skin-green-light  fixed <?= $sidebar ?>' >
	<div id='pesan'></div>
	<div class='loader'>
		<div class="loading">
   	 <p id="pesanku" >Harap Tunggu</p>
  	</div>
	</div>
	<span id='livetime'></span>
	<div class='wrapper'>
		<header class='main-header'>
			<a class='logo' style='background-color:#f9fafc'>
				<span class='animated flipInX logo-mini'>
					<img src="<?= $homeurl . "/" . $setting['logo'] ?>" height="30px">
				</span>
				<span class='animated flipInX' style="margin:-3px;color:#000">
					 <?= $setting['sekolah'] ?>
				</span>
			</a>
			<?php 
				if($setting['jenjang'] =='SMK' ){
					//$style="style='background-color:#00a896;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
					$style="style='background-color: #1fc8db;background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);color: white;opacity: 0.95;'";
				}
				elseif($setting['jenjang'] =='SMP'){
					$style="style='background-color:#060151;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
				}
				elseif($setting['jenjang'] =='SD'){
					$style="style='background-color:#dd4c39;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
				}
				else{
					$style="style='background-color:#00a896;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
				}
				?>
			<nav class='navbar navbar-static-top' <?= $style ;?> role='navigation'>
				<a href='#' class='sidebar-baru' data-toggle='<?= $disa ?>' role='button'>
					<i class="fa fa-bars fa-lg fa-fw"></i> MENU
				</a>

				<div class='navbar-custom-menu'>
					<ul class='nav navbar-nav'>
						<li class="visible-xs"><a><?= $siswa['nama'] ?></a></li>
						<li class='dropdown user user-menu'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
								<?php
								if ($siswa['foto'] <> '') :
									if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
										echo "<img src='$homeurl/dist/img/avatar_default.png' class='user-image'   alt='+'>";
									else :
										echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='user-image'   alt='+'>";
									endif;
								else :
									echo "<img src='$homeurl/dist/img/avatar_default.png' class='user-image'   alt='+'>";
								endif;
								?>
								<span class='hidden-xs'><?= $siswa['nama'] ?> &nbsp; <i class='fa fa-caret-down'></i></span>
							</a>
							<ul class='dropdown-menu'>
								<li class='user-header'>
									<?php
									if ($siswa['foto'] <> '') :
										if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
											echo "<img src='$homeurl/dist/img/avatar_default.png' class='img-circle' alt='User Image'>";
										else :
											echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='img-circle' alt='User Image'>";
										endif;
									else :
										echo "<img src='$homeurl/dist/img/avatar_default.png' class='img-circle' alt='User Image'>";
									endif;
									?>
									<p>
										<?= $siswa['nama'] ?>
									</p>
								</li>
								<li class='user-footer'>
									<div class='pull-right'>
										<a href='<?= $homeurl ?>/logout.php' class='btn btn-sm btn-default btn-flat'><i class='fa fa-sign-out'></i> Keluar</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<?php if($siswa['id_siswa'] == $_SESSION['id_siswa'] AND $siswa['status_siswa'] ==1) {?>
		<aside class='main-sidebar'>
			<section class='sidebar'>
				<hr style="margin:0px">
				<div class='user-panel'>
					<div class='pull-left image'>
						<?php
						if ($siswa['foto'] <> '') :
							if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
								echo "<img src='$homeurl/dist/img/avatar_default.png' class='img'  style='max-width:60px' alt='+'>";
							else :
								echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='img'  style='max-width:60px; height:60px;' alt='+'>";
							endif;
						else :
							echo "<img src='$homeurl/dist/img/avatar_default.png' class='img'  style='max-width:60px' alt='+'>";
						endif;
						?>
					</div>
					<div class='pull-left info' style='left:65px'>
						<?php
						if (strlen($siswa['nama']) > 15) {
							$nama = substr($siswa['nama'], 0, 15) . "...";
						} else {
							$nama = $siswa['nama'];
						}
						?>
						<p title="<?= $siswa['nama'] ?>"><?= $nama ?></p>
						<a href='#'><i class='fa fa-circle text-green'></i> online</a><br>
						<a href='#'><i class='fa fa-circle text-blue'></i> <?= $siswa['id_kelas']?></a><br>
						<a href='#'><i class='fa fa-circle text-red'></i> <?= $siswa['idpk'] ?></a>
					</div>
				</div>
				<hr style="margin:0px">
				<ul class='sidebar-menu tree' data-widget='tree'>
					<li class='header'>Main Menu Siswa</li>
					<li><a href='<?= $homeurl ?>'><i class='fas fa-tachometer-alt fa-fw fa-2x '></i> <span> Dashboard</span></a></li>
					<hr style="margin:0px">
					<?php if($setting['izin_info']==1){ ?>
					<li><a href='<?= $homeurl ?>/pengumuman'><img src="<?= $homeurl ?>/icon_siswa/megaphone.svg" width="30" height="30"> <span> Pengumuman</span></a></li>
					<hr style="margin:0px">
					<?php }else{ } ?>
					<?php if($setting['izin_absen']==1){ ?>
					 <li><a href='<?= $homeurl ?>/absen/'><img src="<?= $homeurl ?>/icon_siswa/attendance_sekolah.svg" width="30" height="30"> <span> Absen Sekolah</span></a></li>
					<?php } if($setting['izin_absen_mapel']==1){ ?>
					<li><a href='<?= $homeurl ?>/absen_mapel/'><img src="<?= $homeurl ?>/icon_siswa/attendance.svg" width="30" height="30"> <span> Absen Mata Pelajaran</span></a></li>
					<?php }?>
					<?php if($setting['izin_materi']==1){ ?>
					<li><a href='<?= $homeurl ?>/meeting'><img src="<?= $homeurl ?>/icon_siswa/camcorder_pro.svg" width="30" height="30">  Tatap Muka<?= ($rooms > 0) ? '<span class="badge bg-yellow" style="float: right; margin-top: 0;">ON</span>' : '' ?></a></li>
					<?php }?>
					<?php if($setting['izin_materi']==1){ ?>
					 <li><a href='<?= $homeurl ?>/materi/'><img src="<?= $homeurl ?>/icon_siswa/book.svg" width="30" height="30"><span> Materi</span></a></li>
           <hr style="margin:0px">
           <?php }else{ } ?>
           <?php if($setting['izin_tugas']==1){ ?>
			<li><a href='<?= $homeurl ?>/tugassiswa'><img src="<?= $homeurl ?>/icon_siswa/tugas.svg" width="30" height="30"><span> Tugas Siswa</span></a></li>
           <hr style="margin:0px">
           <?php }else{ } ?>
           <?php if($setting['izin_ujian']==1){?>
  		   <li><a href='<?= $homeurl ?>/hasil'><img src="<?= $homeurl ?>/icon_siswa/result.svg" width="30" height="30"><span> Hasil Ujian</span></a></li>
		   <hr style="margin:0px">
  		   <?php } ?>

					<?php if($setting['izin_pass']==1){ ?>
                    <li><a href='<?= $homeurl ?>/pass'><img src="<?= $homeurl ?>/icon_siswa/login.svg" width="30" height="30"> <span> Ganti Password</span></a></li>
					<hr style="margin:0px">
					<?php }else{ } ?>
					<hr style="margin:0px">
				</ul><!-- /.sidebar-menu -->
			</section>
		</aside>
		<?php } else { ?>
        <?php
        $jump = jump("$homeurl/logout.php")
        ?>
		<?php } ?>
		</aside>
		<?php 
		if($setting['jenjang'] =='SMK' ){
			$style1="height:102px;z-index:0; background:#587ea3";
			/* #587ea3,#00a896,#007bb6,#2c4762 */
		}
		elseif($setting['jenjang'] =='SMP'){
			$style1="height:102px;z-index:0; background:#0030a7";
		}
		elseif($setting['jenjang'] =='SD'){
			$style1="height:102px;z-index:0; background:#c74230";
		}
		else{
			$style1="height:102px;z-index:0; background:#00a896";
		}
		?>
		<div class='content-wrapper' style='background-image: url(admin/backgroun.jpg);background-size: cover;'>
			<section class='content-header' style="<?= $style1; ?>">
			</section>
			<!-- Halaman Dashbord Siswa -->
			<section class='content' style="margin-top:-95px">
		<?php if ($pg == '') : ?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='alert alert-info alert-dismissible'>
								<?php if($setting['izin_ujian']==1){ ?>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
								<i class='icon fa fa-info'></i>
								Tombol ujian akan aktif bila waktu sudah sama dengan jadwal ujian,
								Refresh browser atau tekan F5 jika waktu ujian belum aktif
								<?php }
								else{
									echo"Jangan lupa berdoa terlebih dahulu";
								}
								?>
							</div>
						</div>

						<div id="boxtampil" class='col-md-12'>
							<?php if($setting['izin_ujian']==0){ ?>
							<div class='box box-solid'>
								<div class='box-header with-border'>
									<div class="text-center">
									<h3 class='box-title'><i class="fa fa-bars fa-lg fa-fw"></i> MENU E-LEARNING</h3>
									</div>
								</div>
								<!-- menu e-learing siswa -->
								<div class='box-body'>
									<div class="text-center">
										<div class="row">
											<div class="col-md-12">
												<style type="text/css">.btn {
												    border-radius: 3px;
												    -webkit-box-shadow: none;
												    box-shadow: none;
												    border: 1px solid transparent;
												}</style>
												<div class="row">
                          <div class="col-md-12">
                            <?php if($setting['izin_ujian']==1){ ?>
                              <?php if($siswa['status_siswa']==1){ ?>
                                <a style="width: 320px;" href="<?= $homeurl ?>/ujian" class="rapih btn btn-app btn-primary">
                                  <img src="icon_siswa/ubk.svg" width="30" height="30"> <b> Ujian Sekolah</b>
                                </a>
                               <?php }else{ ?>
                                <button disabled class="rapih btn btn-app">
                                 <b> Status OFF, Hubungi Admin</b>
                                </button>
                               <?php } ?>
                            <?php }?>
                          </div>
                        </div>
                        
                        <!-- bagian absensi -->
                        <div class="row"> 
                        <?php if($setting['izin_materi']==1){ ?>
                        <div class="row">
                          <a href='<?= $homeurl ?>/meeting' class="rapih btn btn-app btn-primary"><img src="<?= $homeurl ?>/icon_siswa/camcorder_pro.svg" width="30" height="30"> <b>Tatap Muka</b>
                          <?= ($rooms > 0) ? '<span class="badge bg-yellow" style="float: right; margin-top: 0;">ON</span>' : '' ?></a>
                        </div>
                         <?php }?>
                        
                          <?php if($setting['izin_absen']==1){ ?>
                          <a  href="<?= $homeurl ?>/absen/" class="rapih btn btn-app btn-primary" >
                            <img src="icon_siswa/attendance_sekolah.svg" width="30" height="30"> 
                            <b> Absen Sekolah</b>
                          </a>
                          <?php }?>
                          <?php if($setting['izin_absen_mapel']==1){ ?>
                          <a href="<?= $homeurl ?>/absen_mapel/" class="rapih btn btn-app btn-primary" >
                            <img src="icon_siswa/attendance.svg" width="30" height="30"> <b> Absen Mapel</b>
                          </a>
                          <?php }?>
                        </div>
                        
                        <div class="row" >
                         <?php if($setting['izin_materi']==1){ ?>
                          <a href="<?= $homeurl ?>/materi/" class="rapih btn btn-app btn-primary">
                            <img src="icon_siswa/book.svg" width="30" height="30"> <b> Materi</b>
                          </a>
                        <?php }?>
                        <?php if($setting['izin_tugas']==1){ ?>
                          <a href="<?= $homeurl ?>/tugassiswa/" class="rapih btn btn-app btn-primary">
                            <img src="icon_siswa/tugas.svg" width="30" height="30"> <b> Tugas</b>
                          </a>
                        <?php }?>
                      </div>
                       
                       <div class="row">
                            <?php if($setting['izin_info']==1){ ?>
                            <a href="<?= $homeurl ?>/pengumuman/" class="rapih btn btn-app btn-primary">
                              <img src="icon_siswa/megaphone.svg" width="30" height="30"> <b> Informasi Sekolah</b>
                            </a>
                          <?php }?>
                            <?php if($setting['izin_tugas']==1){ ?>
                            <a href="<?= $homeurl ?>/hasil/" class="rapih btn btn-app btn-primary">
                              <img src="icon_siswa/result.svg" width="30" height="30"> <b> Hasil Ujian</b>
                            </a>
                          <?php }?>
                        </div>
                        <?php if($setting['izin_pass']==1){ ?>
                    <a href='<?= $homeurl ?>/pass/' class="rapih btn btn-app btn-primary">
                    <img src="<?= $homeurl ?>/icon_siswa/login.svg" width="30" height="30"> <span> <b>Ganti Password</b></span></a>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="box box-solid bg-purple"><marquee>Hallo <?= $siswa['nama'] ?>. Selamat datang diaplikasi pembelajaran daring <?=$setting['sekolah'] ?>, jangan lupa absen dan kerjakan tugas hari ini.</marquee> </div>
							<?php }else{ ?>
							<div id='formjadwalujian' class='box box-solid'>
								<div class="row">
									<div class="col-md-4">
										<a href='<?= $homeurl ?>/logout.php' class='btn btn-sm btn-danger'><i class="fa fa-sign-out" aria-hidden="true"></i> Keluar Dari Ujian</a>
									</div>
								</div>
								<div class='box-header with-border'>
									<h3 class='box-title'><i class="fas fa-calendar-alt"></i> Jadwal Ujian Hari ini</h3>
									<div class='box-tools'>
										<button class='btn btn-flat btn-primary'><span id='waktu' style="font-family:'OCR A Extended'"><?= $waktu ?> </span></button>
									</div>
								</div><!-- /.box-header -->
								<div class='box-body'>
									<!-- asja untuk meanmpilkan jadwal pada halaman dashbor siswa -->
									<?php
									//idpk adalah di jurusan atau prodi
									//filter data ujian 
									if ($idpk <> '') :
										$mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian WHERE (id_pk='$idpk' or id_pk='semua') AND (level='$level' or level='semua') AND sesi='$idsesi' AND status='1' ORDER BY tgl_ujian ");
									else :
										$mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian WHERE (level='$level' or level='semua') AND sesi='$idsesi' AND status='1' ORDER BY tgl_ujian ");
									endif;
									?>
									<?php while ($mapelx = mysqli_fetch_array($mapelQ)) : ?>
										<?php if (date('Y-m-d', strtotime($mapelx['tgl_selesai'])) >= date('Y-m-d') and date('Y-m-d', strtotime($mapelx['tgl_ujian'])) <= date('Y-m-d')) : ?>
											<?php 
												//ubah ke array kolom kelas di tabel mapel
												$datakelas = unserialize($mapelx['kelas']);
												//ubah ke array kolom id_siswa di tabel mapel
												$dataidsiswa = unserialize($mapelx['siswa']); 
												$id_siswa = $siswa['id_siswa'];

												//jika khusus ada di data kelas dan siswa tidak kosong
												if(in_array('khusus', $datakelas) and  !empty($dataidsiswa)){
													$warna = 'bg-red';
												}
												//jika semua ada di datakelas
												elseif(in_array('semua', $datakelas)){
													$warna = 'bg-blue';
												}
												//jika datakelas tidak kosong dan data siswa tidak kosong
												elseif(!empty($datakelas) and  !empty($dataidsiswa)){
													$warna = 'bg-purple';
												}
												//jika data kelas tidak kosong dan data siswa kosong
												elseif(!empty($datakelas) and  empty($dataidsiswa)){
													$warna = 'bg-green';
												}
												//selain semuanya
												else{
													$warna = 'bg-blue';
												}
												
												?>
												
												<!-- jika id_siswa dan kelas sesuai maka tampilkan jadwal yang ada kelas dan id_siswanya --> 
												<?php if (in_array($id_siswa, $dataidsiswa) and in_array($siswa['id_kelas'], $datakelas)) : ?>
													<?php
													$no++;
													// $pelajaran = explode(' ', $mapelx['nama']);
													$where = array(
														'id_ujian' => $mapelx['id_ujian'],
														'id_mapel' => $mapelx['id_mapel'],
														'id_siswa' => $id_siswa,
														'kode_ujian' => $mapelx['kode_ujian']
													);
													$nilai = fetch($koneksi, 'nilai', $where);
													$ceknilai = rowcount($koneksi, 'nilai', $where);
													if ($ceknilai == '0') :
														if (strtotime($mapelx['tgl_ujian']) <= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
															$status = '<label class="label label-success">Tersedia </label>';
															$btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-primary'><i class='fa fa-edit'></i> MULAI</button>";
														elseif (strtotime($mapelx['tgl_ujian']) >= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
															$status = '<label class="label label-danger">Belum Waktunya</label>';
															$btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> BELUM UJIAN</button>";
														else :
															$status = '<label class="label label-danger">Telat Ujian</label>';
															$btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> Telat Ujian</button>";
														endif;
													else :
														if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] == '') :
															if ($nilai['online'] == 0) {
																$status = '<label class="label label-warning">Berlangsung</label>';
																$btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-success'><i class='fas fa-edit'></i> LANJUTKAN</button>";
															} else {
																$status = '<label class="label label-warning">Siswa sedang aktif</label>';
																$btntest = "<button  class=' btn btn-block btn-sm btn-success' disabled><i class='fas fa-edit'></i> LANJUTKAN</button>";
															} else :
															if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] <> '') {
																$status = '<label class="label label-primary">Selesai</label>';
																$btntest = "<button class='btn btn-block btn-success btn-sm disabled'> Sudah Ujian</button>";
															} else {
																$btntest = "<button class='btn btn-block btn-danger btn-sm disabled'> Eloy</button>";
															}
														endif;
													endif;
													?>
													<div class="col-md-4">
														<!-- Widget: user widget style 1 -->
														<div class="box box-widget widget-user-2">
															<!-- Add the bg color to the header using any of the bg-* classes -->
															<div class="widget-user-header <?= $warna; ?>" style="padding: 6px">

																<!-- /.widget-user-image -->
																<h3 class="widget-user-username"><?= $mapelx['nama'] ?></h3>
																<h5 class="widget-user-desc">
																	<i class="fa fa-tag"></i> <?= $mapelx['kode_ujian'] ?> &nbsp;
																	<i class="fa fa-user"></i> <?= $mapelx['level'] ?> &nbsp;
																	<i class="fa fa-wrench"></i> <?= $mapelx['id_pk'] ?>
																</h5>
															</div>
															<div class="box-footer no-padding">
																<ul class="nav nav-stacked">
																	<li>
																		<a href="#">
																			<i class='fa fa-clock-o'></i> Ujian Dimulai
																			<span class="pull-right badge bg-green"><?= $mapelx['tgl_ujian'] ?></span>
																		</a>
																	</li>
																	<li>
																		<a href="#">
																			<i class='fa fa-clock-o'></i> Ujian Ditutup
																			<span class="pull-right badge bg-red"><?= $mapelx['tgl_selesai'] ?></span>
																		</a>
																	</li>
																	<li>
																		<a href="#">
																			<i class='fa  fa-hourglass-1'></i> Durasi Ujian
																			<span class="pull-right badge bg-purple"><?= $mapelx['tampil_pg'] ?> Soal / <?= $mapelx['lama_ujian'] ?> menit</span>
																		</a>
																	</li>
																	<li><a href="#"><i class='fa fa-feed'></i> Status Ujian <span class="pull-right">
																				<?php
																				if ($mapelx['status'] == 1) {
																					echo "<i class='fa fa-spinner fa-spin'></i> <label class='badge bg-green'>Sedang Aktif</label> <label class='badge bg-red'>Sesi $mapelx[sesi]</label>";
																				} elseif ($mapelx['status'] == 0) {
																					echo "<label class='badge bg-red'>Tidak Aktif</label>";
																				}
																				?>
																			</span></a></li>
																	<li>
																		<a href="#">
																			<i class='fa  fa-hourglass-1'></i> Status Test
																			<span class="pull-right"><?= $status ?></span>
																		</a>
																	</li>
																</ul>
																<center style="padding: 8px">
																	<?= $btntest ?>
																</center>
															</div>
														</div>
														<!-- /.widget-user -->
													</div>
											
												<!--jika data siswa khusu kosong, tampilkan ujian yang hanya kelas saja -->
												<!-- untuk ujian berdasarkan kelas  -->
												<?php elseif(empty($dataidsiswa) and in_array($siswa['id_kelas'], $datakelas)): ?>

													<?php
													$no++;
													// $pelajaran = explode(' ', $mapelx['nama']);
													$where = array(
														'id_ujian' => $mapelx['id_ujian'],
														'id_mapel' => $mapelx['id_mapel'],
														'id_siswa' => $id_siswa,
														'kode_ujian' => $mapelx['kode_ujian']
													);
													$nilai = fetch($koneksi, 'nilai', $where);
													$ceknilai = rowcount($koneksi, 'nilai', $where);
													if ($ceknilai == '0') :
														if (strtotime($mapelx['tgl_ujian']) <= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
															$status = '<label class="label label-success">Tersedia </label>';
															$btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-primary'><i class='fa fa-edit'></i> MULAI</button>";
														elseif (strtotime($mapelx['tgl_ujian']) >= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
															$status = '<label class="label label-danger">Belum Waktunya</label>';
															$btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> BELUM UJIAN</button>";
														else :
															$status = '<label class="label label-danger">Telat Ujian</label>';
															$btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> Telat Ujian</button>";
														endif;
													else :
														if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] == '') :
															if ($nilai['online'] == 0) {
																$status = '<label class="label label-warning">Berlangsung</label>';
																$btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-success'><i class='fas fa-edit'></i> LANJUTKAN</button>";
															} else {
																$status = '<label class="label label-warning">Siswa sedang aktif</label>';
																$btntest = "<button  class=' btn btn-block btn-sm btn-success' disabled><i class='fas fa-edit'></i> LANJUTKAN</button>";
															} else :
															if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] <> '') {
																$status = '<label class="label label-primary">Selesai</label>';
																$btntest = "<button class='btn btn-block btn-success btn-sm disabled'> Sudah Ujian</button>";
															} else {
																$btntest = "<button class='btn btn-block btn-danger btn-sm disabled'> Eloy</button>";
															}
														endif;
													endif;
													?>
													<div class="col-md-4">
														<!-- Widget: user widget style 1 -->
														<div class="box box-widget widget-user-2">
															<!-- Add the bg color to the header using any of the bg-* classes -->
															<div class="widget-user-header <?= $warna; ?>" style="padding: 6px">

																<!-- /.widget-user-image -->
																<h3 class="widget-user-username"><?= $mapelx['nama'] ?></h3>
																<h5 class="widget-user-desc">
																	<i class="fa fa-tag"></i> <?= $mapelx['kode_ujian'] ?> &nbsp;
																	<i class="fa fa-user"></i> <?= $mapelx['level'] ?> &nbsp;
																	<i class="fa fa-wrench"></i> <?= $mapelx['id_pk'] ?>
																</h5>
															</div>
															<div class="box-footer no-padding">
																<ul class="nav nav-stacked">
																	<li>
																		<a href="#">
																			<i class='fa fa-clock-o'></i> Ujian Dimulai
																			<span class="pull-right badge bg-green"><?= $mapelx['tgl_ujian'] ?></span>
																		</a>
																	</li>
																	<li>
																		<a href="#">
																			<i class='fa fa-clock-o'></i> Ujian Ditutup
																			<span class="pull-right badge bg-red"><?= $mapelx['tgl_selesai'] ?></span>
																		</a>
																	</li>
																	<li>
																		<a href="#">
																			<i class='fa  fa-hourglass-1'></i> Durasi Ujian
																			<span class="pull-right badge bg-purple"><?= $mapelx['tampil_pg'] ?> Soal / <?= $mapelx['lama_ujian'] ?> menit</span>
																		</a>
																	</li>
																	<li><a href="#"><i class='fa fa-feed'></i> Status Ujian <span class="pull-right">
																				<?php
																				if ($mapelx['status'] == 1) {
																					echo "<i class='fa fa-spinner fa-spin'></i> <label class='badge bg-green'>Sedang Aktif</label> <label class='badge bg-red'>Sesi $mapelx[sesi]</label>";
																				} elseif ($mapelx['status'] == 0) {
																					echo "<label class='badge bg-red'>Tidak Aktif</label>";
																				}
																				?>
																			</span></a></li>
																	<li>
																		<a href="#">
																			<i class='fa  fa-hourglass-1'></i> Status Test
																			<span class="pull-right"><?= $status ?></span>
																		</a>
																	</li>
																</ul>
																<center style="padding: 8px">
																	<?= $btntest ?>
																</center>
															</div>
														</div>
														<!-- /.widget-user -->
													</div>
												
													<!-- jika kelas sesuai tapi id siswa di kolom tabel ujian kosong-->

												<!-- Jika id Siswa ada dan Status Kelas Khusu maka tampil Jadwal Khusu untuk siswa  (untuk siswa khusus)-->
												<?php elseif(in_array($id_siswa, $dataidsiswa) and in_array('khusus', $datakelas)): ?>

													<?php
													$no++;
													// $pelajaran = explode(' ', $mapelx['nama']);
													$where = array(
														'id_ujian' => $mapelx['id_ujian'],
														'id_mapel' => $mapelx['id_mapel'],
														'id_siswa' => $id_siswa,
														'kode_ujian' => $mapelx['kode_ujian']
													);
													$nilai = fetch($koneksi, 'nilai', $where);
													$ceknilai = rowcount($koneksi, 'nilai', $where);
													if ($ceknilai == '0') :
														if (strtotime($mapelx['tgl_ujian']) <= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
															$status = '<label class="label label-success">Tersedia </label>';
															$btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-primary'><i class='fa fa-edit'></i> MULAI</button>";
														elseif (strtotime($mapelx['tgl_ujian']) >= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
															$status = '<label class="label label-danger">Belum Waktunya</label>';
															$btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> BELUM UJIAN</button>";
														else :
															$status = '<label class="label label-danger">Telat Ujian</label>';
															$btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> Telat Ujian</button>";
														endif;
													else :
														if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] == '') :
															if ($nilai['online'] == 0) {
																$status = '<label class="label label-warning">Berlangsung</label>';
																$btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-success'><i class='fas fa-edit'></i> LANJUTKAN</button>";
															} else {
																$status = '<label class="label label-warning">Siswa sedang aktif</label>';
																$btntest = "<button  class=' btn btn-block btn-sm btn-success' disabled><i class='fas fa-edit'></i> LANJUTKAN</button>";
															} else :
															if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] <> '') {
																$status = '<label class="label label-primary">Selesai</label>';
																$btntest = "<button class='btn btn-block btn-success btn-sm disabled'> Sudah Ujian</button>";
															} else {
																$btntest = "<button class='btn btn-block btn-danger btn-sm disabled'> Eloy</button>";
															}
														endif;
													endif;
													?>
													<div class="col-md-4">
														<!-- Widget: user widget style 1 -->
														<div class="box box-widget widget-user-2">
															<!-- Add the bg color to the header using any of the bg-* classes -->
															<div class="widget-user-header <?= $warna; ?>" style="padding: 6px">

																<!-- /.widget-user-image -->
																<h3 class="widget-user-username"><?= $mapelx['nama'] ?></h3>
																<h5 class="widget-user-desc">
																	<i class="fa fa-tag"></i> <?= $mapelx['kode_ujian'] ?> &nbsp;
																	<i class="fa fa-user"></i> <?= $mapelx['level'] ?> &nbsp;
																	<i class="fa fa-wrench"></i> <?= $mapelx['id_pk'] ?>
																</h5>
															</div>
															<div class="box-footer no-padding">
																<ul class="nav nav-stacked">
																	<li>
																		<a href="#">
																			<i class='fa fa-clock-o'></i> Ujian Dimulai
																			<span class="pull-right badge bg-green"><?= $mapelx['tgl_ujian'] ?></span>
																		</a>
																	</li>
																	<li>
																		<a href="#">
																			<i class='fa fa-clock-o'></i> Ujian Ditutup
																			<span class="pull-right badge bg-red"><?= $mapelx['tgl_selesai'] ?></span>
																		</a>
																	</li>
																	<li>
																		<a href="#">
																			<i class='fa  fa-hourglass-1'></i> Durasi Ujian
																			<span class="pull-right badge bg-purple"><?= $mapelx['tampil_pg'] ?> Soal / <?= $mapelx['lama_ujian'] ?> menit</span>
																		</a>
																	</li>
																	<li><a href="#"><i class='fa fa-feed'></i> Status Ujian <span class="pull-right">
																				<?php
																				if ($mapelx['status'] == 1) {
																					echo "<i class='fa fa-spinner fa-spin'></i> <label class='badge bg-green'>Sedang Aktif</label> <label class='badge bg-red'>Sesi $mapelx[sesi]</label>";
																				} elseif ($mapelx['status'] == 0) {
																					echo "<label class='badge bg-red'>Tidak Aktif</label>";
																				}
																				?>
																			</span></a></li>
																	<li>
																		<a href="#">
																			<i class='fa  fa-hourglass-1'></i> Status Test
																			<span class="pull-right"><?= $status ?></span>
																		</a>
																	</li>
																</ul>
																<center style="padding: 8px">
																	<?= $btntest ?>
																</center>
															</div>
														</div>
														<!-- /.widget-user -->
													</div>

												<!-- untuk ujian berdasarkan semua kelas  -->	
												<?php elseif(in_array('semua', $datakelas)): ?>

													<?php
													$no++;
													// $pelajaran = explode(' ', $mapelx['nama']);
													$where = array(
														'id_ujian' => $mapelx['id_ujian'],
														'id_mapel' => $mapelx['id_mapel'],
														'id_siswa' => $id_siswa,
														'kode_ujian' => $mapelx['kode_ujian']
													);
													$nilai = fetch($koneksi, 'nilai', $where);
													$ceknilai = rowcount($koneksi, 'nilai', $where);
													if ($ceknilai == '0') :
														if (strtotime($mapelx['tgl_ujian']) <= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
															$status = '<label class="label label-success">Tersedia </label>';
															$btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-primary'><i class='fa fa-edit'></i> MULAI</button>";
														elseif (strtotime($mapelx['tgl_ujian']) >= time() and time() <= strtotime($mapelx['tgl_selesai'])) :
															$status = '<label class="label label-danger">Belum Waktunya</label>';
															$btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> BELUM UJIAN</button>";
														else :
															$status = '<label class="label label-danger">Telat Ujian</label>';
															$btntest = "<button' class='btn btn-block btn-sm btn-danger disabled'> Telat Ujian</button>";
														endif;
													else :
														if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] == '') :
															if ($nilai['online'] == 0) {
																$status = '<label class="label label-warning">Berlangsung</label>';
																$btntest = "<button data-id='$mapelx[id_ujian]' data-ids='$id_siswa' class='btnmulaitest btn btn-block btn-sm btn-success'><i class='fas fa-edit'></i> LANJUTKAN</button>";
															} else {
																$status = '<label class="label label-warning">Siswa sedang aktif</label>';
																$btntest = "<button  class=' btn btn-block btn-sm btn-success' disabled><i class='fas fa-edit'></i> LANJUTKAN</button>";
															} else :
															if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_berlangsung'] <> '' and $nilai['ujian_selesai'] <> '') {
																$status = '<label class="label label-primary">Selesai</label>';
																$btntest = "<button class='btn btn-block btn-success btn-sm disabled'> Sudah Ujian</button>";
															} else {
																$btntest = "<button class='btn btn-block btn-danger btn-sm disabled'> Eloy</button>";
															}
														endif;
													endif;
													?>
													<div class="col-md-4">
														<!-- Widget: user widget style 1 -->
														<div class="box box-widget widget-user-2">
															<!-- Add the bg color to the header using any of the bg-* classes -->
															<div class="widget-user-header <?= $warna; ?>" style="padding: 6px">

																<!-- /.widget-user-image -->
																<h3 class="widget-user-username"><?= $mapelx['nama'] ?></h3>
																<h5 class="widget-user-desc">
																	<i class="fa fa-tag"></i> <?= $mapelx['kode_ujian'] ?> &nbsp;
																	<i class="fa fa-user"></i> <?= $mapelx['level'] ?> &nbsp;
																	<i class="fa fa-wrench"></i> <?= $mapelx['id_pk'] ?>
																</h5>
															</div>
															<div class="box-footer no-padding">
																<ul class="nav nav-stacked">
																	<li>
																		<a href="#">
																			<i class='fa fa-clock-o'></i> Ujian Dimulai
																			<span class="pull-right badge bg-green"><?= $mapelx['tgl_ujian'] ?></span>
																		</a>
																	</li>
																	<li>
																		<a href="#">
																			<i class='fa fa-clock-o'></i> Ujian Ditutup
																			<span class="pull-right badge bg-red"><?= $mapelx['tgl_selesai'] ?></span>
																		</a>
																	</li>
																	<li>
																		<a href="#">
																			<i class='fa  fa-hourglass-1'></i> Durasi Ujian
																			<span class="pull-right badge bg-purple"><?= $mapelx['tampil_pg'] ?> Soal / <?= $mapelx['lama_ujian'] ?> menit</span>
																		</a>
																	</li>
																	<li><a href="#"><i class='fa fa-feed'></i> Status Ujian <span class="pull-right">
																				<?php
																				if ($mapelx['status'] == 1) {
																					echo "<i class='fa fa-spinner fa-spin'></i> <label class='badge bg-green'>Sedang Aktif</label> <label class='badge bg-red'>Sesi $mapelx[sesi]</label>";
																				} elseif ($mapelx['status'] == 0) {
																					echo "<label class='badge bg-red'>Tidak Aktif</label>";
																				}
																				?>
																			</span></a></li>
																	<li>
																		<a href="#">
																			<i class='fa  fa-hourglass-1'></i> Status Test
																			<span class="pull-right"><?= $status ?></span>
																		</a>
																	</li>
																</ul>
																<center style="padding: 8px">
																	<?= $btntest ?>
																</center>
															</div>
														</div>
														<!-- /.widget-user -->
													</div>

												<?php else: ?>
												
												<?php endif; ?>
										<?php endif; ?>
									<?php endwhile; ?>
								</div>
							</div>
						  <?php }?>
						</div>
					</div>
					<script>
						$(document).on('click', '.btnmulaitest', function() {
							var idm = $(this).data('id');
							var ids = $(this).data('ids');
							console.log(idm + '-' + ids);

							$.ajax({
								type: 'POST',
								url: 'konfirmasi.php',
								data: 'idm=' + idm + '&ids=' + ids,
								success: function(response) {
									$('#formjadwalujian').hide();
									$('#boxtampil').html(response).slideDown();

								}
							});

						});
					</script>
					<?php elseif($pg == 'viewer'): ?>
                    <?php include "tools/viewers.php"; ?>
                <?php elseif($pg == 'meeting'): ?>
                    <?php

                        $action = dekripsi($ac);

                        if ($action) {

                            $exce = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM meet WHERE room = '". $action ."'"));
                        
                            if ($exce > 0) {
                                    
                                echo '<div id="meeting" style="background-color: #757575; border: none; position: absolute; z-index: 2000; top: 0; width: 100%; left: 0; right: 0; bottom: 0; height: 100%;"></div>';
                                echo '<a href="meeting" style="background: white; position: absolute; z-index: 2001; left: 0; top: 0; color:#757575; padding: 10px 13px; border-radius: 0 0 50% 0;"><i class="fas fa-times"></i></a>';
                                echo '<script src="https://meet.jit.si/external_api.js"></script>';
                                echo '<script>
                                    const options = {
                                        roomName: \''. $action .'\',
                                        parentNode: document.querySelector(\'#meeting\')
                                    };
                                    const api = new JitsiMeetExternalAPI(\'meet.jit.si\', options);
                                </script>';
                        
                            } else {
                        
                                echo "<script>window.location = 'meeting'</script>";
                                exit();
                            
                            }
                        
                        }

                        $rooms = mysqli_fetch_all(mysqli_query($koneksi, "SELECT * FROM meet LEFT JOIN pengawas ON meet.id_guru = pengawas.id_pengawas WHERE meet.id_kelas='". $_SESSION['id_kelas'] ."' AND meet.status=true"), MYSQLI_ASSOC);
                    ?>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='box box-solid'>
                                <div class='box-header with-border'>
                                    <h3 class='box-title'><i class="fas fa-video"></i> Tatap Muka</h3>
                                </div><!-- /.box-header -->
                                <div class='box-body'>
                                    <div class="alert alert-warning" role="alert">Pastikan anda memiliki koneksi yang memadai atau stabil.</div>
                                    <div class="row">
                                        <?php foreach ($rooms as $key => $value) { ?>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption bg-info">
                                                    <h3><?= substr($value['judul'], 0, 18) ?></h3>
                                                    <p>
                                                        <span class="badge bg-red"><?= strtoupper($value['nama']) ?></span>
                                                        <span class="badge bg-yellow"><?= strtoupper($value['id_kelas']) ?></span>
                                                        <span class="badge bg-green"><?= strtoupper($value['id_mapel']) ?></span>
                                                    </p>
                                                    <p>
                                                        <?= $value['deskripsi'] ?>
                                                    </p>
                                                    <div class="btn-group btn-group-lg btn-group-justified" role="group" aria-label="Justified button group">
                                                        <a href="meeting/<?= enkripsi($value['room']) ?>" class="btn btn-block btn-lg btn-info" role="button"><i class="fas fa-video" ></i> &nbsp;Masuk sekarang</a> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
	<?php elseif ($pg == 'absen') : ?>
    	<?php include "absen.php" ?>
    <?php elseif ($pg == 'absen_mapel') : ?>
    	<?php include "absen_mapel.php" ?>
	<?php elseif ($pg == 'materi') : ?>
    	<?php include "materi.php" ?>
    <?php elseif ($pg == 'pass') : ?>
    	<?php include "pass.php" ?>
  	<?php elseif ($pg == 'tugassiswa') : ?>
    	<?php include "tugas.php" ?>
  	<?php elseif ($pg == 'lihattugas') : ?>
    	<?php include "lihattugas.php" ?>
    <?php elseif ($pg == 'daftarnilaitugas') : ?>
       <?php include "daftar_nilai_tugas.php" ?>
	<?php elseif ($pg == 'pengumuman') : ?>
		<?php include "pengumuman.php" ?>				
	<?php elseif ($pg == 'lihathasil') : ?>
		<?php include "hlihathasil.php" ?>
	<?php elseif ($pg == 'hasil') : ?>
		<?php include "hhasil.php" ?>			
				<!-- masuk ke soal tampilan soal -->
				<?php elseif ($pg == 'testongoing') : ?>
					<?php
					$qcek = mysqli_query($koneksi, "select * from nilai where id_ujian='$ac' and id_siswa='$id'");
					$cek = mysqli_num_rows($qcek);
					if ($cek <> 0) :
						$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian WHERE id_ujian='$ac'"));
						$idmapel = $query['id_mapel'];
						$no_soal = 0;
						$no_prev = $no_soal - 1;
						$no_next = $no_soal + 1;
						$id_mapel = $idmapel;

						$id_siswa = $id;

						$where = array(
							'id_siswa' => $id_siswa,
							'id_mapel' => $id_mapel
						);
						$where2 = array(
							'id_siswa' => $id_siswa,
							'id_mapel' => $id_mapel,
							'id_ujian' => $ac
						);
						$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
						$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
						$pengacakq = fetch($koneksi, 'pengacak', $where);

						$pengacak = explode(',', $pengacakq['id_soal']);
						$pengacakpil = explode(',', $pengacakq['id_opsi']);
						$pengacakesai = explode(',', $pengacakq['id_esai']);
						

						$mapel = fetch($koneksi, 'ujian', array('id_mapel' => $id_mapel, 'id_ujian' => $ac));
						$soal = fetch($koneksi, 'soal', array('id_mapel' => $id_mapel, 'id_soal' => $pengacak[$no_soal]));
						
						$jawab = fetch($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $soal['id_soal'], 'id_ujian' => $ac));

						//cek apakah submite tombol selesai di klik
						if (isset($_POST['done'])) :
							$id_siswa = $_SESSION['id_siswa'] ;

							//cek apakah nilai sudah di isi apa belum
							$da2=$db->Status_sudah_ujian($id_siswa,$idmapel,$ac);
							if($da2==1){
								?><script type="text/javascript">alert('Upsss Siswa Sudah Di Isi Nilainya')</script><?php
							}
							else{
							//$benar = $salah = 0;
							
							$ceksoal = select($koneksi, 'soal', array('id_mapel' => $id_mapel, 'jenis' => 1));
							$ceksoalesai = select($koneksi, 'soal', array('id_mapel' => $id_mapel, 'jenis' => 2));
							
							$arrayjawab = array();
							$arrayjawabesai = array();
							$benar='benar_';
							$salah='salah_';

							foreach ($ceksoalesai as $getsoalesai) {
								$w2 = array(
									'id_siswa' => $id_siswa,
									'id_mapel' => $id_mapel,
									'id_soal' => $getsoalesai['id_soal'],
									'jenis' => 2
								);
								$getjwb2 = fetch($koneksi, 'jawaban', $w2);
								$arrayjawabesai[$getjwb2['id_soal']] = str_replace("'"," ",$getjwb2['esai']);
							}
							
							// cari nilai jawaban pg 
							foreach ($ceksoal as $getsoal) {
								$jika = array(
									'id_ujian' => $ac,
									'id_siswa' => $id_siswa,
									'id_mapel' => $id_mapel,
									'id_soal' => $getsoal['id_soal'],
									'jenis' => '1'
								);
								//ambil nilai jawaban pg untuk di simpan di tabel jawaban
								$getjwb = fetch($koneksi, 'jawaban', $jika);
								if ($getjwb) {
									$arrayjawab[$getjwb['id_soal']] = $getjwb['jawaban'];
									($getjwb['jawaban'] == $getsoal['jawaban']) ? ${$benar.$id_siswa}++ : ${$salah.$id_siswa}++;
								}
							}

							// HITUNG BOBOT NILAI SISWA PG
							${$jumsalah.$id_siswa} = $mapel['tampil_pg'] - ${$benar.$id_siswa};
							$bagi = $mapel['tampil_pg'] / 100;
							$bobot = $mapel['bobot_pg'] / 100;
							$skorx = (${$benar.$id_siswa} / $bagi) * $bobot;
							$skor = number_format($skorx, 2, '.', '');

							$data = array( //data array untuk di masukan di kondisi selesai
									'ujian_selesai' => $datetime,
									'jml_benar' => ${$benar.$id_siswa},
								  'jml_salah' => ${$jumsalah.$id_siswa},
									'skor' => $skor,
									'total' => $skor,
									'online' => 0,
									'selesai' => 1,
									'jawaban' => serialize($arrayjawab),
									'jawaban_esai' => serialize($arrayjawabesai)
								);

							 //validasi nilai 0
							
								$nilaix = update($koneksi, 'nilai', $data, $where2);
								if($nilaix=='OK'){

									$delcak = delete($koneksi, 'pengacak', $where);
									if($delcak=='OK'){
										delete($koneksi, 'jawaban', $where2);
									}
									else{
										?><script type="text/javascript">alert('Gagal Hapus Pengacak')</script><?php
									}
								}
								else{
									?><script type="text/javascript">alert('Gagal Update Nilai')</script><?php
								}

								jump("$homeurl");

							}
							
							
						endif; //end if submite selesai

						update($koneksi, 'nilai', array('ujian_berlangsung' => $datetime), $where2);
						$nilai = fetch($koneksi, 'nilai', $where2);
						$habis = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);
						$detik = ($mapel['lama_ujian'] * 60) - $habis;
						$dtk = $detik % 60;
						$mnt = floor(($detik % 3600) / 60);
						$jam = floor(($detik % 86400) / 3600);
						$ujianselesai = $nilai['ujian_selesai'];
						
						if($nilai['selesai']==1){ //jiksa sudah selesai atau selesai paksa di lempar ke home
							jump("$homeurl");
						}
						else{
					?>
						<div class='row' style='margin-right:-25px;margin-left:-25px;'>
							<div class='col-md-12'>      <!--style="background-color: #0f0f17; color: #cccccc"-->
	 							<div class='box box-solid' id="thema" style=" ">
									<div class='box-header with-border'>
										<div class="row">
									  	<div class="col-md-12">
									  		<div class="theme-switch-wrapper">
									   		 	<label class="theme-switch" for="checkbox">
									        	<input type="checkbox" id="checkbox" />
									       	 <div class="slider round"></div>
									  			</label>
									  			 <em id="modeag">Aktifkan Dark Mode atau Mode Terang!</em>
												</div>
									  	</div>
									  </div>
									 
										<div id='divujian'>
											<span style='display:none' id='htmlujianselesai'><?= $ujianselesai ?></span>
										</div>
										<h3 class='box-title'><span class='btn hidden-xs bg-gray active'>SOAL NO </span> <span class='btn bg-green' id='displaynum'><b><?= $no_next ?></b></span></h3>
										<div class='btn-group'>
											<button type='button' id='smaller_font' class='btn bg-purple'> - </button>
											<button type='button' id='reset_font' class='btn bg-purple'><i class='fa fa-sync-alt'></i></button>
											<button type='button' id='bigger_font' class='btn bg-purple'> + </button>
									  </div>
										<div class='box-title pull-right'>
											<i class="fa fa-clock fa-lg hidden-xs "></i>
											<style type="text/css">
												.merah{
													color:red;
												}
											</style>
											<div id="waktu_ujian_user" class='btn-group'>
												<!-- waktu berjalan asja -->
												<span style=" font-family:'OCR A Extended';font-size:35px" id='countdown'><span id='htmljam'><?= $jam ?></span>:<span id='htmlmnt'><?= $mnt ?></span>:<span id='htmldtk'><?= $dtk ?></span></span>
											</div>
											<div class='btn-group'>
												<form action='' method='post'>
													<input type='submit' name='done' id='done-submit' style='display:none;' />
												</form>
											</div>
										</div>
									</div><!-- /.box-header -->
									<div id='loadsoal'>
										<div class='box-body'>
											<div class='row'>
												<div class='col-md-7'>
													<div class='col-md-12'>
														<?php
														if ($soal['file'] <> '') {
															$ext = explode(".", $soal['file']);
															$ext = end($ext);
															if (in_array($ext, $image)) :
																echo "<span id='zoom' style='display:inline-block'><img src='$homeurl/files/$soal[file]' class='img-responsive' /></span>";
															elseif (in_array($ext, $audio)) :
																echo "<audio controls='controls' ><source src='$homeurl/files/$soal[file]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
															else :
																echo "File tidak didukung!";
															endif;
														} ?>
														<div class='callout soal'>
															<div class='soaltanya'><?= $soal['soal'] ?></div>
														</div>
														<?php if ($soal['file1'] <> '') {
															$ext = explode(".", $soal['file1']);
															$ext = end($ext);
															if (in_array($ext, $image)) :
																echo "<span id='zoom1' style='display:inline-block'><img  src='$homeurl/files/$soal[file1]' class='img-responsive' /></span>";
															elseif (in_array($ext, $audio)) :
																echo "<audio controls='controls' ><source src='$homeurl/files/$soal[file1]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
															else :
																echo "File tidak didukung!";
															endif;
														}
														?>
													</div>
												</div>
												<div class='col-md-12'>
													<?php
													if ($mapel['opsi'] == 3) :
														$kali = 3;
													elseif ($mapel['opsi'] == 4) :
														$kali = 4;
														$nop4 = $no_soal * $kali + 3;
														$pil4 = $pengacakpil[$nop4];
														$pilDD = "pil" . $pil4;
														$fileDD = "file" . $pil4;
													elseif ($mapel['opsi'] == 5) :
														$kali = 5;

														$nop4 = $no_soal * $kali + 3;
														$pil4 = $pengacakpil[$nop4];
														$pilDD = "pil" . $pil4;
														$fileDD = "file" . $pil4;

														$nop5 = $no_soal * $kali + 4;
														$pil5 = $pengacakpil[$nop5];
														$pilEE = "pil" . $pil5;
														$fileEE = "file" . $pil5;
													endif;

													$nop1 = $no_soal * $kali;
													$nop2 = $no_soal * $kali + 1;
													$nop3 = $no_soal * $kali + 2;

													$pil1 = $pengacakpil[$nop1];
													$pilAA = "pil" . $pil1;
													$fileAA = "file" . $pil1;

													$pil2 = $pengacakpil[$nop2];
													$pilBB = "pil" . $pil2;
													$fileBB = "file" . $pil2;

													$pil3 = $pengacakpil[$nop3];
													$pilCC = "pil" . $pil3;
													$fileCC = "file" . $pil3;

													$ragu = ($jawab['ragu'] == 1) ? 'checked' : '';
													?>
													<?php if ($soal['pilA'] == '' and $soal['fileA'] == '' and $soal['pilB'] == '' and $soal['fileB'] == '' and $soal['pilC'] == '' and $soal['fileC'] == '' and $soal['pilD'] == '' and $soal['fileD'] == '') : ?>
														<?php
														$ax = ($jawab['jawabx'] == 'A') ? 'checked' : '';
														$bx = ($jawab['jawabx'] == 'B') ? 'checked' : '';
														$cx = ($jawab['jawabx'] == 'C') ? 'checked' : '';
														$dx = ($jawab['jawabx'] == 'D') ? 'checked' : '';
														if ($mapel['opsi'] == 5) :
															$ex = ($jawab['jawaban'] == 'E') ? 'checked' : '';
														endif;
														?>
														<table class='table'>
															<tr>
																<td>
																	<input class='hidden radio-label' type='radio' name='jawab' id='A' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'A','A',1,<?= $ac ?>)" <?= $ax ?> />
																	<label class='button-label' for='A'>
																		<h1>A</h1>
																	</label>
																</td>
																<td>
																	<input class='hidden radio-label' type='radio' name='jawab' id='C' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'C','C',1,<?= $ac ?>)" <?= $cx ?> />
																	<label class='button-label' for='C'>
																		<h1>C</h1>
																	</label>
																</td>
																<?php if ($mapel['opsi'] == 5) { ?>
																	<td>
																		<input class='hidden radio-label' type='radio' name='jawab' id='E' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'E','E',1,<?= $ac ?>)" <?= $ex ?> />
																		<label class='button-label' for='E'>
																			<h1>E</h1>
																		</label>
																	</td>
																<?php } ?>

															</tr>
															<tr>
																<td>
																	<input class='hidden radio-label' type='radio' name='jawab' id='B' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'B','B',1,<?= $ac ?>)" <?= $bx ?> />
																	<label class='button-label' for='B'>
																		<h1>B</h1>
																	</label>
																</td>
																<?php if ($mapel['opsi'] <> 3) { ?>
																	<td>
																		<input class='hidden radio-label' type='radio' name='jawab' id='D' onclick="jawabsoal(<?= $id_mapel ?>, <?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'D','D',1,<?= $ac ?>)" <?= $dx ?> />
																		<label class='button-label' for='D'>
																			<h1>D</h1>
																		</label>
																	</td>
																<?php } ?>
															</tr>
														</table>
													<?php else : ?>
														<?php
														$a = ($jawab['jawabx'] == 'A') ? 'checked' : '';
														$b = ($jawab['jawabx'] == 'B') ? 'checked' : '';
														$c = ($jawab['jawabx'] == 'C') ? 'checked' : '';
														if ($mapel['opsi'] == 4) {
															$d = ($jawab['jawabx'] == 'D') ? 'checked' : '';
														}
														if ($mapel['opsi'] == 5) {
															$d = ($jawab['jawabx'] == 'D') ? 'checked' : '';
															$e = ($jawab['jawabx'] == 'E') ? 'checked' : '';
														}
														?>
														<table width='100%' class='table '>
															<tr>
																<td width='60'>
																	<input class='hidden radio-label' type='radio' name='jawab' id='A' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil1 ?>','A',1,<?= $ac ?>)" <?= $a ?> />
																	<label class='button-label' for='A'>
																		<h1>A</h1>
																	</label>
																</td>
																<td style='vertical-align:middle;'>
																	<span class='soal'><?= $soal[$pilAA] ?></span>
																	<?php
																	if ($soal[$fileAA] <> '') {
																		$ext = explode(".", $soal[$fileAA]);
																		$ext = end($ext);
																		if (in_array($ext, $image)) {
																			echo "<img src='$homeurl/files/$soal[$fileAA]' class='img-responsive' style='max-width:300px;'/>";
																		} elseif (in_array($ext, $audio)) {
																			echo "<audio controls='controls'><source src='$homeurl/files/$soal[$fileAA]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
																		} else {
																			echo "File tidak didukung!";
																		}
																	}
																	?>
																</td>
															</tr>
															<tr>
																<td>
																	<input class='hidden radio-label' type='radio' name='jawab' id='B' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil2 ?>','B',1,<?= $ac ?>)" <?= $b ?> />
																	<label class='button-label' for='B'>
																		<h1>B</h1>
																	</label>
																</td>
																<td style='vertical-align:middle;'>
																	<span class='soal'><?= $soal[$pilBB] ?></span>
																	<?php
																	if ($soal[$fileBB] <> '') {
																		$ext = explode(".", $soal[$fileBB]);
																		$ext = end($ext);
																		if (in_array($ext, $image)) {
																			echo "<img src='$homeurl/files/$soal[$fileBB]' class='img-responsive' style='max-width:300px;'/>";
																		} elseif (in_array($ext, $audio)) {
																			echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileBB]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
																		} else {
																			echo "File tidak didukung!";
																		}
																	}
																	?>
																</td>
															</tr>
															<tr>
																<td>
																	<input class='hidden radio-label' type='radio' name='jawab' id='C' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil3 ?>','C',1,<?= $ac ?>)" <?= $c ?> />
																	<label class='button-label' for='C'>
																		<h1>C</h1>
																	</label>

																</td>
																<td style='vertical-align:middle;'>
																	<span class='soal'><?= $soal[$pilCC] ?></span>
																	<?php
																	if ($soal[$fileCC] <> '') {
																		$ext = explode(".", $soal[$fileCC]);
																		$ext = end($ext);
																		if (in_array($ext, $image)) {
																			echo "<img src='$homeurl/files/$soal[$fileCC]' class='img-responsive' style='max-width:300px;'/>";
																		} elseif (in_array($ext, $audio)) {
																			echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileCC]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
																		} else {
																			echo "File tidak didukung!";
																		}
																	}
																	?>
																</td>
															</tr>
															<?php if ($mapel['opsi'] <> 3) { ?>
																<tr>
																	<td>
																		<input class='hidden radio-label' type='radio' name='jawab' id='D' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil4 ?>','D',1,<?= $ac ?>)" <?= $d ?> />
																		<label class='button-label' for='D'>
																			<h1>D</h1>
																		</label>
																	</td>
																	<td style='vertical-align:middle;'>
																		<span class='soal'><?= $soal[$pilDD] ?></span>
																		<?php
																		if ($soal[$fileDD] <> '') {
																			$ext = explode(".", $soal[$fileDD]);
																			$ext = end($ext);
																			if (in_array($ext, $image)) {
																				echo "<img src='$homeurl/files/$soal[$fileDD]' class='img-responsive' style='max-width:300px;'/>";
																			} elseif (in_array($ext, $audio)) {
																				echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileDD]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
																			} else {
																				echo "File tidak didukung!";
																			}
																		}
																		?>
																	</td>
																</tr>
															<?php } ?>
															<?php if ($mapel['opsi'] == 5) { ?>
																<tr>
																	<td>
																		<input class='hidden radio-label' type='radio' name='jawab' id='E' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil5 ?>','E',1,<?= $ac ?>)" <?= $e ?> />
																		<label class='button-label' for='E'>
																			<h1>E</h1>
																		</label>
																	</td>
																	<td style='vertical-align:middle;'>
																		<span class='soal'><?= $soal[$pilEE] ?></span>
																		<?php
																		if ($soal[$fileEE] <> '') {

																			$ext = explode(".", $soal[$fileEE]);
																			$ext = end($ext);
																			if (in_array($ext, $image)) {
																				echo "<img src='$homeurl/files/$soal[$fileEE]' class='img-responsive' style='max-width:300px;'/>";
																			} elseif (in_array($ext, $audio)) {
																				echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileEE]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
																			} else {
																				echo "File tidak didukung!";
																			}
																		}
																		?>
																	</td>
																</tr>
															<?php } ?>
														</table>
													<?php endif; ?>
												</div>
											</div>
										</div>
										<!-- arah sebelum selanjutnya pada soal siswa -->
										<div class='box-footer navbar-fixed-bottom lanjut' >
											<table width='100%'>
												<tr>
													<td>
														<?php if ($no_soal == 0) { ?>
															<div class='col-md-4 '>
																<button id='move-prev' class='btn  btn-default' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_prev ?>,1)"><i class='fa fa-chevron-left'></i> <span class='hidden-xs'>SEBELUMNYA</span></button>
																<i class='fa fa-spin fa-spinner' id='spin-prev' style='display:none;'></i>
															</div>
														<?php } else { ?>
															<div class='col-md-4 '>
																<button id='move-prev' class='btn  btn-primary' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_prev ?>,1)"><i class='fa fa-chevron-left'></i> <span class='hidden-xs'>SEBELUMNYA</span></button>
																<i class='fa fa-spin fa-spinner' id='spin-prev' style='display:none;'></i>
															</div>
														<?php } ?>
													</td>
													<!-- tempat ragu ragu asja -->
													<td>
														<div class='col-md-4 '>
															<div id='load-ragu'>
																<a href='#' class='btn  btn-warning'><input type='checkbox' onclick="radaragu(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>, <?= $ac ?>)" <?= $ragu ?> /> RAGU</a>
															</div>
														</div>

													</td>
													<td>
														<div class='col-md-4 '>
															<i class='fa fa-spin fa-spinner' id='spin-next' style='display:none;'></i>
															<button id='move-next' class='btn  btn-primary' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_next ?>,1)"><span class='hidden-xs'>SELANJUTNYA</span> <i class='fa fa-chevron-right'></i></button>
														</div>
													</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- tampil popup soal yang sudha di jawab asja #0d7fa0-->
							<div class='navs-slide' style='z-index: 1000;'>
								<div class='btn-slide' style="color:#0520e2;" >
									<i><img class="fas fa-edit fa-fw fa-lg "></i>
								</div>
								<div class='navs-body'>
									<div class='head-slide' style="background-color: #0d7fa0;"><i class="fas fa-edit fa-fw "></i>DAFTAR SOAL</div>
									<div class='body-slide'>
										<div  id="popup_pg"  style='overflow-y:auto; max-height:250px'>
											<div class='col-md-12'>
												<span>-- SOAL PG --</span>
												<div class='row' id='nomorsoal'>
													<?php
													$cekpg = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='1'"));
													$cekesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$id_mapel' AND jenis='2'"));
													$quero = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"));

													if ($cekpg >= $quero['tampil_pg']) {
														$soalpg = $quero['tampil_pg'];
													} else {
														$soalpg = $cekpg;
													}
													if ($cekesai >= $quero['tampil_esai']) {
														$soalesai = $quero['tampil_esai'];
													} else {
														$soalpg = $cekesai;
													}
													?>
													<div id='ketjawab'>
														<?php
														$jumjawab = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jawaban WHERE id_mapel='$id_mapel' AND id_siswa='$id_siswa' AND id_ujian='$ac'"));
														$jumsoal = $soalpg + $soalesai;
														?>
														<input type='hidden' value='<?= $jumsoal ?>' id='jumsoal' />
														<input type='hidden' value='<?= $jumjawab ?>' id='jumjawab' />
													</div>
													<?php for ($n = 0; $n < $soalpg; $n++) : ?>
														<?php
														$id_soal = $pengacak[$n];
														$cekjwb = rowcount($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $id_soal, 'jenis' => '1', 'id_ujian' => $ac));
														$ragu = fetch($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $id_soal, 'jenis' => '1', 'id_ujian' => $ac));

														$color1 = ($cekjwb <> 0) ? 'green' : 'gray';
														$color = ($ragu['ragu'] == 1) ? 'yellow' : $color1;
														$nomor = $n + 1;
														$nomor = ($nomor < 10) ? "0" . $nomor : $nomor;
														if ($soal['pilA'] == '' and $soal['fileA'] == '' and $soal['pilB'] == '' and $soal['fileB'] == '' and $soal['pilC'] == '' and $soal['fileC'] == '' and $soal['pilD'] == '' and $soal['fileD'] == '') {
															$jawabannya = $ragu['jawaban'];
														} else {
															$jawabannya = $ragu['jawabx'];
														}
														?>
														
														<a style="min-width:50px;height:50px;border-radius:10px;border:solid black;font-size:medium" class='btn btn-app bg-<?= $color ?>' id='badge<?= $id_soal ?>' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $n ?>,1)"> <?= $nomor ?> <span id='jawabtemp<?= $id_soal ?>' class='badge bg-red' style="font-size:medium"><?= $jawabannya ?></span></a>
													<?php endfor; ?>
												</div>
											</div>
											<div class='col-md-12'>
												<?php if ($quero['tampil_esai'] <> 0) : ?>
													<span>-- SOAL ESSAI --</span>
													<div class='row' id='nomor'>
														<?php for ($i = 0; $i < $soalesai; $i++) :
															$id_esai = $pengacakesai[$i];
															$cekjwb = rowcount($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $id_esai, 'jenis' => '2', 'id_ujian' => $ac));
															$ragu = fetch($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $id_esai, 'jenis' => '2', 'id_ujian' => $ac));
															$color = ($cekjwb <> 0) ? 'bg-green' : 'bg-gray';

															$nomor = $i + 1;
															$nomor = ($nomor < 10) ? "0" . $nomor : $nomor;
														?>
															<a style="min-width:50px;height:50px;border-radius:10px ;border:solid black;font-size:medium" class="btn btn-app <?= $color ?>" id="badgeesai<?= $id_esai ?>" onclick="loadsoalesai(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $i ?>,2)"> <?= $nomor ?> </a>
														<?php endfor; ?>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
					<?php else : ?>
						<?php jump($homeurl); ?>
					<?php endif; ?>
				<?php else : ?>
					<?php jump($homeurl); ?>
				<?php endif;  ?>

			</section><!-- /.content -->
		</div><!-- /.content-wrapper -->
		<footer class='main-footer hidden-xs'>
			<div class='container'>
				<div class='pull-left hidden-xs'>
					<strong>
						<span id='end-sidebar'>
							&copy; <?= APLIKASI?>
						</span>
					</strong>
				</div>
			</div>
		</footer>
		<?php if($setting['izin_ujian']==0){ ?>
		<footer class='footer hidden-lg'>
			<style type="text/css">.btn {
				border-radius: 3px;
				-webkit-box-shadow: none;
				box-shadow: none;
				border: 1px solid transparent;
			}</style>
			<div class='pull-right hidden-lg' style="padding-right: 10px; padding-bottom: 5px;">
				<div class="text-center">
					<a href="<?= $homeurl?>" class="btn btn-success"><i class="fa fa-home"></i> MENU</a>
				</div>
			</div>
			<div class='pull-left hidden-lg' style="padding-left: 10px; padding-bottom: 5px;">
				<div class="text-center">
					<a class="btn btn-success " onclick="location.reload();"><i class="fa fa-spinner fa-spin "></i> Refres</a>
				</div>
		</footer>
		<?php } ?>

	</div><!-- ./wrapper -->


	<script src='<?= $homeurl ?>/plugins/zoom-master/jquery.zoom.js'></script>
	<script src='<?= $homeurl ?>/dist/bootstrap/js/bootstrap.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/slimScroll/jquery.slimscroll.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/iCheck/icheck.min.js'></script>
	<script src='<?= $homeurl ?>/dist/js/app.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/sweetalert2/dist/sweetalert2.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/slidemenu/jquery-slide-menu.js'></script>
	<script src='<?= $homeurl ?>/plugins/mousetrap/mousetrap.min.js'></script>
	<script src='<?= $homeurl ?>/plugins/MathJax-2.7.3/MathJax.js?config=TeX-AMS_HTML-full'></script>
	<script src='<?= $homeurl ?>/plugins/toastr/toastr.min.js'></script>
	
	<script>
		var url = window.location;
		$('ul.sidebar-menu a').filter(function() {
			return this.href == url;
		}).parent().addClass('active');
		// for treeview
		$('ul.treeview-menu a').filter(function() {
			return this.href == url;
		}).closest('.treeview').addClass('active');
		<?php 
		if($setting['izin_ujian']==1){
		?>

		<?php }else{ } ?>
	</script>
	<?php if ($pg == 'testongoing') : ?>
		<script>
			var homeurl;
			homeurl = '<?= $homeurl ?>';
			/* Font Adjusments */
			let defaultFontSize = 14;
			let fontSize = 0;
			fontSize = localStorage.getItem('fontSize');
			if (!fontSize) {
				fontSize = defaultFontSize;
				localStorage.setItem('fontSize', fontSize);
			}
			soalFont(fontSize);

			function soalFont(fontSize) {
				$('div.soal > p > span').css({
					fontSize: fontSize + 'pt'
				});
				$('span.soal > p > span').css({
					fontSize: fontSize + 'pt'
				});
				$('.soal').css({
					fontSize: fontSize + 'pt'
				})
				$('.callout soal').css({
					fontSize: fontSize + 'pt'
				})
			}

			$(document).ready(function() {
				$('#smaller_font').on('click', function() {
					fontSize = localStorage.getItem('fontSize')
					fontSize--;
					localStorage.setItem('fontSize', fontSize)
					soalFont(fontSize)
				});

				$('#bigger_font').on('click', function() {
					fontSize = localStorage.getItem('fontSize')
					fontSize++;
					localStorage.setItem('fontSize', fontSize)
					soalFont(fontSize)
				});

				$('#reset_font').on('click', function() {
					fontSize = defaultFontSize
					localStorage.setItem('fontSize', fontSize)
					soalFont(fontSize)
				});
				Mousetrap.bind('enter', function() {
					loadsoal(<?= $id_mapel ?>, <?= $id_siswa ?>, <?= $no_next ?>, 1);
				});

				Mousetrap.bind('right', function() {
					loadsoal(<?= $id_mapel ?>, <?= $id_siswa ?>, <?= $no_next ?>, 1);
				});

				Mousetrap.bind('left', function() {
					loadsoal(<?= $id_mapel ?>, <?= $id_siswa ?>, <?= $no_prev ?>, 1);
				});

				Mousetrap.bind('a', function() {
					$('#A').click()
				});

				Mousetrap.bind('b', function() {
					$('#B').click()
				});

				Mousetrap.bind('c', function() {
					$('#C').click()
				});

				Mousetrap.bind('d', function() {
					$('#D').click()
				});

				Mousetrap.bind('e', function() {
					$('#E').click()
				});

				Mousetrap.bind('space', function() {
					$('input[type=checkbox]').click()
					radaragu(<?= $id_mapel ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>, <?= $ac ?>)
				});

				//cek dulu sebelum tekan tombol selesai
				$(document).on('click', '.done-btn', function() {
					var jawab = $('#jumjawab').val();
					var soal = $('#jumsoal').val();
					var belum = soal - jawab;
					var ragu = $('[id^=badge]').hasClass('bg-yellow');
					if (jawab == soal) {
						if (ragu) {
							swal({
								type: 'warning',
								title: 'Oops...',
								html: 'Masih ada soal yang ragu !!',
							})
						} else {
							swal({
								title: 'Apa kamu yakin telah selesai?',
								html: 'Pastikan telah menyelesaikan semua dengan benar! <br>' +
									'Sudah Dijawab : <b>' + jawab + '</b> Belum dijawab : <b>' + belum + '</b>',
								type: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Iya'
							}).then((result) => {
								if (result.value) {
									window.onbeforeunload = null;
									$('#done-submit').click();
								}
							})
						}

					} else {
						swal({
							type: 'warning',
							title: 'Oops...',
							html: 'Masih ada soal yang masih belum dikerjakan !! <br>' +
								'Sudah Dijawab : <b>' + jawab + '</b> Belum dijawab : <b>' + belum + '</b>',
						})
					}
				});
				$('.navs-slide').SlideMenu({
					expand: false,
					collapse: true
				});
				var result = '';
				$('.jawabesai').change(function() {
					result = $(this).val();
					$('#result').html(result);
				});
				// $('#zoom').zoom();
				// $('#zoom1').zoom();

				var jam = $('#htmljam').html();
				var menit = $('#htmlmnt').html();
				var detik = $('#htmldtk').html();

				function hitung() {
					setTimeout(hitung, 1000);
					$('#countdown').html(jam + ':' + menit + ':' + detik);
					detik--;
					if (detik < 0) {
						detik = 59;
						menit--;
							if(menit < 18){
								$("#waktu_ujian_user").addClass("merah");
							}
						if (menit < 0) {
							menit = 59;
							jam--;
							if (jam < 0) {
								jam = 0;
								menit = 0;
								detik = 0;
								waktuhabis();
							}
						}
					}
				}
				hitung();
			});

			function cekwaktu() {
				$('#divujian').load(window.location.href + ' #divujian');
				var status = $('#htmlujianselesai').html();
				if (status != '') {
					location = homeurl;
				}
			}

			function waktuhabis() {
				swal({
					title: 'Oooo Oooww!',
					text: 'Waktu Ujian Telah Habis',
					timer: 1000,
					onOpen: () => {
						swal.showLoading()
					}
				}).then((result) => {
					$('#done-submit').click();
				});
			}

			// load soal asja
			function loadsoal(idmapel, idsiswa, nosoal, jenis) {
				cekwaktu();
				if (nosoal >= 0 && nosoal < <?= $soalpg ?>) {
					curnum = $('#displaynum').html();
					if (nosoal == curnum) {
						$('#spin-next').show();
						
					}
					if (nosoal > curnum) {
						$('#spin-next').show();
						
					}
					if (nosoal < curnum) {
						$('#spin-prev').show();

					}
					$.ajax({
						type: 'POST',
						url: homeurl + '/soal.php',
						data: {
							pg: 'soal',
							id_mapel: idmapel,
							id_siswa: idsiswa,
							no_soal: nosoal,
							jenis: jenis,
							idu: <?= $ac ?>
						},
						success: function(response) {
							num = nosoal + 1;
							//$('#load_block').load(location.href+' #load_block>*','');
							$('#displaynum').html(num);
							// laod popup soal asja
							$('#popup_pg').load(location.href+' #popup_pg>*','');
							
							$('#loadsoal').html(response);
							$('.fa-spin').hide();
							soalFont(fontSize);
							//iCheckform();
						}
					});
				}
			}

			function loadsoalesai(idmapel, idsiswa, nosoal, jenis) {
				cekwaktu();
				if (nosoal >= 0 && nosoal < <?= $soalesai ?>) {
					curnum = $('#displaynum').html();
					if (nosoal == curnum) {
						//$('#spin-next').show();
					}
					if (nosoal > curnum) {
						//$('#spin-next').show();
					}
					if (nosoal < curnum) {
						//$('#spin-prev').show();
					}
					$.ajax({
						type: 'POST',
						url: homeurl + '/soal.php',
						data: {
							pg: 'soalesai',
							id_mapel: idmapel,
							id_siswa: idsiswa,
							no_soal: nosoal,
							jenis: jenis,
							idu: <?= $ac ?>
						},
						success: function(response) {
							num = nosoal + 1;
							// laod popup soal asja
							$('#popup_pg').load(location.href+' #popup_pg>*','');
							$('#displaynum').html(num);
							$('#loadsoal').html(response);
							$('.fa-spin').hide();
							soalFont(fontSize);
							
							//iCheckform();
						}
					});
				}
			}

			function jawabsoal(idmapel, idsiswa, idsoal, jawab, jawabQ, jenis, idu) {
				cekwaktu();
				console.log(idmapel + '-' + idsiswa + '-' + idsoal + '-' + jawab + '-' + jawabQ + '-' + jenis + '-' + idu)
				$.ajax({
					type: 'POST',
					url: homeurl + '/soal.php',
					data: {
						pg: 'jawab',
						id_mapel: idmapel,
						id_siswa: idsiswa,
						id_soal: idsoal,
						jawaban: jawab,
						jenis: jenis,
						id_ujian: idu,
						jawabx: jawabQ
					},
					success: function(response) {
						console.log(response);
						if (response == 'OK') {
							$('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
							$('#nomorsoal #badge' + idsoal).removeClass('bg-yellow');
							$('#nomorsoal #badge' + idsoal).addClass('bg-green');
							$('#nomorsoal #jawabtemp' + idsoal).html(jawabQ);
							$('#ketjawab').load(window.location.href + ' #ketjawab');
						}
					}
				});
			}

			function jawabesai(idmapel, idsiswa, idsoal, jenis) {
				var jawab = $('#jawabesai').val();
				$.ajax({
					type: 'POST',
					url: homeurl + '/soal.php',
					data: {
						pg: 'jawabesai',
						id_mapel: idmapel,
						id_siswa: idsiswa,
						id_soal: idsoal,
						jawaban: jawab,
						jenis: jenis,
						idu: <?= $ac ?>
					},
					success: function(response) {
						if (response == 'OK') {
							toastr.success("jawaban berhasil disimpan");
							$('#badgeesai' + idsoal).removeClass('bg-gray');
							$('#badgeesai' + idsoal).removeClass('bg-yellow');
							$('#badgeesai' + idsoal).addClass('bg-green');
							$('#ketjawab').load(window.location.href + ' #ketjawab');
						}
					}
				});
			}

			function radaragu(idmapel, idsiswa, idsoal, idu) {
				//alert(idsoal);
				//console.log(idmapel + '-' + idsiswa + '-' + idsoal + '-' + idu);
				$.ajax({
						type: 'POST',
						url: homeurl + '/soal.php',
						data: {
							pg: 'ragu',
							id_mapel: idmapel,
							id_siswa: idsiswa,
							id_soal: idsoal,
							id_ujian: idu
						},
						success: function(response) {
							//alert(response);
							if (response == 'OK') {
								if (cekclass == 'btn btn-app bg-green') {
									$('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
									$('#nomorsoal #badge' + idsoal).removeClass('bg-green');
									$('#nomorsoal #badge' + idsoal).addClass('bg-yellow');
									console.log('kuning');
								}
								if (cekclass == 'btn btn-app bg-yellow') {
									$('#nomorsoal #badge' + idsoal).removeClass('bg-gray');
									$('#nomorsoal #badge' + idsoal).removeClass('bg-yellow');
									$('#nomorsoal #badge' + idsoal).addClass('bg-green');
									console.log('hijau');
								}
							}
						}
					});

			}
		</script>
		 <script type="text/javascript">
		 	$(document).ready(function() {
		 		
		 		
		 		var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
		 		function switchTheme(e) {
		 			if (e.target.checked) {
		 				localStorage.setItem('theme',1); 
		 			$("#thema").css("background-color","rgb(53, 54, 58)");
		 			$("#thema").css("color","rgb(232, 234, 237)");
		 			$("#waktu_ujian_user").css("color","white");
		 			$(".btn-slide").css("color","rgb(232, 234, 237)");
		 			$("#modeag").css("color","rgb(232, 234, 237)");
		 			$(".lanjut").css("background-color","rgb(53, 54, 58)");
		 			}
		 			else {
		 				localStorage.setItem('theme',0); 
		 				$("#thema").css("background-color","#ffffff");
		 				$("#thema").css("color","black");
		 				$("#waktu_ujian_user").css("color","black");
		 				$(".lanjut").css("background-color","#ffffff");
		 			}    
		 		}
		 		toggleSwitch.addEventListener('change', switchTheme, false);

		 		var get_thema = localStorage.getItem('theme');
		 		if (get_thema==1) {
		 			toggleSwitch.checked = true;
		 			$("#thema").css("background-color","rgb(53, 54, 58)");
		 			$("#thema").css("color","rgb(232, 234, 237)");
		 			$("#waktu_ujian_user").css("color","white");
		 			$(".btn-slide").css("color","rgb(232, 234, 237)");
		 			$("#modeag").css("color","rgb(232, 234, 237)");
		 			$(".lanjut").css("background-color","rgb(53, 54, 58)");
		 			
		 		}
		 		else {
		 			$("#thema").css("background-color","#ffffff");
		 			$("#thema").css("color","black");
		 			$(".lanjut").css("background-color","#ffffff");
		 			$("#waktu_ujian_user").css("color","black");
		 			toggleSwitch.checked = false;
		 		}   
		 	});
	</script>
	<?php endif; ?>
</body>

</html>