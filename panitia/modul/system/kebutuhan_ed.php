<?php
	defined("RESMI")or die("error");
	$gump       = new GUMP();
	$kebutuhan_id   = $_POST['kebutuhan_id'];
	$kebutuhan_kd   = $_POST['kebutuhan_kd'];
	$kebutuhan_nama = $_POST['kebutuhan_nama'];
	$_POST = array(
		'kebutuhan_id'   => $kebutuhan_id,
		'kebutuhan_kd'   => $kebutuhan_kd,
		'kebutuhan_nama' => $kebutuhan_nama
	);
	$_POST = $gump->sanitize($_POST);
	$gump->validation_rules(array(
		'kebutuhan_id'   => 'required|numeric',
		'kebutuhan_kd'   => 'required|numeric',
		'kebutuhan_nama' => 'required'
	));
	$gump->filter_rules(array(
		'kebutuhan_id'   => 'trim|sanitize_numbers',
		'kebutuhan_kd'   => 'trim|sanitize_numbers',
		'kebutuhan_nama' => 'trim|sanitize_string'
	));
	$ok = $gump->run($_POST);
	if($ok === false){
		$_SESSION['errData'] = $gump->get_readable_errors(true);
    	echo "<script> location.replace('index.php?mod=system&hal=kebutuhan'); </script>";
	}else{
		$sql = $db->prepare("UPDATE us_kebutuhan SET kebutuhan_kd = ?, kebutuhan_nama = ? WHERE kebutuhan_id = ?");
		$sql->bindParam(1, $kebutuhan_kd);
		$sql->bindParam(2, $kebutuhan_nama);
		$sql->bindParam(3, $kebutuhan_id);
		if(!$sql->execute()){
			print_r($sql->errorInfo());
		}else{
			$_SESSION['SaveData']= '';
        	echo "<script> location.replace('index.php?mod=system&hal=kebutuhan'); </script>";
		}
	}
?>