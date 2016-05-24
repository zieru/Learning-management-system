<div class="row" id="materi"">
<div class="panel panel-default">

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

	<div class="panel-heading" style="max-height:55px;">
     <?php echo $tombol_kembali; ?>
	 <h2 style="display: inline; "><i class="glyphicon glyphicon-book"> </i> Materi <?php echo $tombol_more;?></h2>
         <div id="filter-list" class="input-field s6" style="float:right;">
      <form action="<?php echo $go->to('materi','list'); ?>" method="POST" style="float:right;">
        <?php 			echo $input->text('filter','filter','','max-width: 200px;');?>
        <input class="btn btn-default"  name="daftar" type="submit" value="filter">
      </form>
      </div>
  </div> <!-- header -->

  



  

  

<div class="panel-body">
<?php
include 'config/koneksi.php';


//cegah materi yang sudah dihapus tampil didaftarmateri bagi user
if($user["status_INT"]>=2)
{
	$status_materi = "= 1";
}
else
{
	$status_materi = "> 0";
}

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
	$sql = sprintf('SELECT * FROM tb_materi %s WHERE judul LIKE "%%%s%%" AND status %s ORDER by waktuupload DESC',$limit,$_POST['filter'],$status_materi);	
}
else
{
	$sql = sprintf('SELECT * FROM tb_materi WHERE status %s ORDER by waktuupload DESC %s',$status_materi,$limit);
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
<div class="panel-footer" style="border:none; padding: 0px 30px 15px 30px">
	<?php echo $tombol_more_footer;?>
</div>

</div>
</div>