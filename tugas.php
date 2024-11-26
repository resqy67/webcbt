<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit "></i> Tugas Siswa</h3>
      </div><!-- /.box-header -->
      <div class='box-body'>
        <div style="padding-bottom: 10px;" >
          <a href="<?= $homeurl . '/daftarnilaitugas/' . enkripsi($mapel['id_tugas']) ?>" class="btn btn-primary">Lihat Semua Nilai Mapel</a>
        </div>
        <?php
        $mapelQ = mysqli_query($koneksi, "SELECT * FROM tugas where status=1");
        ?>
        <div class="table-responsive">
          <table class="table table-bordered" id="tableabsen">
            <thead>
              <tr>
                <th>NO</th>
                <th>STATUS</th>
                <th>MAPEL</th>
                <th>JUDUL</th>
                <th>MULAI</th>
                <th>TUTUP</th>
                <th>NAMA GURU</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
              <?php
              $datakelas = unserialize($mapel['kelas']);
              $guru = fetch($koneksi, 'pengawas', ['id_pengawas' => $mapel['id_guru']]);
              ?>
              <?php if (in_array($_SESSION['id_kelas'], $datakelas) or in_array('semua', $datakelas)) : 
              // $mulaitgl = new DateTime($mapel['tgl_mulai']); 
              // $selesaitgl = new DateTime($mapel['tgl_selesai']); 
              // $sekarang = new DateTime();
              // $perbedaan = $selesaitgl->diff($sekarang);
              // echo $perbedaan->y.' selisih tahun.';
              // echo $perbedaan->m.' selisih bulan.';
              // echo $perbedaan->d.' selisih hari.';
              // echo $perbedaan->h.' selisih jam.';

                $selesaitgl = strtotime($mapel['tgl_selesai']); 
                $sekarang = strtotime(date("Y-m-d H:i:s"));
               
              if($sekarang > $selesaitgl ){ }
                else{
                  ?>
                  <tr>
                    <td><?= $no++; ?></td>
                     <td>
                      <?php if ($mapel['tgl_mulai'] > date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) { ?>
                        <span class="btn badge"> BELUM MULAI</span>
                      <?php } elseif ($mapel['tgl_mulai'] < date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) { ?>
                        <a href="<?= $homeurl . '/lihattugas/' . enkripsi($mapel['id_tugas']) ?>" class="btn btn-primary">
                          <i class="fa fa-eye"></i> Lihat Tugas
                        </a>
                      <?php } else { ?>
                       <span class="btn badge bg-red"> DI TUTUP</span>
                      <?php } ?>
                    </td>
                    <td><?= $mapel['mapel'] ?></td>
                    <td><?= $mapel['judul'] ?></td>
                    <td> 
                      <span class="btn pull-right badge bg-green"><?= $mapel['tgl_mulai'] ?></span>
                   </td>
                    <td>
                      <span class="btn pull-right badge bg-red"><?= $mapel['tgl_selesai'] ?></span>
                   </td>
                    <td><?= $guru['nama'] ?></td>
                   
                  </tr>
                  
                <?php } endif; ?>

              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var tabel = $('#tableabsen').dataTable();
</script>