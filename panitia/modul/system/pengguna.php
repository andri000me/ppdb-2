<?php
	defined("RESMI") or die("error");
	//option password
    $options = [
    'cost' => 12,
    ];
    //ubah Nama
    if(isset($_POST['simpan'])){
    	$gump = new GUMP();
		$idna    = $_POST['idna'];
		$userna  = $_POST['userna'];
		$ngarana = $_POST['ngarana'];
    	$_POST = array(
			'idna'    => $idna,
			'userna'  => $userna,
			'ngarana' => $ngarana
    	);
    	$gump->filter_rules(array(
			'idna'    => 'trim|sanitize_numbers',
			'userna'  => 'trim|sanitize_string',
			'ngarana' => 'trim|sanitize_string'
    	));
    	$ok = $gump->run($_POST);
    	if($ok === false){
    		$error[] = $gump->get_readable_errors(true);
    	}else{
    		$sql = $db->prepare("UPDATE us_adm SET adm_login = ?, adm_nama = ? WHERE id_adm = ?");
    		$sql->bindParam(1, $userna);
    		$sql->bindParam(2, $ngarana);
    		$sql->bindParam(3, $idna);
    		if(!$sql->execute()){
                print_r($sql->errorInfo());
            }else{
                ?><script>
                    swal({ 
                        title: "Berhasil",
                        text: "Data pribadi anda berhasil disimpan",
                        type: "success" 
                    },
                    function(){
                        window.location.href = 'index.php?mod=system&hal=pengguna';
                    });
                    </script><?php
            }
    	}
    }
    if(isset($_POST['simpan_pass'])){
        $gump         = new GUMP();
        $user         = $_POST['user'];
        $password     = $_POST['password'];
        $password_two = $_POST['password_two'];
        $_POST = array(
            'user'         => $user,
            'password'     => $password,
            'password_two' => $password_two
        );

        $_POST = $gump->sanitize($_POST);
        $gump->validation_rules(array(
            'user'         => 'required',
            'password'     => 'required|min_len,8|max_len,10',
            'password_two' => 'required|min_len,8|max_len,10'
        ));
        $gump->filter_rules(array(
            'user'     => 'trim|sanitize_string',
            'password' => 'trim'
        ));
        $ok = $gump->run($_POST);
        if($ok === false){
            $error[] = $gump->get_readable_errors(true);
        }else{
            $pass = password_hash($password, PASSWORD_BCRYPT, $options);
            $sql = $db->prepare("UPDATE us_adm SET adm_pass = ? WHERE id_adm = ?");
            $sql->bindParam(1, $pass);
            $sql->bindParam(2, $user);
            if(!$sql->execute()){
                print_r($sql->errorInfo());
            }else{
                ?><script>
                    swal({ 
                        title: "Berhasil",
                        text: "Password berhasil disimpan",
                        type: "success" 
                    },
                    function(){
                        window.location.href = 'index.php?mod=system&hal=pengguna';
                    });
                    </script><?php
            }
        }
    }
?>
<div class="row">
	<div class="col-md-8 col-xs-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-user"></i> Profile Pengguna
			</div>
			<div class="box-body">
				<?php
					if(isset($error)){                   
                        foreach($error as $galat){ ?>
                            <div class="alert alert-danger">                       
                                <h4><i class="icon fa fa-ban"></i> Galat</h4>
                                <?php echo $galat; ?>
                                <meta http-equiv="refresh" content="5">
                            </div>
                        <?php
                        }                                      
                    }
					$sql = $db->prepare("SELECT id_adm, adm_login, adm_pass, adm_nama FROM us_adm WHERE id_adm = :idna");
					$sql->execute(array(':idna' => $_SESSION['admID']));
					$adm = $sql->fetch(PDO::FETCH_ASSOC);
				?>
				<form method="post" action="" class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3">Username Login</label>
						<div class="col-md-4">
							<input type="hidden" name="idna" value="<?=$adm['id_adm'];?>">
							<input type="text" class="form-control" name="userna" value="<?=$adm['adm_login'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">Nama Lengkap</label>
						<div class="col-md-4">							
							<input type="text" class="form-control" name="ngarana" value="<?=$adm['adm_nama'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3"></label>
						<div class="col-md-4">							
							<button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-floppy-o"></i> Ganti Profile</button>
						</div>
					</div>
				</form>
				<hr>
                <h4 class="box-title"><i class="fa fa-lock"></i> Ubah Password</h4>
                <form method="post" action="" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Password Baru</label>
                        <div class="col-md-5">
                        	<input type="hidden" name="user" value="<?=$adm['id_adm'];?>">
                            <input class="form-control" id="password" name="password" type="password" pattern="^\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Harus memiliki minimal 8 karakter' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Password" required>
                            <p class="help-text">Password minimal 8 karakter</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Ulangi Password</label>
                        <div class="col-md-5">                            
                            <input class="form-control" id="password_two" name="password_two" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Password tidak sama dengan kolom sebelumnya' : '');" placeholder="Ulangi Password" required>
                            <p class="help-text">Password minimal 8 karakter, sama dengan kolom sebelumnya</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-5">
                            <button type="submit" name="simpan_pass" class="btn btn-info"><i class="fa fa-floppy-o"></i> Ganti Password</button>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>