<?php
defined("RESMI") or die("Akses ditolak");

if(isset($_GET['tingal']) && !empty($_GET['tingal'])){
    $cokot             = urldecode($_GET['tingal']);
    $buka              = encryptor('decrypt', $cokot);
    $q                 = $db->prepare("SELECT * FROM us_pendaftar up 
        JOIN us_jurusan uj ON up.siswa_jurusan=uj.jurusan_id
        WHERE siswa_id = :id");
    $q->execute(array(':id' => $buka));
    $ed                = $q->fetch(PDO::FETCH_ASSOC);
}

if($ed === false){
    ?><script>swal("Galat", "Transaksi tidak dapat dilakukan", "error");</script><?php
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $gump = new GUMP();
        $siswa_id        = $_POST['siswa_id'];
        $siswa_no_daftar = $_POST['siswa_no_daftar'];
        $siswa_gelombang = $_POST['siswa_gelombang'];
        $nama            = $_POST['nama'];
        $jurusan         = $_POST['jurusan'];
        $jenis_kelamin   = $_POST['jenis_kelamin'];
        $nisn            = $_POST['nisn'];
        $nik             = $_POST['nik'];
        $kk              = $_POST['kk'];
        $tmpt_lahir      = $_POST['tmpt_lahir'];
        $tgllahir        = $_POST['tgllahir'];
        $no_akta         = $_POST['no_akta'];
        $agama           = $_POST['agama'];
        $warganegara     = $_POST['warganegara'];
        $kebutuhan       = $_POST['kebutuhan'];
        $jalan           = $_POST['jalan'];
        $rt              = $_POST['rt'];
        $rw              = $_POST['rw'];
        $dusun           = $_POST['dusun'];
        $kelurahan       = $_POST['kelurahan'];
        $kecamatan       = $_POST['kecamatan'];
        $kode_pos        = $_POST['kode_pos'];
        $lintang         = $_POST['lintang'];
        $bujur           = $_POST['bujur'];
        $tinggal         = $_POST['tinggal'];
        $transportasi    = $_POST['transportasi'];
        $anak_ke         = $_POST['anak_ke'];
        $kip             = $_POST['kip'];
        $status_kip      = $_POST['status_kip'];
        $alasan_kip      = $_POST['alasan_kip'];
        $kesejahteraan   = $_POST['kesejahteraan'];
        $no_kartu        = $_POST['no_kartu'];
        $nama_kartu      = $_POST['nama_kartu'];
        $telp            = $_POST['telp'];
        $hp              = $_POST['hp'];

        $_POST = $gump->sanitize($_POST);
        $gump->validation_rules(array(
            'siswa_id'        => 'required|integer',
            'siswa_no_daftar' => 'required',
            'siswa_gelombang' => 'required',
            'nama'            => 'required',
            'jurusan'         => 'required',
            'jenis_kelamin'   => 'required',
            'nisn'            => 'required|numeric|exact_len,10',
            'nik'             => 'required|numeric|exact_len,16',
            'kk'              => 'required|numeric|exact_len,16',
            'tmpt_lahir'      => 'required',
            'tgllahir'        => 'required',
            'no_akta'         => 'required',
            'agama'           => 'required',
            'warganegara'     => 'required',
            'kebutuhan'       => 'required',
            'jalan'           => 'required',
            'rt'              => 'required|numeric',
            'rw'              => 'required|numeric',
            'dusun'           => 'required',
            'kelurahan'       => 'required',
            'kecamatan'       => 'required',
            'kode_pos'        => 'required|numeric',
            'lintang'         => 'required',
            'bujur'           => 'required',
            'tinggal'         => 'required',
            'transportasi'    => 'required',
            'anak_ke'         => 'required|numeric',
            'kip'             => 'required',
            'status_kip'      => 'required',            
            'telp'            => 'required',
            'hp'              => 'required|numeric'
        ));
        $gump->filter_rules(array(
            'siswa_id'        => 'trim|sanitize_numbers',
            'siswa_no_daftar' => 'trim|sanitize_string',
            'siswa_gelombang' => 'trim|sanitize_string',
            'nama'            => 'trim|sanitize_string',
            'jurusan'         => 'trim|sanitize_string',
            'jenis_kelamin'   => 'trim|sanitize_string',
            'nisn'            => 'trim|sanitize_numbers',
            'nik'             => 'trim|sanitize_numbers',
            'kk'              => 'trim|sanitize_numbers',
            'tmpt_lahir'      => 'trim|sanitize_string',
            'tgllahir'        => 'trim|sanitize_string',
            'no_akta'         => 'trim|sanitize_string',
            'agama'           => 'trim|sanitize_string',
            'warganegara'     => 'trim|sanitize_string',
            'kebutuhan'       => 'trim|sanitize_string',
            'jalan'           => 'trim|sanitize_string',
            'rt'              => 'trim|sanitize_numbers',
            'rw'              => 'trim|sanitize_numbers',
            'dusun'           => 'trim|sanitize_string',
            'kelurahan'       => 'trim|sanitize_string',
            'kecamatan'       => 'trim|sanitize_string',
            'kode_pos'        => 'trim|sanitize_numbers',
            'lintang'         => 'trim|sanitize_string',
            'bujur'           => 'trim|sanitize_string',
            'tinggal'         => 'trim|sanitize_string',
            'transportasi'    => 'trim|sanitize_string',
            'anak_ke'         => 'trim|sanitize_numbers',
            'kip'             => 'trim|sanitize_string',
            'status_kip'      => 'trim|sanitize_string',
            'alasan_kip'      => 'trim|sanitize_string',
            'kesejahteraan'   => 'trim|sanitize_string',
            'no_kartu'        => 'trim|sanitize_string',
            'nama_kartu'      => 'trim|sanitize_string',
            'telp'            => 'trim|sanitize_string',
            'hp'              => 'trim|sanitize_numbers'
        ));
        $bisa = $gump->run($_POST);
        if($bisa === false){
            $error[] = $gump->get_readable_errors(true);
        }else{            
            $sqlp = $db->prepare("UPDATE us_pendaftar SET siswa_no_daftar = ?, siswa_gelombang = ?, siswa_jurusan = ?, siswa_nama = ?, siswa_kelamin = ?, siswa_nisn = ?, siswa_nik = ?, siswa_noKK = ?, siswa_tempatLahir = ?, siswa_tglLahir = ?, siswa_noAktaLahir = ?, siswa_agama = ?, siswa_kewarganegaraan = ?, siswa_kebutuhan = ?, siswa_alamat_jln = ?, siswa_rt = ?, siswa_rw = ?, siswa_dusun = ?, siswa_kelurahan = ?, siswa_kecamatan = ?, siswa_kode_pos = ?, siswa_lintang = ?, siswa_bujur = ?, siswa_tinggal = ?, siswa_transport = ?, siswa_anak_ke = ?, siswa_kip = ?, siswa_status_kip = ?, siswa_alasan_kip = ?, siswa_krt_sejahtera = ?, siswa_krt_no = ?, siswa_krt_nama = ?, siswa_telp_rmh = ?, siswa_hp = ? WHERE siswa_id = ?");            
            $sqlp->bindParam(1, $siswa_no_daftar);
            $sqlp->bindParam(2, $siswa_gelombang);
            $sqlp->bindParam(3, $_POST['jurusan']);
            $sqlp->bindParam(4, $_POST['nama']);
            $sqlp->bindParam(5, $_POST['jenis_kelamin']);
            $sqlp->bindParam(6, $_POST['nisn']);
            $sqlp->bindParam(7, $_POST['nik']);
            $sqlp->bindParam(8, $_POST['kk']);
            $sqlp->bindParam(9, $_POST['tmpt_lahir']);
            $sqlp->bindParam(10, $_POST['tgllahir']);
            $sqlp->bindParam(11, $_POST['no_akta']);
            $sqlp->bindParam(12, $_POST['agama']);
            $sqlp->bindParam(13, $_POST['warganegara']);
            $sqlp->bindParam(14, $_POST['kebutuhan']);
            $sqlp->bindParam(15, $_POST['jalan']);
            $sqlp->bindParam(16, $_POST['rt']);
            $sqlp->bindParam(17, $_POST['rw']);
            $sqlp->bindParam(18, $_POST['dusun']);
            $sqlp->bindParam(19, $_POST['kelurahan']);
            $sqlp->bindParam(20, $_POST['kecamatan']);
            $sqlp->bindParam(21, $_POST['kode_pos']);
            $sqlp->bindParam(22, $_POST['lintang']);
            $sqlp->bindParam(23, $_POST['bujur']);
            $sqlp->bindParam(24, $_POST['tinggal']);
            $sqlp->bindParam(25, $_POST['transportasi']);
            $sqlp->bindParam(26, $_POST['anak_ke']);
            $sqlp->bindParam(27, $_POST['kip']);
            $sqlp->bindParam(28, $_POST['status_kip']);
            $sqlp->bindParam(29, $_POST['alasan_kip']);
            $sqlp->bindParam(30, $_POST['kesejahteraan']);
            $sqlp->bindParam(31, $_POST['no_kartu']);
            $sqlp->bindParam(32, $_POST['nama_kartu']);
            $sqlp->bindParam(33, $_POST['telp']);
            $sqlp->bindParam(34, $_POST['hp']);
            $sqlp->bindParam(35, $siswa_id);
            if(!$sqlp->execute()){
                print_r($sqlp->errorInfo());
            }else{
                ?><script>
                        swal({ 
                            title: "Berhasil",
                            text: "Data pribadi anda berhasil disimpan",
                            type: "success" 
                        },
                        function(){
                            window.location.href = 'index.php?mod=ppdb&hal=pribadi';
                        });
                    </script><?php
            }
        }
    }
?>
<div class="row">
    <div class="col-md-10">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">DATA PRIBADI</h3>
            </div>
            <div class="box-body">
                <h4>Mohon lengkapi kolom-kolom berikut dengan jelas dan benar</h4>
                <?php
                if(isset($error)){
                    foreach($error as $error){
                        ?>
                        <div class="alert alert-danger">                        
                            <h4><i class="icon fa fa-ban"></i> Galat</h4>
                            <?php echo $error; ?>
                            <meta http-equiv="refresh" content="15">
                        </div>
                        <?php
                    }
                }
                ?>
                <form class="form-horizontal" action="" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Lengkap</label>
                        <div class="col-sm-6">
                            <input type="hidden" name="siswa_id" value="<?=$ed['siswa_id'];?>">
                            <input type="hidden" name="siswa_no_daftar" value="<?=$ed['siswa_no_daftar'];?>">
                            <input type="hidden" name="siswa_gelombang" value="<?=$ed['siswa_gelombang'];?>">
                            <input type="text" name="nama" class="form-control" value="<?= $sis['siswa_nama'];?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pilihan Jurusan</label>
                        <div class="col-sm-4">
                            <?php
                            $d = $db->prepare("SELECT * FROM us_jurusan ORDER BY jurusan_id ASC");
                            $d->execute();
                            ?>
                            <select name="jurusan" class="form-control" required>
                                <option value="<?=$ed['jurusan_id'];?>" selected><?=$ed['jurusan_nama'];?></option>
                                <option value="">-- Pilih Jurusan --</option>   
                                <?php foreach($d->fetchAll() as $row){ ?>
                                    <option value="<?=$row['jurusan_id'];?>"><?=$row['jurusan_nama'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jenis Kelamin</label>
                        <div class="col-sm-4">
                            <?php
                                if($ed['siswa_kelamin'] == "L"){ ?>
                                    <label class="radio-inline"><input type="radio" name="jenis_kelamin" value="<?=$ed['siswa_kelamin'];?>" checked> Laki-laki</label> &nbsp;<label class="radio-inline"><input type="radio" name="jenis_kelamin" value="P"> Perempuan</label>
                            <?php }else{ ?>
                                    <label class="radio-inline"><input type="radio" name="jenis_kelamin" value="L"> Laki-laki</label> &nbsp;<label class="radio-inline"><input type="radio" name="jenis_kelamin" value="<?=$ed['siswa_kelamin'];?>" checked> Perempuan</label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NISN</label>
                        <div class="col-sm-6">
                            <input type="number" name="nisn" class="form-control" value="<?=$ed['siswa_nisn'];?>" required>
                        </div>                       
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NIK/No.KITAS untuk WNA</label>
                        <div class="col-sm-6">
                            <input type="number" name="nik" class="form-control" value="<?=$ed['siswa_nik'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. KK</label>
                        <div class="col-sm-6">
                            <input type="number" name="kk" class="form-control" value="<?=$ed['siswa_noKK'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tempat Lahir</label>
                        <div class="col-sm-6">
                            <input type="text" name="tmpt_lahir" class="form-control" value="<?=$ed['siswa_tempatLahir'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tanggal Lahir</label>
                        <div class="col-sm-6">
                            <input id="tglLahir" name="tgllahir" class="form-control" data-date-format="dd/mm/yyyy" value="<?=$ed['siswa_tglLahir'];?>" required>
                            <p class="help-text">Format: dd/mm/yyyy, Contoh: 31/12/2000</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No Registrasi Akta Lahir</label>
                        <div class="col-sm-6">
                            <input type="text" name="no_akta" class="form-control" value="<?=$ed['siswa_noAktaLahir'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Agama & Kepercayaan</label>
                        <div class="col-sm-6">
                            <select name="agama" class="form-control" required>
                                <option value="<?=$ed['siswa_agama'];?>" selected><?=$ed['siswa_agama'];?></option>
                                <option value="">--Pilh Agama & Kepercayaan--</option>
                                <?php
                                    $sqlag = $db->prepare("SELECT agama_kd, agama_nama FROM us_agama ORDER BY agama_id ASC");
                                    $sqlag->execute();
                                    foreach($sqlag->fetchAll() as $row){ ?>
                                <option value="<?= $row['agama_kd'].')'.$row['agama_nama'];?>"><?= $row['agama_kd'].')'.$row['agama_nama'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kewarganegaraan</label>
                        <div class="col-sm-6">
                            <select name="warganegara" class="form-control" required>
                                <option value="<?=$ed['siswa_kewarganegaraan'];?>" selected><?=$ed['siswa_kewarganegaraan'];?></option>
                                <option value="">--Pilih Kewarganegaraan--</option>
                                <option value="Indonesia (WNI)">Indonesia (WNI)</option>
                                <option value="Asing (WNA)">Asing (WNA)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Berkebutuhan khusus</label>
                        <div class="col-sm-6">
                            <select name="kebutuhan" class="form-control" required>
                                <option value="<?=$ed['siswa_kebutuhan'];?>" selected><?=$ed['siswa_kebutuhan'];?></option>
                                <option value="">--Pilih Jenis Kebutuhan Khusus</option>
                                <?php 
                                    $sqlk = $db->prepare("SELECT kebutuhan_kd, kebutuhan_nama FROM us_kebutuhan ORDER BY kebutuhan_id ASC");
                                    $sqlk->execute();
                                    foreach($sqlk->fetchAll() as $row) { ?>
                                <option value="<?= $row['kebutuhan_kd'].' '.$row['kebutuhan_nama'];?>"><?= $row['kebutuhan_kd'].' '.$row['kebutuhan_nama'];?></option>
                            <?php } ?>
                            </select>
                        </div>    
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alamat Jalan</label>
                        <div class="col-sm-6">
                            <input type="text" name="jalan" class="form-control" value="<?=$ed['siswa_alamat_jln'];?>" required>
                            <p class="help-text">Lengkap dengan nama jalan/gang, dan nomor rumah</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">RT</label>
                        <div class="col-sm-2">
                            <input type="number" name="rt" class="form-control" value="<?=$ed['siswa_rt'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">RW</label>
                        <div class="col-sm-2">
                            <input type="number" name="rw" class="form-control" value="<?=$ed['siswa_rw'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Dusun</label>
                        <div class="col-sm-6">
                            <input type="text" name="dusun" class="form-control" value="<?=$ed['siswa_dusun'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Kelurahan/Desa</label>
                        <div class="col-sm-6">
                            <input type="text" name="kelurahan" class="form-control" value="<?=$ed['siswa_kelurahan'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Kecamatan</label>
                        <div class="col-sm-6">
                            <input type="text" name="kecamatan" class="form-control" value="<?=$ed['siswa_kecamatan'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kode Pos</label>
                        <div class="col-sm-2">
                            <input type="number" name="kode_pos" class="form-control" value="<?=$ed['siswa_kode_pos'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Lintang </label>
                        <div class="col-sm-4">
                            <input type="text" name="lintang" class="form-control" value="<?=$ed['siswa_lintang'];?>" required>
                            <p style="padding-top:5px;" class="help-text"><button class="btn btn-primary" onclick="getLocation()">Lihat posisi lintang dan bujur</button></p>
                            <p class="help-text" id="lokasi"></p>
                            <script>
                                var x = document.getElementById("lokasi");
                                function getLocation() {
                                    if (navigator.geolocation) {
                                        navigator.geolocation.getCurrentPosition(showPosition);
                                    } else { 
                                        x.innerHTML = "Geolocation tidak didukung oleh browser yang kamu gunakan.";
                                    }
                                }
                                function showPosition(position) {
                                    x.innerHTML = "Lintang: " + position.coords.latitude + 
                                    "<br>Bujur: " + position.coords.longitude + "<br>Pastekan masing-masing posisi ke kolom yang tersedia";
                                }
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bujur </label>
                        <div class="col-sm-4">
                            <input type="text" name="bujur" class="form-control" value="<?=$ed['siswa_bujur'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tempat Tinggal</label>
                        <div class="col-sm-4">
                            <select name="tinggal" class="form-control">
                                <option value="<?=$ed['siswa_tinggal'];?>" selected><?=$ed['siswa_tinggal'];?></option>
                                <option value="">--Pilih Tempat Tinggal--</option>
                                <?php
                                    $sqlt = $db->prepare("SELECT tinggal_kd, tinggal_nama FROM us_tinggal ORDER BY tinggal_id ASC");
                                    $sqlt->execute();
                                    foreach($sqlt->fetchall() as $row){ ?>
                                <option value="<?= $row['tinggal_kd'].')'.$row['tinggal_nama'];?>"><?= $row['tinggal_kd'].')'.$row['tinggal_nama'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Moda Transportasi</label>
                        <div class="col-sm-6">
                            <select name="transportasi" class="form-control" required>
                                <option value="<?=$ed['siswa_transport'];?>" selected><?=$ed['siswa_transport'];?></option>
                                <option value="">--Pilih Moda Transportasi</option>
                            <?php
                                $sqlm = $db->prepare("SELECT transport_kd, transport_nama FROM us_transportasi ORDER BY transport_id");
                                $sqlm->execute();
                                foreach($sqlm->fetchall() as $row){ ?>
                                <option value="<?= $row['transport_kd'].')'.$row['transport_nama'];?>"><?= $row['transport_kd'].')'.$row['transport_nama'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Anak keberapa</label>
                        <div class="col-sm-2">
                            <input type="number" name="anak_ke" class="form-control" value="<?=$ed['siswa_anak_ke'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Apakah punya KIP</label>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-2">
                                    <?php if($ed['siswa_kip'] === 'Ya'){ ?>
                                        <input type="radio" name="kip" class="radio" value="<?=$ed['siswa_kip'];?>" checked><?=$ed['siswa_kip'];?>
                                    <?php }else{ ?>
                                        <input type="radio" name="kip" class="radio" value="Ya">Ya
                                    <?php } ?>
                                </div>
                                <div class="col-sm-2">
                                    <?php if($ed['siswa_kip'] === 'Tidak'){ ?>
                                        <input type="radio" name="kip" class="radio" value="<?=$ed['siswa_kip'];?>" checked><?=$ed['siswa_kip'];?>
                                    <?php }else{?>
                                        <input type="radio" name="kip" class="radio" value="Tidak">Tidak
                                    <?php } ?>
                                </div>
                            </div>
                            <p class="help-text">KIP, Kartu Indonesia Pintar</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Apakah tetap akan menerima KIP</label>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-2">
                                    <?php if($ed['siswa_status_kip'] === 'Ya'){?>
                                        <input type="radio" name="status_kip" class="radio" value="<?=$ed['siswa_status_kip'];?>" checked><?=$ed['siswa_status_kip'];?>
                                    <?php }else{?>
                                        <input type="radio" name="status_kip" class="radio" value="Ya" required>Ya
                                    <?php } ?>
                                </div>
                                <div class="col-sm-2">
                                    <?php if($ed['siswa_status_kip'] === 'Tidak'){ ?>
                                        <input type="radio" name="status_kip" class="radio" value="<?=$ed['siswa_status_kip'];?>" checked><?=$ed['siswa_status_kip'];?>
                                    <?php }else{ ?>
                                        <input type="radio" name="status_kip" class="radio" value="Tidak" required>Tidak
                                    <?php } ?>
                                </div>
                            </div>
                            <p class="help-text">KIP, Kartu Indonesia Pintar</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alasan menolak KIP</label>
                        <div class="col-sm-6">
                            <select name="alasan_kip" class="form-control">
                                <option value="<?=$ed['siswa_alasan_kip'];?>" selected><?=$ed['siswa_alasan_kip'];?></option>
                                <option value="">--Pilih Alasan--</option>
                                <option value="01)Dilarang pemda karena menerima bantuan serupa">01)Dilarang pemda karena menerima bantuan serupa</option>
                                <option value="02)Menolak">02)Menolak</option>
                                <option value="03)sudah mampu">03)Sudah mampu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jenis Kesejahteraan</label>
                        <div class="col-sm-6">
                            <select name="kesejahteraan" class="form-control">
                                <option value="<?=$ed['siswa_krt_sejahtera'];?>" selected><?=$ed['siswa_krt_sejahtera'];?></option>
                                <option value="">-- Pilih Jenis Kesejahteraan --</option>
                                <option value="01) PKH">01) PKH</option>
                                <option value="02) PIP">02) PIP</option>
                                <option value="03) Kartu Perlindungan Sosial">03) Kartu Perlindungan Sosial</option>
                                <option value="04) Kartu Keluarga Sejahtera">04) Kartu Keluarga Sejahtera</option>
                                <option value="05) Kartu Kesehatan">05) Kartu Kesehatan</option>
                            </select>
                            <p class="help-text">Kosongkan jika tidak memiliki</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. Kartu</label>
                        <div class="col-sm-6">
                            <input type="text" name="no_kartu" class="form-control" value="<?=$ed['siswa_krt_no'];?>">
                            <p class="help-text">Kosongkan jika tidak memiliki</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama di Kartu</label>
                        <div class="col-sm-6">
                            <input type="text" name="nama_kartu" class="form-control" value="<?=$ed['siswa_krt_nama'];?>">
                            <p class="help-text">Kosongkan jika tidak memiliki</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nomor Telpon Rumah</label>
                        <div class="col-sm-4">
                            <input type="number" name="telp" class="form-control" value="<?=$ed['siswa_telp_rmh'];?>" required>
                            <p class="help-text">Isi dengan angka 0 jika tidak memiliki telpon rumah</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No HP/Ponsel</label>
                        <div class="col-sm-4">
                            <input type="number" name="hp" class="form-control" value="<?=$ed['siswa_hp'];?>" required>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <h4 class="text-red">Mohon periksa kembali data isian anda sebelum disimpan</h4>
                        </div>                        
                    </div>  
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-3">
                            <select id="simpan" class="form-control" required>
                                <option value="">Simpan Data ?</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <p></p>
                            <button id="save" type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan</button>
                        </div>
                        <script>                            
                            //toggleFields
                            toggleFields();
                            $("#simpan").change(function () {
                                toggleFields();
                            });                        
                            function toggleFields() {
                                if ($("#simpan").val() == "Ya")
                                    $("#save").show();
                                else
                                    $("#save").hide();                                
                            }
                        </script>
                    </div>   
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm3">
                           <a href="?mod=ppdb&hal=pribadi" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Batal</a> 
                        </div>
                    </div>               
                </form>
            </div>
        </div>
    </div>
</div>