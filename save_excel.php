<?php
    session_start();
    define("RESMI","OK");
    if(!isset($_SESSION['idSiswa']) && !isset($_SESSION['admID'])){
        header("Location: ../index.php");
    }

    require('config/database.php');
    require('config/fungsi.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Calon Peserta Didik Baru - SMK Mahadhika 3</title>
</head>
<body>
    <style type="text/css">
    body{
        font-family: sans-serif;
    }
    table{
        margin: 20px auto;
        border-collapse: collapse;
    }
    table th,
    table td{
        border: 1px solid #3c3c3c;
        padding: 3px 8px;

    }
    a{
        background: blue;
        color: #fff;
        padding: 8px 10px;
        text-decoration: none;
        border-radius: 2px;
    }
    </style>

    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=PPDB SMK Mahadhika 3 20-21.xls");
    ?>

    <center>
        <h1>DAFTAR PESERTA PPDB <br/> SMK Mahadhika 3 Tahun 2020/2021</h1>
    </center>

    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>No. Pendaftaran</th>
            <th>Tanggal Pendaftaran</th>
            <th>Gelombang</th>
            <th>Jurusan Pilihan</th>
            <th>Jenis Pendaftaran</th>
            <th>Jenis Kelamin</th>
            <th>NISN</th>
            <th>NIK</th>
            <th>No. KK</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>No. Reg Akta Lahir</th>
            <th>Agama</th>
            <th>Kewarganegaraan</th>
            <th>Berkebutuhan Khusus</th>
            <th>Alamat Jalan</th>
            <th>RT</th>
            <th>RW</th>
            <th>Nama Dusun</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Kode Pos</th>
            <th>Lintang</th>
            <th>Bujur</th>
            <th>Tempat Tinggal</th>
            <th>Moda Transportasi</th>
            <th>Anak ke</th>
            <th>Apakah Punya KIP</th>
            <th>Apakah tetap menerima KIP</th>
            <th>Alasan menolak KIP</th>
            <th>Nama Ayah Kandung</th>
            <th>NIK Ayah</th>
            <th>Thn Lahir Ayah</th>
            <th>Pendidikan Ayah</th>
            <th>Pekerjaan Ayah</th>
            <th>Penghasilan Ayah</th>
            <th>Berkebutuhan Khusus</th>
            <th>Nama Ibu Kandung</th>
            <th>NIK Ibu</th>
            <th>Thn Lahir Ibu</th>
            <th>Pendidikan Ibu</th>
            <th>Pekerjaan Ibu</th>
            <th>Penghasilan Ibu</th>
            <th>Berkebutuhan Khusus</th>
            <th>Nama Wali</th>
            <th>NIK Wali</th>
            <th>Thn Lahir Wali</th>
            <th>Pendidikan Wali</th>
            <th>Pekerjaan Wali</th>
            <th>Penghasilan Wali</th>
            <th>Berkebutuhan Khusus</th>
            <th>No. Telpon</th>
            <th>No. HP</th>
            <th>Tinggi Badan</th>
            <th>Berat Badan</th>
            <th>Lingkar Kepala</th>
            <th>Jarak ke sekolah</th>
            <th>Sebutkan (dlm km)</th>
            <th>Waktu tempuh</th>
            <th>Jml Saudara Kandung</th>
            <th>Jenis Kesejahteraan</th>
            <th>No. Kartu</th>
            <th>Nama di Kartu</th>
            <th>Sekolah Asal</th>
            <th>No UN SMP</th>
            <th>No. Seri Ijazah SMP</th>
            <th>No. SKHUN SMP</th>
        </tr>
        <?php
        $a = $db->prepare("SELECT * FROM us_pendaftar up
            LEFT JOIN us_ortu uo ON up.siswa_id=uo.ot_siswa
            LEFT JOIN us_periodik upe ON up.siswa_id=upe.periodik_siswa
            LEFT JOIN us_registrasi ur ON up.siswa_id=ur.register_siswa
            LEFT JOIN us_jurusan uj ON up.siswa_jurusan=uj.jurusan_id
            LEFT JOIN us_periode upr ON up.siswa_gelombang=upr.periode_id
            ORDER BY up.siswa_id ASC");
        $a->execute();                      
        $no =1;
        foreach($a->fetchAll() as $p){
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$p['siswa_nama'];?></td>
            <td><?=$p['siswa_no_daftar'];?></td>
            <td><?=$p['siswa_tgl_daftar'];?></td>
            <td><?=$p['periode_nama'];?></td>
            <td><?=$p['jurusan_nama'];?></td>
            <td><?=$p['siswa_jenis_daftar'];?></td>
            <td>
                <?php 
                    if($p['siswa_kelamin'] === 'L'){
                        echo 'Laki-laki';
                    }else{
                        echo 'Perempuan';
                    }
                ?>   
            </td>
            <td><?=$p['siswa_nisn'];?></td>
            <td><?=$p['siswa_nik'];?></td>
            <td><?=$p['siswa_noKK'];?></td>
            <td><?=$p['siswa_tglLahir'];?></td>
            <td><?=$p['siswa_tempatLahir'];?></td>
            <td><?=$p['siswa_noAktaLahir'];?></td>
            <td><?=$p['siswa_agama'];?></td>
            <td><?=$p['siswa_kewarganegaraan'];?></td>
            <td><?=$p['siswa_kebutuhan'];?></td>
            <td><?=$p['siswa_alamat_jln'];?></td>
            <td><?=$p['siswa_rt'];?></td>
            <td><?=$p['siswa_rw'];?></td>
            <td><?=$p['siswa_dusun'];?></td>
            <td><?=$p['siswa_kelurahan'];?></td>
            <td><?=$p['siswa_kecamatan'];?></td>
            <td><?=$p['siswa_kode_pos'];?></td>
            <td><?=$p['siswa_lintang'];?></td>
            <td><?=$p['siswa_bujur'];?></td>
            <td><?=$p['siswa_tinggal'];?></td>
            <td><?=$p['siswa_transport'];?></td>
            <td><?=$p['siswa_anak_ke'];?></td>
            <td><?=$p['siswa_kip'];?></td>
            <td><?=$p['siswa_status_kip'];?></td>
            <td><?=$p['siswa_alasan_kip'];?></td>
            <td><?=$p['ot_nama_ayah'];?></td>
            <td><?=$p['ot_nik_ayah'];?></td>
            <td><?=$p['ot_thn_lahir_ayah'];?></td>
            <td><?=$p['ot_pendidikan_ayah'];?></td>
            <td><?=$p['ot_pekerjaan_ayah'];?></td>
            <td><?=$p['ot_gaji_ayah'];?></td>
            <td><?=$p['ot_kebutuhan_ayah'];?></td>
            <td><?=$p['ot_nama_ibu'];?></td>
            <td><?=$p['ot_nik_ibu'];?></td>
            <td><?=$p['ot_thn_lahir_ibu'];?></td>
            <td><?=$p['ot_pendidikan_ibu'];?></td>
            <td><?=$p['ot_pekerjaan_ibu'];?></td>
            <td><?=$p['ot_gaji_ibu'];?></td>
            <td><?=$p['ot_kebutuhan_ibu'];?></td>
            <td><?=$p['ot_nama_wali'];?></td>
            <td><?=$p['ot_nik_wali'];?></td>
            <td><?=$p['ot_thn_lahir_wali'];?></td>
            <td><?=$p['ot_pendidikan_wali'];?></td>
            <td><?=$p['ot_pekerjaan_wali'];?></td>
            <td><?=$p['ot_gaji_wali'];?></td>
            <td><?=$p['ot_kebutuhan_wali'];?></td>
            <td><?=$p['siswa_telp_rmh'];?></td>
            <td><?=$p['siswa_hp'];?></td>
            <td><?=$p['periodik_tinggi_badan'];?></td>
            <td><?=$p['periodik_berat_badan'];?></td>
            <td><?=$p['periodik_lingkar_kpl'];?></td>
            <td><?=$p['periodik_jarak'];?></td>
            <td><?=$p['periodik_jml_jarak'];?></td>
            <td><?=$p['periodik_waktu_jam'].' jam '.$p['periodik_waktu_menit'];?> menit</td>
            <td><?=$p['periodik_jml_saudara'];?></td>
            <td><?=$p['siswa_krt_sejahtera'];?></td>
            <td><?=$p['siswa_krt_no'];?></td>
            <td><?=$p['siswa_krt_nama'];?></td>
            <td><?=$p['register_sekolah'];?></td>
            <td><?=$p['register_no_un'];?></td>            
            <td><?=$p['register_no_ijazah'];?></td>
            <td><?=$p['register_no_skhun'];?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>