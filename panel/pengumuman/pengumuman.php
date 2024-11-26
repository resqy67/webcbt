<?php if($setting['kodesekolahid'] ==$setting['sekolah']){ ?>
<?php if ($pengawas['level'] == 'guru' or $pengawas['level'] == 'peng') : ?>
<div class='row'>
    <div class='alert alert-info alert-dismissible'>
								<?php if($setting['izin_ujian']==0){ ?>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
								<i class='icon fa fa-info'></i>
								Selamat datang, <i><?= $pengawas['nama'] ?>.</i> 
								<?php }
								else{
									echo"Selamat Datang, ".$pengawas['nama']; 
								} 
								?>
								</div>
									<div class='  col-md-8'>
									    <div class='animated swing col-md-4'>
										<a href='?pg=siswa'><div class='info-box bg-green'>
											<span class='info-box-icon bg-green'><img src='../dist/img/svg/manager.svg'></span>
											<div class='info-box-content'>
												<span class='info-box-text'>SISWA</span>
												<span class='info-box-number'><?= $siswa?></span>
											</div><!-- /.info-box-content -->
										</div></a><!-- /.info-box -->
										</div>
										
										<div class='animated swing col-md-4'>
										<a href='?pg=tugas_pb'><div class='info-box bg-navy'>
											<span class='info-box-icon bg-navy'><img src='../dist/img/svg/library.svg' width="75px"></span>
											<div class='info-box-content'>
												<span class='info-box-text'>TUGAS</span>
												<span class='info-box-number'><?= $tugas ?></span>
											</div><!-- /.info-box-content -->
										</div></a><!-- /.info-box -->
										</div>
										
										<?php if($setting['jenjang'] =='SD'){ ?>
										    <div class='animated swing col-md-4'>
										<a href='?pg=ruang'><div class='info-box bg-maroon'>
											<span class='info-box-icon bg-maroon'><img src='../dist/img/svg/library.svg' width="75px"></span>
											<div class='info-box-content'>
												<span class='info-box-text'>RUANGAN</span>
												<span class='info-box-number'><?= $ruang ?></span>
											</div>
										</div>
                                    </div>
                                    <?php }else{ ?>
										<div class='animated swing col-md-4'>
										<a href='?pg=siswa_kelas'><div class='info-box bg-maroon'>
											<span class='info-box-icon bg-maroon'><img src='../dist/img/svg/collaboration.svg' width="75px"></span>
											<div class='info-box-content'>
											 <span class='info-box-text'>Level</span>
											<table>
    										<?php 
    										$siswa_sesi = mysqli_query($koneksi, "SELECT level,COUNT(level)AS jml FROM siswa GROUP BY level");
    										while ($dsiswa = mysqli_fetch_array($siswa_sesi)) :
    										?>
										    <tr style="font-size: 12px; font-weight: bold; height: 20px;">
										      <td width="15px"> <?= $dsiswa['level']; ?></td>
										      <td width="20px"> = </td>
										      <td><?= $dsiswa['jml']; ?></td>
										    </tr>
										<?php endwhile ?>
										</table>
											</div>
										</div>
										</div>
										 <?php } ?>
										 
										<div class='animated swing col-md-4'>
										<a href='?pg=nilai2'><div class='info-box bg-yellow'>
											<span class='info-box-icon bg-yellow'><img src='../dist/img/svg/inspection.svg'></span>
											<div class='info-box-content'>
												<span class='info-box-text'>NILAI</span>
												<span class='info-box-number'><?= $nilai_pindah ?></span>
											</div><!-- /.info-box-content -->
										</div></a><!-- /.info-box -->
										</div>
										
										<div class='animated swing col-md-4'>
										<a href='?pg=materi_pb'><div class='info-box bg-purple'>
											<span class='info-box-icon bg-purple'><img src='icon/books.svg'></span>
											<div class='info-box-content'>
												<span class='info-box-text'>MATERI</span>
												<span class='info-box-number'><?= $materi ?></span>
											</div><!-- /.info-box-content -->
										</div></a><!-- /.info-box -->
										</div>
									
									<div class='animated swing col-md-4'>
										<a href='?pg=banksoal'><div class='info-box bg-aqua'>
											<span class='info-box-icon bg-aqua'><img src='../dist/img/svg/briefcase.svg'></span>
											<div class='info-box-content '>
												<span class='info-box-text'>SOAL</span>
												<span class='info-box-number'><?= $bank_soal ?></span>
											</div><!-- /.info-box-content -->
										</div></a><!-- /.info-box -->
                                    </div>
                                 </div>
        <?php if($setting['izin_ujian']==0){ ?>
        <div class="col-md-4">
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-body">
                    <div id='infoweb'></div>
                    <p style="text-align: center; font-size: 0.7em;" > 
                    <center> <a href="https://tawk.to/chat/5fa7fb450a68960861bcd2d6/default" target="_blank"  class="fa fa-user" > </i><spam> Perangkat Pembelajaran &#8287; <i class="fas fa-comment-dots  "> </i></spam></a></center>
                    <ul class="list-group"><center>
                        <li class="list-group-item">
                            <a style="width: 80px;" href="https://drive.google.com/drive/folders/1AHkhDwy-ZKL1z18xNBjhcY0sYH9KXPj1" target="_blank" class="btn btn-success">
                            RPP
                            </a>
                            <a style="width: 80px;" href="http://ditpsd.kemdikbud.go.id/hal/merdeka-belajar" target="_blank" class="btn btn-warning">
                            Modul
                            </a></li>
                        <li class="list-group-item">
                            <a style="width: 80px;" href="https://drive.google.com/drive/folders/1roqZ1V2V_brkhcq7ViOwqkqwZyCVXXxb" target="_blank" class="btn btn-danger">
                            PPT
                            </a>
                            <a style="width: 80px;" href="https://bse.belajar.kemdikbud.go.id/" target="_blank" class="btn btn-primary">
                            Buku
                            </a></li></center>
                    </ul>
                </div>
            </div>
        </div>
        <?php }else{ ?>
    <div class="col-md-4">
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-body">
                    <div id='infoweb'></div>
                    <p style="text-align: center; font-size: 0.7em;" > 
                    <center> <a href="https://tawk.to/chat/5fa7fb450a68960861bcd2d6/default" target="_blank"> </i><spam> POSKO CBT <?=$setting['sekolah'] ?> &#8287; </i></spam></a></center>
                    <center>
                    <ul class="list-group">
                        <li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">
                            <a href="https://api.whatsapp.com/send/?phone=<?= $setting['fax'] ?>&text=Assalamualaikum, Pak Asep. Minta info aplikasi" target="_blank" class="btn btn-success">
                                <i class="fab fa-whatsapp"></i> Whatsapp
                            </a></li>
                        <li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">
                            <a href="https://t.me/<?= $setting['web'] ?>" target="_blank" class="btn btn-primary">
                                <i class="fab fa-telegram-plane"></i> Telegram
                            </a></li>
                        </ul>
                        </center>
                </div>
            </div>
        </div>
        <?php }?>
    <div class='row'>
        <div class='col-md-8'>
            <div class='box box-solid direct-chat direct-chat-warning'>
                <div class='box-header with-border' style="background-color: #FF0066">
                    <font color='#fff'><h3 class='box-title'><i class='fa fa-bullhorn'></i> Pengumuman</font>
                    </h3> 
                    <div class='box-tools pull-right' ></div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <?php $logC = 0;
		echo "<ul class='timeline'><li class='time-label'><span class='bg-black'>- Terbaru -</span></li>";
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
						</div>
						</li>
						<?php
		}
		if ($logC == 0) {
			echo "<p class='text-center'>Belum ada pengumuman.</p>
			";
		}
		?></ul>
                        </div>
                <!-- /.box-body -->
            </div><!-- /.box -->
                </div>
        <div class='col-md-4'>
            <div class='box box-solid' style="background-color: #FFFAF0">
                <div class='box-body'> 
                    <strong><i class='fa fa-home'></i> <?= $setting['sekolah'] ?></strong><br />
                    <a href="https://bit.ly/Sirasep" target="_blank" >
                    <?= $setting['alamat'] ?></a><br /><br />
                    <strong><i class='fa fa-phone'></i> Telp</strong><br />
                    <a href="https://bit.ly/Sirasep" target="_blank" >
                    <?= $setting['telp'] ?></a><br /><br /> 
                    <strong><i class='fa fa-at'></i> E-mail</strong><br />
                    <a href="https://t.me/Sirasja/" target="_blank" >
                    <?= $setting['email'] ?></a><br />
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        
        <div class='col-md-20'>
            <div class='box box-solid' style="background-color: #E6E6FA">
                <div class='box-body'> 
                    <strong><img src='../dist/img/svg/manager.svg' width="20" height="20"></i> &reg; <?=$setting['yayasan'] ?> <?= date(Y)?></strong><br />
                    <a href="https://bit.ly/Sirasep" target="_blank" ></a>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
<?php endif ?>
<?php }else{ ?> <?php } 