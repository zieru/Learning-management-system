
<br>

<div class="row">
<div class="panel panel-default">
                        <div class="panel-heading">
                        <h1 style="text-align:center;width:100%;">Pencarian <?php echo $situs['judul'];?></h1>
                        <form action="" method="GET" enctype="multiform/data">
                        <?php 
                        if(isset($_GET['keyword']))
                        {
                        	$keyword = sprintf('%s',$_GET['keyword']);
                        	$tagkeyword = sprintf('value="%s"',$_GET['keyword']);
                        }
                        
                        include 'mesin_pencari.php';
                        ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="background:#fff;">
                        
                        <div class="col-md-3" style="padding-left:0px;">    
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-stacked">
                                <li class="active" ><a href="#hasil" data-toggle="tab" aria-expanded="true"><i class="fa fa-fw fa-search"></i>Hasil pencarian</a>
                                </li>
                                <li class="" ><a href="#pengaturan" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-gear"></i>Pengaturan pencarian</a>
                                </li>
                            </ul>
                        </div>   
                        
                        <div class="col-md-9">        
                            <!-- Tab panes -->
                            <div class="tab-content" style="padding-top:10px;">

                            	<div class="tab-pane fade" id="pengaturan" style="list-style:none;">
                                    <?php include 'pengaturan.php';?>
                                    </form>
                                </div>

                                <div class="tab-pane fade active in" id="hasil">
                                    <?php include 'hasil.php'; ?>
                                </div>
                                
                            </div>
                        </div>   

                        </div>
                        <!-- /.panel-body -->
                    </div>
</div>                    