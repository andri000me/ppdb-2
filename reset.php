<?php
    require('config/database.php');
    require('config/fungsi.php');
    require('config/gump.class.php');

    //option password
    $options = [
    'cost' => 12,
    ];

    $sql = $db->prepare("SELECT sekolah_nama FROM us_sekolah");
    $sql->execute();
    $skl = $sql->fetch(PDO::FETCH_ASSOC);
    //proses reset
    if(isset($_POST['reset'])){
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $error[] = 'Masukkan alamat email yang benar';
        }else{
            $sqlr = $db->prepare("SELECT login_email FROM us_login WHERE login_email = :email");
            $sqlr->execute(array(':email' => $_POST['email']));
            $r = $sqlr->fetch(PDO::FETCH_ASSOC);
            if($r['login_email'] != $_POST['email']){
                $error[] = 'Email yang anda masukkan salah/tidak terdaftar.';
            }
        }

        if(!isset($error)){
            //create code
            //create the activasion code
            $token = md5(uniqid(rand(),true));
            
            try {
                
                $stmt = $db->prepare("UPDATE us_login SET resetToken = :token, resetComplete='No' WHERE login_email = :email");
                $stmt->execute(array(
                ':email' => $r['login_email'],
                ':token' => $token
                ));
                
                //send email
                $to = $r['login_email'];
                $subject = "Password Reset";
                $body = "<p>Seseorang telah meminta untuk mereset password.</p>
                <p>Jika itu bukan anda, abaikan email ini dan tidak akan terjadi apa-apa.</p>
                <p>Untuk mereset password, Kunjungi alamat berikut: <a href='".DIR."resetPassword.php?key=$token'>".DIR."resetPassword.php?key=$token</a></p>";
                
                $mail = new Mail();
                $mail->setFrom(SITEEMAIL);
                $mail->addAddress($to);
                $mail->subject($subject);
                $mail->body($body);
                $mail->send();
                
                //redirect to index page
                header('Location: index.php?action=reset');
                exit;
                
                //else catch the exception and show the error.
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
            ?>
            <form action="" method="post">                
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <span class="fa fa-envelope form-control-feedback"></span>
                    <p class="help-text">Masukkan alamat email yang digunakan saat mendaftar</p>
                </div>                
                <div class="row">
                    <div class="col-xs-8">
                        
                    </div>        
                    <div class="col-xs-4">
                        <button type="submit" name="reset" class="btn btn-primary btn-block"><i class="fa fa-unlock"></i> Daftar</button>
                    </div>
                </div>
            </form>
            <b>Sudah punya akun?<a href="index.php"> Login</a></b>
        </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
    <!--Show Password-->
    <script src="assets/js/bootstrap-show-password.js"></script>    
    <!-- AdminLTE App -->
    <script src="assets/js/app.min.js"></script>
</body>
</html>