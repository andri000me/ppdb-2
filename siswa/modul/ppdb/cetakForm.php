<?php
defined("RESMI") or die("Akses ditolak");
?>
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-print"></i> CETAK FORMULIR PENDAFTARAN</h3>
            </div>
            <div class="box-body">
                <p>Sebelum melakukan pencetakan formulir, pastikan semua kolom yang ada di menu PENDAFTARAN telah diisi dengan lengkap dan benar</p>
                <p>Silahkan cetak/print formulir online ini kemudian serahkan ke panitia PPDB di:</p>
                <p>
                    <i class="fa fa-bank"> </i><?=$skl['sekolah_nama'];?><br>
                    <i class="fa fa-map-marker"></i> <?=$skl['sekolah_alamat'];?><br>
                    <i class="fa fa-phone"></i> <?=$skl['sekolah_telpon'];?><br>
                </p>
                    <p><i class="fa fa-whatsapp"></i> <a href="https://api.whatsapp.com/send?phone=<?=$skl['sekolah_hp'];?>&amp;text=<?=$skl['sekolah_pesan'];?>"><?=$skl['sekolah_hp'];?></a> - <?=$skl['sekolah_kontak1'];?></p>
                    <p><i class="fa fa-whatsapp"></i> <a href="https://api.whatsapp.com/send?phone=<?=$skl['sekolah_hp2'];?>&amp;text=<?=$skl['sekolah_pesan'];?>"><?=$skl['sekolah_hp2'];?></a> - <?=$skl['sekolah_kontak2'];?></p>
                    <p class="small">Tap/klik pada nomor diatas untuk menghubungi langsung melalui Whatsapp</p>
                <?php
                    $a = $db->prepare("SELECT * FROM us_pendaftar up
                        JOIN us_ortu uo ON up.siswa_id=uo.ot_siswa                        
                        JOIN us_periodik upe ON up.siswa_id=upe.periodik_siswa                  
                        JOIN us_registrasi ur ON up.siswa_id=ur.register_siswa                        
                        WHERE up.siswa_id = :id");
                    $a->execute(array(':id' => $_SESSION['idSiswa']));
                    $b = $a->fetch(PDO::FETCH_ASSOC);
                    $token = urlencode(encryptor('encrypt', $b['siswa_id']));
                    if(empty($b['ot_siswa']) && empty($b['periodik_siswa']) && empty($b['register_siswa'])){
                    ?>
                    <div class="alert alert-info">
                        <h4><i class="icon fa fa-warning"></i> Informasi!</h4>
                        Untuk melakukan pencetakan Formulir Pendaftaran, mohon lengkapi data-data berikut:<br>
                        1. Data Orang Tua.<br>
                        2. Data Periodik.<br>
                        3. Data Sekolah Asal.<br>
                    </div>
                    <?php }else{ ?>                    
                    <a target="_blank" href="../cetak/ctkForm.php?tingal=<?=$token;?>" class="btn btn-primary"><i class="fa fa-print"></i> CETAK FORMULIR</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
