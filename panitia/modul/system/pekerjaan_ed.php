<?php
	defined("RESMI")or die("error");
	$gump       = new GUMP();
	$pekerjaan_id   = $_POST['pekerjaan_id'];
	$pekerjaan_kd   = $_POST['pekerjaan_kd'];
	$pekerjaan_nama = $_POST['pekerjaan_nama'];
	$_POST = array(
		'pekerjaan_id'   => $pekerjaan_id,
		'pekerjaan_kd'   => $pekerjaan_kd,
		'pekerjaan_nama' => $pekerjaan_nama
	);
	$_POST = $gump->sanitize($_POST);
	$gump->validation_rules(array(
		'pekerjaan_id'   => 'required|numeric',
		'pekerjaan_kd'   => 'required|numeric',
		'pekerjaan_nama' => 'required'
	));
	$gump->filter_rules(array(
		'pekerjaan_id'   => 'trim|sanitize_numbers',
		'pekerjaan_kd'   => 'trim|sanitize_numbers',
		'pekerjaan_nama' => 'trim|sanitize_string'
	));
	$ok = $gump->run($_POST);
	if($ok === false){
		$_SESSION['errData'] = $gump->get_readable_errors(true);
    	echo "<script> location.replace('index.php?mod=system&hal=pekerjaan'); </script>";
	}else{
		$sql = $db->prepare("UPDATE us_pekerjaan SET pekerjaan_kd = ?, pekerjaan_nama = ? WHERE pekerjaan_id = ?");
		$sql->bindParam(1, $pekerjaan_kd);
		$sql->bindParam(2, $pekerjaan_nama);
		$sql->bindParam(3, $pekerjaan_id);
		if(!$sql->execute()){
			print_r($sql->errorInfo());
		}else{
			$_SESSION['SaveData']= '';
        	echo "<script> location.replace('index.php?mod=system&hal=pekerjaan'); </script>";
		}
	}
?>