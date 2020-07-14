<?php
defined("RESMI") or die("Akses ditolak");
if(isset($_SESSION['SaveData'])){
    ?>
    <script>
        swal({ 
                title: "Berhasil",
                text: "Status CPDB berhasil diubah",
                type: "success"                 
            },
                function(){
                    window.location.href = 'index.php?mod=ppdb&hal=pendaftar';
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
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">DATA PENDAFTAR&nbsp;<a href="../save_excel.php" target="_blank" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> EXPORT KE EXCEL</a></h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<?php
                    if(isset($error)){ 
                    //$count = count($_SESSION['errData']);
                        foreach($error as $galat){
                            ?>
                            <div class="alert alert-danger">                        
                                <h4><i class="icon fa fa-ban"></i> Galat</h4>
                                <?php echo $galat; ?>
                                <meta http-equiv="refresh" content="5">
                            </div>
                            <?php
                        }                                      
                    }      
                    ?>
					<?php
                        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
                        $limit = 15;
                        $limit_start = ($page - 1) * $limit;
						$a = $db->prepare("SELECT * FROM us_pendaftar up
							LEFT JOIN us_ortu uo ON up.siswa_id=uo.ot_siswa
							LEFT JOIN us_periodik upe ON up.siswa_id=upe.periodik_siswa
							LEFT JOIN us_registrasi ur ON up.siswa_id=ur.register_siswa
							LEFT JOIN us_jurusan uj ON up.siswa_jurusan=uj.jurusan_id
							LEFT JOIN us_periode upr ON up.siswa_gelombang=upr.periode_id
							ORDER BY up.siswa_id ASC LIMIT ".$limit_start.",".$limit."");
						$a->execute();						
						$no = $limit_start+1;
					?>
					<table id="siswa" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>Nama Pendaftar</th>
								<th>Nomor Pendaftaran</th>
								<th>Gelombang</th>
								<th>Jurusan Pilihan</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($a->fetchAll() as $row){ 
								$token = urlencode(encryptor('encrypt', $row['siswa_id']));
							?>
							<tr>
								<td><?= $no++;?></td>
								<td><?=$row['siswa_nama'];?></td>
								<td><?=$row['siswa_no_daftar'];?></td>
								<td><?=$row['periode_nama'];?></td>
								<td><?=$row['jurusan_nama'];?></td>
								<td>
									<?php
										if($row['siswa_status_pdb'] === '0'){
											echo 'Ditolak';
										}elseif($row['siswa_status_pdb'] === '1'){
											echo "Diterima";
										}else{
											echo "Belum Ditentukan";
										}
									?>&nbsp;<a href="index.php?mod=ppdb&hal=pendaftar_statusEd&tingal=<?=$token;?>"><i class="fa fa-edit"></i></a>
								</td>		
								<td>
									<div class="btn-group btn-group-sm">
                                        <a href="" class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#EdPass" data-siswa_id="<?=$row['siswa_id'];?>" data-no_daftar="<?=$row['siswa_no_daftar'];?>" data-nama_siswa="<?=$row['siswa_nama'];?>"><i class="fa fa-lock"></i></a>
										<a href="index.php?mod=ppdb&hal=pendaftar_view&tingal=<?=$token;?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
										<a target="_blank" href="../cetak/ctkForm.php?tingal=<?=$token;?>" class="btn btn-primary"><i class="fa fa-print"></i></a>
										<a href="" class="btn btn-primary btn-del" data-id="<?=$row['siswa_id'];?>"><i class="fa fa-trash"></i></a>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
                    <ul class="pagination">
                        <?php
                            if ($page == 1) { 
                        ?>
                        <li class="disabled"><a href="#">First</a></li>
                        <li class="disabled"><a href="#">&laquo;</a></li>
                        <?php
                            } else { // Jika buka page ke 1
                                $link_prev = ($page > 1) ? $page - 1 : 1;
                        ?>
                        <li><a href="index.php?mod=ppdb&hal=pendaftar&page=1">First</a></li>
                        <li><a href="index.php?mod=ppdb&hal=pendaftar&page=<?php echo $link_prev; ?>">&laquo;</a></li>
                        <?php
                            }
                        ?>
                        <!-- LINK NUMBER -->
                        <?php
                        // Buat query untuk menghitung semua jumlah data
                        $sql2 = $db->prepare("SELECT COUNT(*) FROM us_pendaftar");
                        $sql2->execute(); // Eksekusi querynya
                        $jml = $sql2->fetchColumn();

                        $jumlah_page = ceil($jml / $limit); // Hitung jumlah halamanya
                        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                        $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link member
                        $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

                        for ($i = $start_number; $i <= $end_number; $i++) {
                            $link_active = ($page == $i) ? 'class="active"' : '';
                        ?>
                        <li <?php echo $link_active; ?>><a href="index.php?mod=ppdb&hal=pendaftar&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php
                            }
                        ?>
                        <!-- LINK NEXT AND LAST -->
                        <?php
                        // Jika page sama dengan jumlah page, maka disable link NEXT nya
                        // Artinya page tersebut adalah page terakhir
                            if ($page == $jumlah_page) { // Jika page terakhir
                        ?>
                        <li class="disabled"><a href="#">&raquo;</a></li>
                        <li class="disabled"><a href="#">Last</a></li>
                        <?php
                            } else { // Jika bukan page terakhir
                            $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
                        ?>
                        <li><a href="index.php?mod=ppdb&hal=pendaftar&page=<?php echo $link_next; ?>">&raquo;</a></li>
                        <li><a href="index.php?mod=ppdb&hal=pendaftar&page=<?php echo $jumlah_page; ?>">Last</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                    <p class="help-text">Jumlah Data: <span class="label bg-blue"><?= $jml?></span></p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Edit Data -->
<div class="modal fade" tabindex="-1" role="dialog" id="Status">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Status Kelulusan CPDB</h4>
            </div>
        <form method="post" action="post.php?mod=ppdb&hal=pendaftar_statusEd">
            <div class="modal-body">            
                <div class="form-group">
                	<label>Nama CPDB</label>
                    <input type="hidden" name="siswa_id">
                    <input type="text" name="siswa_nama" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Jenis Pendaftaran</label>
                    <select name="siswa_jenis_daftar" class="form-control" required>
                        <option value="">-- Pilih Jenis Pendaftaran --</option>
                        <option value="Baru">Baru</option>
                        <option value="Pindahan">Pindahan</option>
                    </select>
                </div> 
                <div class="form-group">
                	<label>Status PPDB</label>
                	<select name="siswa_status_pdb" class="form-control" required>
                		<option value="">-- Pilih Status CPDB --</option>
                		<option value="1">Diterima</option>
                		<option value="0">Ditolak</option>
                	</select>
                </div> 
                <div class="form-group">
                	<label>Jurusan</label>
                	<?php
                		$jur = $db->prepare("SELECT * FROM us_jurusan");
                		$jur->execute();
                	?>
                	<select name="siswa_jurusan" class="form-control">
                		<option value="">--Pilih Jurusan --</option>
                		<?php foreach($jur->fetchAll() as $jr){ ?>
                			<option value="<?=$jr['jurusan_id'];?>"><?=$jr['jurusan_nama'];?></option>
                		<?php } ?><
                	</select>
                </div>      
                <div class="form-group">                                         
                    <label>Keterangan</label>
                    <textarea cols="2" name="siswa_status_ket" class="form-control"></textarea>
                    <p class="help-text">Keterangan atau instruksi untuk pendaftar</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Simpan</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!--Reset Password -->
<div class="modal fade" tabindex="-1" role="dialog" id="EdPass">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Password Pendaftar</h4>
            </div>
        <form method="post" action="post.php?mod=ppdb&hal=pendaftar_pass">
            <div class="modal-body">            
                 <div class="form-group">
                    <label class="control-label">Nama Siswa</label>
                    <input type="hidden" name="siswa_id">
                    <input type="text" name="nama_siswa" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label class="control-label">Nomor Pendaftaran</label>                    
                    <input type="text" name="no_daftar" class="form-control" readonly>
                </div>                 
                <div class="form-group has-feedback">
                    <label class="control-label">Password</label>
                    <input type="text" name="password" class="form-control" value="ppdbm32020" required>
                    <p class="help-text">Password default: <span class="text-red">ppdbm32020</span>. Silahkan ganti sesuai kebutuhan.</p>
                </div>       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Simpan</button>
            </div>
        </form>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
        var ot = $('#siswa').dataTable({"paging": false,"info": false,"ordering":false}); 
        $('#Status').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            $(this).find('input[name="siswa_id"]').val('')
            $(this).find('input[name="siswa_nama"]').val('')  
            $(this).find('select[name="siswa_status_pdb"]').val('')
            $(this).find('input[name="siswa_status_ket"]').val('')
            $(this).find('select[name="siswa_jurusan"]').val('')
            $(this).find('select[name="siswa_jenis_daftar"]').val('')
            if(button.data('siswa_id') != ''){
                var siswa_id           = button.data('siswa_id')
                var siswa_nama         = button.data('siswa_nama')          
                var siswa_status_pdb   = button.data('siswa_status_pdb')
                var siswa_status_ket   = button.data('siswa_status_ket')                
                var siswa_jurusan      = button.data('siswa_jurusan')
                var siswa_jenis_daftar = button.data('siswa_jenis_daftar')
                $(this).find('input[name="siswa_id"]').val(siswa_id)
                $(this).find('input[name="siswa_nama"]').val(siswa_nama)  
                $(this).find('select[name="siswa_status_pdb"]').val(siswa_status_pdb)
                $(this).find('input[name="siswa_status_ket"]').val(siswa_status_ket)
                $(this).find('select[name="siswa_jurusan"]').val(siswa_jurusan)
                $(this).find('select[name="siswa_jenis_daftar"]').val(siswa_jenis_daftar)                       
            }
        });
        $('.btn-del').click(function(e){
            e.preventDefault()
            var button = $(this)
            bootbox.confirm({
                title: "Konfirmasi penghapusan",
                message: "Data yang terhapus tidak dapat dikembalikan, yakin ingin menghapus data ini?",
                buttons: {
                    confirm: {
                        label: 'Ya',
                        className: 'btn-info btn-flat'
                    },
                    cancel: {
                        label: 'Tidak',
                        className: 'btn-danger btn-flat'
                    },
                },
                callback: function (result) {
                    if(result == true){
                        var data = {
                            mod:'ppdb',
                            hal:'pendaftar_del',
                            id:button.data('id')
                        }
                        var sel_row = button.parent().parent().parent();
                        $.get('post.php', data, function(hasil){
                            ot.fnDeleteRow(sel_row);
                            swal("Sukses", "Data berhasil dihapus", "success");            
                        });
                    }
                }
            });      
        });
        $('#EdPass').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)            
            $(this).find('input[name="siswa_id"]').val('')
            $(this).find('input[name="no_daftar"]').val('')                        
            $(this).find('input[name="nama_siswa"]').val('')
            if(button.data('siswa_id') != ''){
                var siswa_id   = button.data('siswa_id')
                var no_daftar  = button.data('no_daftar')                                
                var nama_siswa = button.data('nama_siswa')
                $(this).find('input[name="siswa_id"]').val(siswa_id)
                $(this).find('input[name="no_daftar"]').val(no_daftar)                        
                $(this).find('input[name="nama_siswa"]').val(nama_siswa)                               
            }
        });       
   	});
</script>