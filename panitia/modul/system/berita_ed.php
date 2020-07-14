<?php
    defined("RESMI") or die("Akses ditolak");
    if(!empty($_GET['id'])){
        $id = intval($_GET['id']);
    }
    $sql = $db->prepare("SELECT * FROM us_berita WHERE berita_id = :idna");
    $sql->execute(array(':idna' => $id));
    $be = $sql->fetch(PDO::FETCH_ASSOC);
    //tangani form
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $gump = new GUMP();

    $idna       = $_POST['idna'];
    $tanggal    = $_POST['tanggal'];
    $judul      = $_POST['judul'];
    $isi_berita = $_POST['isi_berita'];
    $tampil     = $_POST['tampil'];

    $_POST = array(
        'idna'       => $idna,
        'tanggal'    => $tanggal,
        'judul'      => $judul,
        'isi_berita' => $isi_berita,
        'tampil'     => $tampil
    );
    $_POST = $gump->sanitize($_POST);

    $gump->validation_rules(array(
        'idna'       => 'required',
        'tanggal'    => 'required',
        'judul'      => 'required',
        'isi_berita' => 'required',
        'tampil'     => 'required'
    ));
    $gump->filter_rules(array(
        'idna'       => 'trim|sanitize_numbers',
        'tanggal'    => 'trim|sanitize_string',
        'judul'      => 'trim|sanitize_string',
        'isi_berita' => 'trim|sanitize_string',
        'tampil'     => 'trim|sanitize_numbers'
    ));

    $ok = $gump->run($_POST);
    if($ok === false){
        $error[] = $gump->get_readable_errors(true);
    }else{        
        $sql = $db->prepare("UPDATE us_berita SET berita_judul = ?, berita_isi = ?, berita_tgl = ?, berita_tampil = ? WHERE berita_id = ?");
        $sql->bindParam(1, $judul);
        $sql->bindParam(2, $isi_berita);
        $sql->bindParam(3, $tanggal);
        $sql->bindParam(4, $tampil);
        $sql->bindParam(5, $idna);
        if(!$sql->execute()){
            print_r($sql->errorInfo());
        }else{
            ?><script>
                swal({ 
                    title: "Berhasil",
                    text: "Berita/pengumanan berhasil disimpan",
                    type: "success" 
                },
                function(){
                    window.location.href = 'index.php?mod=system&hal=berita';
                });
                </script><?php
        }
    }
}
?>
<style> 
    input.besar { 
        transform : scale(1.5); 
    }     
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-newspaper-o"></i> Data Berita/Pengumuman</h3>
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
                        <label class="col-sm-3 control-label">Judul Berita</label>
                        <div class="col-sm-6">
                            <input type="hidden" name="idna" value="<?=$be['berita_id'];?>">
                            <input type="hidden" name="tanggal" value="<?=$be['berita_tgl'];?>">
                            <input type="text" name="judul" value="<?=$be['berita_judul'];?>" class="form-control" required="">
                            <p class="help-text">Judul Berita / Pengumuman</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Isi Berita</label>
                        <div class="col-sm-9">
                            <textarea id="editor1" name="isi_berita" class="textarea">
                              <?=$be['berita_isi'];?>
                          </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tampilkan?</label>
                        <div class="col-sm-6">
                            <?php if($be['berita_tampil'] === '1'){ ?>
                                <input type="hidden" name="tampil" value="0">
                                <input type="checkbox" name="tampil" value="<?=$be['berita_tampil'];?>" class="besar" checked>
                            <?php }else{ ?>
                                <input type="hidden" name="tampil" value="0">
                                <input type="checkbox" name="tampil" value="1" class="besar">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <a href="?mod=system&hal=berita" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Batal</a>&nbsp;
                            <button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-floppy-o"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>