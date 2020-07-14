<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    define("RESMI", "OK");

    if(!isset($_SESSION['idSiswa'])){
        header("Location: ../index.php");
    }    

    //konfigurasi
    require('../config/database.php');
    require('../config/fungsi.php');
    require('../config/gump.class.php');
    if(isset($_GET['mod'])){
        $mod = sanitasi($_GET['mod']);
        $hal = sanitasi($_GET['hal']);
    }
    $sql = $db->prepare("SELECT * FROM us_sekolah");
    $sql->execute();
    $skl = $sql->fetch(PDO::FETCH_ASSOC);
    //ambil data Siswa
    $s = $db->prepare("SELECT * FROM us_pendaftar up 
        JOIN us_jurusan uj ON up.siswa_jurusan=uj.jurusan_id
        WHERE siswa_id = :id");
    $s->execute(array(':id' => $_SESSION['idSiswa']));
    $sis = $s->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html style="height: auto;">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PPDB <?= $skl['sekolah_nama'];?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta http-equiv="refresh" content="500;url=logout.php" />
  <link rel="stylesheet" href="../asset/css/bootstrap.min.css">
  <link rel="stylesheet" href="../asset/plugins/font-awesome/css/font-awesome.min.css">  
  <link rel="stylesheet" href="../asset/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../asset/css/skin-blue.min.css">
  <link rel="stylesheet" href="../asset/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="..asset/plugins/datepicker/datepicker3.css">  
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- jQuery 2.2.3 -->
  <script src="../asset/js/jquery.min.js"></script> 
  <!-- Sweet Alert -->
    <link rel="stylesheet" href="../asset/plugins/sweetalert/sweetalert.css">
    <script src="../asset/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <style type="text/css">
      .zoom {      
        -webkit-transition: all 0.35s ease-in-out;    
        -moz-transition: all 0.35s ease-in-out;    
        transition: all 0.35s ease-in-out;     
        cursor: -webkit-zoom-in;      
        cursor: -moz-zoom-in;      
        cursor: zoom-in;  
      }     

      .zoom:hover,  
      .zoom:active,   
      .zoom:focus {
        /**adjust scale to desired size, 
        add browser prefixes**/
        -ms-transform: scale(2.5);    
        -moz-transform: scale(2.5);  
        -webkit-transform: scale(2.5);  
        -o-transform: scale(2.5);  
        transform: scale(2.5);    
        position:relative;      
        z-index:100;  
      }
    </style>      
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
        <a href="index.php" class="logo">      
            <span class="logo-mini"><b>PPDB</b></span>      
            <span class="logo-lg"><b>PPDB</b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="../asset/img/siswa.png" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= $_SESSION['nama'];?></span>
                        </a>
                        <ul class="dropdown-menu">              
                            <li class="user-header">
                                <img src="../asset/img/siswa.png" class="img-circle" alt="User Image">
                                <p><?= $_SESSION['nama'];?>
                                    <small>PPDB <?= $skl['sekolah_nama'];?></small>
                                </p>
                            </li>             
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <?php include('component/navigation.php');?>
        </section>
    </aside>
    <div class="content-wrapper">
      <div class="container">           
        <section class="content">
          <?php 
          if(isset($_GET['mod'])){
            include('modul/' . $mod . '/' . $hal . '.php');
          }else{      
            include('dashboard.php');
          }
          ?>          
        </section>       
      </div>      
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <a href="https://ucu.suryadi.my.id" target="_blank">nolbyte</a>
        </div>
        <strong>Copyright &copy; 2019 <a href="<?= $skl['sekolah_website'];?>"><?= $skl['sekolah_nama'];?></a>.</strong> All rights
    reserved.
    </footer>
  </div>  
  <script src="../asset/js/bootstrap.min.js"></script>
  <script src="../asset/js/adminlte.min.js"></script>
  <script src="../asset/js/demo.js"></script>
  <!--<script src="../assets/js/typeahead.bundle.js"></script>-->
  <script src="../asset/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../asset/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../asset/plugins/fastclick/fastclick.js"></script>
  <script src="../asset/plugins/bootbox/bootbox.min.js"></script>
  <!--<script src="../assets/plugins/jquery.mask.js"></script>-->
  <script src="../asset/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>  
  <script>
    $(document).ready(function() {
     $('#tabelku').DataTable({          
      "iDisplayLength": 15,
    });
     $('#tglLahir').datepicker({
      format:'dd/mm/yyyy',
      autoclose: true
    });     
  });
</script>
</body>
</html>