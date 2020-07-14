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
                    window.location.href = 'index.php?mod=ppdb&hal=beasiswa';
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
                <h3 class="box-title"><i class="fa fa-money"></i> DATA BEASISWA</h3>&nbsp;&nbsp;<a href="#AddData" class="btn btn-primary" data-toggle="modal" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i> Tambah Data</a>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <?php
                        if(isset($error)){                     
                            foreach($error as $galat){ ?>
                                <div class="alert alert-danger">                        
                                    <h4><i class="icon fa fa-ban"></i> Galat</h4>
                                    <?php echo $galat; ?>
                                    <meta http-equiv="refresh" content="5">
                                </div>
                            <?php
                            }                                      
                        }
                        $a = $db->prepare("SELECT * FROM us_beasiswa WHERE beasiswa_siswa = ?");
                        $a->execute(array($_SESSION['idSiswa']));
                        $no = 1;
                    ?>
                    <table id="beasiswa" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Beasiswa</th>
                                <th>Keterangan</th>
                                <th>Tahun Mulai</th>
                                <th>Tahun Selesai</th>
                                <th>Edit/Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($a->fetchAll() as $row){ ?>
                                <tr>
                                    <td><?= $no++;?></td>
                                    <td><?= $row['beasiswa_jenis'];?></td>
                                    <td><?= $row['beasiswa_keterangan'];?></td>
                                    <td><?= $row['beasiswa_thn_mulai'];?></td>
                                    <td><?= $row['beasiswa_thn_selesai'];?></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="" class="btn btn-primary"
                                            data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#EditData"
											data-beasiswa_id="<?= $row['beasiswa_id'];?>"
											data-beasiswa_siswa="<?=$row['beasiswa_siswa'];?>"
                                            data-beasiswa_keterangan="<?=$row['beasiswa_keterangan'];?>"
											data-beasiswa_jenis="<?=$row['beasiswa_jenis'];?>"
											data-beasiswa_thn_mulai="<?=$row['beasiswa_thn_mulai'];?>"
											data-beasiswa_thn_selesai="<?= $row['beasiswa_thn_selesai'];?>"><i class="fa fa-edit"></i></a>
											<a href="" class="btn btn-primary btn-del" data-id="<?=$row['beasiswa_id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        <form method="post" action="post.php?mod=ppdb&hal=beasiswa_add">
            <div class="modal-body">            
                <div class="form-group">                    
                    <label for="">Jenis Beasiswa</label>                       
                    <select name="jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis Beasiswa --</option>
                        <option value="01) Anak berprestasi">01) Anak berprestasi</option>
                        <option value="02) Anak miskin">02) Anak miskin</option>
                        <option value="03) Pendidikan">03) Pendidikan</option>
                        <option value="04) Unggulan">04) Unggulan</option>
                    </select>
                </div>                
                <div class="form-group">
                    <label class="control-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" required>
                    <p class="help-text">Mis. Beasiswa Murid Berprestasi Tahun 2018</p>
                </div>
                <div class="form-group">
                    <label class="control-label">Tahun Mulai</label>
                    <input type="number" name="thn_mulai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Tahun Selesai</label>
                    <input type="number" name="thn_selesai" class="form-control" required>
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
        <form method="post" action="post.php?mod=ppdb&hal=beasiswa_ed">
            <div class="modal-body">            
                <div class="form-group">
                    <input type="hidden" name="beasiswa_id">
                    <input type="hidden" name="beasiswa_siswa">
                    <label for="">Jenis Beasiswa</label>                       
                    <select name="beasiswa_jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis Beasiswa --</option>
                        <option value="01) Anak berprestasi">01) Anak berprestasi</option>
                        <option value="02) Anak miskin">02) Anak miskin</option>
                        <option value="03) Pendidikan">03) Pendidikan</option>
                        <option value="04) Unggulan">04) Unggulan</option>
                    </select>
                </div>                
                <div class="form-group">
                    <label class="control-label">Keterangan</label>
                    <input type="text" name="beasiswa_keterangan" class="form-control" required>
                    <p class="help-text">Mis. Beasiswa Murid Berprestasi Tahun 2018</p>
                </div>
                <div class="form-group">
                    <label class="control-label">Tahun Mulai</label>
                    <input type="number" name="beasiswa_thn_mulai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Tahun Selesai</label>
                    <input type="number" name="beasiswa_thn_selesai" class="form-control" required>
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
        var ot = $('#beasiswa').dataTable({"iDisplayLength": 20,"ordering": false});
        $('#EditData').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            $(this).find('input[name="beasiswa_id"]').val('')
            $(this).find('input[name="beasiswa_siswa"]').val('')
            $(this).find('select[name="beasiswa_jenis"]').val('')
            $(this).find('input[name="beasiswa_keterangan"]').val('')
            $(this).find('input[name="beasiswa_thn_mulai"]').val('')
            $(this).find('input[name="beasiswa_thn_selesai"]').val('')
            if(button.data('prestasi_id') != ''){
                var beasiswa_id          = button.data('beasiswa_id')
                var beasiswa_siswa       = button.data('beasiswa_siswa')
                var beasiswa_jenis       = button.data('beasiswa_jenis')
                var beasiswa_keterangan  = button.data('beasiswa_keterangan')
                var beasiswa_thn_mulai   = button.data('beasiswa_thn_mulai')
                var beasiswa_thn_selesai = button.data('beasiswa_thn_selesai')
                $(this).find('input[name="beasiswa_id"]').val(beasiswa_id)
                $(this).find('input[name="beasiswa_siswa"]').val(beasiswa_siswa)
                $(this).find('select[name="beasiswa_jenis"]').val(beasiswa_jenis)
                $(this).find('input[name="beasiswa_keterangan"]').val(beasiswa_keterangan)
                $(this).find('input[name="beasiswa_thn_mulai"]').val(beasiswa_thn_mulai)
                $(this).find('input[name="beasiswa_thn_selesai"]').val(beasiswa_thn_selesai)
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
                            hal:'beasiswa_del',
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
    });
</script>