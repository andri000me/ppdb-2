<?php
defined("RESMI") or die("Akses ditolak");
    if(!empty($_GET['id'])){
        $id = intval($_GET['id']);
    }
    $sql = $db->prepare("DELETE FROM us_prestasi WHERE prestasi_id = ?");
    $sql->execute(array($id));
?>