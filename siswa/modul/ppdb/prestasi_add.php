<?php
defined("RESMI") or die("Akses ditolak");

$gump = new GUMP();

$jenis     = $_POST['jenis'];
$tingkat   = $_POST['tingkat'];
$nama      = $_POST['nama'];
$tahun     = $_POST['tahun'];
$panitia   = $_POST['panitia'];
$peringkat = $_POST['peringkat'];

$_POST = $gump->sanitize($_POST);
$gump->validation_rules(array(
    'jenis'     => 'required',
    'tingkat'   => 'required',
    'nama'      => 'required',
    'tahun'     => 'required|numeric',
    'panitia'   => 'required',
    'peringkat' => 'required'
));
$gump->filter_rules(array(
    'jenis'     => 'trim|sanitize_string',
    'tingkat'   => 'trim|sanitize_string',
    'nama'      => 'trim|sanitize_string',
    'tahun'     => 'trim|sanitize_numbers',
    'panitia'   => 'trim|sanitize_string',
    'peringkat' => 'trim|sanitize_string'
));
$ok = $gump->run($_POST);
if($ok === false){
    $_SESSION['errData'] = $gump->get_readable_errors(true);
    echo "<script> location.replace('index.php?mod=ppdb&hal=prestasi'); </script>";
}else{
    $sql = $db->prepare("INSERT INTO us_prestasi SET prestasi_siswa = ?, prestasi_jenis = ?, prestasi_tingkat = ?, prestasi_nama = ?, prestasi_thn = ?, prestasi_panitia = ?, prestasi_peringkat = ?");
    $sql->bindParam(1, $_SESSION['idSiswa']);
    $sql->bindParam(2, $jenis);
    $sql->bindParam(3, $tingkat);
    $sql->bindParam(4, $nama);
    $sql->bindParam(5, $tahun);
    $sql->bindParam(6, $panitia);
    $sql->bindParam(7, $peringkat);
    if(!$sql->execute()){
        print_r($sql->errorInfo());
    }else{
        $_SESSION['SaveData']                         = '';
        echo "<script> location.replace('index.php?mod=ppdb&hal=prestasi'); </script>";
    }
}