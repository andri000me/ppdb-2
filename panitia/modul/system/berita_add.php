<?php
defined("RESMI") or die("Akses ditolak");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $gump = new GUMP();

    $judul      = $_POST['judul'];
    $isi_berita = $_POST['isi_berita'];
    $tampil     = $_POST['tampil'];

    $_POST = array(
        'judul'      => $judul,
        'isi_berita' => $isi_berita,
        'tampil'     => $tampil
    );
    $_POST = $gump->sanitize($_POST);

    $gump->validation_rules(array(
        'judul'      => 'required',
        'isi_berita' => 'required',
        'tampil'     => 'required'
    ));
    $gump->filter_rules(array(
        'judul'      => 'trim|sanitize_string',
        'isi_berita' => 'trim|sanitize_string',
        'tampil'     => 'trim|sanitize_numbers'
    ));

    $ok = $gump->run($_POST);
    if($ok === false){
        $error[] = $gump->get_readable_errors(true);
    }else{
        $tgl = date('m/d/Y');
        $sql = $db->prepare("INSERT INTO us_berita SET berita_judul = ?, berita_isi = ?, berita_tgl = ?, berita_tampil = ?");
        $sql->bindParam(1, $judul);
        $sql->bindParam(2, $isi_berita);
        $sql->bindParam(3, $tgl);
        $sql->bindParam(4, $tampil);
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
                            <input type="text" name="judul" class="form-control" required="">
                            <p class="help-text">Judul Berita / Pengumuman</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Isi Berita</label>
                        <div class="col-sm-9">
                            <textarea name="isi_berita" class="textarea"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tampilkan?</label>
                        <div class="col-sm-6">
                            <input type="hidden" name="tampil" value="0">
                            <input type="checkbox" name="tampil" value="1" class="besar">
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