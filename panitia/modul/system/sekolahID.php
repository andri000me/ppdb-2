<?php

defined("RESMI") or die("Akses ditolak");
$sql = $db->prepare("SELECT * FROM us_sekolah");
$sql->execute();
$s = $sql->fetch(PDO::FETCH_ASSOC);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $gump = new GUMP();
    $id_sekolah = $_POST['id_sekolah'];
    $sekolah    = $_POST['sekolah'];
    $npsn       = $_POST['npsn'];
    $alamat     = $_POST['alamat'];
    $telepon    = $_POST['telepon'];
    $hp1        = $_POST['hp1'];
    $hp2        = $_POST['hp2'];
    $kontak1    = $_POST['kontak1'];
    $kontak2    = $_POST['kontak2'];
    $pesan      = $_POST['pesan'];
    $email      = $_POST['email'];
    $website    = $_POST['website'];
    $ujian = $_POST['ujian'];

    $_POST = array(
        'id_sekolah' => $id_sekolah,
        'sekolah'    => $sekolah,
        'npsn'       => $npsn,
        'alamat'     => $alamat,
        'telepon'    => $telepon,
        'hp1'        => $hp1,
        'hp2'        => $hp2,
        'kontak1'    => $kontak1,
        'kontak2'    => $kontak2,
        'pesan'      => $pesan,
        'email'      => $email,
        'website'    => $website,
        'ujian'      => $ujian
    );
    $_POST = $gump->sanitize($_POST);
    $gump->validation_rules(array(
        'id_sekolah' => 'required|integer',
        'sekolah'    => 'required',
        'npsn'       => 'required|numeric',
        'alamat'     => 'required',
        'telepon'    => 'required|numeric',
        'hp1'        => 'required|numeric',
        'hp2'        => 'required|numeric',
        'kontak1'    => 'required',
        'kontak2'    => 'required',
        'pesan'      => 'required',
        'email'      => 'required|valid_email',
        'website'    => 'required|valid_url'
    ));

    $gump->filter_rules(array(
        'id_sekolah' => 'trim|sanitize_numbers',
        'sekolah'    => 'trim|sanitize_string',
        'npsn'       => 'trim|sanitize_numbers',
        'alamat'     => 'trim|sanitize_string',
        'telepon'    => 'trim|sanitize_numbers',
        'hp1'        => 'trim|sanitize_numbers',
        'hp2'        => 'trim|sanitize_numbers',
        'kontak1'    => 'trim|sanitize_string',
        'kontak2'    => 'trim|sanitize_string',
        'pesan'      => 'trim|sanitize_string',
        'email'      => 'trim|sanitize_string',
        'website'    => 'trim|sanitize_string',
        'ujian'      => 'trim|sanitize_string'
    ));
    $ok = $gump->run($_POST);
    if($ok === false){
        $error[] = $gump->get_readable_errors(true);
    }else{
        $sql = $db->prepare("UPDATE us_sekolah SET sekolah_nama = ?, sekolah_npsn = ?, sekolah_alamat = ?, sekolah_telpon = ?, sekolah_hp = ?, sekolah_hp2 = ?, sekolah_email = ?, sekolah_kontak1 = ?, sekolah_kontak2 = ?, sekolah_pesan = ?, sekolah_website = ?, sekolah_ujian = ? WHERE sekolah_id = ?");
        $sql->bindParam(1, $sekolah);
        $sql->bindParam(2, $npsn);
        $sql->bindParam(3, $alamat);
        $sql->bindParam(4, $telepon);
        $sql->bindParam(5, $hp1);
        $sql->bindParam(6, $hp2);
        $sql->bindParam(7, $email);
        $sql->bindParam(8, $kontak1);
        $sql->bindParam(9, $kontak2);
        $sql->bindParam(10, $pesan);
        $sql->bindParam(11, $website);
        $sql->bindParam(12, $ujian);
        $sql->bindParam(13, $id_sekolah);
        if(!$sql->execute()){
            print_r($sql->errorInfo());            
        }else{
            ?><script>
                    swal({ 
                        title: "Berhasil",
                        text: "Identitas Sekolah Berhasil Disimpan",
                        type: "success",
                        timer: 2000 
                    },
                    function(){
                        window.location.href = 'index.php?mod=system&hal=sekolahID';
                    });
                </script><?php
        }
    }
}
?>
<div class="row">
    <div class="col-md-10">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-home"></i> Identitas Sekolah</h3>
            </div>
            <div class="box-body">
                <?php 
                if(isset($error)){
                    foreach ($error as $error) {
                        ?>
                        <div class="alert alert-warning">
                            <h5><i class="fa fa-warning"></i> Galat</h5>
                            <?= $error;?>
                            <meta http-equiv="refresh" content="2">
                        </div>
                        <?php
                    }
                }
                ?>     
                <form method="post" action="" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Sekolah</label>
                        <div class="col-sm-5">
                            <input type="hidden" name="id_sekolah" value="<?=$s['sekolah_id'];?>">
                            <input type="text" name="sekolah" class="form-control" value="<?=$s['sekolah_nama'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NPSN</label>
                        <div class="col-sm-5">
                            <input type="number" name="npsn" class="form-control" value="<?=$s['sekolah_npsn'];?>" required>
                            <p class="help-text">NPSN digunakan sebagai pelengkap nomor Pendaftaran CPDB</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Alamat Sekolah</label>
                        <div class="col-sm-5">
                            <textarea name="alamat" class="form-control" rows="4" required=""><?=nl2br($s['sekolah_alamat']);?></textarea>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nomor Telepon</label>
                        <div class="col-sm-5">
                            <input type="number" name="telepon" class="form-control" value="<?=$s['sekolah_telpon'];?>" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kontak PPDB 1</label>
                        <div class="col-sm-5">
                            <input type="number" name="hp1" class="form-control" value="<?=$s['sekolah_hp'];?>" required>
                            <p class="help-text">Lengkap dengan kode negara 62 untuk chat via WA</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Kontak</label>
                        <div class="col-sm-5">
                            <input type="text" name="kontak1" class="form-control" value="<?=$s['sekolah_kontak1'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kontak PPDB 2</label>
                        <div class="col-sm-5">
                            <input type="number" name="hp2" class="form-control" value="<?=$s['sekolah_hp2'];?>" required>
                            <p class="help-text">Lengkap dengan kode negara 62 untuk chat via WA</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Kontak</label>
                        <div class="col-sm-5">
                            <input type="text" name="kontak2" class="form-control" value="<?=$s['sekolah_kontak2'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pesan Whatsapp</label>
                        <div class="col-sm-5">
                            <textarea name="pesan" class="form-control" rows="3" required=""><?=nl2br($s['sekolah_pesan']);?></textarea>
                            <p class="help-text text-red">String <b>%20</b>, mohon tidak dihilangkan</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email Sekolah</label>
                        <div class="col-sm-5">
                            <input type="text" name="email" class="form-control" value="<?=$s['sekolah_email'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Website Sekolah</label>
                        <div class="col-sm-5">
                            <input type="text" name="website" class="form-control" value="<?=$s['sekolah_website'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Link Ujian Online</label>
                        <div class="col-sm-5">
                            <input type="text" name="ujian" class="form-control" value="<?=$s['sekolah_ujian'];?>">
                            <p class="help-text">Link Ujian Online Google Form</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-info" name="simpan"><i class="fa fa-floppy-o"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
