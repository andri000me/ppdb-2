<?php
    require('config/database.php');
    require('config/fungsi.php');
    require('config/gump.class.php');

    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: index.php');
    }
    //ambil session
    $username = $_SESSION['username'];
    $pass     = $_SESSION['pass'];
    $nama     = $_SESSION['nama'];

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
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/plugins/font-awesome/css/font-awesome.min.css">  
    <link rel="stylesheet" href="asset/css/AdminLTE.min.css">
    <link rel="stylesheet" href="asset/css/skin-blue.min.css">
    <link rel="stylesheet" href="asset/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="asset/plugins/datepicker/datepicker3.css">  
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- jQuery 2.2.3 -->
    <script src="asset/js/jquery.min.js"></script> 
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="asset/plugins/sweetalert/sweetalert.css">
    <script src="asset/plugins/sweetalert/sweetalert.min.js"></script>
    <style type="text/css">
        .dataTables_filter {
          /*float: left !important;*/
        }    
        .sidebar .sidebar-menu .active .treeview-menu {
          display: block;
        }
        .ok{
            border-radius: 3px;
            background: #f4f4f4;
            margin-left: 65px;
            margin-right: 15px;
            padding: 10px;
            margin-bottom: 15px;            
        }
        .ok p{
            font-size: 16px;
        }        
    </style>     
</head>
<body class="hold-transition skin-blue layout-top-nav">
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
                        $_SESSION['email']    = $l['siswa_email'];
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
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="index.php" class="navbar-brand">PPDB SMK Mahadhika 3</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>                    
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">

                    </div>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="login.php"><i class="fa fa-key"></i> LOGIN PPDB</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Selamat datang <?= $nama;?></h3>
                                </div>
                                <div class="box-body">
                                    <p style="font-size: 16px;">
                                        Berikut informasi login anda<br>
                                        Username: <span class="text-red"><?= $username;?></span><br>
                                        Password: <span class="text-red"><?= $pass;?></span><br>
                                        Silahkan login untuk melengkapi berkas serta melihat status pendaftaran anda.
                                    </p>
                                    <p class="text-red">Simpan username dan password ini, karena informasi ini hanya akan ditampilkan satu kali</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Login PPDB Panel</h3>
                                </div>
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
                                    <form method="post" action="" class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Username</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="username" class="form-control" value="<?=$username;?>" onfocus="this.removeAttribute('readonly');" required>                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Password</label>
                                            <div class="col-sm-6">
                                                <input type="password" name="password" class="form-control" value="<?=$pass;?>" id="password" data-toggle="password" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"></label>
                                            <div class="col-sm-6">
                                                <button type="submit" class="btn btn-success" name="simpan"><i class="fa fa-lock"></i> Login</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <a href="https://ucu.suryadi.my.id" target="_blank">nolbyte</a>
                </div>
                <strong>Copyright &copy; 2020 <a href="http://smk3.mahadhika.sch.id">SMK Mahadhika 3</a>.</strong> All rights reserved.
            </div>        
        </footer>
    </div>
    <script src="asset/js/bootstrap.min.js"></script>
  <script src="asset/js/adminlte.min.js"></script>
  <script src="asset/js/demo.js"></script>
  <!--<script src="../assets/js/typeahead.bundle.js"></script>-->
  <script src="asset/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="asset/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="asset/plugins/fastclick/fastclick.js"></script>
  <script src="asset/plugins/bootbox/bootbox.min.js"></script>
  <!--<script src="../assets/plugins/jquery.mask.js"></script>-->
  <script src="asset/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
</body>
</html>