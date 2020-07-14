<?php

defined("RESMI") or die("Akses ditolak");
//ambil data pendaftar
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



//update status pendaftar

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $gump = new GUMP();



    $siswa_id           = $_POST['siswa_id'];

    $siswa_status_pdb   = $_POST['siswa_status_pdb'];

    $siswa_status_ket   = $_POST['siswa_status_ket'];

    $siswa_jurusan      = $_POST['siswa_jurusan'];

    $siswa_jenis_daftar = $_POST['siswa_jenis_daftar'];



    $_POST = array(

        'siswa_id'           => $siswa_id,    

        'siswa_status_pdb'   => $siswa_status_pdb,

        'siswa_status_ket'   => $siswa_status_ket,

        'siswa_jurusan'      => $siswa_jurusan,

        'siswa_jenis_daftar' => $siswa_jurusan

    );



    $_POST = $gump->sanitize($_POST);

    $gump->validation_rules(array(

        'siswa_id'           => 'required',    

        'siswa_status_pdb'   => 'required',   

        'siswa_jenis_daftar' => 'required'

    ));

    $gump->filter_rules(array(

        'siswa_id'           => 'trim|sanitize_numbers',    

        'siswa_status_pdb'   => 'trim|sanitize_string',

        'siswa_status_ket'   => 'trim|sanitize_string',

        'siswa_jurusan'      => 'trim|sanitize_numbers',

        'siswa_jenis_daftar' => 'trim|sanitize_string'

    ));

    $ok = $gump->run($_POST);

    if($ok === false){

        $error[] = $gump->get_readable_errors(true);        

    }else{

        $sql = $db->prepare("UPDATE us_pendaftar SET siswa_status_pdb = ?, siswa_status_ket = ?, siswa_jurusan = ?, siswa_jenis_daftar = ? WHERE siswa_id = ?");

        $sql->bindParam(1, $siswa_status_pdb);

        $sql->bindParam(2, $siswa_status_ket);

        $sql->bindParam(3, $siswa_jurusan);

        $sql->bindParam(4, $siswa_jenis_daftar);

        $sql->bindParam(5, $siswa_id);

        if(!$sql->execute()){

            print_r($sql->errorInfo());

        }else{

            ?><script>

                swal({ 

                    title: "Berhasil",

                    text: "Status pendaftar berhasil diubah",

                    type: "success" 

                },

                function(){

                    window.location.href = 'index.php?mod=ppdb&hal=pendaftar';

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

                <h3 class="box-title"><i class="fa fa-book"></i> STATUS PESERTA</h3>

            </div>

            <div class="box-body">

                <?php

                if(isset($error)){

                    foreach($error as $error){

                        ?>

                        <div class="alert alert-danger">                        

                            <h4><i class="icon fa fa-ban"></i> Galat</h4>

                            <?php echo $error; ?>

                            <meta http-equiv="refresh" content="5">

                        </div>

                        <?php

                    }

                }

                ?>

                <form method="post" action="" class="form-horizontal">

                    <div class="form-group">

                        <label class="col-sm-3 control-label">Nama CPDB</label>

                        <div class="col-sm-6">

                            <input type="hidden" name="siswa_id" value="<?=$sis['siswa_id'];?>">

                            <input type="text" name="siswa_nama" class="form-control" value="<?=$sis['siswa_nama'];?>" readonly>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 control-label">Jenis Pendaftaran</label>

                        <div class="col-sm-6">

                            <select name="siswa_jenis_daftar" class="form-control" required>

                                <option value="<?=$sis['siswa_jenis_daftar']?>" selected><?=$sis['siswa_jenis_daftar']?></option>

                                <option value="">-- Pilih Jenis Pendaftaran --</option>

                                <option value="Baru">Baru</option>

                                <option value="Pindahan">Pindahan</option>

                            </select>

                        </div>

                    </div> 

                    <div class="form-group">

                        <label class="col-sm-3 control-label">Status PPDB</label>

                        <div class="col-sm-6">

                            <select name="siswa_status_pdb" class="form-control" required>

                                <option value="<?=$sis['siswa_status_pdb']?>" selected>

                                    <?php

                                        if($sis['siswa_status_pdb'] === '0'){

                                            echo 'Ditolak';

                                        }elseif($sis['siswa_status_pdb'] === '1'){

                                            echo "Diterima";

                                        }else{

                                            echo "Belum Ditentukan";

                                        }

                                    ?>

                                </option>

                                <option value="">-- Pilih Status CPDB --</option>

                                <option value="1">Diterima</option>

                                <option value="0">Ditolak</option>

                            </select>

                        </div>

                    </div> 

                    <div class="form-group">

                        <label class="col-sm-3 control-label">Jurusan</label>

                        <div class="col-sm-6">

                            <?php

                                $jur = $db->prepare("SELECT * FROM us_jurusan");

                                $jur->execute();

                            ?>

                            <select name="siswa_jurusan" class="form-control">

                                <option value="<?=$sis['siswa_jurusan']?>" selected><?=$sis['jurusan_nama']?></option>

                                <option value="">--Pilih Jurusan --</option>

                                <?php foreach($jur->fetchAll() as $jr){ ?>

                                    <option value="<?=$jr['jurusan_id'];?>"><?=$jr['jurusan_nama'];?></option>

                                <?php } ?><

                            </select>

                        </div>

                    </div>      

                    <div class="form-group">                                         

                        <label class="col-sm-3 control-label">Keterangan</label>

                        <div class="col-sm-6">

                            <textarea cols="2" name="siswa_status_ket" class="form-control">

                                <?php

                                    $status = $sis['siswa_status_ket'];

                                    if(empty($status)){

                                        echo "Keterangan/instruksi untuk pendaftar";

                                    }else{

                                        echo $status;

                                    }

                                ?> 

                            </textarea>

                            <p class="help-text">Keterangan atau instruksi untuk pendaftar</p>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 control-label"></label>

                        <div class="col-sm-6">

                            <a href="?mod=ppdb&hal=pendaftar" class="btn btn-default"><i class="fa fa-arrow-left"></i> Batal</a>&nbsp;

                            <button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-floppy-o"></i> Simpan</button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>    

</div>