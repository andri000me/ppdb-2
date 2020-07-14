<?php
defined("RESMI") or die("Akses ditolak");
if(!empty($_GET['id'])){
        $id = intval($_GET['id']);
    }
    $sql = $db->prepare("SELECT * FROM us_periode WHERE periode_id = ?");
    $sql->execute(array($id));
    $pe = $sql->fetch(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] === "POST"){    
    $gump = new GUMP();
    $id_periode   = $_POST['id_periode'];
    $nama         = $_POST['nama'];
    $periode      = $_POST['periode'];
    $tgl_awal     = $_POST['tgl_awal'];
    $tgl_akhir    = $_POST['tgl_akhir'];
    $dibuka       = $_POST['dibuka'];
    $berbayar     = $_POST['berbayar'];
    $biaya_daftar = $_POST['biaya_daftar'];

    $_POST = $gump->sanitize($_POST);
    $gump->validation_rules(array(
        'id_periode' => 'required',
        'nama'       => 'required',
        'periode'    => 'required',
        'tgl_awal'   => 'required',
        'tgl_akhir'  => 'required'
    ));
    $gump->filter_rules(array(
        'id_periode'   => 'trim|sanitize_numbers',
        'nama'         => 'trim|sanitize_string',
        'periode'      => 'trim|sanitize_string',
        'tgl_awal'     => 'trim|sanitize_string',
        'tgl_akhir'    => 'trim|sanitize_string',
        'dibuka'       => 'trim|sanitize_numbers',
        'berbayar'     => 'trim|sanitize_numbers',
        'biaya_daftar' => 'trim|sanitize_numbers'
    ));
    $ok = $gump->run($_POST);
    if($ok === false){
        $error[] = $gump->get_readable_errors(true);
    }else{
        $sql = $db->prepare("UPDATE us_periode SET periode_nama = ?, periode_tp = ?, periode_tgl_awal = ?, periode_tgl_akhir = ?, periode_status = ?, periode_berbayar = ?, periode_biaya = ? WHERE periode_id = ?");
        $sql->bindParam(1, $nama);
        $sql->bindParam(2, $periode);
        $sql->bindParam(3, $tgl_awal);
        $sql->bindParam(4, $tgl_akhir);
        $sql->bindParam(5, $dibuka);
        $sql->bindParam(6, $berbayar);
        $sql->bindParam(7, $biaya_daftar);
        $sql->bindParam(8, $id);
        if(!$sql->execute()){
            print_r($sql->errorInfo());
        }else{
            ?><script>
                swal({ 
                    title: "Berhasil",
                    text: "Data periode berhasil disimpan",
                    type: "success" 
                },
                function(){
                    window.location.href = 'index.php?mod=system&hal=periode';
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
    <div class="col-xs-8">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Data Periode Pendaftaran</h3>                
                <p class="help-text" style="color: #9eacb4;">Digunakan untuk menambahkan periode pendaftaran calon peserta didik baru</p>
            </div>
            <form method="post" action="" class="form-horizontal">
                <div class="box-body">
                    <?php
                    if(isset($error)){
                        foreach($error as $error){
                            ?>
                            <div class="alert alert-danger">                        
                                <h4><i class="icon fa fa-ban"></i> Galat</h4>
                                <?php echo $error; ?>
                                <meta http-equiv="refresh" content="2">
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama</label>
                        <div class="col-sm-6">
                            <input type="hidden" name="id_periode" value="<?=$pe['periode_id'];?>">
                            <input type="text" name="nama" class="form-control" value="<?=$pe['periode_nama'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Periode</label>
                        <div class="col-sm-6">
                            <select name="periode" class="form-control" required>
                                <option value="<?=$pe['periode_tp'];?>"><?=$pe['periode_tp'];?></option>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                <option value="2020/2021">2020/2021</option>
                                <option value="2021/2022">2021/2022</option>
                                <option value="2022/2023">2022/2023</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tanggal Awal Pendaftaran</label>
                        <div class="col-sm-6">
                            <input id="tglawal" type="text" name="tgl_awal" class="form-control"  value="<?=$pe['periode_tgl_awal'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tanggal Akhir Pendaftaran</label>
                        <div class="col-sm-6">
                            <input id="tglakhir" type="text" name="tgl_akhir" class="form-control" value="<?=$pe['periode_tgl_akhir'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Dibuka?</label>
                        <div class="col-sm-6">
                            <?php
                                if($pe['periode_status'] === "1"){ ?>
                                    <input type="hidden" name="dibuka" value="0">
                                    <input type="checkbox" name="dibuka" value="<?=$pe['periode_status'];?>" class="besar" checked>
                                <?php }else{ ?>
                                    <input type="hidden" name="dibuka" value="0">
                                    <input type="checkbox" name="dibuka" value="1" class="besar">
                                <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Berbayar?</label>
                        <div class="col-sm-6">
                            <?php if($pe['periode_berbayar'] === '1'){ ?>
                            <input type="hidden" name="berbayar" value="0">
                            <input id="bayar" type="checkbox" name="berbayar" value="<?=$pe['periode_berbayar'];?>" class="besar" checked>
                        <?php }else{ ?>
                            <input type="hidden" name="berbayar" value="0">
                            <input id="bayar" type="checkbox" name="berbayar" value="1" class="besar" onclick="Biaya()">
                        <?php } ?>
                        </div>
                    </div>
                    <?php if($pe['periode_berbayar'] === '0'){ ?>
                    <div id="biaya" class="form-group" style="display: none;">
                        <label class="col-sm-4 control-label">Biaya Pendaftaran</label>
                        <div class="col-sm-6">
                            <input type="text" name="biaya_daftar" class="form-control">
                        </div>
                    </div> 
                    <?php }else{ ?>
                    <div id="biaya" class="form-group">
                        <label class="col-sm-4 control-label">Biaya Pendaftaran</label>
                        <div class="col-sm-6">
                            <input type="text" name="biaya_daftar" class="form-control" value="<?=$pe['periode_biaya'];?>">
                        </div>
                    </div> 
                    <?php } ?>          
                </div>
                <div class="box-footer">
                    <button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-floppy-o"></i> Simpan</button>&nbsp;<a href="?mod=system&hal=periode" class="btn btn-warning"><i class="fa fa-chevron-circle-left"></i> Batal</a>
                </div>
            </form>      
        </div> 
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tglawal').datepicker({
            format:'yyyy/mm/dd',
            autoclose: true
        });
        $('#tglakhir').datepicker({
            format:'yyyy/mm/dd',
            autoclose: true
        });
    });
    function Biaya() {
        var checkBox = document.getElementById("bayar");
        var text = document.getElementById("biaya");
        if (checkBox.checked == true){
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }
</script>