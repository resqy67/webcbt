<?php
require("config/config.default.php");
require("config/config.asja.php");
$cekdb = mysqli_query($koneksi, "SELECT 1 FROM pengawas LIMIT 1");
if ($cekdb == false) {
	header("Location: install.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $setting['sekolah']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?php echo $setting['logo']; ?>" />
	<link rel="stylesheet" type="text/css" href="dist/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="dist/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="dist/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="dist/css/util.css">
	<link rel="stylesheet" type="text/css" href="dist/css/main.css">
	<link rel='stylesheet' href='<?php echo $homeurl; ?>/plugins/sweetalert2/dist/sweetalert2.min.css'>
</head>
<?php if($setting['LoginSiswaMainten'] ==1){ ?>
<body  style="background-image: url(dist/img/offline.jpg);">
<?php }else{ ?>
<body  style="background-image: url(dist/img/bg-header.jpg);">
<?php } ?>
	<div class="limiter">
		<div class="container-login101">
			<div class="animated wrap-login100" style="padding-top:20px">
				<form id="formlogin" action="ceklogin.php" class="login100-form validate-form">
					<span class="animated infinite pulse delay-5s login100-form-title p-b-10">
					    <?php if($setting['LoginSiswaMainten'] ==1){ ?>
					    <img src="dist/img/offline.jpg" style="max-height:30px" class="img-responsive" alt="Responsive image">
					    <?php }else{ ?>
						<img src="<?php echo $setting['logo']; ?>" style="max-height:60px" class="img-responsive" alt="Responsive image">
						<?php } ?>
					</span>
					<?php if($setting['LoginSiswaMainten'] ==1){ ?>
					<?php }else{ ?>
					<span class="login100-form-title p-b-26">
						<font color='green' size='+2'><?php echo $setting['sekolah']; ?></font>	
					<!--	<p><small><font color='navy'>Support By <?= APLIKASI ?></font></small></p> -->
					</span>
					<span> <font color='purple'>Silakan Login</font> |
					<font color='green'>Jangan Lupa Berdoa</font>   
				    <hr></span>
				    <?php } ?>
					<!-- -------------------------------------------------------------------------------- -->
					<?php if($setting['LoginSiswaMainten'] ==1){ ?>
						<center><span style="font-size: 20px;"><b>KAMI SEGERA KEMBALI</b></span></center>
					<?php }else{ ?>	
					<div class="wrap-input100 validate-input" data-validate="Enter Username" required>
							<input class="input100" type="text" name="username" autocomplete='off'>
							<span class="focus-input100" data-placeholder="Username"></span>
					</div>
                    <?php } ?>
                    <?php if($setting['LoginSiswaMainten'] ==1){ ?>
							<center>
								<div class="alert alert-warning">
								  <strong>Mohon Maaf ! <br></strong> Sitem Sedang Maintenance.<br>
								  Silahkan Kembali Beberapa Saat Lagi.
								</div>
							</center>
						<?php }else{ ?>
						<div class="wrap-input100 validate-input" data-validate="Enter password">
							<span class="btn-show-pass">
								<i class="zmdi zmdi-eye"></i>
							</span>
							<input class="input100" type="password" name="password">
							<span class="focus-input100" data-placeholder="Password"></span>
					    </div>
						<blockquote class="blockquote text-center">
						  <p class="mb-0"><?= $setting['IsiPesanSingkat'];?></p>
						  <footer class="blockquote-footer"><cite title="Source Title"><?= $setting['JudulPesanSingkat'];?></cite></footer>
						</blockquote>
					<?php } ?>
					<?php if($setting['LoginSiswaMainten'] ==1){ ?>
					<?php }else{ ?>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button style="background-color: #6666CC;" class="login100-form-btn">
								Login
							</button>
						</div>
					<!-- -------------------------------------------------------------------------------- -->
						<footer class='main-footer ' style="padding-top: 10px;">
							<div >
							<p>Lupa Username dan Password?	<a href="https://docs.google.com/spreadsheets/d/1jeYg5-F7QMdb_BCa2G_7tjDuHy0FvvBv/edit?usp=sharing&ouid=113930229602150475048&rtpof=true&sd=true" target='_blank' class="txt2 hov1"> <font color='green'>Klik Disini</font>
									<!-- <b><?= APLIKASI . " " . VERSI . " " . REVISI ?></b> 
									<b><?= REVISI ?></b> -->
								</p></a>
							</div>
						</footer>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>
		<div id="dropDownSelect1"></div>
	<!--===============================================================================================-->
	<script src="dist/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="dist/vendor/bootstrap/js/popper.js"></script>
	<script src="dist/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src='<?php echo $homeurl; ?>/plugins/sweetalert2/dist/sweetalert2.min.js'></script>
	<script src="dist/js/main.js"></script>
	<script>
		$(document).ready(function() {
			$('#formlogin').submit(function(e) {
				var homeurl;
				homeurl = '<?php echo $homeurl; ?>';
				e.preventDefault();
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					success: function(data) {

						if (data == "ok") {
							console.log('sukses');
							window.location = homeurl;
						}
						if (data == "nopass") {
							swal({
								position: 'top-end',
								type: 'warning',
								title: 'Password Salah',
								showConfirmButton: false,
								timer: 1500
							});
						}
						if (data == "td") {
							swal({
								position: 'top-end',
								type: 'warning',
								title: 'Siswa tidak terdaftar',
								showConfirmButton: false,
								timer: 1500
							});
						}
						if (data == "nologin") {
							swal({
								position: 'top-end',
								type: 'warning',
								title: 'Siswa sudah aktif',
								showConfirmButton: false,
								timer: 1500
							});
						}
						if (data == "ta") {
							swal({
								position: 'top-end',
								type: 'warning',
								title: 'Siswa tidak mengerjakan tugas',
								showConfirmButton: false,
								timer: 1500
							});
						}

					}
				})
				return false;
			});

		});

		function showpass() {
			var x = document.getElementById("pass");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}
	</script>

</body>

</html>