<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<?php $info = ''; ?>
					<div class='row'>
						<div class='col-md-12'>
							<div class='box box-solid'>
								<div class='box-header with-border'>
									<h3 class='box-title'>PINDAH NILAI</h3>
									<div class='box-tools pull-right '>
									<a href="?pg=status2" class="btn btn-sm btn-flat btn-warning"> Status Peserta</a>
									<a class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infojadwal'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Info Pindah</span></a>
								</div><!-- /.box-header -->
									    </div>
								<div class='box-body'>
									<?= $info ?>
									<ul class="nav nav-pills">
									  <li class="active"><a data-toggle="pill" href="#home">PINDAH NILAI</a></li>
									  <li><a data-toggle="pill" href="#menu1">NILAI YANG DIPINDAH</a></li>
									  <!--<li><a data-toggle="pill" href="#menu2">HAPUS NILAI</a></li>-->
									</ul>

									<div class="tab-content" style="padding-top: 20px;">
									  <div id="home" class="tab-pane fade in active">
									  	<div class="row" style="padding-left: 10px;">
											
											</div>
												<table id='example1' class='table table-bordered table-striped'>
													<thead>
                                <tr>
                                    <th width='5px'>#</th>
                                    <th>Nama Ujian</th>
                                    <th>Level</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th><center>Jumlah Nilai</center></th>
                                    <th width="5%">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if ($pengawas['level'] == 'guru') {
                                    $ujianR = mysqli_query($koneksi, "SELECT * FROM nilai a join mapel b ON a.id_mapel=b.id_mapel where b.idguru='$id_pengawas' group by id_ujian");
                                } else {
                                    $ujianR = mysqli_query($koneksi, "SELECT * FROM nilai a join mapel b ON a.id_mapel=b.id_mapel  group by id_ujian");
                                }
                                while ($ujian = mysqli_fetch_array($ujianR)) {
                                    $terkirim = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_ujian='$ujian[id_ujian]' and pindah='1'"));
                                    $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_ujian='$ujian[id_ujian]' and pindah='1'"));
                                    $cek2 = mysqli_num_rows(mysqli_query($koneksi, "select * from jawaban where id_ujian='$ujian[id_ujian]'"));
                                    if ($cek <> 0) {
                                        $dis = 'disabled';
                                    } else {
                                        $dis = '';
                                    }
                                    $no++;
                                    $datanilai = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_ujian='$ujian[id_ujian]'"));
                                    echo "
                                 <tr>
                                    <td>$no</td>
                                    <td>$ujian[nama]</td>
                                    <td>$ujian[level]</td>
                                    <td>$ujian[ujian_mulai]</td>
                                    <td>$ujian[ujian_selesai]</td>
                                    <td><center>$datanilai</center></td>
                                    <td><button class='kirim btn btn-primary btn-sm' data-id='$ujian[id_ujian]' $dis>Pindah</button></td>
                                </tr>
                                ";
                                }
                                ?>

                            </tbody>
                        </table>
                        </div>
									  <div id="menu1" class="tab-pane fade">
									  	<div class="row" style="padding-left: 10px;">
											</div>
												<table id='example2' class='table table-bordered table-striped'>
													<thead>
                                <tr>
                                    <th>Nama Ujian</th>
                                    <th>Level</th>
                                    <th><center>Jumlah Nilai Pindah</center></th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if ($pengawas['level'] == 'guru') {
                                    $ujianQ = mysqli_query($koneksi, "SELECT * FROM nilai_pindah a join mapel b ON a.id_mapel=b.id_mapel where b.idguru='$id_pengawas' group by id_ujian");
                                } else {
                                    $ujianQ = mysqli_query($koneksi, "SELECT * FROM nilai_pindah a join mapel b ON a.id_mapel=b.id_mapel  group by id_ujian");
                                }
                                while ($ujianx = mysqli_fetch_array($ujianQ)) {
                                    $terkirim = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai_pindah where id_ujian='$ujian[id_ujian]'"));
                                    $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai_pindah where id_ujian='$ujian[id_ujian]'"));
                                    $cek2 = mysqli_num_rows(mysqli_query($koneksi, "select * from jawaban where id_ujian='$ujian[id_ujian]'"));
                                    if ($cek <> 0) {
                                        $dis = 'disabled';
                                    } else {
                                        $dis = '';
                                    }

                                    $datanilai = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai_pindah where id_ujian='$ujianx[id_ujian]'"));
                                    echo "
                                 <tr>
                                     <td>$ujianx[nama]</td>
                                     <td>$ujianx[level]</td>
                                     <td><center>$datanilai</center></td>
                                    <td>$ujianx[ujian_mulai]</td>
                                    <td>$ujianx[ujian_selesai]</td>
                                    <td><button class='hapusnilai btn btn-danger btn-sm' data-id='$ujianx[id_ujian]' $dis>Hapus</button></td>
                                </tr>
                                ";
                                }
                                ?>

                            </tbody>
                        </table>
					</div>
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
										<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Informasi Pindah Nilai</h4>
									</div>
									<!-- tambah jadwal  -->
									<div class='modal-body'>
										<p>
										Fitur pindah ujian digunakan untuk memindahkan data nilai agar dapat diproses oleh guru mapel <br>
										Hati-hati saat memindahkan nilai. Nilai yang sudah dipindahkan tidak dapat dikembalikan<br><br>
										<hr>
									    <b>PENTING</b> Pastikan tidak ada siswa yang sedang mengerjakan ujian pada saat memindahkan nilai
									    <hr>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>     
<script>
	$('#example1');
	$(document).on('click', '.kirim', function() {
		var id = $(this).data('id');
		console.log(id);
		swal({
			title: 'Apa anda yakin?',
			text: " Nilai yang dipindahkan tidak dapat dikembalikan!",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: 'nilai/crud_pindah.php?pg=pindah',
					method: "POST",
					data: 'id=' + id,
					success: function(data) {
						toastr.success("berhasil dipindahkan");
						$('#example1').load(location.href + ' #example1');
					}
				});
			}
		})
	});
	
		$('#example2');
	$(document).on('click', '.hapusnilai', function() {
		var id = $(this).data('id');
		console.log(id);
		swal({
			title: 'Apa anda yakin?',
			text: " Akan menghapus nilai ini ??",
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: 'nilai/crud_pindah.php?pg=hapus',
					method: "POST",
					data: 'id=' + id,
					success: function(data) {
						toastr.success("berhasil dihapus");
						$('#example2').load(location.href + ' #example2');
					}
				});
			}
		})
	});
					


 </script>