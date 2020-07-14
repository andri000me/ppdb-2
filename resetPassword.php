<?php
	require_once('config/database.php');
	require_once('config/fungsi.php');
	//jumlah hash passwordnya
	$options = [
	'cost' => 12,
	];

	$a = $db->prepare("SELECT resetToken, resetComplete FROM us_login resetToken = :token");
	$a->execute(array(':token' => $_GET['key']));
	$row=$a->fetch(PDO::FETCH_ASSOC);
	if(empty($row['resetToken'])){
		$stop = 'Token salah, mohon gunakan token yang dikirim ke email.';
	}elseif($row['resetComplete'] == 'Yes') {
		$stop = 'Password anda telah dirubah!';
	}
	if(isset($_POST['ganti'])){
		if(strlen($_POST['password']) < 3){
			$error[] = 'Password terlalu pendek. Minimal 6 karakter';
		}
		
		if(strlen($_POST['passwordConfirm']) < 3){
			$error[] = 'Confirm password terlalu pendek. Minimal 6 karakter';
		}
		
		if($_POST['password'] != $_POST['passwordConfirm']){
			$error[] = 'Passwords tidak sama.';
		}
		if(!isset($error)){
			$pass = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
			try{
				$b = $db->prepare("UPDATE us_login SET password = :pass, resetComplete = 'Yes' WHERE resetToken = :token");
				$b->execute(array(
					'pass' => $pass,
					'resetToken' => $row['resetToken']
				));
				//redirect to index page
				header('Location: index.php?action=resetAccount');
				exit;
				} catch(PDOException $e) {
				$error[] = $e->getMessage();
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PPDB <?= $skl['sekolah_nama'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">    
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">  
    <!-- jQuery -->
    <script src="assets/js/jquery-2.2.3.min.js"></script>  
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="assets/plugins/sweetalert/sweetalert.css">
    <script src="assets/plugins/sweetalert/sweetalert.min.js"></script>    
</head>
<body class="hold-transition login-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="#"><b>RESET PASSWORD</b></a>
        </div>
        <div class="register-box-body">
            <p class="login-box-msg">Reset password dengan email terdaftar</p>
            <?php
            if(isset($error)){
                foreach($error as $error){
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Galat</h4>
                        <?php echo $error; ?>
                        <meta http-equiv="refresh" content="2">
                    </div>
                    <?php
                }
            }
            if(isset($stop)){
            ?>
            <div class="alert alert-danger alert-dismissible">
            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            	<h4><i class="icon fa fa-ban"></i> Galat</h4>
            	<?php echo $stop; ?>
            	<meta http-equiv="refresh" content="2">
            </div>
        <?php }else{ ?>
            <form action="" method="post">                
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password minimal 6 karakter" pattern=".{6,}" title="Minimal 6 karakter password" required>
                    <span class="fa fa-lock form-control-feedback"></span>                    
                </div> 
                <div class="form-group has-feedback">
                    <input type="password" name="passwordConfirm" class="form-control" placeholder="Password minimal 6 karakter" pattern=".{6,}" title="Minimal 6 karakter password" required>
                    <span class="fa fa-lock form-control-feedback"></span>                    
                </div>               
                <div class="row">
                    <div class="col-xs-8">
                        
                    </div>        
                    <div class="col-xs-4">
                        <button type="submit" name="ganti" class="btn btn-success"><i class="fa fa-unlock"></i> Ganti Password</button>
                    </div>
                </div>
            </form>
        <?php } ?>            
        </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
    <!--Show Password-->
    <script src="assets/js/bootstrap-show-password.js"></script>    
    <!-- AdminLTE App -->
    <script src="assets/js/app.min.js"></script>
</body>
</html>