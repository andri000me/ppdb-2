<?php
defined("RESMI") or die("Akses ditolak");

$token = urlencode(encryptor('encrypt', $sis['siswa_id']));
?>

<div class="row">
    <div class="col-md-10">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user"></i> DATA PRIBADI</h3>
            </div>
            <div class="box-body">                    
                <dl class="dl-horizontal">
                    <dt>Nama Lengkap</dt>
                    <dd><?= $sis['siswa_nama'];?></dd>
                    <dt>No Pendaftaran</dt>
                    <dd><?= $sis['siswa_no_daftar'];?></dd>
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
                <a href="index.php?mod=ppdb&hal=pribadi_ed&tingal=<?=$token;?>" class="btn btn-primary"><i class="fa fa-pencil"></i> PERBARUI DATA</a>
            </div>
        </div>
    </div>
</div>