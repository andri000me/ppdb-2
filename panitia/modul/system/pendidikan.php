<?php
defined("RESMI") or die("Akses ditolak");
if(isset($_SESSION['SaveData'])){
    ?>
    <script>
        swal({ 
                title: "Berhasil",
                text: "Data Pendidikan berhasil disimpan",
                type: "success" 
            },
                function(){
                    window.location.href = 'index.php?mod=system&hal=pendidikan';
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
                <h3 class="box-title">Data Pendidikan</h3>&nbsp;&nbsp;<a href="#AddData" class="btn btn-primary" data-toggle="modal">Tambah Data</a>
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
                $sqla = $db->prepare("SELECT pend_id, pend_kd, pend_nama FROM us_pendidikan");
                $sqla->execute();
                $no = 1;
                ?>
                <table id="pend" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Urut</th>
                            <th>Kode Pendidikan</th>
                            <th>Nama Pendidikan</th>
                            <th>Action</th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sqla->fetchAll() as $row){ ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?= $row['pend_kd']?></td>
                                <td><?= $row['pend_nama']?></td>                                                
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="" class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#EditData"
                                        data-pend_id="<?=$row['pend_id'];?>"
                                        data-pend_kd="<?=$row['pend_kd'];?>"
                                        data-pend_nama="<?=$row['pend_nama'];?>"><i class="fa fa-edit"></i></a>
                                        <a href="" class="btn btn-primary btn-del" data-id="<?=$row['pend_id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        <form method="post" action="post.php?mod=system&hal=pendidikan_add">
            <div class="modal-body">            
                <div class="form-group">
                    <label for="">Kode Pendidikan</label>                       
                    <input type="text" name="kode" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Nama Pendidikan</label>
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
        <form method="post" action="post.php?mod=system&hal=pendidikan_ed">
            <div class="modal-body">            
                <div class="form-group">
                    <label for="">Kode Pendidikan</label>    
                    <input type="hidden" name="pend_id">                   
                    <input type="text" name="pend_kd" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Nama Pendidikan</label>
                    <input type="text" name="pend_nama" class="form-control" required>           
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
        var ot = $('#pend').dataTable({"iDisplayLength": 20,"ordering": false});
        $('#EditData').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            $(this).find('input[name="pend_id"]').val('')
            $(this).find('input[name="pend_kd"]').val('')
            $(this).find('input[name="pend_nama"]').val('')            
            if(button.data('pend_id') != ''){
                var pend_id   = button.data('pend_id')
                var pend_kd   = button.data('pend_kd')
                var pend_nama = button.data('pend_nama')                
                $(this).find('input[name="pend_id"]').val(pend_id)
                $(this).find('input[name="pend_kd"]').val(pend_kd)
                $(this).find('input[name="pend_nama"]').val(pend_nama)                
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
                            hal:'pend_del',
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