<style>
#page-wrapper {border-right:none; width:100%;}
div#sidebar{display:none;}
</style>
<br><?php
include $engine->func('login');
?>
<div class="row" style="margin: auto; width: 400px;">         


  <div class="page-header">
  <h2 style="text-align:center; width:100%;">Daftar ke <?php echo $situs['judul'];?></h2>
  </div>
<div class="panel panel-default">
<div class="panel-body">
<p align="center" class="text-primary" >Untuk dapat mendaftarkan akun, mohon isikan formulir berikut dengan benar</p>
</div>

<?php 
if(!isset($_GET['act']))
{
?>


  <form id="form-signin" class="form-signin" action="?sub=login" method="post">

    <?php 

                if(isset($_GET['psn_login']))

  {

    echo '<div class="alert bg-danger">
      <strong>Oh NO!</strong>  Ada Kesalahan.

      </div>';

  }

    ?>    

    <div class="panel-body">
    <?php 
  echo $input->text2($properti = array(
                                'form-group' => TRUE,
                                'name' => 'username',
                                'id' => 'username',
                                'class' => 'form-control',
                                'label-samping' => '<i class="fa fa-user"></i>', 
                                'lainnya' => 'placeholder="Username"'));
    ?>


    <?php 
  echo $input->text2($properti = array(
                                'form-group' => TRUE,
                                'type' => 'password',
                                'name' => 'password',
                                'id' => 'password',
                                'class' => 'form-control',
                                'label-samping' => '<i class="fa fa-key"></i>*', 
                                'lainnya' => 'placeholder="Password"'));
    ?>
    
    <p>* harus diisi</p>
    <label><input type="checkbox" value=""> Dengan ini saya menyatakan telah mengisi data dengan benar, dan menyetujui semua <a data-toggle="modal" data-target="#myModal" href="#">persyaratan dan ketentuan <?php echo $situs['judul'] ;?></a>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Persyaratan dan Ketentuan <?php echo $situs['judul']?></h4>
                                        </div>
                                        <div class="modal-body">
                                          <pre style="border:dotted 2px;font:inherit;white-space: pre-wrap; font-weight:normal;height: 30pc;overflow-y: auto;visible;text-align: justify;">
                                            <?php echo $situs['terms'];?>
                                          </pre>
                                        </div>
                                        
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->




    </label>
    <input name="login" class="btn btn-success btn-block" type="submit" value="Daftar">

  
    </div>



  </form>

  


  <div class="panel-footer" style="padding:10px; margin:auto; border:solid 1px #ccc">

  Sudah ada akun?  <a href="?sub=login">Login</a>

  </div>

  </div>

<?php

}

elseif($_GET['act'] == 'lupapassword')

{

?>

  <form id="form-signin" class="form-signin" action="?sub=login" method="post">

<h5 class="center" style="margin:-10px; padding:20px;">Lupa Password</h5>

    <div class="input-field s6"> <i class="mdi-action-account-circle prefix active"></i>
    <?php 

  echo $input->text('username','username','validate valid');

                                        
  echo $input->label('username','Nama Pengguna','active');

  ?>

    </div>

        <input name="lupapassword1" class="btn right white-text red darken-1" type="submit" value="selanjutnya >">

    </form>

<?php   

}

else

{

  header("location:?sub=login");

}

?> 

 



 

 

 




</div>

