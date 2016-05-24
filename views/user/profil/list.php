<div class="container">
	<div class="header">
            <h2 class="text_b">Daftar Pengguna</h2> 
    </div>
    
    <div class="header2">
    <div class="input-field s6">
    <form action="<?php echo $go->to('profil','list'); ?>" method="POST"> 
     <?php 
	 		$option = array(
			'username' => 'Username',
			'displayname' => 'Nama'
			);
	 		echo $input->label('filter','filter');
			echo $input->text('filter','filter','','max-width: 200px;');
						echo $input->option('pilihanfilter',$option,1,'display:inline-block; max-width:100px;');
			?>
	    <input class="btn white-text"  name="daftar" type="submit" value="filter">
    </form>
    </div>    
    </div>
<div class="row">
	<?php
	if(isset($_POST['filter']))
	{
		$sql = sprintf('SELECT * FROM tb_pengguna WHERE %s = "%s" ',
		$_POST['pilihanfilter'],
		$_POST['filter']);
	}
	else{
	$sql = 'SELECT * FROM tb_pengguna ';}
	$data = $db2->query($sql);
	while($user = $data->fetch())
	{
	echo $template->kotaklistpengguna($user);
	}
	?>	
</div>
</div>