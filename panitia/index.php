<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    define("RESMI", "OK");

    if(!isset($_SESSION['admID'])){
        header("Location:login.php");
    }

    //konfigurasi
    require('../config/database.php');
    require('../config/fungsi.php');
    require('../config/gump.class.php');
    if(isset($_GET['mod'])){
        $mod = sanitasi($_GET['mod']);
        $hal = sanitasi($_GET['hal']);
    }
    $sql = $db->prepare("SELECT sekolah_nama, sekolah_website FROM us_sekolah");
    $sql->execute();
    $skl = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
  <title>PPDB <?= $skl['sekolah_nama'];?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../asset/css/bootstrap.min.css">
  <link rel="stylesheet" href="../asset/plugins/font-awesome/css/font-awesome.min.css">  
  <link rel="stylesheet" href="../asset/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../asset/css/skin-blue.min.css">
  <link rel="stylesheet" href="../asset/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../asset/plugins/datepicker/datepicker3.css"> 
  <link rel="stylesheet" href="../asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> 
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- jQuery 2.2.3 -->
  <script src="../asset/js/jquery.min.js"></script>
  <script src="../asset/js/Chart.min.js"></script> 
  <!-- Sweet Alert -->
    <link rel="stylesheet" href="../asset/plugins/sweetalert/sweetalert.css">
    <script src="../asset/plugins/sweetalert/sweetalert.min.js"></script>        
  <style type="text/css">
    .dataTables_filter {
      /*float: left !important;*/
    }    
    .sidebar .sidebar-menu .active .treeview-menu {
        display: block;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
        <a href="index.php" class="logo">      
            <span class="logo-mini"><b>PPDB</b></span>      
            <span class="logo-lg"><b>PPDB</b>M3</span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="../asset/img/avatar04.png" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= $_SESSION['admin'];?></span>
                        </a>
                        <ul class="dropdown-menu">              
                            <li class="user-header">
                                <img src="../asset/img/avatar04.png" class="img-circle" alt="User Image">
                                <p><?= $_SESSION['admin'];?>
                                    <small><?= $skl['sekolah_nama'];?></small>
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
            <?php include_once('component/navigation.php');?>
        </section>
    </aside>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Dashboard PPDB <?= $skl['sekolah_nama'];?></h1>        
        </section>
               
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
  <script src="../asset/js/tinymce/tinymce.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
  <script src="../asset/plugins/fastclick/fastclick.js"></script>
  <script src="../asset/plugins/bootbox/bootbox.min.js"></script>
  <!--<script src="../assets/plugins/jquery.mask.js"></script>-->
  <script src="../asset/plugins/datepicker/bootstrap-datepicker.js"></script>  
  <script>
    tinymce.init({
        selector: "textarea",theme: "modern",width: 580,height: 280,
        plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor responsivefilemanager code tiny_mce_wiris"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry",
        image_advtab: true ,

        external_filemanager_path:"/filemanager/",
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: { "filemanager" : "../../filemanager/plugin.min.js"}
    });
  </script>
  <script>
    $(document).ready(function() {
        //CKEDITOR.replace( 'editor1' );        
        $('#prestasi').DataTable({          
            "iDisplayLength": 15,
            "ordering": false
        }); 
        $('#beasiswa').DataTable({          
            "iDisplayLength": 15,
            "ordering": false
        });        
  });
</script>
</body>
</html>