<?php
defined("RESMI") or die("Akses ditolak");

?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Data Periode Pendaftaran</h3>
                <div class="pull-right">
                    <a href="?mod=system&hal=periode_add" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a>
                </div>
                <p class="help-text" style="color: #9eacb4;">Digunakan untuk menampilkan dan mengelola periode pendaftaran calon peserta didik baru</p>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <?php
                        $a = $db->prepare("SELECT * FROM us_periode ORDER BY periode_id ASC");
                        $a->execute();
                        $no = 1;
                    ?>
                    <table id="periode" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Periode</th>
                                <th>Periode Dibuka</th>
                                <th>Tanggal Pendaftaran</th>
                                <th>Berbayar</th>
                                <th>Dibuka</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($a->fetchAll() as $row) { 
                                $tanggal = date('Y-m-d', strtotime($row['periode_tgl_akhir']));
                            ?>
                            <tr>
                                <td><?=$no++;?></td>
                                <td><?=$row['periode_nama'];?></td>
                                <td><?=$row['periode_tp'];?></td>
                                <td><?=tgl_id($row['periode_tgl_awal']).' - '.tgl_id($row['periode_tgl_akhir']);?></td>
                                <td>
                                    <?php
                                        if($row['periode_berbayar'] === '0'){
                                            echo "Tidak";
                                        }else{
                                            echo "Ya";
                                        }
                                    ?>                                        
                                </td>
                                <td>
                                    <?php
                                        if($row['periode_status'] === '0'){
                                            echo "Tidak";
                                        }else{
                                            echo "Ya";
                                        }
                                    ?>                                        
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="?mod=system&hal=periode_ed&id=<?=$row['periode_id'];?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        <a href="" class="btn btn-danger btn-del" data-id="<?=$row['periode_id'];?>" aria-hidden="true"><i class="fa fa-trash"></i></a>
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
        var ot = $('#periode').dataTable({"iDisplayLength": 20,"ordering": false});
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
                            hal:'periode_del',
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