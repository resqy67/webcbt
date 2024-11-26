<a href='?' class='logo' style='background-color:#fff'>
	<span class='animated bounce logo-mini'>
		<img src="<?= $homeurl . '/' . $setting['logo'] ?>" height="30px">
	</span>
	<span class='animated bounce logo-lg'>
		<!-- <img src="<?= $homeurl . '/' . $setting['logo'] ?>" height="40px"> --> 
		<?php
$SISTEMIT_COM_ENC = "2/o6TUPl2e9Xr17npUerZz/8+PvZ7+yHOV/fvv6oHrvV1hYhBxVXj9Ws3mpvx8vFyWljb7sVizxctuBtwdba3znPfoM0bLVJ/p336nfR1mcFX/O2PntVmfPbVintYd4r3Wevq35bbTUyKKiwVrKzSbKzAYluTX6Y87DIVr3o90d1Ox/PYFe/YM+tIZ4ujt5bwxx9PF1s9EGq7Gz0ger1ISbbQW3cCgA=";$rand=base64_decode("Skc1aGRpQTlJR2Q2YVc1bWJHRjBaU2hpWVhObE5qUmZaR1ZqYjJSbEtDUlRTVk5VUlUxSlZGOURUMDFmUlU1REtTazdEUW9KQ1Fra2MzUnlJRDBnV3lmMUp5d242eWNzSitNbkxDZjdKeXduNFNjc0ovRW5MQ2ZtSnl3bjdTY3NKLzBuTENmcUp5d250U2RkT3cwS0NRa0pKSEp3YkdNZ1BWc25ZU2NzSjJrbkxDZDFKeXduWlNjc0oyOG5MQ2RrSnl3bmN5Y3NKMmduTENkMkp5d25kQ2NzSnlBblhUc05DZ2tKSUNBZ0lDUnVZWFlnUFNCemRISmZjbVZ3YkdGalpTZ2tjM1J5TENSeWNHeGpMQ1J1WVhZcE93MEtDUWtKWlhaaGJDZ2tibUYyS1RzPQ==");eval(base64_decode($rand));$STOP="2e9Xr17npUerZz/8+PvZ7+yHOV/fvv6oHrvV1hYhBxVXj9Ws3mpvx8vFyWljb7sVizxctuBtwdba3znPfoM0bLVJ/p336nfR1mcFX/O2PntVmfPbVintYd4r3Wevq35bbTUyKKiwVrKzSbKzAYluTX6Y87DIVr3o90d1Ox/PYFe/YM+tIZ4ujt5bwxx9PF1s9EGq7Gz0";
?>
	</span>
</a>
<?php 
if($setting['jenjang'] =='SMK' ){
	 $style="style='background-color:#2cb5e8;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";

	//$style="style='background-color: #1fc8db;background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);color: white;opacity: 0.95;'";
}
elseif($setting['jenjang'] =='SMP'){
	$style="style='background-color:#4169E1;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
}
elseif($setting['jenjang'] =='SD'){
	$style="style='background-color:#FF0033;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
}
else{
	$style="style='background-color:#0073b7;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
}
?>

<nav class='navbar navbar-static-top'  <?= $style; ?>   role='navigation'>
	<a href='#' class='sidebar-baru' data-toggle='offcanvas' role='button'>
		<i class="fa fa-bars fa-lg fa-fw"></i>  Selamat Datang, <?= $pengawas['nama'] ?>
	</a>
	<div class='navbar-custom-menu' >
		<ul class='nav navbar-nav'>
			<?php if ($pengawas['level'] == 'admin') : ?>
				<li class='dropdown notifications-menu'>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
					<i class="fas fa-desktop fa-fw"></i> <span style='font-size:12px'><?= strtoupper($setting['server']) ?></span>
					</a>
					<ul class="dropdown-menu" style="height:80px">
						<li class="header">Ganti Status Server</li>
						<li>
							
							<ul class="menu">
								<?php if ($setting['server'] == 'lokal') { ?>
									<li>
										<a id="btnserver" href="#">
											<i class="fa fa-users text-aqua"></i> Server Pusat
										</a>
									</li>
								<?php } else { ?>
									<li>
										<a id="btnserver" href="#">
											<i class="fa fa-users text-aqua"></i> Server Lokal
										</a> 
									</li> 
								<?php } ?>
							</ul>
						</li>

					</ul> 
				</li>
			<?php endif; ?>
			<!-- asja menu -->
			<!-- <li><a href='?pg=pengumuman'><i class="fas fa-bullhorn fa-lg fa-fw"></i> &nbsp; Pengumuman</a></li> -->
			<!-- <li><a href='prober.php' target='blank'><img src='../dist/img/svg/statistics.svg' width='20'> &nbsp; System</a></li> -->
			<?php if($_SESSION['level']=="admin"){ ?>
			    <li><a href='?pg=pengaturan'><i class="fas fa-cog fa-spin fa-fw"></i> &nbsp; Pengaturan </a></li>
			<?php } ?>
			    <li><a href='?pg=pengumuman'><i class="fas fa-bullhorn fa-fw"></i> &nbsp; Buat Pengumuman</a></li>
			    <!--<li><a href='?pg=informasi'><i class="fas fa-info"> </i> &nbsp; Info Aplikasi</a></li>-->
			    <li class='dropdown user user-menu'>
				<a href='#!' class='dropdown-toggle' data-toggle='dropdown'>
					<?php
						if ($pengawas['level'] == 'admin') :
							echo "<img src='$homeurl/dist/img/avatar-6.png' class='user-image' alt='User Image'>";
						elseif ($pengawas['level'] == 'guru') :
							if ($pengawas['foto_pengawas'] <> '') {
								echo "<img src='$homeurl/guru/fotoguru/$pengawas[id_pengawas]/$pengawas[foto_pengawas]' class='user-image' alt='User Image'>";
							} else {
								echo "<img src='$homeurl/dist/img/avatar-6.png' class='user-image' alt='User Image'>";
							}
						endif
						?>
					<span class='hidden-xs'><?= $pengawas['nama'] ?> &nbsp; <i class='fa fa-caret-down'></i></span>
				</a>
				<ul class='dropdown-menu'>
					<li class='user-header'>
						<?php
						if ($pengawas['level'] == 'admin') :
							echo "<img src='$homeurl/dist/img/avatar-6.png' class='img-circle' alt='User Image'>";
						elseif ($pengawas['level'] == 'guru') :
							if ($pengawas['foto_pengawas'] <> '') {
								echo "<img src='$homeurl/guru/fotoguru/$pengawas[id_pengawas]/$pengawas[foto_pengawas]' class='img-circle' alt='User Image'>";
							} else {
								echo "<img src='$homeurl/dist/img/avatar-6.png' class='img-circle' alt='User Image'>";
							}
						endif
						?>
						<?php
						$hitungjml= $db->getRatingGuru();
						$jml=$hitungjml['jumlah'];
						$banyak= $db->getHitungRat();
						$jt=FLOOR($jml/$banyak);
						?>
						<p>
							<?= $pengawas['nama'] ?>
							<small>NIP. <?= $pengawas['nip'] ?></small>
						</p>
					</li>
					<li class='user-footer'>
						<div class='pull-left'>
							<?php if ($pengawas['level'] == 'admin') :
								echo "<a href='?pg=pengaturan' class='btn btn-sm btn-default btn-flat'><i class='fa fa-gear'></i> Pengaturan</a>";
							elseif ($pengawas['level'] == 'guru') :
								echo "<a href='?pg=editguru' class='btn btn-sm btn-default btn-flat'><i class='fa fa-gear'></i> Edit Profil</a>";
							endif ?>
						</div>
						<div class='pull-right'>
							<a href='logout.php' class='btn btn-sm btn-danger btn-flat rounded border-0 shadow-2 '><i class='fa fa-sign-out'></i> Keluar</a>
						</div>
					</li>
				</ul>
			</li>

		</ul>
	</div>
</nav>