<br>
<div class="row">
<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th fa-fw"></i> Kategori Materi <?php echo  $input->button('Baru',$go->to('materi','kategori-baru')) ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php
                        $sql       = sprintf("SELECT * FROM tb_materi_kategori");
                        $kueri_ambil_kategori = $db2->query($sql);
                        $jumlah_kategori = $kueri_ambil_kategori->rowCount();
                        ?>
                            <div class="list-group">
                            <?php
                            if($jumlah_kategori == 0){echo 'tidak ada data';}
                            while($kategori = $kueri_ambil_kategori->fetch())
                            {
                            ?>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> <?php echo $kategori['nama_kategori'] ?>
                                    <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                                </a>
                            <?php
                            }
                            ?>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>                    
</div>                    