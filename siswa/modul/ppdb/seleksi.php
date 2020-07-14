<?php
    defined("RESMI")or die("error");
?>
<div class="row">
    <div class="col-md-10">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-book"></i> HASIL SELEKSI</h3>
            </div>
            <div class="box-body">
               <?php
                    if($sis['siswa_status_pdb'] === '1'){
                        echo 'Hallo <b> '.$sis['siswa_nama'].' </b><br>';
                        echo 'Anda <b>Diterima</b> di '.$skl['sekolah_nama'].'<br>';
                        echo nl2br($siswa_status_ket);
                    }elseif($status === '0'){
                        echo 'Hallo, <b> '.$sis['nama'].'</b><br>';
                        echo 'Maaf, kamu <b>Tidak Diterima</b> di '.$skl['sekolah_nama'].'<br>';
                        echo nl2br($siswa_status_ket);
                    }else{
                        echo '<h4>Hasil Seleksi Belum Ditentukan</h4>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>