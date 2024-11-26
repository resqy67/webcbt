    <style type="text/css">
      .clear {
    clear:both;    
}
.btn-info {
    margin-right:15px;
    text-transform:uppercase;
    padding:10px;
    display:block;
    float:left;
}
.btn-info a {
    display:block;
    text-decoration:none;
    width:100%;
    height:100%;
    color:#fff;
}
.more.label {
    float:right;    
}
    </style>
<?php
if($_GET['pg']==''){ ?>
<div class='row'>
  <div class="col-md-12"> 
  <div class="alert" style="background: linear-gradient(to bottom, #999966 8%, #cc9900 56%); color:white;">Klik nama Mapel untuk masuk ke materi <b>&</b> Jangan lupa berikan rating untuk guru</div>
    <div class='box box-solid'>
      <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
          Silahkan Piih Mata Pelajaran 
        </a>
   
      
	  
	  <!-- <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
          Silahkan Piih Mata Pelajaran 
        </a>
        <?php
        $guru_materi = $dbb->guru_materi($level);
        $no=1;
        foreach ($guru_materi as $value) { 
		      $datakelas = unserialize($value['kelas']);
		      if (in_array($_SESSION['id_kelas'], $datakelas) or in_array('semua', $datakelas)){
		      	$a = $dbb->get_materi2($value['id_guru'],$level,$value['idmapel2']);
		      	//$idguruu = enkripsi($value['id_guru']);
            $level2 = enkripsi($value['kodelevel']);
            $idmapel = enkripsi($value['idmapel2']);
		      ?>
		      <a href="?pg=guru&level=<?= $level2; ?>&idmapel=<?= $idmapel; ?>&page=1" class="list-group-item list-group-item-action"><?= $value['nama_mapel']; ?> <?= $value['kodelevel']; ?><span class="badge " style="background-color:#3c8dbc">
          <?php echo $a['jml'] ?> Materi
        	</span></a>
		      <?php 
		    	}
		      else{ ?>
		      	
		      <?php }
        
          }?>
        </div>-->
	  <?php
	 $rand_color = $dbb->randomHex($color);
	
        $guru_materi = $dbb->guru_materi($level);
        $no=1;
        foreach ($guru_materi as $value) { 
		      $datakelas = unserialize($value['kelas']);
		      if (in_array($_SESSION['id_kelas'], $datakelas) or in_array('semua', $datakelas)){
		      	$a = $dbb->get_materi2($value['id_guru'],$level,$value['idmapel2']);
		      	$idguruu = enkripsi($value['id_guru']);
            $level2 = enkripsi($value['kodelevel']);
            $idmapel = enkripsi($value['idmapel2']);
			 $sesi= $dbb->v_siswa();
			$idsesi = $siswa['id_siswa'];
			$os=mysqli_query($koneksi,"SELECT * FROM rating WHERE id_guru='$value[id_guru]' ");
			$oss=mysqli_fetch_array($os);
			$ozz=mysqli_num_rows($os);
			$jml=mysqli_query($koneksi,"SELECT SUM(nilai) AS jumlah FROM rating WHERE id_guru='$value[id_guru]'");
			$jl=mysqli_fetch_array($jml);
			$jh=$jl['jumlah'];
			$jt=FLOOR($jh/$ozz);
			
			?>
		    <!--  <div class="col-md-4" style="padding:1px">
            <!-- Widget: user widget style 2 -->
            <!-- <div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-warning" style="background-color:<?php echo '#32a852';?>">
                <div class="widget-user-image">
				<!--<?php if ($value['foto_pengawas'] <> '') {
				echo "<img class='img-circle elevation-2' src='$homeurl/guru/fotoguru/$value[id_guru]/$value[foto_pengawas]' alt='Foto'>";
				} else { 
				echo "<img class='img-circle elevation-2' src='$homeurl/dist/img/avatar-6.png' alt='Foto'>";
				} ?> -->
                <!--</div> 
                <!-- /.widget-user-image -->
                <!-- <h5 class="widget-user-username" style="color:gold; -webkit-text-fill-color: black; -webkit-text-stroke: 1px white; font-size:18px;">Guru Mapel: <?= $value['nama']; ?></h5>
                <!-- <?php if ($value['jabatan'] <> '') {?>
				<h5 class="widget-user-desc" style="color:gold;"><?= $value['jabatan']; ?>&nbsp;
				<?php if ($jt > 0 && $jt <= 10) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt > 10 && $jt <= 20) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt > 20 && $jt <= 30) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt > 30 && $jt <= 49) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt >= 50 && $jt <= 74) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt >= 75 && $jt <= 89) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt >= 90 && $jt <= 100) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }else{ ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php } ?>
				</h5> -->
				<!--<h5 class="widget-user-desc" style="color:gold;">ada <?= $jt ?></h5>-->
				<?php }else{ ?>
				<h5 class="widget-user-desc" style="color:gold;"><?= $value['level']; ?>&nbsp;
				<?php if ($jt > 0 && $jt <= 10) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt > 10 && $jt <= 20) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt > 20 && $jt <= 30) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt > 30 && $jt <= 49) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt >= 50 && $jt <= 74) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt >= 75 && $jt <= 89) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }elseif ($jt >= 90 && $jt <= 100) { ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php }else{ ?>
				<?php echo "<img src='$homeurl/guru/rating/1.png' style='width:20px;height:19px'>"; ?>
				<?php } ?>
				</h5>
				<!--<h5 class="widget-user-desc" style="color:gold;">ada <?= $jt ?></h5>-->
				<?php } ?>
              </div>
              <div class="card-footer p-0">
                <ul class="nav ">
                  <li class="nav-item">
                    <a href="?pg=guru&level=<?= $level2; ?>&idmapel=<?= $idmapel; ?>&id=<?=$idguruu; ?>&page=1" class="list-group-item list-group-item-action" >
                      <?= $value['nama_mapel']; ?> - <?= $value['nama']; ?> <span class="float-right badge bg-success" style="background-color:#3c8dbc"><?php echo $a['jml'] ?> Baca Materi</span>
                    </a>
                  </li>
                  
                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
		      <?php 
		    	}
		      else{ ?>
		      	
		      <?php }
        
          }?>
	 
        </div>
      </div>
        </div> 
    </div>
  </div>
</div>
<!--end row-->


<?php
}
elseif ($_GET['pg']=='guru') { ?>
<div class='row'>
  <div class="col-md-12"> 
    <?php
    $getguru =$_GET['id'];
    $getlevel =$_GET['level'];
    $getidmapel =$_GET['idmapel'];

    $guru = dekripsi($getguru);
    $level3 = dekripsi($getlevel);
    $idmapel3 = dekripsi($getidmapel); //Kode Mapel
    
    $halaman = $dbb->halaman(); //2
    $mulai= $dbb->mulai($halaman); //0
    $artikel = $dbb->get_materi($mulai,$halaman,$_SESSION['id_kelas'],$guru, $level3,$idmapel3);
	$ggr=$dbb->ratguru();
	$cekrat=$dbb->cekratguru();
	$erating=$dbb->editrating();
    ?>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit"></i>Materi &nbsp; <a class="btn btn-danger" style="border-radius: 15px;" href="<?= $homeurl ?>/materi/"><i class="fas fa-arrow-left"></i> Kembali Pilih Mapel </a> 
        </h3>
		<?php if ( $cekrat > 0) { ?>
		<h3 class='box-title pull-right'><a data-hari="<?= $vl['hari'] ?>"
                  data-performag="<?= $erating['nilai'] ?>"
                  data-toggle="modal" data-target="#myModal" data-id="<?= $erating['id_rating'] ?>" type="button" class="btn btn-primary editrating" style="border-radius: 15px;"><i class="fas fa-eye"></i> Update Rating </a> 
        </h3>
		<?php }else{?>
		<h3 class='box-title pull-right'><a id="btn_tambah" type="button" class="btn btn-primary" style="border-radius: 15px;"><i class="fas fa-plus"></i> Rating Guru </a> 
        </h3>
		<?php }?>
      </div>
	  <!--halaman btn_tambah-->
	<div id="form_materi" class="row justify-content-center" style="display: none;">
          <div class="col-md-12">
            <form id="formtugas">
			</br></br>
			 <h4 class="modal-title" style="text-align: center">Berikan ulasan untuk Bpk/Ibu: <?=$ggr['nama']?></h4>
              <div class="modal-body">
			   <div class='form-group'>
			    <input id="idguru" type='hidden' name='idguru' value="<?= $ggr['id_guru']?>" class='form-control' required='true' />
                    <label>Performa Guru</label>
                    <div class="form-group">
                      <select id="performaa" name="performaa" class="form-control" required>
                        <option>Pilih Performa</option>
                        <option value="10">Sangat Negatif</option>
                        <option value="25">Negatif</option>
                        <option value="35">Kurang Di Pahami</option>
                        <option value="50">Baik</option>
                        <option value="75">Sangat Baik</option>
                        <option value="100">Istimewa</option>
                      </select>
                    </div>
                  </div>
				<div class="form-group">
				  <label>Alasan</label>
                    <input type='text' id='alasann' name='alasann'  class='form-control'  autocomplete='off' required='true' />
                  </div>
                
                 
                  
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="klose">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
		<!-- end btn_tambah-->
		<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Performa Guru Dalam Belajar Mengajar</h4>
      </div>
      <div class="modal-body">
	  
 <form id="formtugas2">
		 <div class='form-group'>
		 <input id="id" type='hidden' name='id' class='form-control' required='true' />
                    <label>Performa Guru</label>
                    <div class="form-group">
                      <select id="performag" name="performag" class="form-control" required>
                        <option>Pilih Performa</option>
                        <option value="10">Sangat Negatif</option>
                        <option value="25">Negatif</option>
                        <option value="35">Kurang Dipahami</option>
                        <option value="50">Baik</option>
                        <option value="75">Sangat Baik</option>
                        <option value="100">Istimewa</option>
                      </select>
                    </div>
                  </div>
		 <div class="form-group">
				  <label>Alasan</label>
                    <input type='text' id='alasang' name='alasang' value="<?=$erating['alasan'] ?>" class='form-control'  autocomplete='off' required='true' />
                  </div>
		
		<div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Update</button>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
		</form>
			</div>
		</div>
	</div>
</div>
      <div class='box-body' id="okk" style="">
        <?php
        //$no=$mulai+1;
        foreach ($artikel as $value) {
          $idguruu = enkripsi($value['id_guru']);
          $idmaterii = enkripsi($value['materi2_id']);
          $materi2_mapel = enkripsi($value['materi2_mapel']);
          $kodelv = enkripsi($value['kodelv']);
        ?>
        <div class="span8" style="background-color:#f2f0f0">
          <h3 style="color:brown"><?= $value['materi2_judul']; ?></h3>
          <p><span class="badge">MAPEL : <?= $value['nama_mapel']; ?></span></p>
          <div>
            <!-- <div class="more label"><a href="<?= $homeurl ?>/materi/?pg=baca&idmateri=<?= $value['materi2_id']?>">Read more</a></div>  -->
            <div class="tags">
              <?php if($value['materi2_file']==null or $value['materi2_file']==""){ }else{?>
                <span  class="btn-info" style="border-radius: 15px 50px 30px;"><a href="<?= $homeurl ?>/guru/berkas2/<?= $value['id_guru'] ?>/<?= $value['materi2_file'] ?>" download >Unduh File</a></span>
                <?php }?>
                <span class="btn-info" style="border-radius: 15px 50px 30px;"><a href="<?= $homeurl ?>/materi/?pg=baca&id=<?= $idguruu; ?>&idmateri=<?= $idmaterii?>"><i class="fa fa-book"></i> Baca Materi</a></span>
                <span style="background-color: #000080;" class="btn-info"><a class="viewer" data-id="<?= $value['materi2_id']; ?>" data-jenis="3" href="<?= $homeurl ?>/materi/?pg=video&id=<?= $idguruu; ?>&idvideo=<?= $idmaterii?>"><i class="fa fa-play"></i> Video</a></span>
            </div>    
          </div> 
        <div class="clear"></div>
        <hr/>
        
        </div>
        <?php }?>
		
      </div>
        <div class="text-center">
         <ul class="pagination">
          <?php 
          $pangging = $dbb->paging($halaman, dekripsi($materi2_mapel),dekripsi($kodelv));
          for ($i=1; $i<=$pangging ; $i++){ 
            if($_GET["page"] == $i){ $aktif = 'class="active"';}else{ $aktif =''; }
          ?>
            <li <?= $aktif; ?>><a  href="?pg=guru&idmapel=<?= $materi2_mapel ?>&level=<?= $kodelv ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
          <?php } ?>
         </ul>
        </div>
    </div>
	
  </div>
</div>

<?php
}
elseif($_GET['pg']=='baca'){ ?>
<div class='row'>
  <div class='col-md-12' >
    <div class='box box-solid' id="box-baca">
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit "></i> Membaca Materi</h3>
      </div>
      <div class='box-body' >
        <div class="row"> 
          <div class="col-md-4">
            <!-- <a href="<?= $homeurl ?>/materi/" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a> -->
            <a class="btn btn-default" href = "javascript:history.back()"><i class="fas fa-arrow-left"></i> Kembali Pilih Materi</a>
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
          </div>
        </div>
        <div class="row" style="padding-right: 0px; padding-left: 0px;"> 
          <div class="col-md-12" >
          <?php

            $da2=$dbb->baca_materi();
             foreach ($da2 as $value) { ?>
              <h2 style="color: #3c8dbc;" ><?= $value['materi2_judul']; ?></h2>
              <hr>
              <p class="text-justify" >
                <?= $value['materi2_isi']; ?>
              </p>
              <hr>
              <br>
              <blockquote class="blockquote">
                <p class="mb-0"><?= $value['nama_mapel']; ?> </p>
                <footer class="blockquote-footer"><?= $value['materi2_tgl']; ?>
                <cite title="Source Title">&nbsp;&nbsp;<?= $value['nama']; ?></cite></footer>
              </blockquote>
            <?php  } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <a class="btn btn-success" href = "javascript:history.back()"><i class="fas fa-arrow-left"></i> Kembali Pilih Materi</a>
            <!-- <?php 
            $next = $_GET['idmateri']+1;
            $prev = $_GET['idmateri']-1;
            $next2=$dbb->next_materi();
            $prev2=$dbb->prev_materi();
            ?>
            <?php if($_GET['idmateri'] == $prev2['min']){ }else{ ?>
            <a href="<?= $homeurl ?>/materi/?pg=baca&idmateri=<?= $prev ?>" class="btn btn-primary pull-left"><i class="fas fa-arrow-left"></i> Previous </a>
            <?php } ?>
            <?php if($_GET['idmateri'] == $next2['max']){ }else{ ?>
            <a href="<?= $homeurl ?>/materi/?pg=baca&idmateri=<?= $next ?>" class="btn btn-primary pull-right"> NEXT <i class="fas fa-arrow-right"></i></a>
            <?php }  ?> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    function switchTheme(e) {
      if (e.target.checked) {
        localStorage.setItem('theme',1); 
        $("#box-baca").css("background-color","rgb(53, 54, 58)");
        $("#box-baca").css("color","rgb(232, 234, 237)");
      }
      else {
        localStorage.setItem('theme',0); 
        $("#box-baca").css("background-color","#ffffff");
        $("#box-baca").css("color","black");
      }    
    }
    toggleSwitch.addEventListener('change', switchTheme, false);

    var get_thema = localStorage.getItem('theme');
    if (get_thema==1) {
      toggleSwitch.checked = true;
      $("#box-baca").css("background-color","rgb(53, 54, 58)");
      $("#box-baca").css("color","rgb(232, 234, 237)");

    }
    else {
      $("#box-baca").css("background-color","#ffffff");
      $("#box-baca").css("color","black");
      toggleSwitch.checked = false;
    }
  });
  
</script>
<?php }
elseif($_GET['pg']=='video'){ ?>
<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit"></i> Video Materi</h3>
      </div>
      <div class='box-body'>
        <div class="row" style="padding-bottom: 20px;"> 
          <div class="col-md-4">
            <a href="<?= $homeurl ?>/materi/" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <?php $getguru =$_GET['id']; 
            $da3=$dbb->video_materi($getguru);
           if ($da3['url_youtube'] !=null or $da3['url_youtube'] !="") { ?>
           <a class="btn btn-primary" target="_blank" href="<?= $da3[url_youtube] ?>" >Klik Link Video Materi</a>
           <br>
           <?php }
            if ($da3['url_gdrive'] !=null or $da3['url_gdrive'] !="") { ?>
            <a class="btn btn-success" target="_blank" href="<?= $da3[url_gdrive] ?>" >Klik Link Google Drive Materi</a>
            <br>
            <?php  } 
            if($da3['url_embed'] !=null or $da3['url_embed'] !=""){
            ?>
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $da3[url_embed] ?>?rel=0" allowfullscreen></iframe>
            </div>
           <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
}
else{

}
?>
<script type="text/javascript">
  $(document).ready( function () {
    $('#tb_materi').DataTable({
      "pageLength": 25
    });
} );
$(document).on('click', '#btn_tambah', function() {
      $('#form_materi').slideDown(1000);
      $('#form_materi').removeAttr("style");
      $("#okk").css("display","none");
      $("#btn_tambah").css("display","none");
      $('#btn_tambah2').removeAttr("style");
    });	
 $(document).on('click', '#klose', function() {
      $('#form_materi').css("display","none");
      $("#okk").removeAttr("style");
      $("#btn_tambah2").css("display","none");
      $('#btn_tambah').removeAttr("style");
    });
<?php //simpan rating ?>
    $('#formtugas').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var pesan ="rating";
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: '../_rating.php',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Tambah rating');
              setTimeout(function () { location.reload(1); }, 2000);
            }
            else if(respon==99){
              toastr.warning('Anda Sudah Menilai Guru Ini Sebelumnya');
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
        return false;
      });
	  
$(document).ready(function(){
    $('.editrating').click(function() {
      var id = $(this).data('id');
      var performag = $(this).data('performag');

      $('#id').val(id);
      $('#performag').val(performag).change();
    });
	});


<?php //update rating ?>
    $('#formtugas2').submit(function(e) {
      e.preventDefault();
      var data = new FormData(this);
      var pesan ="rating";
        //console.log(data);
        $.ajax({
          type: 'POST',
          url: '../_updaterating.php',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(respon) {
            console.log(respon);
            if(respon==1){
              toastr.success('Berhasil Update rating');
              setTimeout(function () { location.reload(1); }, 2000);
            }
            else if(respon==99){
              toastr.warning('oooo');
            }
            else{
              toastr.error('Upss Gagal');
            }
          }
        });
        return false;
      });
</script>