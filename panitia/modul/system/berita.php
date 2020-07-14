<?php
defined("RESMI") or die("Akses ditolak");

?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-newspaper-o"></i> Berita/Pengumuman PPDB</h3>
                <div class="pull-right">
                    <a href="?mod=system&hal=berita_add" class="btn btn-warning"><i class="fa fa-plus"></i> Tambah Data</a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <?php
                    $sql = $db->prepare("SELECT * FROM us_berita ORDER BY berita_id ASC");
                    $sql->execute();
                    $no = 1;
                    ?>
                    <table id="berita" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Berita</th>
                                <th>Isi Berita</th>
                                <th>Tanggal Kirim</th>
                                <th>Tampil</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>    
                            <?php foreach($sql->fetchAll() as $b){ ?>                        
                                <tr>                                    
                                    <td><?=$no++;?></td>
                                    <td><?=$b['berita_judul'];?></td>
                                    <td><?= substr($b['berita_isi'], 0, 50);?>[...]</td>
                                    <td><?=tgl_id($b['berita_tgl']);?></td>
                                    <td>
                                        <?php
                                        if($b['berita_tampil'] === '1'){
                                            echo "Ya";
                                        }else{
                                            echo "Tidak";
                                        }
                                        ?>                                            
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="?mod=system&hal=berita_ed&id=<?=$b['berita_id'];?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                            <a href="" class="btn btn-danger btn-del" data-id="<?=$b['berita_id'];?>" aria-hidden="true"><i class="fa fa-trash"></i></a>
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
<script>
    $(document).ready(function(){
        var ot = $('#berita').dataTable({"iDisplayLength": 20,"ordering": false});
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
                            hal:'berita_del',
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