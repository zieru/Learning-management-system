<?php if(!isset($_GET['sub'])){
		$fix_layout = 'padding-left:10px;';
		$fix_layout = null;
	}
	else
	{
		$fix_layout =null;
		}
?>


<!-- Navigation -->
<div class="navbar-wrapper navbar-default" style="background-color: #f5f5f5;  border-bottom: 1px solid #e5e5e5; height:57px; position:fixed; width:100%; z-index:100">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom:0;">
            <div class="navbar-header" style="width:100%;">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $engine->uri('url'); ?>/index.php?">E.C.</a>

                        <li class="navbar-brand" style="width:300px; display:inline-block; padding-top:9px;">
                        <?php
                        $pencarian['pengaturan'] = TRUE;
                        echo '<form action="index.php?" method="GET" enctype="multiform/data">';
                        include $engine->view("pencarian/mesin_pencari");
                        echo '</form>';
                        ?>
                            <!-- /input-group -->
            
                        <li class="menukiri">                        
                            <a href="<?php echo $engine->uri('url'); ?>/index.php?">Beranda</a>                    
                            <a href="<?php echo $go->to('materi','list');?>">Materi</a>                    
                            <a href="<?php echo $go->to('forum','list'); ?>">Forum</a>                    
                        </li>                            
                        
                      </li>
            
            
            
             <ul class="nav navbar-top-links navbar-right" style="display:inline-block">
            <?php
            if(isset($_SESSION['login']))
            {?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <img src="<?php echo random_gravatar('20', $user['email'])?>">  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                    <div class=" dropdown-header header-nav-current-user css-truncate">
                    Masuk Sebagai <strong class="css-truncate-target"><?php echo $user['username'];?></strong>
                    </div>
        <div class="dropdown-divider"></div>
                        <li><a href="<?php echo $go->to('profil','lihat',$user['username']); ?>"><i class="glyphicon glyphicon-user fa-fw"></i> Profil</a></li>
                        <li><a href="<?php echo $go->to('profil','ubah',$user['username']); ?>"><i class="fa fa-gear fa-fw"></i> Pengaturan</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $go->to("login","logout"); ?>"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
              <?php 
              }
              else
              {?>
                 <li><a href="#"><i class="fa fa-user fa-fw"></i> </a></li>
                 <a class="btn btn-success" href="<?php echo $go->to('register'); ?>">Daftar</a>
                 <a class="btn btn-default" href="<?php echo $go->to('login'); ?>">Masuk</a>
                 
                    


              <?php  
              }
              ?>

            </ul>
            <!-- /.navbar-top-links -->

            
            </div>
            <!-- /.navbar-header -->

           

</div>