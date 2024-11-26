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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="favicon.ico" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <title>PJJ | <?= $setting['sekolah'] ?></title>
    <!-- Vendor -->
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet" />
    <link href="assets/modules/home/Chart.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">
    <link href="assets/modules/home/front.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?= $setting['logo'] ?>" />
    <link rel="stylesheet" href="assets/css/1.css">
    <link rel="stylesheet" href="assets/css/2.css">
    <link rel="stylesheet" href="assets/css/3.css">
    <link rel="stylesheet" href="assets/css/components2.css">
    <link rel="stylesheet" href="assets/modules/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <!--WAKTU JALAN-->
    <link rel="stylesheet" type="text/css" href="assets/front/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/front/vendor/countdowntime/flipclock.css">
    <link rel="stylesheet" type="text/css" href="assets/front/css/main.css">
    <!--===============================================================================================-->
</head>

<body data-spy="scroll" data-target="#menu" data-offset="100">
    <div class="home-wrapper" id="home">
        <div class="home-header">
            <div class="container p-0">
                <nav class="navbar navbar-expand-lg navbar-light" id="navbar-header">
                    <a class="navbar-brand" href="javascript:;">
                        <img src="<?php echo "$homeurl/$setting[logo]"; ?>" style="max-height:50px" class="img-responsive" alt="Responsive image" height="75" />
                        <div class="home-header-text d-none d-sm-block">
                            <h4>e-Learning</h4>
                            <h5><?= $setting['sekolah'] ?></h5>
                            <h6>Tahun 2021</h6>
                        </div>
                    </a>
                    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="smkh.sch.id" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="https://smkh.sch.id" terget="_blank">Home</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="home-banner">
            <div class="home-banner-bg home-banner-bg-color"></div>
            <div class="home-banner-bg home-banner-bg-img"></div>
            <div class="container mt-5">
                <div class="row">

                    <div class="col-sm-8">
                        <div id="carousel" class="carousel slide" data-ride="carousel">
                            
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div>
                                        <h5 data-animation="animated fadeInDownBig">
                                            Selamat Datang di e-Learning <?= $setting['sekolah'] ?>
                                        </h5>
                                   
                                        <p data-animation="animated slideInRight" data-delay="1s">
                                            Aplikasi Pembelajaran Siswa <?= $setting['sekolah'] ?> Tahun <?= date('Y') ?>
                                        </p>
                                        <p data-animation="animated slideInRight" data-delay="2s">
                                            Silakan Login untuk menyampaikan materi dan tugas
                                        </p>
                                        <p data-animation="animated flipInX" data-delay="3s">
                                            <a href="https://www.youtube.com/watch?v=MSL7rkrW5FY" target="_blank" class="btn btn-warning nav-link">
                                                TUTORIALNYA DI SINI
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card card-login">
                            <div class="card-body">
                               <h6 style="text-align:center ">LOGIN</h6>
                                <form class="form-signin" action='' method='post' name="login" style="z-index: 2;">
                                    <div class="form-group">
                                        <span class="fa fa-user"></span>
                                        <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <span class="fa fa-key"></span>
                                        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
                                    </div>
                                    <button class="btn btn-primary btn-block" button name='submit'>Masuk</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
<script type="text/javascript">
    $('.loader').fadeOut('slow');
    $(document).ready(function() {
        $('.klikmenu').click(function() {
            var menu = $(this).data('id');
            if (menu == "beranda") {
                $('#btnsiswa').show();
                $('#isi_load').load('home.php');
            } else if (menu == "login") {
                $('#isi_load').load('login.php');
            }
        });
        // halaman yang di load default pertama kali
        $('#isi_load').load('home.php');
    });
</script>
<script>
    $('#form-login').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'crud_web.php?pg=login',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#btnsimpan').prop('disabled', true);
            },
            success: function(data) {
                var json = $.parseJSON(data);
                $('#btnsimpan').prop('disabled', false);
                if (json.pesan == 'ok') {
                    iziToast.success({
                        title: 'Mantap!',
                        message: 'Login Berhasil',
                        position: 'topRight'
                    });
                    setTimeout(function() {
                        window.location.href = "user";
                    }, 2000);

                } else {
                    iziToast.error({
                        title: 'Maaf!',
                        message: json.pesan,
                        position: 'topCenter'
                    });
                }
                //$('#bodyreset').load(location.href + ' #bodyreset');
            }
        });
        return false;
    });
    if (jQuery().daterangepicker) {
        if ($(".datepicker").length) {
            $('.datepicker').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                singleDatePicker: true,
            });
        }
        if ($(".datetimepicker").length) {
            $('.datetimepicker').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD hh:mm'
                },
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
            });
        }
        if ($(".daterange").length) {
            $('.daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                drops: 'down',
                opens: 'right'
            });
        }
    }
    if (jQuery().select2) {
        $(".select2").select2();
    }
</script>
<script>
    $('#form-siswa').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'crud_web.php?pg=simpan',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#btnsimpan').prop('disabled', true);
            },
            success: function(data) {
                var json = $.parseJSON(data);
                $('#btnsimpan').prop('disabled', false);
                if (json.pesan == 'ok') {
                    iziToast.success({
                        title: 'Mantap!',
                        message: 'Data berhasil disimpan',
                        position: 'topRight'
                    });
                    setTimeout(function() {
                        $('#home').load('konfirmasi.php?id=' + json.id + '&nisn=' + json.nisn + '&pass=' + json.pass + '&nama=' + json.nama);
                    }, 2000);

                } else {
                    iziToast.error({
                        title: 'Maaf!',
                        message: json.pesan,
                        position: 'topCenter'
                    });
                    document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random();

                }
                //$('#bodyreset').load(location.href + ' #bodyreset');
            }
        });
        return false;
    });
    if (jQuery().daterangepicker) {
        if ($(".datepicker").length) {
            $('.datepicker').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                singleDatePicker: true,
            });
        }
        if ($(".datetimepicker").length) {
            $('.datetimepicker').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD hh:mm'
                },
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
            });
        }
        if ($(".daterange").length) {
            $('.daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                drops: 'down',
                opens: 'right'
            });
        }
    }
    if (jQuery().select2) {
        $(".select2").select2();
    }
</script>
<script>
    $('#form-siswa2').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'crud_web.php?pg=simpan2',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#btnsimpan').prop('disabled', true);
            },
            success: function(data) {
                var json = $.parseJSON(data);
                $('#btnsimpan').prop('disabled', false);
                if (json.pesan == 'ok') {
                    iziToast.success({
                        title: 'Mantap!',
                        message: 'Data berhasil disimpan',
                        position: 'topRight'
                    });
                    setTimeout(function() {
                        $('#home').load('konfirmasi.php?id=' + json.id + '&nisn=' + json.nisn + '&pass=' + json.pass + '&nama=' + json.nama);
                    }, 2000);

                } else {
                    iziToast.error({
                        title: 'Maaf!',
                        message: json.pesan,
                        position: 'topCenter'
                    });
                    document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random();

                }
                //$('#bodyreset').load(location.href + ' #bodyreset');
            }
        });
        return false;
    });
    if (jQuery().daterangepicker) {
        if ($(".datepicker").length) {
            $('.datepicker').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                singleDatePicker: true,
            });
        }
        if ($(".datetimepicker").length) {
            $('.datetimepicker').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD hh:mm'
                },
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
            });
        }
        if ($(".daterange").length) {
            $('.daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                drops: 'down',
                opens: 'right'
            });
        }
    }
    if (jQuery().select2) {
        $(".select2").select2();
    }
</script>
<!--WAKTU JALAN-->
<script src="assets/front/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="assets/front/vendor/bootstrap/js/popper.js"></script>
<script src="assets/front/vendor/countdowntime/flipclock.min.js"></script>
<script src="assets/front/vendor/countdowntime/moment.min.js"></script>
<script src="assets/front/vendor/countdowntime/moment-timezone.min.js"></script>
<script src="assets/front/vendor/countdowntime/moment-timezone-with-data.min.js"></script>
<script src="assets/front/vendor/countdowntime/countdowntime.js"></script>

<script>
    $('.cd100').countdown100({
        /*Set Endtime here*/
        /*Endtime must be > current time*/
        endtimeMonth: <?= $diff->m ?>,
        endtimeDate: <?= $diff->d ?>,
        endtimeHours: <?= $diff->h ?>,
        endtimeMinutes: <?= $diff->i ?>,
        endtimeSeconds: <?= $diff->s ?>,
        timeZone: ""
        // ex:  timeZone: "America/New_York"
        //go to " http://momentjs.com/timezone/ " to get timezone
    });
</script>