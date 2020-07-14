<?php
defined("RESMI") or die("Akses ditolak");
if(isset($_SESSION['SaveData'])){
    ?>
    <script>
        swal({ 
                title: "Berhasil",
                text: "Data prestasi anda berhasil disimpan",
                type: "success" 
            },
                function(){
                    window.location.href = 'index.php?mod=ppdb&hal=prestasi';
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
                <h3 class="box-title"><i class="fa fa-trophy"></i> DATA PRESTASI</h3>&nbsp;&nbsp;<a href="#AddData" class="btn btn-primary" data-toggle="modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i> Tambah Data</a>
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
                    $b = $db->prepare("SELECT * FROM us_prestasi WHERE prestasi_siswa = :idSiswa");
                    $b->execute(array(':idSiswa' => $_SESSION['idSiswa']));
                    $no = 1;
                    ?>
                    <table id="prestasi" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>                            
                                <th>Jenis</th>
                                <th>Tingkat</th>
                                <th>Nama</th>
                                <th>Tahun</th>
                                <th>Penyelenggara</th>
                                <th>Peringkat</th>
                                <th>Edit/Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($b->fetchAll() as $row){ ?>
                                <tr>
                                    <td><?= $no++;?></td>
                                    <td><?= $row['prestasi_jenis'];?></td>
                                    <td><?= $row['prestasi_tingkat'];?></td>
                                    <td><?= $row['prestasi_nama'];?></td>
                                    <td><?= $row['prestasi_thn'];?></td>
                                    <td><?= $row['prestasi_panitia'];?></td>
                                    <td><?= $row['prestasi_peringkat'];?></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="" class="btn btn-primary"
                                            data-backdrop="static" data-keyboard="false" data-toggle="modal"
                                            data-target="#EditData"
                                            data-prestasi_id="<?=$row['prestasi_id'];?>"
                                            data-prestasi_siswa="<?=$row['prestasi_siswa'];?>"
                                            data-prestasi_jenis="<?=$row['prestasi_jenis'];?>"
                                            data-prestasi_tingkat="<?=$row['prestasi_tingkat'];?>"
                                            data-prestasi_nama="<?=$row['prestasi_nama'];?>"
                                            data-prestasi_thn="<?=$row['prestasi_thn'];?>"
                                            data-prestasi_panitia="<?=$row['prestasi_panitia'];?>"
                                            data-prestasi_peringkat="<?=$row['prestasi_peringkat'];?>"><i class="fa fa-edit"></i></a>
                                            <a href="" class="btn btn-primary btn-del" data-id="<?=$row['prestasi_id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
<!-- Add Data -->
<div class="modal fade" tabindex="-1" role="dialog" id="AddData">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Data</h4>
            </div>
        <form method="post" action="post.php?mod=ppdb&hal=prestasi_add">
            <div class="modal-body">            
                <div class="form-group">
                    <label for="">Jenis Prestasi</label>                       
                    <select name="jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis Prestasi --</option>
                        <option value="01) Sains">01) Sains</option>
                        <option value="02) Seni">02) Seni</option>
                        <option value="03) Olahraga">03) Olahraga</option>
                        <option value="04) lain-lain">04) lain-lain</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Tingkat</label>
                    <select name="tingkat" class="form-control" required>
                        <option value="">-- Pilih Tingkat --</option>                        
                        <option value="1) Sekolah">1) Sekolah</option>
                        <option value="2) Kecamatan">2) Kecamatan</option>
                        <option value="3) Kabupaten">3) Kabupaten</option>
                        <option value="4) Provinsi">4) Provinsi</option>
                        <option value="5) Nasional">5) Nasional</option>
                        <option value="6) Internasional">6) Internasional</option>
                    </select>           
                </div> 
                <div class="form-group">
                    <label class="control-label">Nama Prestasi</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" required>
                </div>    
                <div class="form-group">
                    <label class="control-label">Penyelenggara</label>
                    <input type="text" name="panitia" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Peringkat</label>
                    <input type="text" name="peringkat" class="form-control" required>
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
<!-- Edit Data -->
<div class="modal fade" tabindex="-1" role="dialog" id="EditData">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Data</h4>
            </div>
        <form method="post" action="post.php?mod=ppdb&hal=prestasi_ed">
            <div class="modal-body">            
                <div class="form-group">
                    <input type="hidden" name="prestasi_id">
                    <input type="hidden" name="prestasi_siswa">
                    <label for="">Jenis Prestasi</label>                       
                    <select name="prestasi_jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis Prestasi --</option>
                        <option value="01) Sains">01) Sains</option>
                        <option value="02) Seni">02) Seni</option>
                        <option value="03) Olahraga">03) Olahraga</option>
                        <option value="04) lain-lain">04) lain-lain</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Tingkat</label>
                    <select name="prestasi_tingkat" class="form-control" required>
                        <option value="">-- Pilih Tingkat --</option>                        
                        <option value="1) Sekolah">1) Sekolah</option>
                        <option value="2) Kecamatan">2) Kecamatan</option>
                        <option value="3) Kabupaten">3) Kabupaten</option>
                        <option value="4) Provinsi">4) Provinsi</option>
                        <option value="5) Nasional">5) Nasional</option>
                        <option value="6) Internasional">6) Internasional</option>
                    </select>           
                </div> 
                <div class="form-group">
                    <label class="control-label">Nama Prestasi</label>
                    <input type="text" name="prestasi_nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Tahun</label>
                    <input type="number" name="prestasi_thn" class="form-control" required>
                </div>    
                <div class="form-group">
                    <label class="control-label">Penyelenggara</label>
                    <input type="text" name="prestasi_panitia" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Peringkat</label>
                    <input type="text" name="prestasi_peringkat" class="form-control" required>
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
        var ot = $('#prestasi').dataTable({"responsive": true,"iDisplayLength": 20,"ordering": false});
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
                            hal:'prestasi_del',
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
        $('#EditData').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            $(this).find('input[name="prestasi_id"]').val('')
            $(this).find('input[name="prestasi_siswa"]').val('')  
            $(this).find('select[name="prestasi_jenis"]').val('')
            $(this).find('select[name="prestasi_tingkat"]').val('')
            $(this).find('input[name="prestasi_nama"]').val('')
            $(this).find('input[name="prestasi_thn"]').val('')
            $(this).find('input[name="prestasi_panitia"]').val('')
            $(this).find('input[name="prestasi_peringkat"]').val('')             
            if(button.data('prestasi_id') != ''){
                var prestasi_id        = button.data('prestasi_id')
                var prestasi_siswa     = button.data('prestasi_siswa')          
                var prestasi_jenis     = button.data('prestasi_jenis')
                var prestasi_tingkat   = button.data('prestasi_tingkat')
                var prestasi_nama      = button.data('prestasi_nama')
                var prestasi_thn       = button.data('prestasi_thn')
                var prestasi_panitia   = button.data('prestasi_panitia')
                var prestasi_peringkat = button.data('prestasi_peringkat')
                $(this).find('input[name="prestasi_id"]').val(prestasi_id)
                $(this).find('input[name="prestasi_siswa"]').val(prestasi_siswa)  
                $(this).find('select[name="prestasi_jenis"]').val(prestasi_jenis)
                $(this).find('select[name="prestasi_tingkat"]').val(prestasi_tingkat)
                $(this).find('input[name="prestasi_nama"]').val(prestasi_nama)
                $(this).find('input[name="prestasi_thn"]').val(prestasi_thn)
                $(this).find('input[name="prestasi_panitia"]').val(prestasi_panitia)
                $(this).find('input[name="prestasi_peringkat"]').val(prestasi_peringkat)       
            }
        });        
    });
</script>