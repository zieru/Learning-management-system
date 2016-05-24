<br>
<div class="materi_list section scrollspy" id="materi">
<div class="row">
<div class="panel panel-default panel-favorit">
    <?php
		if(!isset($_GET['act']))
		{
			//jika tidak buka laman materi
             $tombol_more = $menu->toolbar('materi');
             $tombol_more_footer = sprintf('<a href="%s" class="btn btn-default btn-block">Lihat Semua Materi</a>', $go->to('materi','list'));
		}
		else
		{
			$tombol_more = $menu->toolbar('materi');
			$tombol_more_footer = NULL;
		}
		?>

	<div class="panel-heading">
	 <h2 style="display: inline;"><i class="glyphicon glyphicon-book"></i></h2>
    <h2 style="display: inline;"> Materi Favorit </h2>
    <div id="filter-list" class="input-field s6" style="float:right;">
      <form action="<?php echo $go->to('materi','list'); ?>" method="POST">
        <?php 			echo $input->text('filter','filter','','max-width: 200px;');?>
        <input class="btn btn-default"  name="daftar" type="submit" value="filter">
      </form>
    </div> <!-- input field-->
  </div> <!-- header -->

  



  

  

<div class="panel-body">
<?php
include 'config/koneksi.php';

if(!isset($_GET['act']))
{
	$row = 4;
	$limit = 'LIMIT '. 2*$row ;
}
else
{
	$limit = NULL;
}


if(isset($_POST['filter']))
{
	$sql = sprintf('SELECT * FROM tb_materi %s WHERE judul LIKE "%%%s%%" ORDER by waktuupload DESC',$limit,$_POST['filter']);	
}
else
{
	$sql = sprintf('SELECT a.id,a.id_materi, a.id_pengguna,b.hash,b.judul,b.konten,b.status,b.tipe
                        FROM tb_materi_favorit a
                        LEFT JOIN tb_materi b
                        ON a.id_materi = b.hash
                        WHERE a.id_pengguna= %s',$user['uid']);  
}
	$debug = $sql;
	error_log($debug);

$kueri = $db2->query($sql);
$jumlah_materi = $kueri->rowCount();

if($jumlah_materi == 0 )
{
	echo 'tidak ada data';
}
while($materi = $kueri->fetch())
{	
	echo $template->materidaftar($materi);
}

?>

</div> <!-- panel body-->
<div class="panel-footer" style="background:none; border:none; padding: 0px 30px 15px 30px">
	<?php echo $tombol_more_footer;?>
</div>

</div>
</div>
</div>