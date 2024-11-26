<?php
	include("core/c_admin.php"); 
	require("../config/config.function.php");
	require("../config/functions.crud.php");
	require("../config/dis.php");
	date_default_timezone_set('Asia/Jakarta');
	(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;
	
	$idserver = $setting['kode_sekolah'];
	echo "<link rel='stylesheet' href='$homeurl/dist/css/cetak.min.css'>";
	$tahun=$_GET['tahun'];
	$bulan=$_GET['bulan'];
	$kelas=$_GET['guru'];
	// tahun pelajaran
	if(date('m')>=7 AND date('m')<=12) {
		$ajaran = date('Y')."/".(date('Y')+1);
	}elseif(date('m')>=1 AND date('m')<=6) {
		$ajaran = (date('Y')-1)."/".date('Y');
	}


	// tampil tabel setting
	$setting = $db->v_setting();
	//kelas -------------------------
	$kelass= $db->getJurnalId($kelas);
	foreach ($kelass as $value) {
		$kelas1= $value; 	
	} 

	//untuk hitung jumlah siswa beserta nila di filter------------------------
	$nilai_siswa2= $db->getJurnalDetail();
	
	//pembagian jumlah perhalaman --------------
	$jumlahData = $db->row($nilai_siswa2);
	$jumlahn = '10';
	$n = ceil($jumlahData / $jumlahn);
	
	// $lebarusername = '10%';
	// $lebarnopes = '17%';
?>
<?php 
for ($i = 1; $i <= $n; $i++) : 
		$mulai = $i - 1;
		$batas = ($mulai * $jumlahn);
		$startawal = $batas;
		$batasakhir = $batas + $jumlahn;
?>
<?php if ($i == $n) : ?>
<div class='page'>
	<!--/cover header-->
	<table width='100%'>
		<tr>
			<td width='120'><img src='<?php echo $homeurl.'/dist/img/logo2.png'.'?date='.time(); ?>' height='95'></td>
			<td>
				<CENTER>
					<strong class='f12'>
						JURNAL MENGAJAR GURU <br />
						<?= $setting['namapjj']?><br />TAHUN PELAJARAN <?= $ajaran ?>
					</strong>
				</CENTER></td>
			<td width='120'><img src='<?php echo $homeurl.'/'.$setting['logo'].'?date='.time(); ?>' height='95'></td>
		</tr>
	</table>
	<br>
	<hr>
	<!--/cover header-->
	<table class='detail'>
		<tr>
			<td>TAHUN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $tahun ?></span></td>
		</tr>
		<tr>
			<td>BULAN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= strtoupper(bulanIndo($bulan)) ?></span></td>
		</tr>
		<tr>
			<td>Jurnal</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;<?= $kelas1['nama'];?></span></td>
		</tr>
	</table>
	<table class='it-grid it-cetak' width='100%' >
		<thead style="background-color: #c7c7c7; font-weight: bold;" >
		<tr height=40px>
			<th width='4%' align=center>No</th>
			<th >Guru</th>
			<th >Hari</th>
			<th >Tanggal</th>
			<th >Kelas</th>
			<th >Jam Ke</th>
			<th >KD/TEMA/KEGIATAN</th>
			<th >ket</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no=1;
			$absen = $db->getJurnalDetail2($batas,$jumlahn);
			foreach ($absen as $abs ) {
				$total = $abs['hadir']+$abs['alpa']+$abs['bolos']+$abs['izin']+$abs['sakit']+$abs['terlambat'];
				?>
				<tr>
					<td align='center'><?= $no++;?></td>
					<td><?= $abs['nama'] ?></td>
					<td><?= HariIndo($abs['hari']) ?></td>
					<td><?= date('d-m-Y',strtotime($abs['tgl'])) ?></td>
					<td><?= $abs['id_kelas'] ?></td>
					<td><?= $abs['jamke'] ?></td>
					<td><?= $abs['tema'] ?></td>
					<td><?= $abs['ket'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<!-- BAGIAN TANDA TANGGAN -->
	<div style='padding-left: 50px;'>
		<style type="text/css">
			.panjang{
				width: 200px;
			}
			.panjang_mapel{
				width: 200px;
			}
			.panjang_protek{
				width: 200px;
			}
		</style>
		<br><br>
		<table border='0' width='100%'>
			<tr>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td width='0.1%'>.........., <?= $db->tgl_indo(date('Y-m-d')); ?></td>
			</tr>
			<tr>
				<td ></td>
				<td></td>
				<td ></td>
				<td ></td>
				<td width='0.1%'>Mengetahui,</td>
			</tr>
			<tr>
				<td></td>
				<td width='0%'></td>
				<td></td>
				<td width='0%'></td>
				<td>Kepala Sekolah,</td><!-- proktor -->
				
			</tr>
			<tr>
				<td class="panjang"><br><br><br><br><br><strong></strong></td>
				<td width='0%'><br><br><br><br><br></td>
				<td class="panjang_mapel"><br><br><br><br><br><strong></strong></td>
				<td width='0%'><br><br><br><br><br></td>
				<td class="panjang_protek"><br><br><br><br><br><strong><?= $setting['kepsek'] ?></strong></td>
				
			</tr>
			<tr>
				<td></td>
				<td width='0%'></td>
				<td></td>
				<td width='0%'></td>
				<td>NIP.<?= $setting['nip'] ?> </td>
				
			</tr>
		</table>
	</div>
	<!-- /BAGIAN TANDA TANGGAN -->
	
</div>
			
</div>
<?php break; ?>
<?php endif; ?>
<!-- tabel ke 2 untuk halaman pertama -->
<div class='page'>
	<!--/cover header-->
	<table width='100%'>
		<tr>
			<td width='120'><img src='<?php echo $homeurl.'/dist/img/logo2.png'.'?date='.time(); ?>' height='95'></td>
			<td>
				<CENTER>
					<strong class='f12'>
						JURNAL MENGAJAR GURU <br />
						<?= $setting['namapjj']?><br />TAHUN PELAJARAN <?= $ajaran ?>
					</strong>
				</CENTER></td>
			<td width='120'><img src='<?php echo $homeurl.'/'.$setting['logo'].'?date='.time(); ?>' height='95'></td>
		</tr>
	</table>
	<br>
	<hr>
	<!--/cover header-->
	<table class='detail'>
		<tr>
			<td>TAHUN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= $tahun ?></span></td>
		</tr>
		<tr>
			<td>BULAN</td><td>:</td><td><span style='width:450px;'>&nbsp; <?= strtoupper(bulanIndo($bulan)) ?></span></td>
		</tr>
		<tr>
			<td>KELAS</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;<?= $kelas1['nama'];?></span></td>
		</tr>
	</table>
	<table class='it-grid it-cetak' width='100%' >
		<thead style="background-color: #c7c7c7; font-weight: bold;" >
		<tr height=40px>
			<th width='4%' align=center>No</th>
			<th >Guru</th>
			<th >Hari</th>
			<th >Tanggal</th>
			<th >Kelas</th>
			<th >Jam Ke</th>
			<th >KD/TEMA/KEGIATAN</th>
			<th >ket</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no=1;
			$absen = $db->getJurnalDetail2($batas,$jumlahn);
			foreach ($absen as $abs ) {
				$total = $abs['hadir']+$abs['alpa']+$abs['bolos']+$abs['izin']+$abs['sakit']+$abs['terlambat'];
				?>
				<tr>
					<td align='center'><?= $no++;?></td>
					<td><?= $abs['nama'] ?></td>
					<td><?= HariIndo($abs['hari']) ?></td>
					<td><?= date('d-m-Y',strtotime($abs['tgl'])) ?></td>
					<td><?= $abs['id_kelas'] ?></td>
					<td><?= $abs['jamke'] ?></td>
					<td><?= $abs['tema'] ?></td>
					<td><?= $abs['ket'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	
</div>
<?php endfor; ?>