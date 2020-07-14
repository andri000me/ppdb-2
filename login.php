<?php
    require('config/database.php');
    require('config/fungsi.php');
    require('config/gump.class.php');

    session_start();
    
    $sql = $db->prepare("SELECT sekolah_nama FROM us_sekolah");
    $sql->execute();
    $skl = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PPDB <?= $skl['sekolah_nama'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="asset/plugins/font-awesome/css/font-awesome.min.css">    
    <!-- Theme style -->
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/AdminLTE.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">  
    <!-- jQuery -->
    <script src="asset/js/jquery.min.js"></script>  
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="asset/plugins/sweetalert/sweetalert.css">
    <script src="asset/plugins/sweetalert/sweetalert.min.js"></script>     
</head>
<body class="hold-transition login-page">
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $gump = new GUMP();
            $username = $_POST['username'];
            $password = $_POST['password'];
            $_POST = array(
                'username'    => $username,
                'password' => $password
            );
            $_POST = $gump->sanitize($_POST);
            $gump->validation_rules(array(
                'username'    => 'required',
                'password' => 'required|min_len,8'
            ));
            $gump->filter_rules(array(
                'username' => 'trim|sanitize_string'
            ));
            $boleh = $gump->run($_POST);
            if($boleh === false){
                $error[] = $gump->get_readable_errors(true);
            }else{
                $sqll = $db->prepare("SELECT * FROM us_pendaftar WHERE siswa_no_daftar = :username");
                $sqll->execute(array(':username' => $username));
                $l = $sqll->fetch(PDO::FETCH_ASSOC);
                if($l){
                    if(password_verify($password, $l['siswa_password'])){
                        $_SESSION['idSiswa']  = $l['siswa_id'];
                        $_SESSION['nama']     = $l['siswa_nama'];                        
                        $_SESSION['noDaftar'] = $l['siswa_no_daftar'];
                        header("Location: siswa/index.php");
                    }else{
                        $error[] = 'Username/Password salah';
                    }
                }else{
                    $error[] = 'Username/Password tidak ditemukan';
                }
            }

        }
    ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>PPDB PANEL</b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Silahkan login untuk memulai</p>
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
            //action
            if(isset($_GET['action'])){                
                                        //check the action
                switch ($_GET['action']) {
                    case 'active':
                    echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
                    break;
                    case 'reset':
                    echo "
                    <div class=\"alert alert-success\">                                         
                    <h4><i class=\"icon fa fa-check\"></i> Sukses!</h4>
                    Kode reset telah dikirim. Silahkan cek email anda.                                          
                    </div>
                    ";
                    break;
                    case 'resetAccount':
                    echo "
                    <div class=\"alert alert-success\">                                         
                    <h4><i class=\"icon fa fa-check\"></i> Sukses!</h4>
                    Password telah diganti. Silahkan login.                                         
                    </div>
                    ";
                    break;
                }

            }
            ?>
            <form action="" method="post">
                <div class="form-group has-feedback">
                    <input type="text" name="username" class="form-control" placeholder="Nomor Pendaftaran" onfocus="this.removeAttribute('readonly');" required>
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" id="password" data-toggle="password" autocomplete="new-password" required>                    
                </div>
                <div class="row">                    
                    <div class="col-xs-8">
                        <a href="index.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock"></i> Sign In</button>
                    </div>
                </div>
            </form>
              <!--<b>Belum punya akun?<a href="register.php"> Buat Akun</a></b><br>
            <b>Lupa password?<a href="reset.php"> Reset</a></b>-->
        </div>
    </div>
    <!-- Bootstrap 4 -->
    <script src="asset/js/bootstrap.min.js"></script>   
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>    
</body>
</html>