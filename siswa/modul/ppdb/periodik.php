<?php
defined("RESMI") or die("Akses ditolak");

$sqla = $db->prepare("SELECT * FROM us_periodik WHERE periodik_siswa = :id");
$sqla->execute(array(':id' => $_SESSION['idSiswa']));
$pp = $sqla->fetch(PDO::FETCH_ASSOC);
$token = urlencode(encryptor('encrypt', $pp['periodik_id']));
if(empty($pp['periodik_siswa'])){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $gump = new GUMP();
        $tinggi_bdn  = $_POST['tinggi_bdn'];
        $berat_bdn   = $_POST['berat_bdn'];
        $lingkar_kpl = $_POST['lingkar_kpl'];
        $jarak       = $_POST['jarak'];
        $jarak_jml   = $_POST['jarak_jml'];
        $jarak_jam   = $_POST['jarak_jam'];
        $jarak_menit = $_POST['jarak_menit'];
        $jml_saudara = $_POST['jml_saudara'];

        $_POST = $gump->sanitize($_POST);
        $gump->validation_rules(array(
            'tinggi_bdn'  => 'required|numeric',
            'berat_bdn'   => 'required|numeric',
            'lingkar_kpl' => 'required|numeric',
            'jarak'       => 'required|numeric',
            'jarak_jml'   => 'required|numeric',
            'jarak_jam'   => 'required|numeric',
            'jarak_menit' => 'required|numeric',
            'jml_saudara' => 'required|numeric'
        ));
        $gump->filter_rules(array(
            'tinggi_bdn' => 'trim|sanitize_numbers',
            'berat_bdn' => 'trim|sanitize_numbers',
            'lingkar_kpl' => 'trim|sanitize_numbers',
            'jarak' => 'trim|sanitize_numbers',
            'jarak_jml' => 'trim|sanitize_numbers',
            'jarak_jam' => 'trim|sanitize_numbers',
            'jarak_menit' => 'trim|sanitize_numbers',
            'jml_saudara' => 'trim|sanitize_numbers'
        ));
        $boleh = $gump->run($_POST);
        if($boleh === false){
            $gump->get_readable_errors(true);
        }else{
            $p = $db->prepare("INSERT INTO us_periodik SET periodik_siswa = ?, periodik_tinggi_badan = ?, periodik_berat_badan = ?, periodik_lingkar_kpl = ?, periodik_jarak = ?, periodik_jml_jarak = ?, periodik_waktu_jam = ?, periodik_waktu_menit = ?, periodik_jml_saudara = ?");
            $p->bindParam(1, $_SESSION['idSiswa']);
            $p->bindParam(2, $_POST['tinggi_bdn']);
            $p->bindParam(3, $_POST['berat_bdn']);
            $p->bindParam(4, $_POST['lingkar_kpl']);
            $p->bindParam(5, $_POST['jarak']);
            $p->bindParam(6, $_POST['jarak_jml']);
            $p->bindParam(7, $_POST['jarak_jam']);
            $p->bindParam(8, $_POST['jarak_menit']);
            $p->bindParam(9, $_POST['jml_saudara']);
            if(!$p->execute()){
                print_r($p->errorInfo());
            }else{
                ?><script>
                        swal({ 
                            title: "Berhasil",
                            text: "Data wali anda berhasil disimpan",
                            type: "success" 
                        },
                        function(){
                            window.location.href = 'index.php?mod=ppdb&hal=periodik';
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
                <h4 class="box-title"><i class="fa fa-calculator"></i> DATA PERIODIK</h4>
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
                            <meta http-equiv="refresh" content="2">
                        </div>
                        <?php
                    }
                }
                ?>
                <form method="post" class="form-horizontal" action="">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tinggi Badan</label>
                        <div class="col-sm-3">
                            <input type="number" name="tinggi_bdn" class="form-control" required>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Berat Badan </label>
                        <div class="col-sm-3">
                            <input type="number" name="berat_bdn" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Lingkar Kepala</label>
                        <div class="col-sm-3">
                            <input type="number" name="lingkar_kpl" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jarak tempat tinggal ke sekolah</label>
                        <div class="col-sm-3">
                            <select name="jarak" class="form-control" required>
                                <option value="">-- Pilih Jarak Tempuh --</option>
                                <option value="Kurang dari 1 km">Kurang dari 1 km</option>
                                <option value="Lebih dari 1 km">Lebih dari 1 km</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Sebutkan (dalam kilometer)</label>
                        <div class="col-sm-3">
                            <input type="number" name="jarak_jml" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Waktu tempuh ke sekolah (jam/menit)</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="number" name="jarak_jam" class="form-control" placeholder="1" required>
                                <p class="help-text">Isikan 0 jika krg dari 1 km</p>
                            </div>
                            <div class="col-sm-3">
                                <input type="number" name="jarak_menit" class="form-control" placeholder="60" required>
                                <p class="help-text">menit</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jumlah saudara kandung</label>
                        <div class="col-sm-3">
                            <input type="number" name="jml_saudara" class="form-control" required>
                            <p class="help-text">Isikan angka 0 jika anak tunggal</p>
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
                </form>
            </div>
        </div>
    </div>    
</div>
<?php }else{ ?>
<div class="row">
    <div class="col-md-10">
        <div class="box box-info">
            <div class="box-header with-border">
                <h4 class="box-title"><i class="fa fa-calculator"></i> DATA PERIODIK</h4>
            </div>
            <div class="box-body">
                
                <dl class="dl-horizontal">
                    <dt>Tinggi Badan</dt>
                    <dd><?= $pp['periodik_tinggi_badan'];?> cm</dd>
                    <dt>Berat Badan</dt>
                    <dd><?= $pp['periodik_berat_badan'];?> kg</dd>
                    <dt>Lingkar kepala</dt>
                    <dd><?= $pp['periodik_lingkar_kpl'];?> cm</dd>
                    <dt>Jarak tempat tinggal ke sekolah</dt>
                    <dd><?= $pp['periodik_jarak'];?></dd>
                    <dt>Sebutkan (dalam kilometer)</dt>
                    <dd><?= $pp['periodik_jml_jarak'];?> km</dd>
                    <dt>Waktu tempuh ke sekolah</dt>
                    <dd><?= $pp['periodik_waktu_jam'].'jam '.$pp['periodik_waktu_menit'].'menit';?></dd>
                    <dt>Jumlah saudara kandung</dt>
                    <dd><?= $pp['periodik_jml_saudara'];?></dd>
                </dl>
                <a href="index.php?mod=ppdb&hal=periodik_ed&tingal=<?=$token;?>" class="btn btn-primary"><i class="fa fa-pencil"></i> PERBARUI DATA</a>
            </div>
        </div>
    </div>    
</div>
<?php } ?>