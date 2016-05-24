<?php
	$sql = sprintf('SELECT * FROM tb_pengguna WHERE username = "%s"',$_GET['hash']);
	$data = $db2->query($sql);
	$user = $data->fetch();
?>
<div class="row">

<form action="<?php echo $go->to('proses'); ?>" method="post">
<div class="kotak-login card">
 <div class="input-field col s12">
    <select>
      <option value="" disabled selected>Choose your option</option>
      <option value="1">Option 1</option>
      <option value="2">Option 2</option>
      <option value="3">Option 3</option>
    </select>
    <label>Materialize Select</label>
  </div>

<h5 class="center" style="margin:-10px; padding:20px;">Ubah Profil</h5>

	<p>Data Diri</p>
    <div class="input-field s6"> <i class="mdi-action-account-circle prefix active"></i>
    <?php 
	echo $input->text2($properti = array(
						'name' => 'username',						
						'lainnya' => "readonly = 'readonly' value ='$user[username]'"
						));
	echo $input->label('username','Nama Pengguna','active');
	?>
    </div>
   
    <div class="input-field s6"> <i class="mdi-action-account-circle prefix active"></i>
    <?php 
	echo $input->text2($properti = array(
						'name' => 'displayname',						
						'lainnya' => "value ='$user[displayname]'"
						));
	echo $input->label('displayname','Nama Lengkap','active');
	?>
    </div>
    
    <div class="input-field s6"> <i class="prefix active"></i>
    <?php 
	echo $input->text2($properti = array(
						'name' => 'alamat',						
						'lainnya' => "value ='$user[alamat]'"
						));
	echo $input->label('alamat','Alamat','active');
	?>
    </div>
    
    <div class="input-field s6"> <i class="fa fa-discuss prefix active"></i>
    <?php 
	echo $input->text2($properti = array(
						'name' => 'email',						
						'lainnya' => "value ='$user[email]'"
						));
	echo $input->label('email','E-MAIL / SUREL','active');
	?>
    </div>
    
    
    <div class="input-field s6"> <i class="prefix active"></i>
    
         <?php 
	 		$option = array(
			'Laki' => 'Laki-Laki',
			'Perempuan' => 'Perempuan'
			);
					echo $input->option('jeniskelamin',$option,1,'display:block; max-width:200px;');
					echo $input->label('jeniskelamin','Jenis Kelamin','active');
			?>
    </div>
    
    <hr>
	<p>Konfirmasi Sandi Untuk Melakukan Perubahan</p>
    <div class="input-field s6"> <i class="fa fa-key prefix active"></i>
	<?php
      echo $input->password('password','password','validate valid');
	  echo $input->label('password','Kata Sandi','active');
	?>
    </div>
    
    <input name="ubahprofil" class="btn right white-text red darken-1" type="submit" value="Konfirmasi" >

<div> <!-- end kotak-login card -->    
</form>

</div>
