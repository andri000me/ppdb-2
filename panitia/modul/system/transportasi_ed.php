<?php
	defined("RESMI")or die("error");
	$gump       = new GUMP();
	$transport_id   = $_POST['transport_id'];
	$transport_kd   = $_POST['transport_kd'];
	$transport_nama = $_POST['transport_nama'];
	$_POST = array(
		'transport_id'   => $transport_id,
		'transport_kd'   => $transport_kd,
		'transport_nama' => $transport_nama
	);
	$_POST = $gump->sanitize($_POST);
	$gump->validation_rules(array(
		'transport_id'   => 'required|numeric',
		'transport_kd'   => 'required|numeric',
		'transport_nama' => 'required'
	));
	$gump->filter_rules(array(
		'transport_id'   => 'trim|sanitize_numbers',
		'transport_kd'   => 'trim|sanitize_numbers',
		'transport_nama' => 'trim|sanitize_string'
	));
	$ok = $gump->run($_POST);
	if($ok === false){
		$_SESSION['errData'] = $gump->get_readable_errors(true);
    	echo "<script> location.replace('index.php?mod=system&hal=transportasi'); </script>";
	}else{
		$sql = $db->prepare("UPDATE us_transportasi SET transport_kd = ?, transport_nama = ? WHERE transport_id = ?");
		$sql->bindParam(1, $transport_kd);
		$sql->bindParam(2, $transport_nama);
		$sql->bindParam(3, $transport_id);
		if(!$sql->execute()){
			print_r($sql->errorInfo());
		}else{
			$_SESSION['SaveData']= '';
        	echo "<script> location.replace('index.php?mod=system&hal=transportasi'); </script>";
		}
	}
?>