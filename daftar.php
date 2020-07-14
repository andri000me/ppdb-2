<?php
    require('config/database.php');
    require('config/fungsi.php');
    require('config/gump.class.php');
    //option password
    $options = [
    'cost' => 12,
    ];

    session_start();
    //acak huruf untuk password
    $acak = randomPass();

    $sql = $db->prepare("SELECT * FROM us_sekolah");
    $sql->execute();
    $skl = $sql->fetch(PDO::FETCH_ASSOC);
    $npsn = $skl['sekolah_npsn'];
    $status = 1;
    $b = $db->prepare("SELECT * FROM us_periode WHERE periode_status = ?");
    $b->execute(array($status));
    $c = $b->fetch(PDO::FETCH_ASSOC);
    
    //nomor pendaftaran
    $tgl = date("dm");
    $u = $db->prepare("SELECT siswa_id FROM us_pendaftar ORDER BY siswa_id DESC LIMIT 1");
    $u->execute();
    $n = $u->fetch(PDO::FETCH_ASSOC);    
    $urut = $n['siswa_id']++;
    $no_daftar = $npsn.$tgl.sprintf('%03s', $urut);
    
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
        //Tangani form
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $gump = new GUMP();
        $nama_lengkap  = $_POST['nama_lengkap'];
        $nik           = $_POST['nik'];
        $tmpt_lahir    = $_POST['tmpt_lahir'];
        $tgl_lahir     = $_POST['tgl_lahir'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $no_hp         = $_POST['no_hp'];
        $password      = $_POST['password'];
        $jurusan       = $_POST['jurusan'];
        $survey        = $_POST['survey'];
        $survey_nama   = $_POST['survey_nama'];

        $_POST = array(
            'nama_lengkap'  => $nama_lengkap,
            'nik'           => $nik,
            'tmpt_lahir'    => $tmpt_lahir,
            'tgl_lahir'     => $tgl_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'no_hp'         => $no_hp,
            'password'      => $password,
            'jurusan'       => $jurusan,
            'survey'        => $survey,
            'survey_nama'   => $survey_nama
        );
        $_POST = $gump->sanitize($_POST);
        $gump->validation_rules(array(
            'nama_lengkap'  => 'required',
            'nik'           => 'required|numeric',
            'tmpt_lahir'    => 'required',
            'tgl_lahir'     => 'required',
            'jenis_kelamin' => 'required',
            'no_hp'         => 'required',
            'password'      => 'required|min_len,8',
            'jurusan'       => 'required'
        ));
        $gump->filter_rules(array(
            'nama_lengkap'  => 'trim|sanitize_string',
            'nik'           => 'trim|sanitize_numbers',
            'tmpt_lahir'    => 'trim|sanitize_string',
            'tgl_lahir'     => 'trim|sanitize_string',
            'jenis_kelamin' => 'trim|sanitize_string',
            'no_hp'         => 'trim|sanitize_numbers',            
            'jurusan'       => 'trim|sanitize_numbers',
            'survey'        => 'trim|sanitize_string',
            'survey_nama'   => 'trim|sanitize_string'
        ));
        $ok = $gump->run($_POST);
        if($ok === false){
            $error[] = $gump->get_readable_errors(true);
        }else{  
            $sq = $db->prepare("SELECT siswa_nik FROM us_pendaftar WHERE siswa_nik = :nik");
            $sq->execute(array(':nik' => $nik));
            if($sq->rowCount() > 0){
                $error[] = 'NIK sudah terdaftar';
            }else{
                $tgl_daftar = date("m/d/Y");               
                $pass = password_hash($password, PASSWORD_BCRYPT, $options);
                $sql = $db->prepare("INSERT INTO us_pendaftar SET siswa_no_daftar = ?, siswa_tgl_daftar = ?, siswa_gelombang = ?, siswa_nama = ?, siswa_nik = ?, siswa_tempatLahir = ?, siswa_tglLahir = ?, siswa_kelamin = ?, siswa_hp = ?, siswa_password = ?, siswa_key = ?, siswa_jurusan = ?");
                $sql->bindParam(1, $no_daftar);
                $sql->bindParam(2, $tgl_daftar);
                $sql->bindParam(3, $c['periode_id']);
                $sql->bindParam(4, $nama_lengkap);
                $sql->bindParam(5, $nik);
                $sql->bindParam(6, $tmpt_lahir);
                $sql->bindParam(7, $tgl_lahir);
                $sql->bindParam(8, $jenis_kelamin);
                $sql->bindParam(9, $no_hp);            
                $sql->bindParam(10, $pass);
                $sql->bindParam(11, $password);
                $sql->bindParam(12, $jurusan);
                if(!$sql->execute()){
                    print_r($sql->errorInfo());
                }else{
                    $lastID = $db->lastInsertId();                
                    $_SESSION['idSiswa']  = $lastID;
                    $_SESSION['noDaftar'] = $no_daftar;
                    $_SESSION['pass']     = $_POST['password'];
                    $_SESSION['nama']     = $_POST['nama_lengkap'];                
                //header('Location: siswa/index.php');
                    ?><script>
                        swal({ 
                            title: "Pendaftaran Berhasil",
                            text: "Halaman akan segera dialihkan",
                            type: "success",
                            timer: 2000 
                        },
                        function(){
                            window.location.href = 'siswa/index.php';
                        });
                        </script><?php
                }
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
                    <div class="col-md-10">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?=$c['periode_nama'];?></h3>
                                <p class="help-text"><?=tgl_id($c['periode_tgl_awal']).' - '.tgl_id($c['periode_tgl_akhir']);?></p>
                            </div>
                            <div class="box-body">
                                <h4>IDENTITAS DIRI</h4>                                
                                <p class="help-text text-red"><b>Semua kolom wajib diisi</b></p>
                                <?php 
                                if(isset($error)){
                                    foreach ($error as $error) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <h5><i class="fa fa-warning"></i> Kesalahan Ditemukan</h5>
                                            <?= $error.'<br>';?>
                                            <meta http-equiv="refresh" content="2">
                                        </div>
                                        <?php
                                    }
                                }
                                ?>                                
                                <form method="post" action="" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Nama Lengkap</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama lengkap tanpa gelar dan singkatan sesuai KK" required>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-sm-4 control-label">Nomor Induk Kependudukan</label>
                                        <div class="col-sm-6">
                                            <input type="number" name="nik" class="form-control">
                                            <p class="help-text">Nomor Induk Kependudukan</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Tempat Lahir</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="tmpt_lahir" class="form-control" placeholder="Tempat lahir sesuai KK" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Tanggal Lahir</label>
                                        <div class="col-sm-6">
                                            <input id="tgllahir" type="text" name="tgl_lahir" placeholder="Tanggal lahir (dd-mm-yyyy) sesuai KK" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Jenis Kelamin</label>
                                        <div class="col-sm-6">
                                            <label class="radio-inline"><input type="radio" name="jenis_kelamin" value="L" checked=""> Laki-laki</label> &nbsp;<label class="radio-inline"><input type="radio" name="jenis_kelamin" value="P"> Perempuan</label>                                       
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">HP</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="no_hp" class="form-control"placeholder="Nomor HP yang bisa dihubungi" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Nomor Pendaftaran</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="no_daftar" class="form-control" value="<?=$no_daftar;?>" readonly required>
                                            <p class="help-text">Catat dan simpan Nomor Pendaftaran ini. Digunakan untuk login</p>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Token</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="password" class="form-control" value="<?=$acak;?>" autocomplete="new-password" readonly required> 
                                            <p class="help-text">Catat dan simpan Token. Digunakan untuk login.</p>
                                        </div>                   
                                    </div>
                                    <h4>PILIHAN JURUSAN</h4>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Pilihan Jurusan</label>
                                        <div class="col-sm-6">
                                            <?php
                                            $d = $db->prepare("SELECT * FROM us_jurusan ORDER BY jurusan_id ASC");
                                            $d->execute();
                                            ?>
                                            <select name="jurusan" class="form-control" required>
                                                <option value="">-- Pilih Jurusan --</option>   
                                                <?php foreach($d->fetchAll() as $row){ ?>
                                                    <option value="<?=$row['jurusan_id'];?>"><?=$row['jurusan_nama'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <h4>SURVEY PPDB</h4>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Informasi PPDB</label>
                                        <div class="col-sm-6">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="survey" value="Brosur" required checked>Brosur    
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="survey" value="Google">Google    
                                                </label>
                                            </div> 
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="survey" value="Media Sosial">Media Sosial    
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="survey" value="Teman">Teman    
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input id="survey" type="radio" name="survey" value="Lain-lain">Lain-lain, Sebutkan    
                                                </label>
                                            </div>
                                            <div id="nama" class="radio">
                                                <input type="text" name="survey_nama" class="form-control" placeholder="Tuliskan nama orang yang merekomendasikan">
                                            </div>
                                            <p class="help-text">Dari mana anda mendapatkan informasi tentang PPDB ini?</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-6 pull-right">
                                            <a href="index.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Batal</a>&nbsp;<button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-floppy-o"></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>                                
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