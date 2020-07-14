<?php
	defined("RESMI")or die("error");
	$gump       = new GUMP();
	$agama_id   = $_POST['agama_id'];
	$agama_kd   = $_POST['agama_kd'];
	$agama_nama = $_POST['agama_nama'];
	$_POST = array(
		'agama_id'   => $agama_id,
		'agama_kd'   => $agama_kd,
		'agama_nama' => $agama_nama
	);
	$_POST = $gump->sanitize($_POST);
	$gump->validation_rules(array(
		'agama_id'   => 'required|numeric',
		'agama_kd'   => 'required|numeric',
		'agama_nama' => 'required'
	));
	$gump->filter_rules(array(
		'agama_id'   => 'trim|sanitize_numbers',
		'agama_kd'   => 'trim|sanitize_numbers',
		'agama_nama' => 'trim|sanitize_string'
	));
	$ok = $gump->run($_POST);
	if($ok === false){
		$_SESSION['errData'] = $gump->get_readable_errors(true);
    	echo "<script> location.replace('index.php?mod=system&hal=agama'); </script>";
	}else{
		$sql = $db->prepare("UPDATE us_agama SET agama_kd = ?, agama_nama = ? WHERE agama_id = ?");
		$sql->bindParam(1, $agama_kd);
		$sql->bindParam(2, $agama_nama);
		$sql->bindParam(3, $agama_id);
		if(!$sql->execute()){
			print_r($sql->errorInfo());
		}else{
			$_SESSION['SaveData']= '';
        	echo "<script> location.replace('index.php?mod=system&hal=agama'); </script>";
		}
	}
?>