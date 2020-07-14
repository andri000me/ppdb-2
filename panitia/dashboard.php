<?php
defined("RESMI") or die("Akses ditolak");

//jumlah pendaftar
$a1 = $db->prepare("SELECT * FROM us_pendaftar");
$a1->execute();
$tp = $a1->rowCount();

//jumlah laki-laki
$kelamin = "L";
$a2 = $db->prepare("SELECT * FROM us_pendaftar WHERE siswa_kelamin = :kelamin");
$a2->execute(array(':kelamin' => $kelamin));
$pl = $a2->rowCount();

//jumlah Perempuan
$kelamin = "P";
$a3 = $db->prepare("SELECT * FROM us_pendaftar WHERE siswa_kelamin = :kelamin");
$a3->execute(array(':kelamin' => $kelamin));
$pp = $a3->rowCount();

//Jumlah sesuai jurusan
$prw = "Pariwisata";
$a4 = $db->prepare("SELECT * FROM us_pendaftar up LEFT JOIN us_jurusan uj ON up.siswa_jurusan=uj.jurusan_id WHERE uj.jurusan_nama = :jur");
$a4->execute(array(':jur' => $prw));
$ppar = $a4->rowCount();
$per = "Akomodasi Perhotelan";
$a5 = $db->prepare("SELECT * FROM us_pendaftar up LEFT JOIN us_jurusan uj ON up.siswa_jurusan=uj.jurusan_id WHERE uj.jurusan_nama = :juru");
$a5->execute(array(':juru' => $per));
$pper = $a5->rowCount();
?>
<div class="row">
    <div class="col-md-3 col-xs-12">        
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?= $tp;?></h3>
                <p>Jumlah Pendaftar</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="index.php?mod=ppdb&hal=pendaftar" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-md-3 col-xs-12">  
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?=$pl;?></h3>
                <p>Pendaftar Laki-laki</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="index.php?mod=ppdb&hal=pendaftar" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-md-3 col-xs-12">  
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?=$pp;?></h3>
                <p>Pendaftar Perempuan</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="index.php?mod=ppdb&hal=pendaftar" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>        
</div>
<div class="row">            
    <div class="col-md-3 col-xs-12">  
        <div class="small-box bg-orange">
            <div class="inner">
                <h3><?=$ppar;?></h3>
                <p>Pendaftar Pariwisata</p>
            </div>
            <div class="icon">
                <i class="fa fa-plane"></i>
            </div>
            <a href="index.php?mod=ppdb&hal=pendaftar" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-md-3 col-xs-12">  
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?=$pper;?></h3>
                <p>Pendaftar Akomodasi Perhotelan</p>
            </div>
            <div class="icon">
                <i class="fa fa-building-o"></i>
            </div>
            <a href="index.php?mod=ppdb&hal=pendaftar" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>        
</div>
<div class="row">
    <div class="col-md-6 col-xs-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-line-chart"></i> Graphic Pendaftar Jurusan</h3>
            </div>
            <div class="box-body">
                <canvas id="myChart1"></canvas>
            </div>
        </div>
    </div>
    <script>
        var ctx = document.getElementById("myChart1").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Pariwisata", "Akomodasi Perhotelan"],
                datasets: [{
                    label: '',
                    data: [
                    <?php 
                    echo $ppar;
                    ?>, 
                    <?php 
                    echo $pper;
                    ?>
                    ],
                    backgroundColor: [
                    'rgb(255, 159, 64, 0.5)',
                    'rgb(255, 99, 132, 0.5)',
                    ],
                    borderColor: [
                    'rgb(255, 159, 64, 1)',
                    'rgb(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <div class="col-md-6 col-xs-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-line-chart"></i> Graphic Pendaftar Jenis Kelamin</h3>
            </div>
            <div class="box-body">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Laki-laki", "Perempuan"],
                datasets: [{
                    label: '',
                    data: [
                    <?php 
                    echo $pl;
                    ?>, 
                    <?php 
                    echo $pp;
                    ?>
                    ],
                    backgroundColor: [
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)'
                    ],
                    borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-users"></i> Pendaftar Terbaru</h3>
			</div>
			<div class="box-body">
				<?php
					$a5 = $db->prepare("SELECT * FROM us_pendaftar up
							LEFT JOIN us_ortu uo ON up.siswa_id=uo.ot_siswa
							LEFT JOIN us_periodik upe ON up.siswa_id=upe.periodik_siswa
							LEFT JOIN us_registrasi ur ON up.siswa_id=ur.register_siswa
							LEFT JOIN us_jurusan uj ON up.siswa_jurusan=uj.jurusan_id
							LEFT JOIN us_periode upr ON up.siswa_gelombang=upr.periode_id
							ORDER BY up.siswa_id DESC LIMIT 10");
					$a5->execute();						
					$no =1;
				?>
				<div class="table-responsive">
					<table id="siswa" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>Nama Pendaftar</th>
								<th>Nomor Pendaftaran</th>
								<th>Gelombang</th>
								<th>Jurusan Pilihan</th>
								<th>Tanggal Daftar</th>								
							</tr>
						</thead>
						<tbody>
							<?php foreach($a5->fetchAll() as $row){ 
								$token = urlencode(encryptor('encrypt', $row['siswa_id']));
								?>
								<tr>
									<td><?= $no++;?></td>
									<td><?=$row['siswa_nama'];?></td>
									<td><?=$row['siswa_no_daftar'];?></td>
									<td><?=$row['periode_nama'];?></td>
									<td><?=$row['jurusan_nama'];?></td>
									<td><?=tgl_id($row['siswa_tgl_daftar']);?></td>	
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="box-footer">
					<a href="?mod=ppdb&hal=pendaftar" class="btn btn-warning"><i class="fa fa-search"></i> SELENGKAPNYA</a>
				</div>
			</div>
		</div>
	</div>
</div>