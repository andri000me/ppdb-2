<?php
	defined("RESMI")or die("error");
	$gump       = new GUMP();
	$jurusan_id   = $_POST['jurusan_id'];
	$jurusan_kd   = $_POST['jurusan_kd'];
	$jurusan_nama = $_POST['jurusan_nama'];
	$_POST = array(
		'jurusan_id'   => $jurusan_id,
		'jurusan_kd'   => $jurusan_kd,
		'jurusan_nama' => $jurusan_nama
	);
	$_POST = $gump->sanitize($_POST);
	$gump->validation_rules(array(
		'jurusan_id'   => 'required|numeric',
		'jurusan_kd'   => 'required',
		'jurusan_nama' => 'required'
	));
	$gump->filter_rules(array(
		'jurusan_id'   => 'trim|sanitize_numbers',
		'jurusan_kd'   => 'trim|sanitize_string',
		'jurusan_nama' => 'trim|sanitize_string'
	));
	$ok = $gump->run($_POST);
	if($ok === false){
		$_SESSION['errData'] = $gump->get_readable_errors(true);
    	echo "<script> location.replace('index.php?mod=system&hal=jurusan'); </script>";
	}else{
		$sql = $db->prepare("UPDATE us_jurusan SET jurusan_kd = ?, jurusan_nama = ? WHERE jurusan_id = ?");
		$sql->bindParam(1, $jurusan_kd);
		$sql->bindParam(2, $jurusan_nama);
		$sql->bindParam(3, $jurusan_id);
		if(!$sql->execute()){
			print_r($sql->errorInfo());
		}else{
			$_SESSION['SaveData']= '';
        	echo "<script> location.replace('index.php?mod=system&hal=jurusan'); </script>";
		}
	}
?>