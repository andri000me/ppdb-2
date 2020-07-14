<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require('config/database.php');
    require('config/fungsi.php');
    require('config/gump.class.php');
    $sql = $db->prepare("SELECT * FROM us_sekolah");
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

        $no_daftar = "";

        $nama = "";

        $status = "";

        $keterangan = "";

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            $gump = new GUMP();



            $nomor_daftar = $_POST['nomor_daftar'];

            $tgl_lahir    = $_POST['tgl_lahir'];



            $_POST = array(

                'nomor_daftar' => $nomor_daftar,

                'tgl_lahir'    => $tgl_lahir

            );



            $_POST = $gump->sanitize($_POST);

            $gump->validation_rules(array(

                'nomor_daftar' => 'required|numeric',

                'tgl_lahir'    => 'required'

            ));



            $gump->filter_rules(array(

                'nomor_daftar' => 'trim|sanitize_numbers',

                'tgl_lahir'    => 'trim|sanitize_string'

            ));

            $ok = $gump->run($_POST);

            if($ok === false){

                $error[] = $gump->get_readable_errors(true);

            }else{

                $sql = $db->prepare("SELECT * FROM us_pendaftar WHERE siswa_no_daftar = :no");

                $sql->execute(array(':no' => $nomor_daftar));

                $h = $sql->fetch(PDO::FETCH_ASSOC);

                if($h){

                    $no_daftar  = $h['siswa_no_daftar'];

                    $nama       = $h['siswa_nama'];

                    $status     = $h['siswa_status_pdb'];

                    $keterangan = $h['siswa_status_ket'];

                }else{

                    $error[] = "Data tidak ditemukan";

                }

            }

        }

    ?>

    <div class="wrapper">

        <header class="main-header">

            <nav class="navbar navbar-static-top">

                <div class="container">

                    <div class="navbar-header">

                        <a href="index.php" class="navbar-brand">PPDB <?= $skl['sekolah_nama'];?></a>

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

                        <div class="col-md-10">

                            <div class="box box-info">

                                <div class="box-header with-border">

                                    <h3 class="box-title"><i class="fa fa-sort-amount-asc"></i> HASIL SELEKSI PPDB </h3>

                                </div>

                                <div class="box-body">

                                    <?php 

                                    if(isset($error)){

                                        foreach ($error as $error) {

                                            ?>

                                            <div class="alert alert-warning">

                                                <h5><i class="fa fa-warning"></i> Galat</h5>

                                                <?= $error;?>

                                                <meta http-equiv="refresh" content="3">

                                            </div>

                                            <?php

                                        }

                                    }

                                    ?>        

                                    <form method="post" action="" class="form-horizontal">

                                        <div class="form-group">

                                            <label class="col-sm-3 control-label">Nomor Pendaftaran</label>

                                            <div class="col-sm-6">

                                                <input type="number" name="nomor_daftar" class="form-control" required>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3 control-label">Tanggal Lahir</label>

                                            <div class="col-sm-6">

                                                <input type="text" name="tgl_lahir" class="form-control" id="tgllahir" placeholder="Tanggal lahir (dd-mm-yyyy): 31-12-2003" required>                                            

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3 control-label"></label>

                                            <div class="col-sm-6">

                                                <a href="index.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Batal</a>&nbsp;

                                                <button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-upload"></i> Kirim</button>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <?php 

                            if(empty($h)){

                                echo '';

                            }else{

                        ?>

                            <div class="col-md-10">

                                <div class="box box-info">

                                    <div class="box-body">

                                        <?php

                                            if($status === '1'){

                                                echo 'Hallo <b> '.$nama.' </b><br>';

                                                echo 'Anda <b>Diterima</b> di '.$skl['sekolah_nama'].'<br>';

                                                echo nl2br($keterangan);

                                            }elseif($status === '0'){

                                                echo 'Hallo, <b> '.$nama.'</b><br>';

                                                echo 'Maaf, kamu <b>Tidak Diterima</b> di '.$skl['sekolah_nama'].'<br>';

                                                echo $keterangan;

                                            }else{

                                                echo '<h4>Hasil Seleksi Belum Dibuka</h4>';

                                            }

                                        ?>

                                    </div>

                                </div>

                            </div>

                        <?php

                            }

                        ?>

                    </div>

                </section>

            </div>

        </div>

        <footer class="main-footer">

            <div class="container">

                <div class="pull-right hidden-xs">

                    <a href="https://ucu.suryadi.my.id" target="_blank">nolbyte</a>

                </div>

                <strong>Copyright &copy; 2020 <a href="<?= $skl['sekolah_website'];?>"><?= $skl['sekolah_nama'];?></a>.</strong> All rights reserved.

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

  <script>

    $(document).ready(function() {

        $('#tabelku').DataTable({          

            "iDisplayLength": 15,

        }); 

        $('#tgllahir').datepicker({

            format:'dd-mm-yyyy',

            autoclose: true

        });

        $('[data-toggle="tooltip"]').tooltip({

            placement : 'top'

        });

        //toggleFields

        $('#nama').hide();

        $('input[type=radio]').on("change", function() {

            if ($(this).val() == "Lain-lain") {

              $('#nama').show();

          } else {

              $('#nama').hide();

          }

      });

    });

</script>

</body>

</html>