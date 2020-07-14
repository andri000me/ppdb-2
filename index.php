<?php
    require('config/database.php');
    require('config/fungsi.php');
    require('config/gump.class.php');

    session_start();

    $sql = $db->prepare("SELECT * FROM us_sekolah");
    $sql->execute();
    $skl = $sql->fetch(PDO::FETCH_ASSOC);
    $status = 1;
    $b = $db->prepare("SELECT * FROM us_periode WHERE periode_status = ?");
    $b->execute(array($status));
    $c = $b->fetch(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">  
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- jQuery 2.2.3 -->
    <script src="asset/js/jquery.min.js"></script> 
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="asset/plugins/sweetalert/sweetalert.css">
    <script src="asset/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>   
    <style type="text/css">
        .dataTables_filter {
          /*float: left !important;*/
        }    
        .sidebar .sidebar-menu .active .treeview-menu {
          display: block;
        }
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
<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="index.php" class="navbar-brand">PPDB <?=$skl['sekolah_nama'];?></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>                    
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">

                    </div>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="login.php"><i class="fa fa-key"></i> LOGIN</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="col-md-4">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">PPDB <?=$skl['sekolah_nama'];?> <?=$c['periode_tp'];?></h3>
                            </div>
                            <div class="box-body">
                                <h4>Penerimaan Peserta Didik Baru <?=$c['periode_nama'];?></h4>
                                <p><?=tgl_id($c['periode_tgl_awal']).' - '.tgl_id($c['periode_tgl_akhir']);?></p>
                                <p>
                                    <?php
                                        if($c['periode_berbayar'] === '0'){
                                            echo '<b>Bebas biaya pendaftaran</b>';
                                        }else{
                                            echo '<b>Biaya Pendaftaran:</b> Rp. '.number_format($c['periode_biaya'], 0, ".", ".");
                                        }
                                    ?>
                                </p>
                                <p><b>INFORMASI</b></p>
                                <p><i class="fa fa-whatsapp"></i> <a href="https://api.whatsapp.com/send?phone=<?=$skl['sekolah_hp'];?>&amp;text=Saya%20tertarik%20untuk%20mendaftar%20di%20SMK%20Mahadhika%203"><?=$skl['sekolah_hp'];?></a> - <?=$skl['sekolah_kontak1'];?></p>
                                <p><i class="fa fa-whatsapp"></i> <a href="https://api.whatsapp.com/send?phone=<?=$skl['sekolah_hp2'];?>&amp;text=Saya%20tertarik%20untuk%20mendaftar%20di%20SMK%20Mahadhika%203"><?=$skl['sekolah_hp2'];?></a> - <?=$skl['sekolah_kontak2'];?></p>
                                <p class="small">Tap/klik pada nomor diatas untuk menghubungi langsung melalui Whatsapp</p>
                            </div>
                            <div class="box-footer">
                                <a href="daftar.php" class="btn btn-block btn-info"><i class="fa fa-user-plus"></i> DAFTAR SEKARANG</a><br>
                                <a href="login.php" class="btn btn-block btn-primary"><i class="fa fa-lock"></i> LOGIN PPDB</a><br>
                                <a href="hasil_seleksi.php" class="btn btn-block btn-success"><i class="fa fa-sort-amount-asc"></i> HASIL SELEKSI</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <?php
                            $ya = 1;
                            $sql = $db->prepare("SELECT * FROM us_berita WHERE berita_tampil = :ya ORDER BY berita_id ASC");
                            $sql->execute(array(':ya' => $ya));
                        ?>
                        <div class="row">
                            <?php foreach($sql->fetchAll() as $be){ ?>
                            <div class="box box-warning">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?=$be['berita_judul'];?></h3>
                                </div>                  
                                <div class="box-body">
                                    <?= nl2br($be['berita_isi']);?>
                                </div>          
                            </div>
                        <?php } ?>
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
                <strong>Copyright &copy; 2020 <a href="<?=$skl['sekolah_website'];?>"><?=$skl['sekolah_nama'];?></a>.</strong> All rights reserved.
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
  <script>
    $(document).ready(function() {
        $('#tabelku').DataTable({          
        "iDisplayLength": 15,
        });    
    });
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
</body>
</html>