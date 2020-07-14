<?php
defined("RESMI") or die("Akses ditolak");
if(isset($_SESSION['SaveData'])){
    ?>
    <script>
        swal({ 
                title: "Berhasil",
                text: "Data Jurusan berhasil disimpan",
                type: "success" 
            },
                function(){
                    window.location.href = 'index.php?mod=system&hal=jurusan';
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
                <h3 class="box-title">Data Jurusan</h3>&nbsp;&nbsp;<a href="#AddData" class="btn btn-primary" data-toggle="modal">Tambah Data</a>
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
                $sqla = $db->prepare("SELECT jurusan_id, jurusan_kd, jurusan_nama FROM us_jurusan");
                $sqla->execute();
                $no = 1;
                ?>
                <table id="jurusan" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Urut</th>
                            <th>Kode Jurusan</th>
                            <th>Nama Jurusan</th>
                            <th>Action</th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sqla->fetchAll() as $row){ ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?= $row['jurusan_kd']?></td>
                                <td><?= $row['jurusan_nama']?></td>                                                
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="" class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#EditData"
                                        data-jurusan_id="<?=$row['jurusan_id'];?>"
                                        data-jurusan_kd="<?=$row['jurusan_kd'];?>"
                                        data-jurusan_nama="<?=$row['jurusan_nama'];?>"><i class="fa fa-edit"></i></a>
                                        <a href="" class="btn btn-primary btn-del" data-id="<?=$row['jurusan_id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        <form method="post" action="post.php?mod=system&hal=jurusan_add">
            <div class="modal-body">            
                <div class="form-group">
                    <label for="">Kode Jurusan</label>                       
                    <input type="text" name="kode" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Nama Jurusan</label>
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
        <form method="post" action="post.php?mod=system&hal=jurusan_ed">
            <div class="modal-body">            
                <div class="form-group">
                    <label for="">Kode Jurusan</label>    
                    <input type="hidden" name="jurusan_id">                   
                    <input type="text" name="jurusan_kd" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label">Nama Jurusan</label>
                    <input type="text" name="jurusan_nama" class="form-control" required>           
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
        var ot = $('#jurusan').dataTable({"iDisplayLength": 20,"ordering": false});
        $('#EditData').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            $(this).find('input[name="jurusan_id"]').val('')
            $(this).find('input[name="jurusan_kd"]').val('')
            $(this).find('input[name="jurusan_nama"]').val('')            
            if(button.data('jurusan_id') != ''){
                var jurusan_id   = button.data('jurusan_id')
                var jurusan_kd   = button.data('jurusan_kd')
                var jurusan_nama = button.data('jurusan_nama')                
                $(this).find('input[name="jurusan_id"]').val(jurusan_id)
                $(this).find('input[name="jurusan_kd"]').val(jurusan_kd)
                $(this).find('input[name="jurusan_nama"]').val(jurusan_nama)                
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
                            hal:'jurusan_del',
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