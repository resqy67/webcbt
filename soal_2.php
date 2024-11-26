<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");

/*
------ mryes
Tempat Aksekui Soal siswa akan di eksekui 
untuk ditampilkan saat ujian berjalan

*/ 

$id_siswa = (isset($_SESSION['id_siswa'])) ? $_SESSION['id_siswa'] : 0;
$siswa = fetch($koneksi, 'siswa', array('id_siswa' => $id_siswa));

$pg = @$_POST['pg'];  //jenis perintah yang di trima dari  dari jquery index.php siswa
$ac = @$_POST['idu'];
$id = @$_POST['id'];

$audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
$image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
?>
<!-- soal pg -->
<?php if ($pg == 'soal') { ?>
	<?php
	$no_soal = $_POST['no_soal'];
	$no_prev = $no_soal - 1;
	$no_next = $no_soal + 1;
	$id_mapel = $_POST['id_mapel'];
	$id_siswa = $_POST['id_siswa'];
	$jenis = $_POST['jenis'];

	$where = array(
		'id_siswa' => $id_siswa,
		'id_mapel' => $id_mapel
	);
	$where2 = array(
		'id_siswa' => $id_siswa,
		'id_mapel' => $id_mapel,
		'id_ujian' => $ac
	);

	$pengacakq = fetch($koneksi, 'pengacak', $where);
	$pengacak = explode(',', $pengacakq['id_soal']);
	$pengacakesai = explode(',', $pengacakq['id_esai']);
	$pengacakpil = explode(',', $pengacakq['id_opsi']);

	$mapel = fetch($koneksi, 'ujian', array('id_mapel' => $id_mapel, 'id_ujian' => $ac));
	
	update($koneksi, 'nilai', array('ujian_berlangsung' => $datetime), $where);
	
	$soal = fetch($koneksi, 'soal', array('id_mapel' => $id_mapel, 'id_soal' => $pengacak[$no_soal], 'jenis' => $jenis));
	
	$jawab = fetch($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $soal['id_soal'], 'id_ujian' => $ac));
	$nilai = fetch($koneksi, 'nilai', $where2);

	if($nilai['selesai']==1){ 
		jump("$homeurl");
	}
	else{
		$blok = fetch($koneksi, 'tb_block');
		if($nilai['blok']==1){
		?>

		<div id="load_block">
						<!-- mryes lock layar blok -->
						<div class="row" style="padding-top: 50px;">
							<div class="col-md-12">
								<div class="wrapper-page bootstrap snippets">
									<div class="text-center">
										<a href="#" class="logo logo-lg">
											<i class="fa fa-lock"></i> 
											<span><?= $blok['judul_block']; ?></span> 
										</a>
									</div>
									<div class="text-center m-t-20">
										<div class="form-group">
											<?php
												if ($siswa['foto'] <> '') :
													if (!file_exists("foto/fotosiswa/$siswa[foto]")) :
														echo "<img src='$homeurl/dist/img/avatar_default.png' class='img-responsive img-circle img-thumbnail' alt='User Image'>";
													else :
														echo "<img width='100px' src='$homeurl/foto/fotosiswa/$siswa[foto]' class='img-responsive img-circle img-thumbnail' alt='User Image'>";
													endif;
												else :
													echo "<img src='$homeurl/dist/img/avatar_default.png' class='img-responsive img-circle img-thumbnail' alt='User Image'>";
												endif;
												?>
												<p>
													<?= $siswa['nama'] ?>
												</p>
											<p class="text-muted"><blockquote><?= $blok['isi_block']; ?></blockquote></p>
											<p class="text-muted"><?= $blok['footer_block']; ?></p>
											
										</div>
									</div>
								</div>
							</div>
						<!-- lock layar -->
						</div>
						</div> <!-- end load_block -->
		<?php }else{ ?>
		<div class='box-body'>
			<div class='row'>
					<div class='col-md-7'>
						<?php
						if ($soal['file'] <> '') {
							$ext = explode(".", $soal['file']);
							$ext = end($ext);
							if (in_array($ext, $image)) {
							?>
							<span > 
								<a data-id="<?php echo $soal[file]; ?>" class="foto_click" href="#" data-toggle="modal" data-target="#modalfoto">
									<img  src='<?php echo"$homeurl/files/$soal[file]"?>' class='img-responsive'/>
								</a>
								</span>
							<?php } elseif (in_array($ext, $audio)) {
								echo "<audio controls='controls' ><source src='$homeurl/files/$soal[file]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
							} else {
								echo "File tidak didukung!";
							}
						} ?>
						<div class='callout soal'>
							<div class='soaltanya'><?= $soal['soal'] ?></div>
						</div>
					<?php
					if ($soal['file1'] <> '') {
						$ext = explode(".", $soal['file1']);
						$ext = end($ext);
						if (in_array($ext, $image)) {
							?> 
							<!--  id='zoom1'  -->
							<span > 
								<a data-id="<?php echo $soal[file]; ?>" class="foto_click" href="#" data-toggle="modal" data-target="#modalfoto">
									<img  src='<?php echo"$homeurl/files/$soal[file1]"?>' class='img-responsive'/>
								</a>
							</span>
						<?php } elseif (in_array($ext, $audio)) {
							echo "<audio controls='controls' ><source src='$homeurl/files/$soal[file1]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
						} else {
							echo "File tidak didukung!";
						}
					}
					?>
				</div>
			
			<!-- +++++++The Modal FOTO ++++++++++++ -->
			<script type="text/javascript">
				$( document ).ready(function() {
					$(".foto_click").click(function(){
						var id = $(this).data('id');
						var cek_foto = '/files/'+id;
	              //var host = window.location.host;
	              var base_url = '<?= $homeurl; ?>'
	              var foto = '<img style="width:100%;" class="img-responsive " src="'+base_url+''+cek_foto+'">';
	              $('#foto_modal').html(foto);
	            });
				});
			</script>
			<!-- <script>
						$(document).ready(function() {
							$('#zoom').zoom();
							$('#zoom1').zoom();
							$('.lup').zoom();
							$('.soal img')
								.wrap('<span style="display:inline-block"></span>')
								.css('display', 'block')
								.parent()
								.zoom();
						});
					</script> -->
					<div class="modal" id="modalfoto" aria-hidden="true" role="dialog" tabindex="-1" class="modal fade">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<!-- Modal Header -->
								<div class="modal-header" style="background-color: #0d7fa0; padding: 0px; padding-left: 20px;padding-top: 20px;">
									<button type="button" class="close" data-dismiss="modal"><span style="color: red;">Keluar</span>&times;</button>
								</div> 
								<!-- Modal body -->
								<div class="modal-body" id="foto_modal">

								</div>
							</div>
						</div>
					</div>
					<!-- +++++++ END The Modal FOTO  ++++++++++++ -->
				
				<div class='col-md-12'>
					<!-- tampil opsi mryes -->
					<?php
					if ($mapel['opsi'] == 3) {
						$kali = 3;
					} elseif ($mapel['opsi'] == 4) {
						$kali = 4;
						$nop4 = $no_soal * $kali + 3;
						$pil4 = $pengacakpil[$nop4];
						$pilDD = "pil" . $pil4;
						$fileDD = "file" . $pil4;
					} elseif ($mapel['opsi'] == 5) {
						$kali = 5;
						$nop4 = $no_soal * $kali + 3;
						$pil4 = $pengacakpil[$nop4];
						$pilDD = "pil" . $pil4;
						$fileDD = "file" . $pil4;
						$nop5 = $no_soal * $kali + 4;
						$pil5 = $pengacakpil[$nop5];
						$pilEE = "pil" . $pil5;
						$fileEE = "file" . $pil5;
					}

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


					$a = ($jawab['jawabx'] == 'A') ? 'checked' : '';
					$b = ($jawab['jawabx'] == 'B') ? 'checked' : '';
					$c = ($jawab['jawabx'] == 'C') ? 'checked' : '';

					if ($mapel['opsi'] == 4) :
						$d = ($jawab['jawabx'] == 'D') ? 'checked' : '';
					elseif ($mapel['opsi'] == 5) :
						$d = ($jawab['jawabx'] == 'D') ? 'checked' : '';
						$e = ($jawab['jawabx'] == 'E') ? 'checked' : '';
					endif;

					$ragu = ($jawab['ragu'] == 1) ? 'checked' : '';
					?>
					<?php if ($soal['pilA'] == '' and $soal['fileA'] == '' and $soal['pilB'] == '' and $soal['fileB'] == '' and $soal['pilC'] == '' and $soal['fileC'] == '' and $soal['pilD'] == '' and $soal['fileD'] == '') { ?>
						<?php
						$ax = ($jawab['jawabx'] == 'A') ? 'checked' : '';
						$bx = ($jawab['jawabx'] == 'B') ? 'checked' : '';
						$cx = ($jawab['jawabx'] == 'C') ? 'checked' : '';
						$dx = ($jawab['jawabx'] == 'D') ? 'checked' : '';
						if ($mapel['opsi'] == 5) :
							$ex = ($jawab['jawabx'] == 'E') ? 'checked' : '';
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
										<input class='hidden radio-label' type='radio' name='jawab' id='D' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'D','D',1,<?= $ac ?>)" <?= $dx ?> />
										<label class='button-label' for='D'>
											<h1>D</h1>
										</label>
									</td>
								<?php } ?>
							</tr>
						</table>
					<?php } else { ?>
						<!-- table-striped table-hover -->
						<table width='100%' class='table'>
							<tr>
								<!-- Opsi A -->
								<td width='60'>
									<input class='hidden radio-label' type='radio' name='jawab' id='A' onclick="jawabsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil1 ?>','A',1,<?= $ac ?>)" <?= $a ?> />
									<label class='button-label' for='A'>
										<h1>A</h1>
									</label>
								</td>
								<td style='vertical-align:middle;'>
									<!-- gambar opsi -->
									<span class='soal'><?= $soal[$pilAA] ?></span>

									<?php if ($soal[$fileAA] <> '') : ?>
										<?php
										$ext = explode(".", $soal[$fileAA]);
										$ext = end($ext);

										if (in_array($ext, $image)) :
											?>
											<a data-id="<?php echo $soal[$fileAA]; ?>" class="foto_click" href="#" data-toggle="modal" data-target="#modalfoto">
											<?php echo "<span  style='display:inline-block'><img src='$homeurl/files/$soal[$fileAA]' class='img-responsive' style='width:250px;'/></span>";
											?>
											</a>
											<?php
										elseif (in_array($ext, $audio)) :
											echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileAA]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
										else :
											echo "File tidak didukung!";
										endif;
										?>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<!-- Opsi B -->
								<td width='60'>
									<input class='hidden radio-label' type='radio' name='jawab' id='B' onclick="jawabsoal(<?= $id_mapel ?>, <?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil2 ?>','B',1, <?= $ac ?>)" <?= $b ?> />
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
										if (in_array($ext, $image)) :
											?>
											<a data-id="<?php echo $soal[$fileBB]; ?>" class="foto_click" href="#" data-toggle="modal" data-target="#modalfoto">
											<?php
											echo "<span style='display:inline-block'><img src='$homeurl/files/$soal[$fileBB]' class='img-responsive' style='width:250px;'/></span></a>";
										elseif (in_array($ext, $audio)) :
											echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileBB]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
										else :
											echo "File tidak didukung!";
										endif;
									}
									?>
								</td>
							</tr>
							<tr>
								<!-- Opsi C -->
								<td>
									<input class='hidden radio-label' type='radio' name='jawab' id='C' onclick="jawabsoal(<?= $id_mapel ?>, <?= $id_siswa ?>, <?= $soal['id_soal'] ?>,'<?= $pil3 ?>','C',1,<?= $ac ?>)" <?= $c ?> />
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
											?>
											<a data-id="<?php echo $soal[$fileCC]; ?>" class="foto_click" href="#" data-toggle="modal" data-target="#modalfoto">
											<?php
											echo "<span style='display:inline-block'><img src='$homeurl/files/$soal[$fileCC]' class='img-responsive' style='width:250px;'/></span></a>";
										} elseif (in_array($ext, $audio)) {
											echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileCC]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
										} else {
											echo "File tidak didukung!";
										}
									}
									?>
								</td>
							</tr>
							<?php if ($mapel['opsi'] <> 3) : ?>
								<tr>
									<td>
										<input class='hidden radio-label' type='radio' name='jawab' id='D' onclick="jawabsoal(<?= $id_mapel ?>, <?= $id_siswa ?>,<?= $soal['id_soal'] ?>,'<?= $pil4 ?>','D',1,<?= $ac ?>)" <?= $d ?> />
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
												?>
											<a data-id="<?php echo $soal[$fileDD]; ?>" class="foto_click" href="#" data-toggle="modal" data-target="#modalfoto">
											<?php
												echo "<span style='display:inline-block'><img src='$homeurl/files/$soal[$fileDD]' class='img-responsive' style='width:250px;'/></span></a>";
											} elseif (in_array($ext, $audio)) {
												echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileDD]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
											} else {
												echo "File tidak didukung!";
											}
										}
										?>
									</td>
								</tr>
							<?php endif; ?>
							<?php if ($mapel['opsi'] == 5) : ?>
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
												?>
											<a data-id="<?php echo $soal[$fileEE]; ?>" class="foto_click" href="#" data-toggle="modal" data-target="#modalfoto">
											<?php
												echo "<span  style='display:inline-block'><img src='$homeurl/files/$soal[$fileEE]' class='img-responsive' style='width:250px;'/></span></a>";
											} elseif (in_array($ext, $audio)) {
												echo "<audio controls='controls' ><source src='$homeurl/files/$soal[$fileEE]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
											} else {
												echo "File tidak didukung!";
											}
										} ?>
									</td>
								</tr>
							<?php endif; ?>
						</table>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class='box-footer navbar-fixed-bottom lanjut' >
			<table width='100%'>
				<tr>
					<td style="text-align:center">
						<?php if ($no_soal == 0) { ?>

							<button id='move-prev' class='btn btn-primary' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_prev ?>,1)"><i class='fas fa-angle-double-left'></i> <span class='hidden-xs'>SEBELUMNYA</span></button>
							<!-- <i class='fa fa-spin fa-spinner' id='spin-prev' style='display:none;'></i> -->

						<?php } else { ?>

							<button id='move-prev' class='btn  btn-primary' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_prev ?>,1)"><i class='fas fa-angle-double-left'></i> <span class='hidden-xs'>SEBELUMNYA</span></button>
							<!-- <i class='fa fa-spin fa-spinner' id='spin-prev' style='display:none;'></i> -->

						<?php } ?>
					</td>
					<td style="text-align:center">

						<div id='load-ragu'>
							<a href='#' class='btn btn-warning'><input type='checkbox' onclick="radaragu(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soal['id_soal'] ?>, <?= $ac ?>)" <?= $ragu ?> /> RAGU</a>
						</div>

					</td>
					<td style="text-align:center">
						<?php
						$jumsoalpg = $mapel['tampil_pg'];
						$jumsoalesai = $mapel['tampil_esai'];
						$cekno_soal = $no_soal + 1;
						?>
						<?php if (($no_soal >= 0) && ($cekno_soal < $jumsoalpg)) { ?>

							<!-- <i class='fa fa-spin fa-spinner' id='spin-next' style='display:none;'></i> -->
							<button id='move-next' class='btn  btn-primary' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_next ?>,1)"><span class='hidden-xs'>SELANJUTNYA </span><i class='fas fa-angle-double-right'></i></button>

						<?php } elseif (($no_soal >= 0) && ($cekno_soal = $jumsoalpg) && ($jumsoalesai == 0)) { ?>
							<?php
							$waktu_awal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT id_ujian, ujian_mulai FROM nilai WHERE id_siswa = '$id_siswa' AND id_mapel = '$id_mapel' AND id_ujian = '$ac'"));
							$lamaujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT lama_ujian FROM ujian WHERE id_ujian = '$waktu_awal[id_ujian]'"));
							$nilai2 = fetch($koneksi, 'nilai', $where2);
							?>
								
								<!-- ini tombol yang tampil di soal siswa -->
							<?php if ($nilai2['cek_tombol_selesai']==1) : ?>
								<!-- jika cek_tombol selesai sudah 1 maka tombol selesai tampil -->
									<input type='submit' name='done' id='done-submit' style='display:none;' />
									<button class='done-btn btn btn-danger'><i class="fas fa-flag-checkered"></i><span class='hidden-xs'>&nbsp;SELESAI</span> </button>
							<?php else : ?> 
									<input type='submit' name='done' id='selesai-submit' style='display:none;' />
									<button class='done-btn btn btn-danger' id="selesai-submit2" disabled><i class="fas fa-flag-checkered"></i><span class='hidden-xs'>&nbsp; SELESAI</span><br>
									</button>

							<?php endif; ?>


						<?php } elseif (($no_soal >= 0) && ($cekno_soal = $jumsoalpg) && ($jumsoalesai > 0)) { ?>

							<!-- <i class='fa fa-spin fa-spinner' id='spin-next' style='display:none;'></i> -->
							<button id='badgeesai' class='btn  btn-success' onclick="loadsoalesai(<?= $id_mapel ?>,<?= $id_siswa ?>,0,2)"><span class='hidden-xs'>SOAL ESAI </span><i class='fas fa-angle-double-right'></i></button>

						<?php } ?>
					</td>
				</tr>
			</table>
		</div>
	<?php 
		} 
	} ?>
	<script>
		$(document).ready(function() {
			Mousetrap.bind('enter', function() {
				loadsoal(<?= $id_mapel . "," . $id_siswa . "," . $no_next . ",1" ?>);
			});

			Mousetrap.bind('right', function() {
				loadsoal(<?= $id_mapel . "," . $id_siswa . "," . $no_next . ",1" ?>);
			});

			Mousetrap.bind('left', function() {
				loadsoal(<?= $id_mapel . "," . $id_siswa . "," . $no_prev . ",1" ?>);
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
				radaragu(<?= $id_mapel . "," . $id_siswa . "," . $soal['id_soal'] ?>, <?= $ac ?>)
			});

		});
	</script>
	<script>
		MathJax.Hub.Typeset()
	</script>
<?php } ?>
<!-- soal esai -->
<?php if ($pg == 'soalesai') { ?>
	<?php
	$no_soal = $_POST['no_soal'];
	$no_prev = $no_soal - 1;
	$no_next = $no_soal + 1;
	$id_mapel = $_POST['id_mapel'];
	$id_siswa = $_POST['id_siswa'];
	$jenis = $_POST['jenis'];

	$where = array(
		'id_siswa' => $id_siswa,
		'id_mapel' => $id_mapel
	);
	$where2 = array(
		'id_siswa' => $id_siswa,
		'id_mapel' => $id_mapel,
		'id_ujian' => $ac
	);

	$pengacakq = fetch($koneksi, 'pengacak', $where);
	$pengacak = explode(',', $pengacakq['id_soal']);
	$pengacakpil = explode(';', $pengacakq['id_opsi']);
	$pengacakesai = explode(',', $pengacakq['id_esai']);
	$mapel = fetch($koneksi, 'ujian', array('id_mapel' => $id_mapel, 'id_ujian' => $ac));

	update($koneksi, 'nilai', array('ujian_berlangsung' => $datetime), $where2);

	$soalesai = fetch($koneksi, 'soal', array('id_mapel' => $id_mapel, 'id_soal' => $pengacakesai[$no_soal], 'jenis' => $jenis));
	$jawabesai = fetch($koneksi, 'jawaban', array('id_siswa' => $id_siswa, 'id_mapel' => $id_mapel, 'id_soal' => $soalesai['id_soal'], 'id_ujian' => $ac));
	?>
	<div class='box-body'>
		<div class='col-md-12'>
			<?php
			if ($soalesai['file'] <> '') {
				$ext = explode(".", $soalesai['file']);
				$ext = end($ext);
				if (in_array($ext, $image)) {
					echo "<div class='col-md-5'><span  id='zoom' style='display:inline-block'> <img  src='$homeurl/files/$soalesai[file]' class='img-responsive'/></span></div>";
				} elseif (in_array($ext, $audio)) {
					echo "<audio controls='controls' ><source src='$homeurl/files/$soalesai[file]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
				} else {
					echo "File tidak didukung!";
				}
			}
			if ($soalesai['file1'] <> '') {
				$ext = explode(".", $soalesai['file1']);
				$ext = end($ext);
				if (in_array($ext, $image)) {
					echo "<div class='col-md-5'><span  id='zoom1' style='display:inline-block'> <img  src='$homeurl/files/$soalesai[file1]' class='img-responsive'/></span></div>";
				} elseif (in_array($ext, $audio)) {
					echo "<audio controls='controls' ><source src='$homeurl/files/$soalesai[file1]' type='audio/$ext' style='width:100%;'/>Your browser does not support the audio tag.</audio>";
				} else {
					echo "File tidak didukung!";
				}
			}
			?>
		</div>
		<div id='result'></div>
<div class='row'>
    <div class='col-md-12'>
        <div class='callout soal'>
            <div class='soaltanya'><?= $soalesai['soal'] ?></div>
        </div>
        <textarea id='jawabesai' name='textjawab' style='height:200px' class='form-control' onchange="jawabesai(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $soalesai['id_soal'] ?>,2)"><?= $jawabesai['esai'] ?></textarea>
        <br><br>
    </div>
</div>
<div class='box-footer navbar-fixed-bottom'>
    <table width='100%'>
        <tr>
            <td>
                <?php
                $jumsoalpg = $mapel['tampil_pg'];
                $jumsoalesai = $mapel['tampil_esai'];
                $cekno_soal = $no_soal + 1;
                $pg_max = $jumsoalpg - 1;
                ?>
                <?php if (($no_soal > 0)) : ?>
                <td style="text-align:center">
                    <button id='move-prev' class='btn btn-default' onclick="loadsoalesai(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_prev ?>,2)"><i class='fas fa-angle-double-left'></i><span class='hidden-xs'> SOAL SEBELUMNYA</span></button>
                </td>
                <?php elseif (($no_soal == 0) && ($cekno_soal < $jumsoalesai)) : ?>
                <td style="text-align:center">
                    <button id='badge' class='btn btn-warning' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $pg_max ?>,1)"><i class='fas fa-angle-double-left'></i><span class='hidden-xs'> KEMBALI SOAL PG</span></button>
                </td>
                <?php endif; ?>

                <!-- Kondisi ketika hanya ada 1 soal esai -->
                <?php if ($jumsoalesai == 1) : ?>
                <td style="text-align:center">
                    <!-- Tambahkan tombol kembali ke soal PG jika hanya ada 1 soal esai -->
                    <button id='badge' class='btn btn-warning' onclick="loadsoal(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $pg_max ?>,1)"><i class='fas fa-angle-double-left'></i><span class='hidden-xs'> KEMBALI SOAL PG</span></button>
                </td>
                <td style="text-align:center">
                    <button class='done-btn btn btn-danger' onclick="selesaikanUjian()"><i class="fas fa-flag-checkered"></i><span class='hidden-xs'>&nbsp; SELESAI </span></button>
                </td>

                <!-- Kondisi untuk lebih dari 1 soal esai -->
                <?php elseif (($no_soal >= 0) && ($cekno_soal < $jumsoalesai)) : ?>
                <td style="text-align:center">
                    <button id='move-next' class='btn btn-primary' onclick="loadsoalesai(<?= $id_mapel ?>,<?= $id_siswa ?>,<?= $no_next ?>,2)"><span class='hidden-xs'>SOAL SELANJUTNYA</span> <i class='fas fa-angle-double-right'></i></button>
                </td>

                <!-- Kondisi untuk soal terakhir dan mengaktifkan tombol selesai -->
                <?php elseif (($no_soal > 0) && ($cekno_soal == $jumsoalesai)) : ?>
                <td style="text-align:center">
                    <?php
                    $waktu_awal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT id_ujian, ujian_mulai FROM nilai WHERE id_siswa = '$id_siswa' AND id_mapel = '$id_mapel' AND id_ujian = '$ac'"));
                    $lamaujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT lama_ujian FROM ujian WHERE id_ujian = '$waktu_awal[id_ujian]'"));
                    $nilai2 = fetch($koneksi, 'nilai', $where2);
                    ?>
                    
                    <!-- Pastikan tombol selesai diaktifkan jika cek_tombol_selesai bernilai 1 -->
                    <?php if ($nilai2['cek_tombol_selesai'] == 1) : ?>
                    <input type='submit' name='done' id='done-submit' style='display:none;' />
                    <button class='done-btn btn btn-danger' onclick="selesaikanUjian()"><i class="fas fa-flag-checkered"></i><span class='hidden-xs'>&nbsp; SELESAI </span></button>
                    <?php else : ?>
                    <input type='submit' name='done' id='selesai-submit' style='display:none;' />
                    <button class='done-btn btn btn-danger' id="selesai-submit2" disabled><i class="fas fa-flag-checkered"></i><span class='hidden-xs'>&nbsp; SELESAI </span><br>
                    </button>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>

	
<!-- jawaban pg -->
<?php } elseif ($pg == 'jawab') {
	$jenis = $_POST['jenis'];
	$id_mapel = $_POST['id_mapel'];
	$id_ujian = $_POST['id_ujian'];
	$data = array(
		'id_ujian' => $_POST['id_ujian'],
		'id_mapel' => $_POST['id_mapel'],
		'id_siswa' => $_POST['id_siswa'],
		'id_soal' => $_POST['id_soal'],
		'jenis' => $_POST['jenis'],
		'jawaban' => $_POST['jawaban'],
		'jawabx' => $_POST['jawabx']
	);
	$where = array(
		'id_ujian' => $_POST['id_ujian'],
		'id_mapel' => $_POST['id_mapel'],
		'id_siswa' => $_POST['id_siswa'],
		'jenis' => $_POST['jenis'],
		'id_soal' => $_POST['id_soal']
	);
	$mapel2 = fetch($koneksi, 'ujian', array('id_mapel' => $id_mapel , 'id_ujian' => $id_ujian));
	//proese simpan jawaban
	$cekjawaban = rowcount($koneksi, 'jawaban', $where);
	if ($cekjawaban == 0) {
		$exec = insert($koneksi, 'jawaban', $data);
		if($mapel2['history'] == 1){ //jika histori jawaban di aktifkan
			$exec = insert($koneksi, 'jawaban_copy', $data);
		}

	} else {
		$exec = update($koneksi, 'jawaban', $data, $where);
		if($mapel2['history'] == 1){
			$exec = update($koneksi, 'jawaban_copy', $data, $where);
		}
		
	}
	echo $exec;
} 
//<!-- jawaban esai -->
elseif ($pg == 'jawabesai') {

	
	$data = array(
		'id_ujian' => $_POST['idu'],
		'id_mapel' => $_POST['id_mapel'],
		'id_siswa' => $_POST['id_siswa'],
		'id_soal' => $_POST['id_soal'],
		'jenis' => 2,
		'esai' => addslashes($_POST['jawaban'])
	);
	$where = array(
		'id_ujian' => $_POST['idu'],
		'id_mapel' => $_POST['id_mapel'],
		'id_siswa' => $_POST['id_siswa'],
		'jenis' => 2,
		'id_soal' => $_POST['id_soal']
	);
	$mapell = fetch($koneksi, 'ujian', array('id_mapel' => $_POST['id_mapel'] , 'id_ujian' => $_POST['idu']));
	$cekjawaban = rowcount($koneksi, 'jawaban', $where);
	if ($cekjawaban == 0) {
		$exec = insert($koneksi, 'jawaban', $data);
		if($mapell['history'] == 1){
			$exec = insert($koneksi, 'jawaban_copy', $data);
		}
	} else {
		$exec = update($koneksi, 'jawaban', $data, $where);
		if($mapell['history'] == 1){
			$exec = update($koneksi, 'jawaban_copy', $data, $where);
		}
		
	}
	echo $exec;
} 
//<!--Proses Pilihan ragu ragu -->
elseif ($pg == 'ragu') {
	$where = array(
		'id_mapel' => $_POST['id_mapel'],
		'id_siswa' => $_POST['id_siswa'],
		'id_soal' => $_POST['id_soal'],
		'id_ujian' => $_POST['id_ujian'],
		'jenis' => 1
	);
	$cekragu = fetch($koneksi, 'jawaban', $where);
	if ($cekragu['ragu'] == 0) {
		$exec = update($koneksi, 'jawaban', array('ragu' => 1), $where);
	} else {
		$exec = update($koneksi, 'jawaban', array('ragu' => 0), $where);
	}
	echo $exec;
	// print_r($where);
}
?>
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