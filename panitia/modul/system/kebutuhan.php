<?php
defined("RESMI") or die("Akses ditolak");
if(isset($_SESSION['SaveData'])){
    ?>
    <script>
        swal({ 
                title: "Berhasil",
                text: "Data Kebutuhan berhasil disimpan",
                type: "success" 
            },
                function(){
                    window.location.href = 'index.php?mod=system&hal=kebutuhan';
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
    <div class="col-md-10">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Data kebutuhan</h3>&nbsp;&nbsp;<a href="#AddData" class="btn btn-primary" data-toggle="modal">Tambah Data</a>
            </div>
            <div class="box-body">
                <?php
                if(isset($error)){                     
                    foreach($error as $galat){ ?>
                        <div class="alert alert-danger">                        
                            <h4><i class="icon fa fa-ban"></i> Galat</h4>
                            <?php echo $galat.'<br>'; ?>
                            <meta http-equiv="refresh" content="5">
                        </div>
                <?php
                    }                                      
                }
                $sqla = $db->prepare("SELECT kebutuhan_id, kebutuhan_kd, kebutuhan_nama FROM us_kebutuhan");
                $sqla->execute();
                $no = 1;
                ?>
                <table id="kebutuhan" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Urut</th>
                            <th>Kode kebutuhan</th>
                            <th>Nama kebutuhan</th>
                            <th>Action</th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sqla->fetchAll() as $row){ ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?= $row['kebutuhan_kd']?></td>
                                <td><?= $row['kebutuhan_nama']?></td>                                                
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="" class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#EditData"
                                        data-kebutuhan_id="<?=$row['kebutuhan_id'];?>"
                                        data-kebutuhan_kd="<?=$row['kebutuhan_kd'];?>"
                                        data-kebutuhan_nama="<?=$row['kebutuhan_nama'];?>"><i class="fa fa-edit"></i></a>
                                        <a href="" class="btn btn-primary btn-del" data-id="<?=$row['kebutuhan_id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
<!-- Add Data-->
<div class="modal fade" tabindex="-1" role="dialog" id="AddData">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Data</h4>
            </div>
        <form method="post" action="post.php?mod=system&hal=kebutuhan_add">
            <div class="modal-body">            
                <div class="form-group">
                    <label for="">Kode kebutuhan</label>                       
                    <input type="number" name="kode" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Nama kebutuhan</label>
                    <input type="text" name="nama" class="form-control" required>           
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
                <h4 class="modal-title">Ubah Data</h4>
            </div>
        <form method="post" action="post.php?mod=system&hal=kebutuhan_ed">
            <div class="modal-body">            
                <div class="form-group">
                    <label for="">Kode kebutuhan</label>    
                    <input type="hidden" name="kebutuhan_id">                   
                    <input type="text" name="kebutuhan_kd" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Nama kebutuhan</label>
                    <input type="text" name="kebutuhan_nama" class="form-control" required>           
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
        var ot = $('#kebutuhan').dataTable({"iDisplayLength": 20,"ordering": false});
        $('#EditData').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            $(this).find('input[name="kebutuhan_id"]').val('')
            $(this).find('input[name="kebutuhan_kd"]').val('')
            $(this).find('input[name="kebutuhan_nama"]').val('')            
            if(button.data('kebutuhan_id') != ''){
                var kebutuhan_id   = button.data('kebutuhan_id')
                var kebutuhan_kd   = button.data('kebutuhan_kd')
                var kebutuhan_nama = button.data('kebutuhan_nama')                
                $(this).find('input[name="kebutuhan_id"]').val(kebutuhan_id)
                $(this).find('input[name="kebutuhan_kd"]').val(kebutuhan_kd)
                $(this).find('input[name="kebutuhan_nama"]').val(kebutuhan_nama)                
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
                            mod:'system',
                            hal:'kebutuhan_del',
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