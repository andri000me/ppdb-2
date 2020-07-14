<?php

defined("RESMI") or die("Akses ditolak");
    if(!empty($_GET['id'])){
        $id = intval($_GET['id']);
    }
    $sql = $db->prepare("DELETE up, ub, upe, uo, upr FROM us_pendaftar up
    	LEFT JOIN us_beasiswa ub ON up.siswa_id=ub.beasiswa_siswa
    	LEFT JOIN us_ortu uo ON up.siswa_id=uo.ot_siswa
    	LEFT JOIN us_periodik upe ON up.siswa_id=upe.periodik_siswa
    	LEFT JOIN us_prestasi upr ON up.siswa_id=upr.prestasi_siswa
    	WHERE up.siswa_id = :id");
    $sql->execute(array(':id' => $id));

?>