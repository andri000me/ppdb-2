<?php
defined("RESMI") or die("Akses ditolak");
if(isset($_SESSION['SaveData'])){
    ?>
    <script>
        swal({ 
                title: "Berhasil",
                text: "Password anda berhasil diubah",
                type: "success" 
            },
                function(){
                    window.location.href = 'index.php';
            });
    </script>
    <?php
    unset($_SESSION['SaveData']);
}
if(isset($_SESSION['errData'])){
    $error[] = $_SESSION['errData'];
    unset($_SESSION['errData']);
}
?>
<div class="row">
	<div class="col-md-8">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">PPDB Online <?= $skl['sekolah_nama'];?></h3>
			</div>
			<div class="box-body">
				<h3>Selamat datang, <?= $sis['siswa_nama'];?>&nbsp;[<?=$_SESSION['noDaftar'];?>]</h3>
				<b>Berikut informasi login anda</b><br>				
				Username: <span class="text-red"><?=$sis['siswa_no_daftar'];?></span><br>
				Password: <span class="text-red"><?=$sis['siswa_key'] ;?></span>&nbsp;&nbsp;
				<a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#EditPass" data-siswa_id="<?=$sis['siswa_id'];?>" data-siswa_key="<?=$sis['siswa_key'];?>"><i class="fa fa-edit"></i>Ganti Password</a><br>
				Silahkan gunakan menu di sebelah kiri untuk melengkapi formulir pendaftaran serta info-info lainnya.<br>
				Sebelum mengisi formulir pendaftaran, mohon persiapkan hal-hal berikut:<br>
				<ol>
					<li>No Kartu Keluarga</li>
					<li>Nomor Induk Kependudukan</li>
					<li>Nomor Registrasi Akta Lahir</li>
					<li>Nyalakan/enable-kan lokasi di handphone untuk menentukan posisi lintang dan bujur tempat tinggal<br>
                        <a href="../asset/img/location.png" data-toggle="lightbox"><img alt="Lokasi HP" class="img-responsive" src="../asset/img/location.png" style="width:30%" /></a>
                    </li>
                    <li>Lengkapi Formulir Pendaftaran melalui Menu PENDAFTARAN sebelah kiri<br>
                        <img src="../asset/img/menu-daftar.png" class="img-responsive">
                    </li>
					<!--<li>Menentukan garis lintang dan bujur tempat tinggal dengan cara berikut<br>				<ul>
							<li>Nyalakan Location di HP</li>
							<li>Buka aplikasi Google Maps</li>
							<li>Tap/tekan lama pada area tempat tinggal anda. Anda akan melihat pin merah muncul</li>
							<li>Koordinat lintang dan bujur akan muncul di kotak telusur di bagian atas</li>
							<li>
								<img class="img-responsive zoom" src="../assets/img/maps.png" style="width: 60%">
							</li>
							<li>Catat kedua koordinat kemudian pastekan ke kolom lintang dan bujur yang ada di menu <a href="index.php?mod=ppdb&hal=pribadi">DATA PRIBADI</a></li>
						</ul>
					</li>-->
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Panitia PPDB Online <?= $skl['sekolah_nama'];?></h3>
			</div>
			<div class="box-body">
				<p>
                    <i class="fa fa-bank"> </i><?=$skl['sekolah_nama'];?><br>
                    <i class="fa fa-map-marker"></i> <?=$skl['sekolah_alamat'];?><br>
                    <i class="fa fa-phone"></i> <?=$skl['sekolah_telpon'];?><br>
                </p>
                    <p><i class="fa fa-whatsapp"></i> <a href="https://api.whatsapp.com/send?phone=<?=$skl['sekolah_hp'];?>&amp;text=<?=$skl['sekolah_pesan'];?>"><?=$skl['sekolah_hp'];?></a> - <?=$skl['sekolah_kontak1'];?></p>
                    <p><i class="fa fa-whatsapp"></i> <a href="https://api.whatsapp.com/send?phone=<?=$skl['sekolah_hp2'];?>&amp;text=<?=$skl['sekolah_pesan'];?>"><?=$skl['sekolah_hp2'];?></a> - <?=$skl['sekolah_kontak2'];?></p>
                    <p class="small">Tap/klik pada nomor diatas untuk menghubungi langsung melalui Whatsapp</p>
			</div>
		</div>
	</div>
</div>
<!-- Edit Data -->
<div class="modal fade" tabindex="-1" role="dialog" id="EditPass">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Data</h4>
            </div>
        <form method="post" action="post.php?mod=ppdb&hal=pass_ed">
            <div class="modal-body">            
                 <div class="form-group">
                    <label class="control-label">Password Saat ini</label>
                    <input type="hidden" name="siswa_id">
                    <input type="text" name="siswa_key" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label class="control-label">Password Baru</label>
                    <input class="form-control" id="password" name="password" type="password" pattern="^\S{8,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Harus memiliki minimal 8 karakter' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Password" required>
                    <p class="help-text">Password minimal 8 karakter</p>
                </div>
                <div class="form-group">
                    <label class="control-label">Ulangi Password Baru</label>
                    <input class="form-control" id="password_two" name="password_two" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Password tidak sama dengan kolom sebelumnya' : '');" placeholder="Ulangi Password" required>
                    <p class="help-text">Konfirmasi Password</p>
                </div>       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Simpan</button>
            </div>
        </form>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		$('#EditPass').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)            
            $(this).find('input[name="siswa_id"]').val('')
            $(this).find('input[name="siswa_key"]').val('')            
            if(button.data('siswa_id') != ''){
                var siswa_id = button.data('siswa_id')
                var siswa_key = button.data('siswa_key')                
                $(this).find('input[name="siswa_id"]').val(siswa_id)
                $(this).find('input[name="siswa_key"]').val(siswa_key)                
            }
        });      
	});	
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>