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
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $gump = new GUMP();

            $nama     = $_POST['nama'];
            $email    = $_POST['email'];
            $password = $_POST['password'];

            $_POST = array(
                'nama'     => $nama,
                'email'    => $email,
                'password' => $password
            );

            $_POST = $gump->sanitize($_POST);

            $gump->validation_rules(array(
                'nama'     => 'required',
                'email'    => 'required|valid_email',
                'password' => 'required|min_len,6'
            ));
            $gump->filter_rules(array(
                'nama'  => 'trim|sanitize_string',
                'email' => 'trim|sanitize_email'
            ));
            $validasi = $gump->run($_POST);
            if($validasi === false){
                $error[] = $gump->get_readable_errors(true);
            }else{
                $sqla = $db->prepare("SELECT login_email FROM us_login");
                $sqla->execute();
                $m = $sqla->fetch(PDO::FETCH_ASSOC);
                if($m['login_email'] === $_POST['email']){
                    $error[] = 'Alamat email telah terdaftar. Mohon ulangi pendaftaran';
                }else{
                    $tgl = date("dmy");
                    $u = $db->prepare("SELECT max(login_id) as maxID FROM us_login");
                    $u->execute();
                    $n = $u->fetch(PDO::FETCH_ASSOC);
                    $nu = $n['maxID'];
                    $urut = (int) substr($nu, 3, 3);
                    $urut++;
                    $no_daftar = 'PPDB/M3.20/'.$tgl.'-'.sprintf('%04s', $urut);
                    $passwd = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
                    $sql = $db->prepare("INSERT INTO us_login SET login_nama = ?, login_email = ?, login_password = ?, login_no_daftar = ?");
                    $sql->bindParam(1, $nama);
                    $sql->bindParam(2, $email);
                    $sql->bindParam(3, $passwd);
                    $sql->bindParam(4, $no_daftar);
                    if(!$sql->execute()){
                        print_r($sql->errorInfo());
                    }else{
                        ?><script>
                            swal({ 
                                title: "Pendaftaran Berhasil",
                                text: "Silahkan login untuk melanjutkan",
                                type: "success" 
                            },
                            function(){
                                window.location.href = 'index.php';
                            });
                        </script><?php
                    }
                }
            }

        }
    ?>
    <div class="register-box">
        <div class="register-logo">
            <a href="#"><b>REGISTER PPDB</b></a>
        </div>
        <div class="register-box-body">
            <p class="login-box-msg">Buat Akun PPDB</p>
            <?php 
                if(isset($error)){
                    foreach ($error as $error) {
                    ?>
                        <div class="alert alert-warning">
                            <h5><i class="fa fa-warning"></i> Galat</h5>
                            <?= $error;?>
                            <meta http-equiv="refresh" content="2">
                        </div>
                    <?php
                    }
                }
            ?>
            <form action="" method="post">
                <div class="form-group has-feedback">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                    <span class="fa fa-user form-control-feedback"></span>
                    <p class="help-text">Masukkan nama lengkap sesuai KTP/KK</p>
                </div>
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <span class="fa fa-envelope form-control-feedback"></span>
                    <p class="help-text">Masukkan alamat email yang aktif dan valid</p>
                </div>
                <div class="form-group has-feedback">
                    <input pattern=".{6,10}" type="password" name="password" class="form-control" placeholder="Password" required oninvalid="this.setCustomValidity('Password diisi minimal 6 karakter')" onchange="try{setCustomValidity('')}catch(e){}" id="password" data-toggle="password" required>
                    <p class="help-text">Password minimal 6 karakter</p>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        
                    </div>        
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock"></i> Daftar</button>
                    </div>
                </div>
            </form>
            <b>Sudah punya akun?<a href="index.php"> Login</a></b><br>
            <!--<b>Lupa password?<a href="reset.php"> Reset</a></b>-->
        </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
    <!--Show Password-->
    <script src="assets/js/bootstrap-show-password.js"></script>    
    <!-- AdminLTE App -->
    <script src="assets/js/app.min.js"></script>
</body>
</html>