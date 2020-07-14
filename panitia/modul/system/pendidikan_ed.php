<?php
	defined("RESMI")or die("error");
	$gump       = new GUMP();
	$pend_id   = $_POST['pend_id'];
	$pend_kd   = $_POST['pend_kd'];
	$pend_nama = $_POST['pend_nama'];
	$_POST = array(
		'pend_id'   => $pend_id,
		'pend_kd'   => $pend_kd,
		'pend_nama' => $pend_nama
	);
	$_POST = $gump->sanitize($_POST);
	$gump->validation_rules(array(
		'pend_id'   => 'required|numeric',
		'pend_kd'   => 'required|numeric',
		'pend_nama' => 'required'
	));
	$gump->filter_rules(array(
		'pend_id'   => 'trim|sanitize_numbers',
		'pend_kd'   => 'trim|sanitize_numbers',
		'pend_nama' => 'trim|sanitize_string'
	));
	$ok = $gump->run($_POST);
	if($ok === false){
		$_SESSION['errData'] = $gump->get_readable_errors(true);
    	echo "<script> location.replace('index.php?mod=system&hal=pendidikan'); </script>";
	}else{
		$sql = $db->prepare("UPDATE us_pendidikan SET pend_kd = ?, pend_nama = ? WHERE pend_id = ?");
		$sql->bindParam(1, $pend_kd);
		$sql->bindParam(2, $pend_nama);
		$sql->bindParam(3, $pend_id);
		if(!$sql->execute()){
			print_r($sql->errorInfo());
		}else{
			$_SESSION['SaveData']= '';
        	echo "<script> location.replace('index.php?mod=system&hal=pendidikan'); </script>";
		}
	}
?>