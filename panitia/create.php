<?php
    require('../config/database.php');
    $options = [
    'cost' => 12,
    ];
    if(isset($_POST['kirim'])){
        $login = $_POST['login'];
        $nama = $_POST['nama'];
        $passwd = $_POST['passwd'];

        $konci = password_hash($passwd, PASSWORD_BCRYPT, $options);
        $sql = $db->prepare("INSERT INTO us_adm SET adm_login = ?, adm_pass = ?, adm_nama = ?");
        $sql->bindParam(1, $login);
        $sql->bindParam(2, $konci);
        $sql->bindParam(3, $nama);
        if(!$sql->execute()){
            print_r($sql->errorInfo());
        }else{
            echo "data berhasil disimpan";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Buat User</title>
</head>
<body>
    <form method="post" action="">
        <label>Login</label>
        <input type="text" name="login"><br>
        <label>Nama</label>
        <input type="text" name="nama"><br>
        <label>Password</label>
        <input type="password" name="passwd"><br>
        <input type="submit" name="kirim" value="simpan">
    </form>
</body>
</html>