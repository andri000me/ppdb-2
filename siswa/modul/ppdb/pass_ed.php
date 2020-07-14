<?php
defined("RESMI") or die("Akses ditolak");
//option password
    $options = [
    'cost' => 12,
    ];
$gump = new GUMP();
$siswa_id = $_POST['siswa_id'];
$password = $_POST['password'];
$_POST = array(
    'siswa_id' => $siswa_id,
    'password' => $password
);
$_POST = $gump->sanitize($_POST);
$gump->validation_rules(array(
    'siswa_id' => 'required',
    'password' => 'required'
));
$gump->filter_rules(array(
    'siswa_id' => 'trim|sanitize_numbers'
));
$ok = $gump->run($_POST);
if($ok === false){
    $_SESSION['errData'] = $gump->get_readable_errors(true);
    echo "<script> location.replace('index.php'); </script>";
}else{
    $pass = password_hash($password, PASSWORD_BCRYPT, $options);
    $sql = $db->prepare("UPDATE us_pendaftar SET siswa_password = ?, siswa_key = ? WHERE siswa_id = ?");
    $sql->bindParam(1, $pass);
    $sql->bindParam(2, $password);
    $sql->bindParam(3, $siswa_id);
    if(!$sql->execute()){
        print_r($sql->errorInfo());
    }else{
        $_SESSION['SaveData']= '';
        echo "<script> location.replace('index.php'); </script>";
    }
}