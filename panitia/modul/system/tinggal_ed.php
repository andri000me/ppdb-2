<?php
	defined("RESMI")or die("error");
	$gump       = new GUMP();
	$tinggal_id   = $_POST['tinggal_id'];
	$tinggal_kd   = $_POST['tinggal_kd'];
	$tinggal_nama = $_POST['tinggal_nama'];
	$_POST = array(
		'tinggal_id'   => $tinggal_id,
		'tinggal_kd'   => $tinggal_kd,
		'tinggal_nama' => $tinggal_nama
	);
	$_POST = $gump->sanitize($_POST);
	$gump->validation_rules(array(
		'tinggal_id'   => 'required|numeric',
		'tinggal_kd'   => 'required|numeric',
		'tinggal_nama' => 'required'
	));
	$gump->filter_rules(array(
		'tinggal_id'   => 'trim|sanitize_numbers',
		'tinggal_kd'   => 'trim|sanitize_numbers',
		'tinggal_nama' => 'trim|sanitize_string'
	));
	$ok = $gump->run($_POST);
	if($ok === false){
		$_SESSION['errData'] = $gump->get_readable_errors(true);
    	echo "<script> location.replace('index.php?mod=system&hal=tinggal'); </script>";
	}else{
		$sql = $db->prepare("UPDATE us_tinggal SET tinggal_kd = ?, tinggal_nama = ? WHERE tinggal_id = ?");
		$sql->bindParam(1, $tinggal_kd);
		$sql->bindParam(2, $tinggal_nama);
		$sql->bindParam(3, $tinggal_id);
		if(!$sql->execute()){
			print_r($sql->errorInfo());
		}else{
			$_SESSION['SaveData']= '';
        	echo "<script> location.replace('index.php?mod=system&hal=tinggal'); </script>";
		}
	}
?>