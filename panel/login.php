<!DOCTYPE html>
<?php

require("../config/config.default.php");
require("../config/config.function.php");
require("../config/config.asja.php");
$cekdb = mysqli_query($koneksi, "SELECT 1 FROM pengawas LIMIT 1");
if ($cekdb == false) {
	header("Location: ../install.php");
}

$ceks = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting"));
$token_bot = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM bot_telegram"));

$namaaplikasi = $ceks['aplikasi'];
$namasekolah = $ceks['sekolah'];

if (isset($_POST['submit'])) {


	$username = $_POST['username'];
	$password = $_POST['password'];
	$query = mysqli_query($koneksi, "SELECT * FROM pengawas WHERE username='$username'");

	$cek = mysqli_num_rows($query);
	$user = mysqli_fetch_array($query);


	if ($cek <> 0) {

		if ($user['level'] == 'admin') {

			if (!password_verify($password, $user['password'])) {
				$info = info("Password salah!", "NO");
			} else {
				$_SESSION['id_pengawas'] = $user['id_pengawas'];
				$_SESSION['level'] = 'admin';
				// validasi session token
				$_SESSION['token'] = $ceks['db_token'];
				$_SESSION['token1'] = $ceks['db_token1'];
				$_SESSION['token_bot_telegram'] = $token_bot['botToken'];
				echo "<script>location.href = '.';</script>";
			}
		} 
		elseif ($user['level'] == 'peng') {
			if (!password_verify($password, $user['password'])) {
				$info = info("Password salah!", "NO");
			} else {
				$_SESSION['id_pengawas'] = $user['id_pengawas'];
				$_SESSION['level'] = 'peng';

				// validasi session token
				$_SESSION['token'] = $ceks['db_token'];
				$_SESSION['token1'] = $ceks['db_token1'];
				$_SESSION['token_bot_telegram'] = $token_bot['botToken'];
				echo "<script>location.href = '.';</script>";
			}
		}
		elseif ($user['level'] == 'guru') {

			if ($password == $user['password']) {
				$_SESSION['id_pengawas'] = $user['id_pengawas'];
				$_SESSION['level'] = 'guru';
				$_SESSION['jrs'] = $user['id_jrs'];
				$_SESSION['kls'] = $user['id_kls'];
				$_SESSION['jabatan'] = $user['jabatan'];
				// validasi session token
				$_SESSION['token'] = $ceks['db_token'];
				$_SESSION['token1'] = $ceks['db_token1'];
				$_SESSION['token_bot_telegram'] = $token_bot['botToken'];

				echo "<script>location.href = '.';</script>";
			} else {
				$info = info("Password salah!", "NO");
			}
		}
	} elseif ($cek == 0 or $cekguru == 0) {
		echo "<script>alert('Pengguna tidak terdaftar');</script>";
	}
}

?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="<?php echo "$homeurl/$setting[logo]"; ?>" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link href="<?= $homeurl ?>/dist/css/style.css" rel="stylesheet">
    <title><?= $setting['sekolah'] ?> </title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
<form class="form-signin" action='' method='post' name="login" style="z-index: 2;">
        <img src="<?php echo "$homeurl/$setting[logo]"; ?>" style="max-height:50px" class="img-responsive" alt="Responsive image">
<?php if($setting['LoginSiswaMainten'] ==1){ ?>
							<center>
								<div class="alert alert-warning">
								  <strong>Mohon Maaf ! <br></strong> Akses input soal tutup.<br>
								  Soal sedang dalam proses pengecekan.
								</div>
							</center>
<?php }else{ ?>	
            <h1 class="h3 mb-3 font-weight-normal"><?= $setting['sekolah'] ?></h1>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password"
            required="">
            </div>
            <input type="hidden" name="mobile" value="<?= $_GET['mobile'] ?>">
            <button class="btn btn-lg btn-primary btn-block" button name='submit'>Login</button>
 <!-------------------------- -->
<!-- <?php if($setting['izin_jadwal'] ==0){ ?>-->
<!--<br><br>-->
<!-- <p><font color="red">Batas Waktu Input Soal: </font></p>-->
<!-- <p id="asja"></p>-->
<!--<script>-->
<!--var countDownDate = new Date("Oct 2, 2022 00:00:00").getTime();-->
<!--var x = setInterval(function() {-->
<!--  var now = new Date().getTime();-->
<!--  var distance = countDownDate - now;-->
<!--  var days = Math.floor(distance / (1000 * 60 * 60 * 24));-->
<!--  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));-->
<!--  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));-->
<!--  var seconds = Math.floor((distance % (1000 * 60)) / 1000);-->
<!--  document.getElementById("asja").innerHTML = days + "Hari   " + hours + "Jam   "-->
<!--  + minutes + "Menit   " + seconds + "Detik   ";-->
<!--  if (distance < 0) {-->
<!--    clearInterval(x);-->
<!--    document.getElementById("asja").innerHTML = "WAKTU UNTUK INPUT SOAL TELAH BERAKHIR";-->
<!--  }-->
<!--}, 1000);-->
<!--</script>-->
<!--<?php } ?>-->
 <!-------------------------- -->
              <?php } ?>
            </div>
          </form>
        </div>
      </div>

     <div class="panels-container">
        <div class="panel left-panel">
            <?php if($setting['LoginSiswaMainten'] ==1){ ?>
            <?php }else{ ?>
          <div class="content">
			<h3>SELAMAT DATANG</h3> 
          <br>
          <img src="icon/pict.png" style="max-width:550px"class="image" alt="" />
            <form class="form-signin" action="https://www.youtube.com/watch?v=xv2KipTa25s" target=_blank method="POST" name="login" style="z-index: 2;">
            <!--<p>
              Belum punya akun?
            </p> -->
            <br>
            <!-- <button class="btn transparent">
             <i class='fab fa-youtube'></i> TUTORIAL
            </button> -->
            <?php } ?>
            </form>
          </div>
    </div>
    <footer>
<!--Start of Tawk.to Script-->
<!--<?php if($setting['LoginSiswaMainten'] ==1){ ?>-->
<!--<?php }else{ ?>-->
<!--<script type="text/javascript">-->
<!--var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();-->
<!--(function(){-->
<!--var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];-->
<!--s1.async=true;-->
<!--s1.src='https://embed.tawk.to/5fa7fb450a68960861bcd2d6/1emk4csaa';-->
<!--s1.charset='UTF-8';-->
<!--s1.setAttribute('crossorigin','*');-->
<!--s0.parentNode.insertBefore(s1,s0);-->
<!--})();-->
<!--</script>-->
<!--<?php } ?>-->
<!--End of Tawk.to Script-->
    </footer>
  </body>
</html>
