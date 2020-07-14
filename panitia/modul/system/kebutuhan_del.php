<?php
defined("RESMI") or die("Akses ditolak");
    if(!empty($_GET['id'])){
        $id = intval($_GET['id']);
    }
    $sql = $db->prepare("DELETE FROM us_kebutuhan WHERE kebutuhan_id = ?");
    $sql->execute(array($id));
?>