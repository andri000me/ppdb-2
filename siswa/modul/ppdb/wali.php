<?php
defined("RESMI") or die("Akses ditolak");

$sqlu = $db->prepare("SELECT * FROM us_ortu WHERE ot_siswa = :id");
$sqlu->execute(array(':id' => $_SESSION['idSiswa']));
$ot = $sqlu->fetch(PDO::FETCH_ASSOC);
$token = urlencode(encryptor('encrypt', $ot['ot_id']));
if(empty($ot['ot_siswa'])){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$gump = new GUMP();
		$nama_ayah       = $_POST['nama_ayah'];
		$nik_ayah        = $_POST['nik_ayah'];
		$thn_lahir_ayah  = $_POST['thn_lahir_ayah'];
		$pendidikan_ayah = $_POST['pendidikan_ayah'];
		$pekerjaan_ayah  = $_POST['pekerjaan_ayah'];
		$gaji_ayah       = $_POST['gaji_ayah'];
		$kebutuhan_ayah  = $_POST['kebutuhan_ayah'];
		$nama_ibu        = $_POST['nama_ibu'];
		$nik_ibu         = $_POST['nik_ibu'];
		$thn_lahir_ibu   = $_POST['thn_lahir_ibu'];
		$pendidikan_ibu  = $_POST['pendidikan_ibu'];
		$pekerjaan_ibu   = $_POST['pekerjaan_ibu'];
		$gaji_ibu        = $_POST['gaji_ibu'];
		$kebutuhan_ibu   = $_POST['kebutuhan_ibu'];
		$nama_wali       = $_POST['nama_wali'];
		$nik_wali        = $_POST['nik_wali'];
		$thn_lahir_wali  = $_POST['thn_lahir_wali'];
		$pendidikan_wali = $_POST['pendidikan_wali'];
		$pekerjaan_wali  = $_POST['pekerjaan_wali'];
		$gaji_wali       = $_POST['gaji_wali'];
		$kebutuhan_wali  = $_POST['kebutuhan_wali'];

		$_POST = $gump->sanitize($_POST);
		$gump->validation_rules(array(
			'nama_ayah'       => 'required',
			'nik_ayah'        => 'required|numeric|exact_len,16',
			'thn_lahir_ayah'  => 'required|numeric|exact_len,4',
			'pendidikan_ayah' => 'required',
			'pekerjaan_ayah'  => 'required',
			'gaji_ayah'       => 'required',
			'kebutuhan_ayah'  => 'required',
			'nama_ibu'        => 'required',
			'nik_ibu'         => 'required|numeric|exact_len,16',
			'thn_lahir_ibu'   => 'required|numeric|exact_len,4',
			'pendidikan_ibu'  => 'required',
			'pekerjaan_ibu'   => 'required',
			'gaji_ibu'        => 'required',
			'kebutuhan_ibu'   => 'required',
			'nama_wali'       => 'required',
			'nik_wali'        => 'required|numeric|exact_len,16',
			'thn_lahir_wali'  => 'required|numeric|exact_len,4',
			'pendidikan_wali' => 'required',
			'pekerjaan_wali'  => 'required',
			'gaji_wali'       => 'required',
			'kebutuhan_wali'  => 'required',
		));
		$gump->filter_rules(array(
			'nama_ayah'       => 'trim|sanitize_string',
			'nik_ayah'        => 'trim|sanitize_numbers',
			'thn_lahir_ayah'  => 'trim|sanitize_numbers',
			'pendidikan_ayah' => 'trim|sanitize_string',
			'pekerjaan_ayah'  => 'trim|sanitize_string',
			'gaji_ayah'       => 'trim|sanitize_string',
			'kebutuhan_ayah'  => 'trim|sanitize_string',
			'nama_ibu'        => 'trim|sanitize_string',
			'nik_ibu'         => 'trim|sanitize_numbers',
			'thn_lahir_ibu'   => 'trim|sanitize_numbers',
			'pendidikan_ibu'  => 'trim|sanitize_string',
			'pekerjaan_ibu'   => 'trim|sanitize_string',
			'gaji_ibu'        => 'trim|sanitize_string',
			'kebutuhan_ibu'   => 'trim|sanitize_string',
			'nama_wali'       => 'trim|sanitize_string',
			'nik_wali'        => 'trim|sanitize_numbers',
			'thn_lahir_wali'  => 'trim|sanitize_numbers',
			'pendidikan_wali' => 'trim|sanitize_string',
			'pekerjaan_wali'  => 'trim|sanitize_string',
			'gaji_wali'       => 'trim|sanitize_string',
			'kebutuhan_wali'  => 'trim|sanitize_string',
		));
		$valid = $gump->run($_POST);
		if($valid === false){
			$error[] = $gump->get_readable_errors(true);
		}else{
			$sqlo = $db->prepare("INSERT INTO us_ortu SET ot_siswa = ?, ot_nama_ayah = ?, ot_nik_ayah = ?, ot_thn_lahir_ayah = ?, ot_pendidikan_ayah = ?, ot_pekerjaan_ayah = ?, ot_gaji_ayah = ?, ot_kebutuhan_ayah = ?, ot_nama_ibu = ?, ot_nik_ibu = ?, ot_thn_lahir_ibu = ?, ot_pendidikan_ibu = ?, ot_pekerjaan_ibu = ?, ot_gaji_ibu = ?, ot_kebutuhan_ibu = ?, ot_nama_wali = ?, ot_nik_wali = ?, ot_thn_lahir_wali = ?, ot_pendidikan_wali = ?, ot_pekerjaan_wali = ?, ot_gaji_wali = ?, ot_kebutuhan_wali = ?");
			$sqlo->bindParam(1, $_SESSION['idSiswa']);
			$sqlo->bindParam(2, $_POST['nama_ayah']);
			$sqlo->bindParam(3, $_POST['nik_ayah']);
			$sqlo->bindParam(4, $_POST['thn_lahir_ayah']);
			$sqlo->bindParam(5, $_POST['pendidikan_ayah']);
			$sqlo->bindParam(6, $_POST['pekerjaan_ayah']);
			$sqlo->bindParam(7, $_POST['gaji_ayah']);
			$sqlo->bindParam(8, $_POST['kebutuhan_ayah']);
			$sqlo->bindParam(9, $_POST['nama_ibu']);
			$sqlo->bindParam(10, $_POST['nik_ibu']);
			$sqlo->bindParam(11, $_POST['thn_lahir_ibu']);
			$sqlo->bindParam(12, $_POST['pendidikan_ibu']);
			$sqlo->bindParam(13, $_POST['pekerjaan_ibu']);
			$sqlo->bindParam(14, $_POST['gaji_ibu']);
			$sqlo->bindParam(15, $_POST['kebutuhan_ibu']);
			$sqlo->bindParam(16, $_POST['nama_wali']);
			$sqlo->bindParam(17, $_POST['nik_wali']);
			$sqlo->bindParam(18, $_POST['thn_lahir_wali']);
			$sqlo->bindParam(19, $_POST['pendidikan_wali']);
			$sqlo->bindParam(20, $_POST['pekerjaan_wali']);
			$sqlo->bindParam(21, $_POST['gaji_wali']);
			$sqlo->bindParam(22, $_POST['kebutuhan_wali']);
			if(!$sqlo->execute()){
				print_r($sqlo->errorInfo());
			}else{
				?><script>
                        swal({ 
                            title: "Berhasil",
                            text: "Data wali anda berhasil disimpan",
                            type: "success" 
                        },
                        function(){
                            window.location.href = 'index.php?mod=ppdb&hal=wali';
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
				<h3 class="box-title"><i class="fa fa-users"></i> DATA WALI</h3>
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
				<form class="form-horizontal" action="" method="post">
					<div class="form-group">
						<label class="col-sm-4 control-label">DATA AYAH KANDUNG</label>
						<div class="col-sm-6"></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama Ayah Kandung</label>
						<div class="col-sm-6">
							<input type="hidden" name="siswa" value="<?=$_SESSION['idSiswa'];?>">
							<input type="text" name="nama_ayah" class="form-control" required>
							<p class="help-text">Nama lengkap tanpa gelar</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">NIK Ayah</label>
						<div class="col-sm-6">
							<input type="number" name="nik_ayah" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tahun Lahir</label>
						<div class="col-sm-3">
							<input type="number" name="thn_lahir_ayah" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pendidikan</label>				
						<div class="col-sm-4">
							<select name="pendidikan_ayah" class="form-control" required>
								<option value="">-- Pilih Pendidikan --</option>
								<?php
									$sqlp = $db->prepare("SELECT pend_id, pend_kd, pend_nama FROM us_pendidikan ORDER BY pend_id ASC");
									$sqlp->execute();
									foreach($sqlp->fetchAll() as $row){ ?>
										<option value="<?= $row['pend_kd'].')'.$row['pend_nama'];?>"><?= $row['pend_kd'].')'.$row['pend_nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pekerjaan</label>
						<div class="col-sm-4">
							<select name="pekerjaan_ayah" class="form-control" required>
								<option value="">-- Pilih Pekerjaan --</option>
								<?php
									$sqlpp = $db->prepare("SELECT * FROM us_pekerjaan ORDER BY pekerjaan_id ASC");
									$sqlpp->execute();
									foreach($sqlpp->fetchAll() as $row){ ?>
								<option value="<?= $row['pekerjaan_kd'].')'.$row['pekerjaan_nama'];?>"><?= $row['pekerjaan_kd'].')'.$row['pekerjaan_nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Penghasilan bulanan</label>
						<div class="col-sm-4">
							<select name="gaji_ayah" class="form-control" required>
								<option value="">-- Pilih Penghasilan --</option>
								<?php
									$sqlg = $db->prepare("SELECT gaji_id, gaji_kode, gaji_nama FROM us_penghasilan ORDER BY gaji_id ASC");
									if(!$sqlg->execute()){
										print_r($sqlg->errorInfo());
									}else{
									foreach($sqlg->fetchAll() as $gaji){ ?>
										<option value="<?= $gaji['gaji_kode'].') '.$gaji['gaji_nama'];?>"><?= $gaji['gaji_kode'].') '.$gaji['gaji_nama'];?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Berkebutuhan khusus</label>
						<div class="col-sm-4">
							<select name="kebutuhan_ayah" class="form-control" required>
								<option value="">-- Pilih jenis kebutuhan khusus</option>
								<?php
									$sqlk = $db->prepare("SELECT kebutuhan_id, kebutuhan_kd, kebutuhan_nama FROM us_kebutuhan ORDER BY kebutuhan_id ASC");
									$sqlk->execute();
									foreach($sqlk->fetchAll() as $row){ ?>
										<option value="<?= $row['kebutuhan_kd'].')'.$row['kebutuhan_nama'];?>"><?= $row['kebutuhan_kd'].')'.$row['kebutuhan_nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<!-- DATA IBU -->
					<div class="form-group">
						<label class="col-sm-4 control-label">DATA IBU KANDUNG</label>
						<div class="col-sm-6"></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama Ibu Kandung</label>
						<div class="col-sm-6">
							<input type="text" name="nama_ibu" class="form-control" required>
							<p class="help-text">Nama lengkap tanpa gelar</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">NIK Ibu</label>
						<div class="col-sm-6">
							<input type="number" name="nik_ibu" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tahun Lahir</label>
						<div class="col-sm-3">
							<input type="number" name="thn_lahir_ibu" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pendidikan</label>				
						<div class="col-sm-4">
							<select name="pendidikan_ibu" class="form-control" required>
								<option value="">-- Pilih Pendidikan --</option>
								<?php
									$sqlp = $db->prepare("SELECT pend_id, pend_kd, pend_nama FROM us_pendidikan ORDER BY pend_id ASC");
									$sqlp->execute();
									foreach($sqlp->fetchAll() as $row){ ?>
										<option value="<?= $row['pend_kd'].')'.$row['pend_nama'];?>"><?= $row['pend_kd'].')'.$row['pend_nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pekerjaan</label>
						<div class="col-sm-4">
							<select name="pekerjaan_ibu" class="form-control" required>
								<option value="">-- Pilih Pekerjaan --</option>
								<?php
									$sqlpp = $db->prepare("SELECT * FROM us_pekerjaan ORDER BY pekerjaan_id ASC");
									$sqlpp->execute();
									foreach($sqlpp->fetchAll() as $row){ ?>
								<option value="<?= $row['pekerjaan_kd'].')'.$row['pekerjaan_nama'];?>"><?= $row['pekerjaan_kd'].')'.$row['pekerjaan_nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Penghasilan bulanan</label>
						<div class="col-sm-4">
							<select name="gaji_ibu" class="form-control" required>
								<option value="">-- Pilih Penghasilan --</option>
								<?php
									$sqlg = $db->prepare("SELECT gaji_id, gaji_kode, gaji_nama FROM us_penghasilan ORDER BY gaji_id ASC");
									if(!$sqlg->execute()){
										print_r($sqlg->errorInfo());
									}else{
									foreach($sqlg->fetchAll() as $gaji){ ?>
										<option value="<?= $gaji['gaji_kode'].') '.$gaji['gaji_nama'];?>"><?= $gaji['gaji_kode'].') '.$gaji['gaji_nama'];?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Berkebutuhan khusus</label>
						<div class="col-sm-4">
							<select name="kebutuhan_ibu" class="form-control" required>
								<option value="">-- Pilih jenis kebutuhan khusus</option>
								<?php
									$sqlk = $db->prepare("SELECT kebutuhan_id, kebutuhan_kd, kebutuhan_nama FROM us_kebutuhan ORDER BY kebutuhan_id ASC");
									$sqlk->execute();
									foreach($sqlk->fetchAll() as $row){ ?>
										<option value="<?= $row['kebutuhan_kd'].')'.$row['kebutuhan_nama'];?>"><?= $row['kebutuhan_kd'].')'.$row['kebutuhan_nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<!-- DATA WALI -->
					<div class="form-group">
						<label class="col-sm-4 control-label">DATA WALI</label>
						<div class="col-sm-6"></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nama Wali</label>
						<div class="col-sm-6">
							<input type="text" name="nama_wali" class="form-control" required>
							<p class="help-text">Nama lengkap tanpa gelar</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">NIK Wali</label>
						<div class="col-sm-6">
							<input type="number" name="nik_wali" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Tahun Lahir</label>
						<div class="col-sm-3">
							<input type="number" name="thn_lahir_wali" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pendidikan</label>				
						<div class="col-sm-4">
							<select name="pendidikan_wali" class="form-control" required>
								<option value="">-- Pilih Pendidikan --</option>
								<?php
									$sqlp = $db->prepare("SELECT pend_id, pend_kd, pend_nama FROM us_pendidikan ORDER BY pend_id ASC");
									$sqlp->execute();
									foreach($sqlp->fetchAll() as $row){ ?>
										<option value="<?= $row['pend_kd'].')'.$row['pend_nama'];?>"><?= $row['pend_kd'].')'.$row['pend_nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Pekerjaan</label>
						<div class="col-sm-4">
							<select name="pekerjaan_wali" class="form-control" required>
								<option value="">-- Pilih Pekerjaan --</option>
								<?php
									$sqlpp = $db->prepare("SELECT * FROM us_pekerjaan ORDER BY pekerjaan_id ASC");
									$sqlpp->execute();
									foreach($sqlpp->fetchAll() as $row){ ?>
								<option value="<?= $row['pekerjaan_kd'].')'.$row['pekerjaan_nama'];?>"><?= $row['pekerjaan_kd'].')'.$row['pekerjaan_nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Penghasilan bulanan</label>
						<div class="col-sm-4">
							<select name="gaji_wali" class="form-control" required>
								<option value="">-- Pilih Penghasilan --</option>
								<?php
									$sqlg = $db->prepare("SELECT gaji_id, gaji_kode, gaji_nama FROM us_penghasilan ORDER BY gaji_id ASC");
									if(!$sqlg->execute()){
										print_r($sqlg->errorInfo());
									}else{
									foreach($sqlg->fetchAll() as $gaji){ ?>
										<option value="<?= $gaji['gaji_kode'].') '.$gaji['gaji_nama'];?>"><?= $gaji['gaji_kode'].') '.$gaji['gaji_nama'];?></option>
								<?php } } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Berkebutuhan khusus</label>
						<div class="col-sm-4">
							<select name="kebutuhan_wali" class="form-control" required>
								<option value="">-- Pilih jenis kebutuhan khusus</option>
								<?php
									$sqlk = $db->prepare("SELECT kebutuhan_id, kebutuhan_kd, kebutuhan_nama FROM us_kebutuhan ORDER BY kebutuhan_id ASC");
									$sqlk->execute();
									foreach($sqlk->fetchAll() as $row){ ?>
										<option value="<?= $row['kebutuhan_kd'].')'.$row['kebutuhan_nama'];?>"><?= $row['kebutuhan_kd'].')'.$row['kebutuhan_nama'];?></option>
								<?php } ?>
							</select>
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
<?php
	}else{ ?>
<div class="row">
	<div class="col-md-10">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-users"></i> DATA WALI</h3>
			</div>
			<div class="box-body">
				
				<dl class="dl-horizontal">
					<h5>Data Ayah</h5>
					<dt>Nama Ayah Kandung</dt>
					<dd><?= $ot['ot_nama_ayah'];?></dd>
					<dt>NIK Ayah</dt>
					<dd><?= $ot['ot_nik_ayah'];?></dd>
					<dt>Tahun Lahir</dt>
					<dd><?= $ot['ot_thn_lahir_ayah'];?></dd>
					<dt>Pendidikan</dt>
					<dd><?= $ot['ot_pendidikan_ayah'];?></dd>
					<dt>Pekerjaan</dt>
					<dd><?= $ot['ot_pekerjaan_ayah'];?></dd>
					<dt>Penghasilan bulanan</dt>
					<dd><?= $ot['ot_gaji_ayah'];?></dd>
					<dt>Berkebutuhan khusus</dt>
					<dd><?= $ot['ot_kebutuhan_ayah'];?></dd>
					<!-- Nama Ibu -->
					<h5>Data Ibu</h5>
					<dt>Nama Ibu Kandung</dt>
					<dd><?= $ot['ot_nama_ibu'];?></dd>
					<dt>NIK Ibu</dt>
					<dd><?= $ot['ot_nik_ibu'];?></dd>
					<dt>Tahun Lahir</dt>
					<dd><?= $ot['ot_thn_lahir_ibu'];?></dd>
					<dt>Pendidikan</dt>
					<dd><?= $ot['ot_pendidikan_ibu'];?></dd>
					<dt>Pekerjaan</dt>
					<dd><?= $ot['ot_pekerjaan_ibu'];?></dd>
					<dt>Penghasilan bulanan</dt>
					<dd><?= $ot['ot_gaji_ibu'];?></dd>
					<dt>Berkebutuhan khusus</dt>
					<dd><?= $ot['ot_kebutuhan_ibu'];?></dd>
					<!-- Nama Wali -->
					<h5>Data Wali</h5>
					<dt>Nama Wali</dt>
					<dd><?= $ot['ot_nama_wali'];?></dd>
					<dt>NIK Wali</dt>
					<dd><?= $ot['ot_nik_wali'];?></dd>
					<dt>Tahun Lahir</dt>
					<dd><?= $ot['ot_thn_lahir_wali'];?></dd>
					<dt>Pendidikan</dt>
					<dd><?= $ot['ot_pendidikan_wali'];?></dd>
					<dt>Pekerjaan</dt>
					<dd><?= $ot['ot_pekerjaan_wali'];?></dd>
					<dt>Penghasilan bulanan</dt>
					<dd><?= $ot['ot_gaji_wali'];?></dd>
					<dt>Berkebutuhan khusus</dt>
					<dd><?= $ot['ot_kebutuhan_wali'];?></dd>
				</dl>
				<a href="index.php?mod=ppdb&hal=wali_ed&tingal=<?=$token;?>" class="btn btn-primary"><i class="fa fa-pencil"></i> PERBARUI DATA</a>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>