<?php
defined("RESMI") or die("Akses ditolak");
$gump = new GUMP();

$beasiswa_id          = $_POST['beasiswa_id'];
$beasiswa_siswa       = $_POST['beasiswa_siswa'];
$beasiswa_jenis       = $_POST['beasiswa_jenis'];
$beasiswa_keterangan  = $_POST['beasiswa_keterangan'];
$beasiswa_thn_mulai   = $_POST['beasiswa_thn_mulai'];
$beasiswa_thn_selesai = $_POST['beasiswa_thn_selesai'];

$_POST = $gump->sanitize($_POST);
$gump->validation_rules(array(
    'beasiswa_id'          => 'required|integer',
    'beasiswa_siswa'       => 'required|integer',
    'beasiswa_jenis'       => 'required',
    'beasiswa_keterangan'  => 'required',
    'beasiswa_thn_mulai'   => 'required|numeric',
    'beasiswa_thn_selesai' => 'required|numeric'
));
$gump->filter_rules(array(
    'beasiswa_id'          => 'trim|sanitize_numbers',
    'beasiswa_siswa'       => 'trim|sanitize_numbers',
    'beasiswa_jenis'       => 'trim|sanitize_string',
    'beasiswa_keterangan'  => 'trim|sanitize_string',
    'beasiswa_thn_mulai'   => 'trim|sanitize_numbers',
    'beasiswa_thn_selesai' => 'trim|sanitize_numbers'
));
$ok = $gump->run($_POST);
if($ok === false){
    $_SESSION['errData'] = $gump->get_readable_errors(true);
    echo "<script> location.replace('index.php?mod=ppdb&hal=beasiswa'); </script>";
}else{
    $sql = $db->prepare("UPDATE us_beasiswa SET beasiswa_siswa = ?, beasiswa_jenis = ?, beasiswa_keterangan = ?, beasiswa_thn_mulai = ?, beasiswa_thn_selesai = ? WHERE beasiswa_id = ?");
    $sql->bindParam(1, $beasiswa_siswa);
    $sql->bindParam(2, $beasiswa_jenis);
    $sql->bindParam(3, $beasiswa_keterangan);
    $sql->bindParam(4, $beasiswa_thn_mulai);
    $sql->bindParam(5, $beasiswa_thn_selesai);
    $sql->bindParam(6, $beasiswa_id);
    if(!$sql->execute()){
        print_r($sql->errorInfo());
    }else{
        $_SESSION['SaveData']= '';
        echo "<script> location.replace('index.php?mod=ppdb&hal=beasiswa'); </script>";
    }
}