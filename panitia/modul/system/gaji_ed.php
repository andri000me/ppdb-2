<?php
	defined("RESMI")or die("error");
	$gump      = new GUMP();
	$gaji_id   = $_POST['gaji_id'];
	$gaji_kode = $_POST['gaji_kode'];
	$gaji_nama = $_POST['gaji_nama'];
	$_POST = array(
		'gaji_id'   => $gaji_id,
		'gaji_kode' => $gaji_kode,
		'gaji_nama' => $gaji_nama
	);
	$_POST = $gump->sanitize($_POST);
	$gump->validation_rules(array(
		'gaji_id'   => 'required|numeric',
		'gaji_kode' => 'required|numeric',
		'gaji_nama' => 'required'
	));
	$gump->filter_rules(array(
		'gaji_id'   => 'trim|sanitize_numbers',
		'gaji_kode' => 'trim|sanitize_numbers',
		'gaji_nama' => 'trim|sanitize_string'
	));
	$ok = $gump->run($_POST);
	if($ok === false){
		$_SESSION['errData'] = $gump->get_readable_errors(true);
    	echo "<script> location.replace('index.php?mod=system&hal=gaji'); </script>";
	}else{
		$sql = $db->prepare("UPDATE us_penghasilan SET gaji_kode = ?, gaji_nama = ? WHERE gaji_id = ?");
		$sql->bindParam(1, $gaji_kode);
		$sql->bindParam(2, $gaji_nama);
		$sql->bindParam(3, $gaji_id);
		if(!$sql->execute()){
			print_r($sql->errorInfo());
		}else{
			$_SESSION['SaveData']= '';
        	echo "<script> location.replace('index.php?mod=system&hal=gaji'); </script>";
		}
	}
?>