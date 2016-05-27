<?php
if(isset($_POST['balastopik']))
{
	$konten = $db->real_escape_string($_POST['konten']);
			$sql = sprintf("INSERT INTO tb_diskusi (fid,uid,tid,tipe,judul,konten,timestamp,publi) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')",$engine->hashacak(16),$user['uid'] ,$_GET['hash'] , 0, $_POST['judul'], $konten, time(),1);
			$db->query($sql);
			echo "data disimpan: " . $db->affected_rows;
}

?>

<?php
	$sql = sprintf("SELECT * FROM tb_diskusi WHERE fid = '%s'",$_GET['hash']);
	$data = $db->query($sql);
	$topik = $data->fetch_assoc();
        
        if($data->num_rows < 1)
        {
            echo $cx_error->code('nodata');
            exit();
        }
        
        
	$urutanpost = 1;
	
	$sql = sprintf("SELECT * FROM tb_pengguna WHERE uid = '%s'",$topik['uid']);
	$data = $db->query($sql);

	$pengguna = $data->fetch_assoc();
?>


<div class="row">
<div class="panel panel-default" style="background:#337ab7;">

    <header class="panel-heading panel-primary" style="background-color: #E8E9EA;
    border-bottom: 5px solid #e5e5e5;
    box-shadow: 0px 10px 10px #ccc;">
          <a href="?sub=forum&act=list"><i title="Kembali" class="fa fa-2x fa-arrow-left"></i></a>
      <h2 style="display:inline-block; padding-left:30px;">
      <i class="fa fa-comment fa-fw"></i>
       <?php echo $topik['judul'];?> </h2> 
      </header>

  
<div class="panel-body" style="background:whitesmoke;">


  <?php
  		//menampilkan topik	
  		echo $template->komentar(array(
  										'user' => $template->parseuser($topik['uid']),
  										'komentar' => $topik,
  										'thread_diskusi' => TRUE,
  										'thread_utama' => TRUE
  										)); 

  ?>


<?php
	$sql = sprintf("SELECT * FROM tb_diskusi WHERE tid = '%s' ORDER BY timestamp ASC",$_GET['hash']);
	$data = $db->query($sql);

	while($balasantopik = $data->fetch_assoc())
	{
		$urutanpost++;
		$sql = sprintf("SELECT * FROM tb_pengguna WHERE uid = '%s'",$balasantopik['uid']);
		$datapengguna = $db->query($sql);
		$pengguna = $datapengguna->fetch_assoc();

?>  
  <!-- reply -->
    <?php

  		//menampilkan balasan	
  		echo $template->komentar(array(
  										'user' =>$template->parseuser($balasantopik['uid']),
  										'komentar' => $balasantopik,
  										'thread_diskusi' => TRUE
  										)); 

		

	}

	//end balasantopik

 ?> 

</div>  


<div class="panel-footer">
		<?php

	 	echo $template->inputdiskusi($diskusi=array(
										'tipe' => 'diskusi_balas'
								 ));
		?>
</div>
  

  
</div> <!-- panel -->
</div> <!-- row -->

