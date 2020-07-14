<?php
defined("RESMI") or die("Akses ditolak");
?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">NAVIGASI</li>
    <li>
        <a href="index.php">
            <i class="fa fa-th"></i> <span>Dashboard</span>            
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-gears"></i><span>Sistem</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li><a href="index.php?mod=system&hal=sekolahID"><i class="fa fa-circle-o"></i> Identitas Sekolah</a></li>
            <li><a href="index.php?mod=system&hal=jurusan"><i class="fa fa-circle-o"></i> Jurusan</a></li>
            <li><a href="index.php?mod=system&hal=periode"><i class="fa fa-circle-o"></i> Periode Pendaftaran</a></li>
            <li><a href="index.php?mod=system&hal=berita"><i class="fa fa-circle-o"></i> Berita/Pengumuman</a></li>
            <li><a href="index.php?mod=system&hal=agama"><i class="fa fa-circle-o"></i> Agama</a></li>
            <li><a href="index.php?mod=system&hal=pekerjaan"><i class="fa fa-circle-o"></i> Pekerjaan</a></li>
            <li><a href="index.php?mod=system&hal=pendidikan"><i class="fa fa-circle-o"></i> Pendidikan</a></li>
            <li><a href="index.php?mod=system&hal=gaji"><i class="fa fa-circle-o"></i> Penghasilan</a></li>
            <li><a href="index.php?mod=system&hal=kebutuhan"><i class="fa fa-circle-o"></i> Kebutuhan Khusus</a></li>
            <li><a href="index.php?mod=system&hal=tinggal"><i class="fa fa-circle-o"></i> Tempat Tinggal</a></li>
            <li><a href="index.php?mod=system&hal=transportasi"><i class="fa fa-circle-o"></i> Moda Transportasi</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-users"></i><span>Pendaftar</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li><a href="index.php?mod=ppdb&hal=pendaftar"><i class="fa fa-circle-o"></i> Data Pendaftar</a></li>            
        </ul>
    </li>
    <li>
        <a href="index.php?mod=system&hal=pengguna">
            <i class="fa fa-user"></i> <span>Profile Pengguna</span>            
        </a>
    </li>
</ul>