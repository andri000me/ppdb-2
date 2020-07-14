<?php
    defined("RESMI") or die("Akses ditolak");
    if(!empty($_GET['id'])){
        $id = intval($_GET['id']);
    }
    $sql = $db->prepare("DELETE FROM us_berita WHERE berita_id = :idna");
    $sql->execute(array(':idna' => $id));
?>