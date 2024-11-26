<?php
//require("../config/m_admin.php");

require "../../config/config.function.php";
include '../../config/m_admin.php';
$db= new Budut(); // panggil model 

	function tbAbsensi(){ return 'absensi'; }

if($token == $token1)
{
	if(isset($_GET['adm'])){
//&1.tombol selesai -------------------------------------
	   if($_GET['adm']=="tombol_selesai"){
			$cek = $db->tombol_selesai_paksa();
			echo $cek;
		}
		elseif($_GET['adm']=="kunci_tombol_selesai"){
			$cek = $db->kunci_tombol_selesai_paksa();
			echo $cek;
		}
		elseif($_GET['adm']=="cek_siswa"){
			$kls = $_POST['kelas'];
			$ujian = $_POST['ujian'];
			$jrs = $_POST['jrs'];
			$cek = $db->siswa_tidak_ujian($kls,$jrs,$ujian);
			echo $cek;
		}
		else{
			echo 100;
		}

	} //END isset($_GET['adm'])
	if(isset($_GET['esai'])){
//&2. Nilai Essai-------------------------------------
		if($_GET['esai']=="oke"){
			
			$id_nilai =$_POST['id_nilai'];
			$id_ujian =$_POST['id_ujian'];
			$id_mapel =$_POST['id_mapel'];
			$id_siswa =$_POST['id_siswa'];
			$bobot =$_POST['bobot'];

			if(isset($_POST)){
				$id = $_POST;
				//hapus array yang bukan nilia dari soal esai
				unset($id['bobot']);
				unset($id['id_ujian']);
				unset($id['id_mapel']);
				unset($id['id_nilai']);
				unset($id['id_siswa']);

				$esai_total=0;
				foreach ($id as $key => $value) {
					$esai_total += $value;
				}
				$nilai_essai = serialize($id);

			}

			$total = ($esai_total*$bobot)/100;
			
			
			$data_nilai = array(
				'nilai_esai2' => $nilai_essai,
				'nilai_esai' => $total
			);
			$where = array(
				'id_nilai' =>$id_nilai,
				'id_ujian' =>$id_ujian,
				'id_mapel' =>$id_mapel,
				'id_siswa' =>$id_siswa
			);
			
			$tabel='nilai_pindah';

			$exc = $db->update($tabel,$data_nilai,$where);
			if($exc == 1){
				echo $exc;
			}
			else{
				echo $exc;
			}
			
			//print_r($data_nilai);
		}
	}
//&3.Materi -----------
	if(isset($_GET['nilai'])){
		if($_GET['nilai']=='remidi'){
			$id = $_POST;
			
			$where = array(
				// 'id_siswa' => $id['id_siswa'],
				// 'id_mapel' => $id['id_mapel']
				'id_nilai' => $id['id_nilai']
			);
			
			$total = ($id['pg'] + $id['esai'] );
			
			$data= array(
				'jml_benar' => $id['jml_bener'],
				'jml_salah' => $id['jml_salah'],
				'skor' => $id['pg'],
				'nilai_esai' => $id['esai'],
				'total' => $total
			);
			
			$tabel ='nilai_pindah';
			
			
			$exc = $db->update($tabel,$data,$where);
			if($exc == 1){
				echo $exc;
			}
			else{
				echo $exc;
			}
		}
		//update nilai 0
		if($_GET['nilai']=='nilai_update'){
			$id = $_POST;
			
			$data= array(
				'jml_benar' => $id['benar'],
				'jml_salah' => $id['salah'],
				'skor' => $id['nilai'],
				'total' => $id['nilai'],
				'jawaban' =>$id['sejawab'],
				'jawaban_esai'=>$id['sejawabesai'],
			);
			
			$where = array(
				'id_siswa' => $id['idsiswa'],
				'id_mapel' => $id['idmapel'],
				'id_ujian' => $id['idujian'],
			);
			$tabel ='nilai_pindah';
			$exc = $db->update($tabel,$data,$where);
			if($exc == 1){
				echo $exc;
			}
			else{
				echo $exc;
			}

		}

		else{

		}
	}

	if(isset($_GET['hapus'])){
		if($_GET['hapus']=='history'){
			//$id = $_POST;
			$tabel ="jawaban_copy";
			$exc = $db->truncate($tabel);
			if($exc == 1){
				echo $exc; //out 1
			}
			else{
				echo $exc; //out 0
			}
		}

		else{
			echo 100;
		}
	}

	if(isset($_GET['token'])){
		if($_GET['token']=='acak'){
			$id = $_POST;
			
			$exc = $db->create_random_token(25);
			echo $exc;
		}

		else{
			echo "error";
		}
	}
//&4.Materi -----------
	if(isset($_GET['materi'])){
		if($_GET['materi']=='cari_mapel'){
			$tabel ="mata_pelajaran";
			$where = array(
				'kode_level' => $_POST['id']
			);
			$exc = $db->cari_data_byid($tabel,$where);
		}
	}
//&5.Absen -----------
	if(isset($_GET['absen'])){
		if($_GET['absen']=='getabsen'){
			$exc = $db->getAbsen($_POST['tahun'],$_POST['bulan'],$_POST['kelas']);
		}
		else if($_GET['absen']=='getsiswa'){
			$kelas = $db->v_kelas2($_POST['id']);
			foreach ($kelas as $kls) {
				$idkelas = $kls['id_kelas'];
			}
			$idjrs='semua';
			$siswas = $db->v_siswa($idkelas,$idjrs);
			foreach ($siswas as $siswa) {
				$data = array(
					'idsiswa' => $siswa['id_siswa'],
					'namasiswa' => $siswa['nama'],
				);
				$data2[]=$data;
			}
			echo json_encode($data2);
		}
		else if($_GET['absen']=='upabsen'){ //update asbensi siswa
			// print_r($_POST);
			$status_asben = $_POST['status_absen'];
			$idsiswa = $_POST['idsiswa'];
			$jam = $db->getJamSkl();
				if($status_asben =='H'){
					$jamin=date($jam['jamIn']);
					$jamout=date($jam['jamOut']);
					$jenis=1;
				}
				else if($status_asben =='T'){
					$jamin=date($jam['jamTerlambat']);
					$jamout=date($jam['jamOut']);
					$jenis=1;
				}
				else if($status_asben =='S'){
					$jamin=date($jam['jamAlpah']);
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
				else if($status_asben =='I'){
					$jamin=date($jam['jamAlpah']);
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
				else if($status_asben =='A'){
					$jamin=date($jam['jamAlpah']);
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
				else{
					$jamin=date('07:30');
					$jamout=date($jam['jamAlpah']);
					$jenis=1;
				}
				$data = array(
					'absJamIn'	=>$jamin,
					'absJamOut'	=>$jamout,
					'absStatus'	=>$status_asben,
					'absJenis'	=>$jenis,
				);
				$where = array(
					'absId'	=>$idsiswa
				);

				$exc = $db->update(tbAbsensi(),$data,$where);
				if($exc == 1){
					echo $exc;
				}
				else{
					echo $exc;
				}

		}
		else if($_GET['absen']=='delabsen'){
			$idabsen = $_POST['idabsen'];
			$where = array('absId'	=>$idabsen);
			$exc = $db->delete(tbAbsensi(),$where);
			if($exc == 'OK'){
					echo 1;
				}
				else{
					echo 0;
				}
			
		}
		else if($_GET['absen']=='jamabsen'){
			$data = array(
					'jamIn'	=>$_POST['jamin'],
					'jamOut'	=>$_POST['jamout'],
					'jamAlpah'	=>$_POST['jamalpa'],
					'jamTerlambat'	=>$_POST['jamterlambat'],
				);
				$where = array(
					'jmId'	=>$_POST['jamid']
				);
			$exc = $db->update('jam_skl',$data,$where);
			if($exc == 1){
					echo $exc;
				}
				else{
					echo $exc;
				}
		}
		else if($_GET['absen']=='tahunabsen'){
			$data = array(
					'thKode'	=>$_POST['kodetahun'],
					'thNama'	=>$_POST['namatahun'],
				);
			
			$table='tahun';
				
			$exc = $db->insert($table,$data);
			if($exc == 1){
					echo $exc;
				}
				else{
					echo $exc;
				}
		}
		else if($_GET['absen']=='updatetahun'){
			$data = array(
					'thKode'	=>$_POST['kode'],
					'thNama'	=>$_POST['nama'],
					'thAktif'	=>$_POST['status'],
				);
			$where = array(
					'thId'	=>$_POST['id']
				);
			
			$table='tahun';
				
			$exc = $db->update($table,$data,$where);
			if($exc == 1){
					echo $exc;
				}
				else{
					echo $exc;
				}
		}
		else if($_GET['absen']=='deletetahun'){
			$table='tahun';
			$id = $_POST['id'];
			$where = array('thId'	=>$id);
			$exc = $db->delete($table,$where);
			if($exc == 'OK'){
					echo 1;
				}
				else{
					echo 0;
				}
		}
		else{

		}
	}
//&6.Absen perMapel-----------
	if(isset($_GET['absen_mapel'])){
		if($_GET['absen_mapel']=='insert'){
			$table='absensi_mapel';
			$mapel = $db->getMata_pelajaran($_POST['mapel']);
			$datamapel = mysqli_fetch_assoc($mapel);
			//-------------------
			$data=array(
				'amKelas'	=>$_POST['idkelas'],
				'amIdMapel'=>$_POST['mapel'],
				'amIdGuru'=>$_SESSION['id_pengawas'],
				'amNamaMapel'=>$datamapel['nama_mapel'],
				'amSlag'=>$datamapel['nama_mapel'],
				'amJamMulai'=>$_POST['jamin'],
				'amJamAkhir'=>$_POST['jamout'],
				'amHari'=>$_POST['hari'],
			);
			//-----------
			$where= array(
				'amIdMapel'=>$_POST['mapel'],
				'amIdGuru'=>$_SESSION['id_pengawas'],
				'amKelas'	=>$_POST['idkelas'],
				'amHari'	=>$_POST['hari'],
			);
			$cek = $db->fetch($table,$where);
			if(count($cek) > 1){ echo 99; }
			else{
				$exc =  $db->insert($table,$data);
				if($exc == 1){ echo $exc; }else{ echo $exc; }
			}
			
		}
		else if($_GET['absen_mapel']=='update'){
			$table='absensi_mapel';
			$data=array(
				'amSlag'=>$_POST['mapel'],
				'amJamMulai'=>$_POST['jamin2'],
				'amJamAkhir'=>$_POST['jamout2'],
				'amHari'=>$_POST['hari2'],
			);
			//-----------
			$where= array('amId'=>$_POST['id']);
			$exc = $db->update($table,$data,$where);
			if($exc == 1){ echo $exc; }else{ echo $exc; }
			
		}
		else if($_GET['absen_mapel']=='delet'){
			$table='absensi_mapel';
			$where= array('amId'=>$_POST['id']);
			$exc = $db->delete($table,$where);
			if($exc == 'OK'){ echo 1; }else{ echo 0; }
		}
		else if($_GET['absen_mapel']=='getkelas'){
			//print_r($_POST);
			return $db->kelas_by_level($_POST['idlevel']);
		}
		else if($_GET['absen_mapel']=='getmapel'){
			return $db->getMata_pelajaran_by_level($_POST['idlevel']);
		}
		else{

		}
	}
//&7.jurnalguru-----------
	if(isset($_GET['jurnal_guru'])){
		if($_GET['jurnal_guru']=='insert'){
			$table='jurnalguru';
			$mapel = $db->getMata_pelajaran($_POST['mapel']);
			$datamapel = mysqli_fetch_assoc($mapel);
			//-------------------
			$data=array(
				'hari'	=>$_POST['hari'],
				'tgl'=>$_POST['tanggal'],
				'jamke'=>$_POST['jamke'],
				'id_kelas'=>$_POST['idkelas'],
				'id_guru'=>$_SESSION['id_pengawas'],
				'tema'=>$_POST['isijurnal'],
				'ket'=>$_POST['keterangan'],
			);
			//-----------
			$where= array(
				'id_guru'=>$_SESSION['id_pengawas'],
				'id_kelas'	=>$_POST['idkelas'],
				'tgl'=>$_POST['tanggal'],
				'hari'	=>$_POST['hari'],
				'jamke'	=>$_POST['jamke'],
			);
			$cek = $db->fetch($table,$where);
			if(count($cek) > 1){ echo 99; }
			else{
				$exc =  $db->insert($table,$data);
				if($exc == 1){ echo $exc; }else{ echo $exc; }
			}
			
		}
		else if($_GET['jurnal_guru']=='update'){
			$table='jurnalguru';
			$data=array(
				'tgl'=>$_POST['tanggal2'],
				'hari'=>$_POST['hari2'],
				'jamke'=>$_POST['jamke2'],
				'tema'=>$_POST['isijurnal2'],
				'ket'=>$_POST['keterangan2'],
			);
			//-----------
			$where= array('id_jurnal'=>$_POST['id']);
			$exc = $db->update($table,$data,$where);
			if($exc == 1){ echo $exc; }else{ echo $exc; }
			
		}
		else if($_GET['jurnal_guru']=='delet'){
			$table='jurnalguru';
			$where= array('id_jurnal'=>$_POST['id']);
			$exc = $db->delete($table,$where);
			if($exc == 'OK'){ echo 1; }else{ echo 0; }
		}
		else if($_GET['jurnal_guru']=='getkelas'){
			//print_r($_POST);
			return $db->kelas_by_level($_POST['idlevel']);
		}
		else if($_GET['jurnal_guru']=='getmapel'){
			return $db->getMata_pelajaran_by_level($_POST['idlevel']);
		}
		else{

		}
	}
//&7.Kelas-------------------------------------------------------
	if(isset($_GET['kelas'])){
		if($_GET['kelas']=='getkelas'){
			return $db->kelas_by_level($_POST['idlevel']);
		}
	}
//&8.Bot Telegram-------------------------------------------------------
	if(isset($_GET['telegram'])){
		if($_GET['telegram']=='addchatid'){
			$where= array(
				'tlIdGuru'=>$_POST['idguru'],
			);
			$data=array(
				'tlChatId'	=>$_POST['chatid'],
				//'tlNama'=>$_POST['mapel'],
				'tlIdBotTelegram'=>1,
				'tlIdGuru'=>$_POST['idguru'],
			);
			$cek = $db->fetch('telegram_bot',$where);
			if(count($cek) > 1){ echo 99; }
			else{
				$exc =  $db->insert('telegram_bot',$data);
				echo $exc;
			}
		}
		else if($_GET['telegram']=='updatechatid'){
			$where= array(
				'tlId'=>$_POST['id'],
			);
			$data=array(
				'tlChatId'	=>$_POST['chatid'],
			);
			$exc = $db->update('telegram_bot',$data,$where);
			echo $exc;

		}
		else if($_GET['telegram']=='addbottelegram'){
			$where= array(
				'botId'=>1,
			);
			$data=array(
				'botToken'	=>$_POST['bot_token'],
				'botChatId'	=>$_POST['id_grub'],
			);
			$exc = $db->update('bot_telegram',$data,$where);
			echo $exc;
		}
		else{ }
	}

} //end if token

else{
	jump("$homeurl");
	
}




