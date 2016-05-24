<?php
if(!isset($tagkeyword))
{
    $tagkeyword = NULL;
}

if(!isset($pencarian['pengaturan']))
{
    $pencarian['pengaturan'] = NULL;
}

?>
                        
                            <div class="input-group custom-search-form">
                                <input type="hidden" name="sub" value="pencarian">
                                <input type="text" class="form-control" name="keyword" placeholder="Cari..." <?php echo $tagkeyword; ?> >


                                <span class="input-group-btn">

                                    <div class="btn-group">
                                        <?php if($pencarian['pengaturan'] == TRUE)
                                        {?>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="fa fa-gear"></i>
                                        </button>


                                        <?php
                                        echo '<ul class="dropdown-menu" style="left: -162px;">

                                            <li class="dropdown-header">PENGATURAN PENCARIAN</li>  
                                            <li role="separator" class="divider"></li> ';
                                        include 'opsi_pencarian.php';
                                        echo '</ul>';

                                         }?>
                                    </div>


                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>

                                </span>

                            </div>




<?php
$pencarian['pengaturan'] = NULL;
?>                        