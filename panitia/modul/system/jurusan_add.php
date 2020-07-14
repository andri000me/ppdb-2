<?php
	defined("RESMI")or die("error");
	$gump = new GUMP();
	$kode = $_POST['kode'];
	$nama = $_POST['nama'];
	$_POST = array(
		'kode' => $kode,
		'nama' => $nama
	);
	$_POST = $gump->sanitize($_POST);
	$gump->validation_rules(array(
		'kode' => 'required',
		'nama' => 'required'
	));
	$gump->filter_rules(array(
		'kode' => 'trim|sanitize_string',
		'nama' => 'trim|sanitize_string'
	));
	$ok = $gump->run($_POST);
	if($ok === false){
		$_SESSION['errData'] = $gump->get_readable_errors(true);
    	echo "<script> location.replace('index.php?mod=system&hal=jurusan'); </script>";
	}else{
		$sql = $db->prepare("INSERT INTO us_jurusan SET jurusan_kd = ?, jurusan_nama = ?");
		$sql->bindParam(1, $kode);
		$sql->bindParam(2, $nama);
		if(!$sql->execute()){
			print_r($sql->errorInfo());
		}else{
			$_SESSION['SaveData']= '';
        	echo "<script> location.replace('index.php?mod=system&hal=jurusan'); </script>";
		}
	}
?>