<?php
defined("RESMI") or die("Akses ditolak");
$gump = new GUMP();

$jenis       = $_POST['jenis'];
$keterangan  = $_POST['keterangan'];
$thn_mulai   = $_POST['thn_mulai'];
$thn_selesai = $_POST['thn_selesai'];

$_POST = $gump->sanitize($_POST);
$gump->validation_rules(array(
	'jenis'       => 'required',
	'keterangan'  => 'required',
	'thn_mulai'   => 'required|numeric',
	'thn_selesai' => 'required|numeric'
));
$gump->filter_rules(array(
	'jenis'       => 'trim|sanitize_string',
	'keterangan'  => 'trim|sanitize_string',
	'thn_mulai'   => 'trim|sanitize_numbers',
	'thn_selesai' => 'trim|sanitize_numbers'
));
$ok = $gump->run($_POST);
if($ok === false){
	$_SESSION['errData'] = $gump->get_readable_errors(true);
    echo "<script> location.replace('index.php?mod=ppdb&hal=beasiswa'); </script>";
}else{
	$sql = $db->prepare("INSERT INTO us_beasiswa SET beasiswa_siswa = ?, beasiswa_jenis = ?, beasiswa_keterangan = ?, beasiswa_thn_mulai = ?, beasiswa_thn_selesai = ?");
	$sql->bindParam(1, $_SESSION['idSiswa']);
	$sql->bindParam(2, $jenis);
	$sql->bindParam(3, $keterangan);
	$sql->bindParam(4, $thn_mulai);
	$sql->bindParam(5, $thn_selesai);
	if(!$sql->execute()){
		print_r($sql->errorInfo());
	}else{
		$_SESSION['SaveData']= '';
        echo "<script> location.replace('index.php?mod=ppdb&hal=beasiswa'); </script>";
	}
}