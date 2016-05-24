<div id="materi-kategori" class="row">
<div class="panel panel-default">
    <?php
		if(!isset($_GET['act']))
		{
			//jika tidak buka laman materi
 			$tombol_more = $menu->toolbar('materi');
 			$tombol_more_footer = sprintf('<a href="%s" class="btn btn-default btn-block">Lihat Semua Kategori</a>', $go->to('materi','kategori'));
		}
		else
		{
			$tombol_more = $menu->toolbar('materi');
			$tombol_more_footer = NULL;
		}
		?>

	<div class="panel-heading">
    <h2 style="display: inline;"><i class="fa fa-th"></i><?php echo $tombol_more;?>	 </h2>
    <h2 style="display: inline;">Kategori Materi </h2>
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
	$limit = 'LIMIT '. 1*$row ;
}
else
{
	$limit = NULL;
}


if(isset($_POST['filter']))
{
	$sql = sprintf('SELECT * FROM tb_materi_kategori %s WHERE nama_kategori LIKE "%%%s%%" ',$limit,$_POST['filter']);	
}
else
{
	$sql = sprintf('SELECT * FROM tb_materi_kategori %s',$limit);
}
	$debug = $sql;
	error_log($debug);

$kueri = $db2->query($sql);
$jumlah_materi = $kueri->rowCount();

if($jumlah_materi == 0 )
{
	echo 'tidak ada data';
}
while($kategori = $kueri->fetch())
{	
	echo $template->materikategori($kategori);
}

?>
</div> <!-- panel body-->
<div class="panel-footer" style="border:none; padding: 0px 30px 15px 30px">
	<?php echo $tombol_more_footer;?>
</div>

</div>
</div>