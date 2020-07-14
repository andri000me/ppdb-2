<?php
defined("RESMI") or die("Akses ditolak");
?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">NAVIGASI</li>
    <li>
        <a href="index.php"><i class="fa fa-home"></i> <span>BERANDA</span></a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-gears"></i><span>PENDAFTARAN</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li><a href="index.php?mod=ppdb&hal=pribadi"><i class="fa fa-circle-o"></i> DATA PRIBADI</a></li>
            <li><a href="index.php?mod=ppdb&hal=wali"><i class="fa fa-circle-o"></i> DATA WALI</a></li>
            <li><a href="index.php?mod=ppdb&hal=periodik"><i class="fa fa-circle-o"></i> DATA PERIODIK</a></li>
            <li><a href="index.php?mod=ppdb&hal=prestasi"><i class="fa fa-circle-o"></i> DATA PRESTASI</a></li>
            <li><a href="index.php?mod=ppdb&hal=beasiswa"><i class="fa fa-circle-o"></i> DATA BEASISWA</a></li>
            <li><a href="index.php?mod=ppdb&hal=sekolah"><i class="fa fa-circle-o"></i> DATA SEKOLAH ASAL</a></li>
        </ul>
    </li>       
    <li>
        <a href="?mod=ppdb&hal=cetakForm"><i class="fa fa-print"></i>CETAK FORMULIR</a>
    </li>
    <li>
        <?php
            if(!empty($skl['sekolah_ujian'])){
                echo '<a href="'.$skl['sekolah_ujian'].'" target="_blank"><i class="fa fa-laptop"></i> TEST SELEKSI ONLINE</a>';
            }else{
                echo '';
            }
        ?>
    </li>
</ul>