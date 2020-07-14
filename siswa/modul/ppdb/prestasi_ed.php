<?php
defined("RESMI") or die("Akses ditolak");

$gump = new GUMP();

$prestasi_siswa     = $_POST['prestasi_siswa'];
$prestasi_id        = $_POST['prestasi_id'];
$prestasi_jenis     = $_POST['prestasi_jenis'];
$prestasi_tingkat   = $_POST['prestasi_tingkat'];
$prestasi_nama      = $_POST['prestasi_nama'];
$prestasi_thn       = $_POST['prestasi_thn'];
$prestasi_panitia   = $_POST['prestasi_panitia'];
$prestasi_peringkat = $_POST['prestasi_peringkat'];

$_POST = $gump->sanitize($_POST);
$gump->validation_rules(array(
    'prestasi_siswa'     => 'required|integer',
    'prestasi_id'        => 'required|integer',
    'prestasi_jenis'     => 'required',
    'prestasi_tingkat'   => 'required',
    'prestasi_nama'      => 'required',
    'prestasi_thn'       => 'required|numeric',
    'prestasi_panitia'   => 'required',
    'prestasi_peringkat' => 'required'
));
$gump->filter_rules(array(
    'prestasi_siswa'     => 'trim|sanitize_numbers',
    'prestasi_id'        => 'trim|sanitize_numbers',
    'prestasi_jenis'     => 'trim|sanitize_string',
    'prestasi_tingkat'   => 'trim|sanitize_string',
    'prestasi_nama'      => 'trim|sanitize_string',
    'prestasi_thn'       => 'trim|sanitize_numbers',
    'prestasi_panitia'   => 'trim|sanitize_string',
    'prestasi_peringkat' => 'trim|sanitize_string'
));
$ok = $gump->run($_POST);
if($ok === false){
    $_SESSION['errData'] = $gump->get_readable_errors(true);
    echo "<script> location.replace('index.php?mod=ppdb&hal=prestasi'); </script>";
}else{
    $sql = $db->prepare("UPDATE us_prestasi SET prestasi_siswa = ?, prestasi_jenis = ?, prestasi_tingkat = ?, prestasi_nama = ?, prestasi_thn = ?, prestasi_panitia = ?, prestasi_peringkat = ? WHERE prestasi_id = ?");
    $sql->bindParam(1, $prestasi_siswa);
    $sql->bindParam(2, $prestasi_jenis);
    $sql->bindParam(3, $prestasi_tingkat);
    $sql->bindParam(4, $prestasi_nama);
    $sql->bindParam(5, $prestasi_thn);
    $sql->bindParam(6, $prestasi_panitia);
    $sql->bindParam(7, $prestasi_peringkat);
    $sql->bindParam(8, $prestasi_id);
    if(!$sql->execute()){
        print_r($sql->errorInfo());
    }else{
        $_SESSION['SaveData'] = '';
        echo "<script> location.replace('index.php?mod=ppdb&hal=prestasi'); </script>";
    }
}