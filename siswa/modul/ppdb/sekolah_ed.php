<?php
defined("RESMI") or die("Akses ditolak");

if(isset($_GET['tingal']) && !empty($_GET['tingal'])){
    $cokot             = urldecode($_GET['tingal']);
    $buka              = encryptor('decrypt', $cokot);
    $q                 = $db->prepare("SELECT * FROM us_registrasi WHERE register_id = :id");
    $q->execute(array(':id' => $buka));
    $ed                = $q->fetch(PDO::FETCH_ASSOC);
}

if($ed === false){
    ?><script>swal("Galat", "Transaksi tidak dapat dilakukan", "error");</script><?php
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$gump = new GUMP();

		$register_id    = $_POST['register_id'];
		$register_siswa = $_POST['register_siswa'];
		$sekolah_asal   = $_POST['sekolah_asal'];
		$no_un          = $_POST['no_un'];
		$no_ijazah      = $_POST['no_ijazah'];
		$no_skhun       = $_POST['no_skhun'];
		$_POST          = $gump->sanitize($_POST);

		$gump->validation_rules(array(
			'register_id'    => 'required|integer',
			'register_siswa' => 'required|integer',
			'sekolah_asal'   => 'required',
			'no_un'          => 'required|min_len,20',
			'no_ijazah'      => 'required|min_len,16',
			'no_skhun'       => 'required|min_len,16'
		));
		$gump->filter_rules(array(
			'register_id'    => 'trim|sanitize_numbers',
			'register_siswa' => 'trim|sanitize_numbers',
			'sekolah_asal'   => 'trim|sanitize_string',
			'no_un'          => 'trim|sanitize_string',
			'no_ijazah'      => 'trim|sanitize_string',
			'no_skhun'       => 'trim|sanitize_string'
		));

		$ok = $gump->run($_POST);
		if($ok === false){
			$error[] = $gump->get_readable_errors(true);
		}else{
			$c = $db->prepare("UPDATE us_registrasi SET register_siswa = ?, register_sekolah = ?, register_no_un = ?, register_no_ijazah = ?, register_no_skhun = ? WHERE register_id = ?");
			$c->bindParam(1, $register_siswa);
			$c->bindParam(2, $sekolah_asal);
			$c->bindParam(3, $no_un);
			$c->bindParam(4, $no_ijazah);
			$c->bindParam(5, $no_skhun);
            $c->bindParam(6, $register_id);
			if(!$c->execute()){
				print_r($c->errorInfo());
			}else{
				?><script>
                        swal({ 
                            title: "Berhasil",
                            text: "Data sekolah asal berhasil disimpan",
                            type: "success" 
                        },
                        function(){
                            window.location.href = 'index.php?mod=ppdb&hal=sekolah';
                        });
                    </script><?php
			}
		}
	}
?>
<div class="row">
	<div class="col-md-10">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-bank"></i> DATA SEKOLAH ASAL</h3>
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
                <form method="post" action="" class="form-horizontal">
                	<div class="form-group">
                		<label class="col-sm-3 control-label">Sekolah Asal</label>
                		<div class="col-sm-6">
                			<input type="hidden" name="register_id" value="<?=$ed['register_id'];?>">
                			<input type="hidden" name="register_siswa" value="<?=$ed['register_siswa'];?>">
                			<input type="text" name="sekolah_asal" value="<?= $ed['register_sekolah'];?>" class="form-control" required>
                			<p class="help-text">Nama sekolah peserta didik sebelumnya</p>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="control-label col-sm-3">No. Peserta UN SMP/MTS</label>
                		<div class="col-sm-6">
                			<input type="text" name="no_un" value="<?=$ed['register_no_un'];?>" class="form-control" required>
                			<p class="help-text">20 digit nomor peserta Ujian. Format 2-12-02-01-001-002-7</p>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-sm-3 control-label">No. Seri Ijazah SMP/MTS</label>
                		<div class="col-sm-6">
                			<input type="text" name="no_ijazah" value="<?=$ed['register_no_ijazah'];?>" class="form-control" required>
                			<p class="help-text">Isi dengan angka 0 jika belum memiliki</p>
                		</div>
                	</div>
                	<div class="form-group">
                		<label class="col-sm-3 control-label">No. SKHUN SMP/MTS</label>
                		<div class="col-sm-6">
                			<input type="text" name="no_skhun" value="<?=$ed['register_no_skhun'];?>" class="form-control" required>
                			<p class="help-text">Isi dengan angka 0 jika tidak memiliki</p>
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