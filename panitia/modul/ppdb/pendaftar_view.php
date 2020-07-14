<?php
defined("RESMI") or die("Akses ditolak");
if(isset($_GET['tingal']) && !empty($_GET['tingal'])){
    $cokot             = urldecode($_GET['tingal']);
    $buka              = encryptor('decrypt', $cokot);
    $q                 = $db->prepare("SELECT * FROM us_pendaftar up
                            LEFT JOIN us_ortu uo ON up.siswa_id=uo.ot_siswa
                            LEFT JOIN us_periodik upe ON up.siswa_id=upe.periodik_siswa
                            LEFT JOIN us_registrasi ur ON up.siswa_id=ur.register_siswa
                            LEFT JOIN us_jurusan uj ON up.siswa_jurusan=uj.jurusan_id
                            LEFT JOIN us_periode upr ON up.siswa_gelombang=upr.periode_id
                            WHERE siswa_id = :id");
    $q->execute(array(':id' => $buka));
    $sis = $q->fetch(PDO::FETCH_ASSOC);
    if($sis === false){
        ?><script>swal("Galat", "Transaksi tidak dapat dilakukan", "error");</script><?php
    }
}
//token
$token = urlencode(encryptor('encrypt', $sis['siswa_id']));
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user"></i> Detail CPDB: <b><?=$sis['siswa_nama'];?></b></h3>
                <div class="pull-right">
                    <a href="index.php?mod=ppdb&hal=pendaftar" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>&nbsp;
                    <a target="_blank" href="../cetak/ctkForm.php?tingal=<?=$token;?>" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a>
                </div>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Data Pribadi</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Data Wali</a></li>
                        <li><a href="#tab_3" data-toggle="tab">Data Periodik</a></li>
                        <li><a href="#tab_4" data-toggle="tab">Data Beasiswa</a></li>
                        <li><a href="#tab_5" data-toggle="tab">Data Prestasi</a></li>
                        <li><a href="#tab_6" data-toggle="tab">Data Sekolah Asal</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <dl class="dl-horizontal">
                                <dt>Nama Lengkap</dt>
                                <dd><?= $sis['siswa_nama'];?></dd>
                                <dt>No Pendaftaran</dt>
                                <dd><?= $sis['siswa_no_daftar'];?></dd>
                                <dt>Tanggal Pendaftaran</dt>
                                <dd><?= tgl_id($sis['siswa_tgl_daftar']);?></dd>
                                <dt>Jurusan</dt>
                                <dd><?= $sis['jurusan_nama'];?></dd>
                                <dt>Jenis Kelamin</dt>
                                <dd>
                                    <?php
                                    if($sis['siswa_kelamin'] === 'L'){
                                        echo "Laki-laki";
                                    }else{
                                        echo "Perempuan";
                                    }
                                    ?>                        
                                </dd>
                                <dt>NISN</dt>
                                <dd><?= $sis['siswa_nisn'];?></dd>
                                <dt>NIK</dt>
                                <dd><?= $sis['siswa_noKK'];?></dd>
                                <dt>Tempat Lahir</dt>
                                <dd><?= $sis['siswa_tempatLahir'];?></dd>
                                <dt>Tanggal ahir</dt>
                                <dd><?= tgl_id($sis['siswa_tglLahir']);?></dd>
                                <dt>No. Registrasi Akta Lahir</dt>
                                <dd><?= $sis['siswa_noAktaLahir'];?></dd>
                                <dt>Agama</dt>
                                <dd><?= $sis['siswa_agama'];?></dd>
                                <dt>Kewarganeagaraan</dt>
                                <dd><?= $sis['siswa_kewarganegaraan'];?></dd>
                                <dt>Berkebutuhan Khusus</dt>
                                <dd><?= $sis['siswa_kebutuhan'];?></dd>
                                <dt>Alamat jalan</dt>
                                <dd><?= $sis['siswa_alamat_jln'];?></dd>
                                <dt>RT</dt>
                                <dd><?= $sis['siswa_rt'];?></dd>
                                <dt>RW</dt>
                                <dd><?= $sis['siswa_rw'];?></dd>
                                <dt>Nama Dusun</dt>
                                <dd><?= $sis['siswa_dusun'];?></dd>
                                <dt>Kelurahan/Desa</dt>
                                <dd><?= $sis['siswa_kelurahan'];?></dd>
                                <dt>Kecamatan</dt>
                                <dd><?= $sis['siswa_kecamatan'];?></dd>
                                <dt>Kode Pos</dt>
                                <dd><?= $sis['siswa_kode_pos'];?></dd>
                                <dt>Lintang</dt>
                                <dd><?= $sis['siswa_lintang'];?></dd>
                                <dt>Bujur</dt>
                                <dd><?= $sis['siswa_bujur'];?></dd>
                                <dt>Tempat Tinggal</dt>
                                <dd><?= $sis['siswa_tinggal'];?></dd>
                                <dt>Moda Transportasi</dt>
                                <dd><?= $sis['siswa_transport'];?></dd>
                                <dt>Anak keberapa</dt>
                                <dd><?= $sis['siswa_anak_ke'];?></dd>
                                <dt>Apakah punya KIP</dt>
                                <dd><?= $sis['siswa_kip'];?></dd>
                                <dt>Akan tetap menerima KIP</dt>
                                <dd><?= $sis['siswa_status_kip'];?></dd>
                                <dt>Alasan menolak KIP</dt>
                                <dd><?= $sis['siswa_alasan_kip'];?></dd>
                                <dt>Jenis Kesejahteraan</dt>
                                <dd><?= $sis['siswa_krt_sejahtera'];?></dd>
                                <dt>No. Kartu</dt>
                                <dd><?=$sis['siswa_krt_no'];?></dd>
                                <dt>Nama di Kartu</dt>
                                <dd><?=$sis['siswa_krt_nama'];?></dd>
                                <dt>No. Telpon rumah</dt>
                                <dd><?= $sis['siswa_telp_rmh'];?></dd>
                                <dt>No. HP</dt>
                                <dd><?= $sis['siswa_hp'];?></dd>
                            </dl>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <dl class="dl-horizontal">
                                <h3>Data Ayah</h3>
                                <dt>Nama Ayah Kandung</dt>
                                <dd><?= $sis['ot_nama_ayah'];?></dd>
                                <dt>NIK Ayah</dt>
                                <dd><?= $sis['ot_nik_ayah'];?></dd>
                                <dt>Tahun Lahir</dt>
                                <dd><?= $sis['ot_thn_lahir_ayah'];?></dd>
                                <dt>Pendidikan</dt>
                                <dd><?= $sis['ot_pendidikan_ayah'];?></dd>
                                <dt>Pekerjaan</dt>
                                <dd><?= $sis['ot_pekerjaan_ayah'];?></dd>
                                <dt>Penghasilan bulanan</dt>
                                <dd><?= $sis['ot_gaji_ayah'];?></dd>
                                <dt>Berkebutuhan khusus</dt>
                                <dd><?= $sis['ot_kebutuhan_ayah'];?></dd>
                                <!-- Nama Ibu -->
                                <h3>Data Ibu</h3>
                                <dt>Nama Ibu Kandung</dt>
                                <dd><?= $sis['ot_nama_ibu'];?></dd>
                                <dt>NIK Ibu</dt>
                                <dd><?= $sis['ot_nik_ibu'];?></dd>
                                <dt>Tahun Lahir</dt>
                                <dd><?= $sis['ot_thn_lahir_ibu'];?></dd>
                                <dt>Pendidikan</dt>
                                <dd><?= $sis['ot_pendidikan_ibu'];?></dd>
                                <dt>Pekerjaan</dt>
                                <dd><?= $sis['ot_pekerjaan_ibu'];?></dd>
                                <dt>Penghasilan bulanan</dt>
                                <dd><?= $sis['ot_gaji_ibu'];?></dd>
                                <dt>Berkebutuhan khusus</dt>
                                <dd><?= $sis['ot_kebutuhan_ibu'];?></dd>
                                <!-- Nama Wali -->
                                <h3>Data Wali</h3>
                                <dt>Nama Wali</dt>
                                <dd><?= $sis['ot_nama_wali'];?></dd>
                                <dt>NIK Wali</dt>
                                <dd><?= $sis['ot_nik_wali'];?></dd>
                                <dt>Tahun Lahir</dt>
                                <dd><?= $sis['ot_thn_lahir_wali'];?></dd>
                                <dt>Pendidikan</dt>
                                <dd><?= $sis['ot_pendidikan_wali'];?></dd>
                                <dt>Pekerjaan</dt>
                                <dd><?= $sis['ot_pekerjaan_wali'];?></dd>
                                <dt>Penghasilan bulanan</dt>
                                <dd><?= $sis['ot_gaji_wali'];?></dd>
                                <dt>Berkebutuhan khusus</dt>
                                <dd><?= $sis['ot_kebutuhan_wali'];?></dd>
                            </dl>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <dl class="dl-horizontal">
                                <dt>Tinggi Badan</dt>
                                <dd><?= $sis['periodik_tinggi_badan'];?> cm</dd>
                                <dt>Berat Badan</dt>
                                <dd><?= $sis['periodik_berat_badan'];?> kg</dd>
                                <dt>Lingkar kepala</dt>
                                <dd><?= $sis['periodik_lingkar_kpl'];?> cm</dd>
                                <dt>Jarak tempat tinggal ke sekolah</dt>
                                <dd><?= $sis['periodik_jarak'];?></dd>
                                <dt>Sebutkan (dalam kilometer)</dt>
                                <dd><?= $sis['periodik_jml_jarak'];?> km</dd>
                                <dt>Waktu tempuh ke sekolah</dt>
                                <dd><?= $sis['periodik_waktu_jam'].'jam '.$sis['periodik_waktu_menit'].'menit';?></dd>
                                <dt>Jumlah saudara kandung</dt>
                                <dd><?= $sis['periodik_jml_saudara'];?></dd>
                            </dl>
                        </div>
                        <div class="tab-pane" id="tab_4">
                            <table id="beasiswa" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Beasiswa</th>
                                        <th>Keterangan</th>
                                        <th>Tahun Mulai</th>
                                        <th>Tahun Selesai</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($q->fetchAll() as $row){ ?>
                                        <tr>
                                            <td><?= $no++;?></td>
                                            <td><?= $row['beasiswa_jenis'];?></td>
                                            <td><?= $row['beasiswa_keterangan'];?></td>
                                            <td><?= $row['beasiswa_thn_mulai'];?></td>
                                            <td><?= $row['beasiswa_thn_selesai'];?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="" class="btn btn-primary"
                                                    data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#EditData"
                                                    data-beasiswa_id="<?= $row['beasiswa_id'];?>"
                                                    data-beasiswa_siswa="<?=$row['beasiswa_siswa'];?>"
                                                    data-beasiswa_keterangan="<?=$row['beasiswa_keterangan'];?>"
                                                    data-beasiswa_jenis="<?=$row['beasiswa_jenis'];?>"
                                                    data-beasiswa_thn_mulai="<?=$row['beasiswa_thn_mulai'];?>"
                                                    data-beasiswa_thn_selesai="<?= $row['beasiswa_thn_selesai'];?>"><i class="fa fa-edit"></i></a>
                                                    <a href="" class="btn btn-primary btn-del" data-id="<?=$row['beasiswa_id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>                        
                            </table>
                        </div>
                        <div class="tab-pane" id="tab_5">
                            <table id="prestasi" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>                            
                                        <th>Jenis</th>
                                        <th>Tingkat</th>
                                        <th>Nama</th>
                                        <th>Tahun</th>
                                        <th>Penyelenggara</th>
                                        <th>Peringkat</th>
                                        <th>Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($q->fetchAll() as $row){ ?>
                                        <tr>
                                            <td><?= $no++;?></td>
                                            <td><?= $row['prestasi_jenis'];?></td>
                                            <td><?= $row['prestasi_tingkat'];?></td>
                                            <td><?= $row['prestasi_nama'];?></td>
                                            <td><?= $row['prestasi_thn'];?></td>
                                            <td><?= $row['prestasi_panitia'];?></td>
                                            <td><?= $row['prestasi_peringkat'];?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="" class="btn btn-primary"
                                                    data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                                    data-target="#EditData"
                                                    data-prestasi_id="<?=$row['prestasi_id'];?>"
                                                    data-prestasi_siswa="<?=$row['prestasi_siswa'];?>"
                                                    data-prestasi_jenis="<?=$row['prestasi_jenis'];?>"
                                                    data-prestasi_tingkat="<?=$row['prestasi_tingkat'];?>"
                                                    data-prestasi_nama="<?=$row['prestasi_nama'];?>"
                                                    data-prestasi_thn="<?=$row['prestasi_thn'];?>"
                                                    data-prestasi_panitia="<?=$row['prestasi_panitia'];?>"
                                                    data-prestasi_peringkat="<?=$row['prestasi_peringkat'];?>"><i class="fa fa-edit"></i></a>
                                                    <a href="" class="btn btn-primary btn-del" data-id="<?=$row['prestasi_id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab_6">
                            <dl class="dl-horizontal">
                                <dt>Sekolah Asal</dt>
                                <dd><?=$sis['register_sekolah'];?></dd>
                                <dt>No. Peserta UN SMP/MTS</dt>
                                <dd><?=$sis['register_no_un'];?></dd>
                                <dt>No. Seri Ijazah SMP/MTS</dt>
                                <dd><?= $sis['register_no_ijazah'];?></dd>
                                <dt>No. SKHUN SMP/MTS</dt>
                                <dd><?= $sis['register_no_skhun'];?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>