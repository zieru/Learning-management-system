<br>
<style>
#page-wrapper {border-right:none; width:100%;};
</style>
<?php
include $engine->func('login');
?>
<div class="row" style="margin: auto; width: 340px;">         


  <div class="page-header">
  <h2 style="text-align:center; width:100%;">Masuk</h2>
  </div>
<div class="panel panel-default">
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
                                'label-samping' => '<i class="fa fa-key"></i>', 
                                'lainnya' => 'placeholder="Password"'));
    ?>
    <p>  <a href="?sub=login&act=lupapassword">Lupa Password?</a> <p>
    <input name="login" class="btn btn-success btn-block" type="submit" value="Login">

    <p style="text-align:center;">Atau</p>

    <a class="btn btn-social btn-google-plus btn-block">
                                <i class="fa fa-google-plus"></i> Sign in with Google </a>        

    </div>



  </form>

  


  <div class="panel-footer" style="padding:10px; margin:auto; border:solid 1px #ccc">

  Belum ada akun?  <a href="?sub=register">Daftar</a>

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

