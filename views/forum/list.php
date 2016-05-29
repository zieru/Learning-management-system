<?php

include $engine->config('koneksi');

?>

<div id="forum" class="row">
<div class="panel panel-default">
<div class="panel-heading">
     <?php echo $tombol_kembali; ?>
    <h2 style="display:inline;" ><i class="fa fa-comment fa-fw"></i>Forum Diskusi</h2>

     <?php

		if(!isset($_GET['act']))
		{
			//jika tidak buka laman materi
             echo '<span style="font-size:small;"><a href="'.$go->to('forum','list').'">Lihat Semua</a></span>';

		}
		else
		{
			echo $template->tombol($tombolproperti = array(
										'label' => 'Baru',
										'aksi' => 'tambahforumdiskusi',
										'style' => '    margin-top: -15px'
										));
		}
		?>
        
            <div id="filter-list" class="input-field s6" style="float:right;">
      <form action="<?php echo $go->to('forum','list'); ?>" method="POST" style="display:inline; float:right;">
        <?php 
			echo $input->text('filter','filter','','max-width: 200px;');
			?>
        <input class="btn btn-default white-text"  name="daftar" type="submit" value="filter">
      </form>
      </div>
   




 
</div>  


<div class="panel-body">
<div class="list-group">
<?php
if(!isset($_GET['act']))
{
	$limit = 'LIMIT 6';
}
else
{
	$limit = NULL;
}

if(isset($_POST['filter']))
{
	$sql = sprintf('SELECT * FROM tb_diskusi %s WHERE tipe = 1 AND judul = "%s"',$limit,$_POST['filter']);	
}
else
{
	$sql = sprintf('SELECT * FROM tb_diskusi WHERE tipe = 1 ORDER BY timestamp DESC %s',$limit);
}

$kueri = $db2->query($sql);
$jumlah_materi = $kueri->rowCount();

if($jumlah_materi == 0 )
{
	echo 'tidak ada data';
}
while($forum = $kueri->fetch())
{	
	$sql = sprintf('SELECT * FROM tb_diskusi WHERE tid= "%s" ORDER BY timestamp DESC',$forum['fid']);
	$kueri_last_reply = $db2->query($sql);
	$jumlah_reply = $kueri_last_reply->rowCount();

	
	$forum['author'] = sprintf('Oleh :<a href="%s">%s</a>',
								$go->to('profil','lihat',$template->parseuser($forum['uid'],'username')),
								$template->parseuser($forum['uid'],'displayname'));
	
	
	$forum['judul_list'] = sprintf('<div class="row">
									<div class="col-xs-8 col-sm-8 col-md-8">
									<i class="fa fa-envelope fa-fw"></i>
									 <a href="%s">%s</a>
									 <br>
									<span class="text-muted small" style="font-size: 11px;">
									%s <em>@%s</em>
									</span>	
									</div>
									',
									$go->to('forum', 'lihat', $forum['fid']),
									$forum['judul'],
									$forum['author'],
									date('M jS / H:i ', $forum['timestamp']));
									
					
if($jumlah_reply > 0)
{
$last_reply = $kueri_last_reply->fetch();
$forum['balasan_terakhir'] = sprintf(', Terakhir oleh : <a href="%s">%s</a> @%s',
									$go->to('profil','lihat',$template->parseuser($last_reply['uid'],'username')),
									$template->parseuser($last_reply['uid'],'displayname'),
									date('M jS /H:i ', $last_reply['timestamp']));	
}
else {
	$forum['balasan_terakhir'] = NULL;
	}

									
	$forum['deskripsi_list'] = sprintf('
	<div class="col-xs-4 col-sm-4 col-md-4" class="pull-right ">
<span class="text-muted small" style="font-size: 11px;">
Balasan Topik : <a href=""><b>%s Post</b></a>%s
</span>
</div> 
</div>',$jumlah_reply,$forum['balasan_terakhir']);
	$forum['style'] = 'style="    height: 60px;"';
	$forum['aksi_list'] = NULL;
	echo $template->daftar_list($forum);
}
?>
</div>
</div>

</div> <!-Panel-->
 </div><!--row-->

