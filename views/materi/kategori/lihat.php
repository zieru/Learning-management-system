<br>
<?php
if(!isset($_GET['hash']))
{
	echo $cx_error->code('404');
	exit();
}
else
{
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

	$konten = NULL;
	
	//cari judul kategori
	$sql = sprintf('SELECT id,nama_kategori FROM tb_materi_kategori WHERE id = "%s"',$_GET['hash']);	
	$kueri = $db2->query($sql);
	if($kueri->rowCount() > 0)
	{
		$kategori = $kueri->fetch();;
	}
	else
	{
		
		exit($cx_error->code('404'));
	}
	
	
	if(isset($_POST['filter']))
	{
		$sql = sprintf('SELECT a.id,a.nama_kategori,b.hash,b.kategori,b.judul,b.status,b.tipe
						FROM tb_materi_kategori a
						LEFT JOIN tb_materi b
						ON a.id = b.kategori
						WHERE b.kategori=%s  AND b.judul AND status %s LIKE "%%%s%%" ',$_GET['hash'],$status_materi,$_POST['filter']);	
		$konten .= '<div class="alert alert-info" style="padding:0px 5px;">
					<a href="" class="btn btn-circle" style="padding-right:40px;"><i class="fa fa-times"></i>Batal </a>
					<i><b>Menampilkan hasil kategori : </b>'.$_POST['filter'] .'</i>   
                            </div>';
	}
	else
	{
		//$sql = sprintf('SELECT a.hash,a.kategori,a.judul,b.id,b.nama_kategori
		//				FROM tb_materi a
		//				INNER JOIN tb_materi_kategori b
		//				ON a.kategori = b.id
		//				WHERE a.kategori=%s ',$_GET['hash']);
		$sql = sprintf('SELECT a.id,a.nama_kategori,b.hash,b.kategori,b.judul,b.status,b.tipe
						FROM tb_materi_kategori a
						LEFT JOIN tb_materi b
						ON a.id = b.kategori
						WHERE a.id=%s AND status %s',$_GET['hash'],$status_materi);
	}

	$debug = $sql;
	error_log($debug);
	$kueri = $db2->query($sql);
	$jumlah_materi = $kueri->rowCount();
	
	
	while($materi = $kueri->fetch())
	{	

		if(!empty($materi['hash']))
		{
			$konten .= $template->materidaftar($materi);
		}
		else
		{
			$jumlah_materi--;
		}
	}


		if($jumlah_materi == 0)
		{
			$konten .= $cx_error->code('nodata');
		}	
}
?>

<div class="materi_list section scrollspy" id="materi-kategori">
<div class="row">
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
         <?php echo $tombol_kembali; ?>
    <h2 style="display: inline;"><i class="fa fa-th"></i> Materi <?php echo $kategori['nama_kategori'] ?> <span style="font-size:small;"> <?php echo $tombol_more;?></span></h2>
    <div id="filter-list" class="input-field s6" style="float:right;">
      <form action="" method="POST">
        <?php  echo $input->text('filter','filter','','max-width: 200px;');?>
        <input class="btn btn-default"  name="daftar" type="submit" value="filter">
      </form>
    </div> <!-- input field-->
  </div> <!-- header -->


  

<div class="panel-body">
  <?php 
  echo $konten;
  ?>
</div> <!-- panel body-->

<div class="panel-footer" style="background:whitesmoke; border:none; padding:0px 30px 15px 30px;">
	<?php echo $tombol_more_footer;?>
</div>

</div>
</div>
</div>