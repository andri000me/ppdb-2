<?php
    defined("RESMI") or die("error");
    //option password
    $options = [
    'cost' => 12,
    ];
    $gump     = new GUMP();
    $siswa_id = $_POST['siswa_id'];    
    $password = $_POST['password'];
    $_POST = array(
        'siswa_id' => $siswa_id,        
        'password' => $password
    );
    $_POST = $gump->sanitize($_POST);
    $gump->validation_rules(array(
        'siswa_id' => 'required|integer',        
        'password' => 'required|min_len,8'
    ));
    $gump->filter_rules(array(
        'siswa_id' => 'trim|sanitize_numbers',
        'username' => 'trim|sanitize_string'
    ));
    $ok = $gump->run($_POST);
    if($ok === false){
        $_SESSION['errData'] = $gump->get_readable_errors(true);
        echo "<script> location.replace('index.php?mod=ppdb&hal=pendaftar'); </script>";
    }else{
        $pass = password_hash($password, PASSWORD_BCRYPT, $options);
        $sql = $db->prepare("UPDATE us_pendaftar SET siswa_password = ? WHERE siswa_id = ?");
        $sql->bindParam(1, $pass);
        $sql->bindParam(2, $siswa_id);
        if(!$sql->execute()){
            print_r($sql->errorInfo());
        }else{
            $_SESSION['SaveData'] = '';
            echo "<script> location.replace('index.php?mod=ppdb&hal=pendaftar'); </script>";
        }
    }
?>