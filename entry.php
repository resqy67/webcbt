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
  <title><?= $setting['aplikasi'] ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="<?php echo $setting['logo'] ?>" rel="shortcut icon" />
	<link rel="stylesheet" href="vendors/bootstrap-4/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendors/fontawesome/css/all.css">
	 <link rel='stylesheet' href='plugins/sweetalert2/dist/sweetalert2.min.css'>
	<script src="vendors/jquery/jquery.min.js"></script>
	<script src="vendors/bootstrap-4/js/popper.min.js"></script>
	<script src="vendors/bootstrap-4/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid text-white" style="background:#326698;background-size: contain;background-image: url('dist/img/bg-header.png');background-repeat: no-repeat;background-position: left; height:150px;position:fixed;top:0px;left:0px;right:0px">
	  <?php if($setting['LoginSiswaMainten'] ==1){ ?>
		<center>
<span style="font-size: 20px;"><b><font color='red'>KAMI SEGERA KEMBALI</font></b></span>
<div class="alert alert-warning">
	<strong>Mohon Maaf ! <br></strong> Sistem Sedang Maintenance.<br>
	Silahkan Kembali Beberapa Saat Lagi.
</div>
<a href="info.php" class="btn btn-sm btn-info">Informasi </a>
<?php }else{ ?>
	  <div class="row">
		<div class="col pl-5 pt-1">
		    <center>
			<table>
				<tr>
					<td>
						<img style="margin:5px;height:70px" src="dist/img/logo2.png">
					</td>
					<td>
						<div><b><?php echo $setting['sekolah'] ?> </b></div>
						<div><small>ASESMEN BERBASIS KOMPUTER<small></div>
					</td>
				</tr>
			</table>
			</center>
		</div>
	  </div>
</div>

<div class="wrapper fadeInDown"  style="margin-top:100px;">
  <div id="formContent">
    <div class="fadeIn text-left p-5">
      <div><b>Selamat Datang</b></div>
      <div><small><font color ="green" >Silakan login </font> | <font color ="red">Jangan lupa berdoa sebelum memulai</font></small></div>
	 <form id="formlogin" action="ceklogin.php" class="text-center" onsubmit="return validateForm()">
		  <div class="input-group mt-4 mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text" style="border:0px;background:#fff"><i class="fa fa-user-circle"></i></span>
			</div>
			<input type="text" class="form-control" placeholder="Username" name="username" id="username" autocomplete="off" autocorrect="new-password" autocapitalize="none" spellcheck="false">
		  </div>
		  <div class="input-group mt-3 mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text" style="border:0px;background:#fff"><i class="fa fa-lock"></i></span>
			</div>
			<input type="password" class="form-control" placeholder="Password" name="password" id="password"  autocomplete="off" autocorrect="new-password" autocapitalize="none" spellcheck="false">
			<div class="input-group-prepend">
			  <span class="input-group-text" style="border:0px;background:#fff;padding-right:0px;padding-left:0px" onCLick="showPassword()" id="btn-eye"><i class="fa fa-eye"></i></span>
			</div>
		  </div>
		  <button type="submit" class="btn btn-primary btn-round form-control" id="submit" style="border-radius:20px" >Login</button>
		</form> 
  </div> 
</div>
 </div>
<?php } ?>


</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function validateForm() {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();
        
        if (username === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Username wajib diisi.'
            });
            return false;
        }

        if (password === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Password wajib diisi.'
            });
            return false;
        }

        return true;
    }
</script>
<script type="text/javascript" src="vendors/assets/js/jquery.min.js"></script>
<style>
	/* STRUCTURE */
	.loader {
	  margin: 0;
	  position: absolute;
	  top: 50%;
	  left: 50%;
	  -ms-transform: translate(-50%, -50%);
	  transform: translate(-50%, -50%);
	}

	.wrapper {
	  display: flex;
	  align-items: center;
	  flex-direction: column; 
	  justify-content: center;
	  width: 100%;
	  min-height: 100%;
	  padding: 20px;
	  margin-top:-80px;
	}

	#formContent {
	  -webkit-border-radius: 10px 10px 10px 10px;
	  border-radius: 10px 10px 10px 10px;
	  background: #fff;
	  padding: 30px;
	  width: 90%;
	  max-width: 450px;
	  position: relative;
	  padding: 0px;
	  -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
	  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
	  text-align: center;
	}

	


	/* TABS */

	h2.inactive {
	  color: #cccccc;
	}

	h2.active {
	  color: #0d0d0d;
	  border-bottom: 2px solid #5fbae9;
	}
	
	input[type=text] {
	  border: none;
	  color: #0d0d0d;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 16px;
	  border-radius:0px;
	  border-bottom:2px solid #eee;
	}
	input[type=password] {
	  border: none;
	  color: #0d0d0d;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 16px;
	  border-radius:0px;
	  border-bottom:2px solid #eee;
	}

	/* ANIMATIONS */

	/* Simple CSS3 Fade-in-down Animation */
	.fadeInDown {
	  -webkit-animation-name: fadeInDown;
	  animation-name: fadeInDown;
	  -webkit-animation-duration: 1s;
	  animation-duration: 1s;
	  -webkit-animation-fill-mode: both;
	  animation-fill-mode: both;
	}

	@-webkit-keyframes fadeInDown {
	  0% {
		opacity: 0;
		-webkit-transform: translate3d(0, -100%, 0);
		transform: translate3d(0, -100%, 0);
	  }
	  100% {
		opacity: 1;
		-webkit-transform: none;
		transform: none;
	  }
	}

	@keyframes fadeInDown {
	  0% {
		opacity: 0;
		-webkit-transform: translate3d(0, -100%, 0);
		transform: translate3d(0, -100%, 0);
	  }
	  100% {
		opacity: 1;
		-webkit-transform: none;
		transform: none;
	  }
	}

	/* Simple CSS3 Fade-in Animation */
	@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
	@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
	@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

	.fadeIn {
	  opacity:0;
	  -webkit-animation:fadeIn ease-in 1;
	  -moz-animation:fadeIn ease-in 1;
	  animation:fadeIn ease-in 1;

	  -webkit-animation-fill-mode:forwards;
	  -moz-animation-fill-mode:forwards;
	  animation-fill-mode:forwards;

	  -webkit-animation-duration:1s;
	  -moz-animation-duration:1s;
	  animation-duration:1s;
	}

	.fadeIn.first {
	  -webkit-animation-delay: 0.4s;
	  -moz-animation-delay: 0.4s;
	  animation-delay: 0.4s;
	}

	.fadeIn.second {
	  -webkit-animation-delay: 0.6s;
	  -moz-animation-delay: 0.6s;
	  animation-delay: 0.6s;
	}

	.fadeIn.third {
	  -webkit-animation-delay: 0.8s;
	  -moz-animation-delay: 0.8s;
	  animation-delay: 0.8s;
	}

	.fadeIn.fourth {
	  -webkit-animation-delay: 1s;
	  -moz-animation-delay: 1s;
	  animation-delay: 1s;
	}

	/* Simple CSS3 Fade-in Animation */
	.underlineHover:after {
	  display: block;
	  left: 0;
	  bottom: -10px;
	  width: 0;
	  height: 2px;
	  background-color: #56baed;
	  content: "";
	  transition: width 0.2s;
	}

	.underlineHover:hover {
	  color: #0d0d0d;
	}

	.underlineHover:hover:after{
	  width: 100%;
	}
</style>
<script src='plugins/sweetalert2/dist/sweetalert2.min.js'></script>
<script src="dist/vendors/jquery/jquery-3.2.1.min.js"></script>

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
								position: 'top',
								type: 'warning',
								title: 'Password Salah',
								showConfirmButton: false,
								timer: 1500
							});
						}
						if (data == "td") {
							swal({
								position: 'top',
								type: 'warning',
								title: 'Siswa tidak terdaftar',
								showConfirmButton: false,
								timer: 1500
							});
						}
						if (data == "nologin") {
							swal({
								position: 'top',
								type: 'warning',
								title: 'Siswa sudah aktif',
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
<script>
	function showPassword() {
		var type = $('#password').attr('type');
		if (type ==='password') {
			$('#btn-eye').css('color','#00ff00');
			$('#password').attr('type','text');
		}
		else {
			$('#btn-eye').css('color','#636e72');
			$('#password').attr('type','password');
		}
	}
</script>
  

</body>
</html>
