<br>


 <?php 
if (empty($_GET['hash']))
{
    echo $cx_error->code('e404');
    die;
} //empty($_GET['hash'])


if (!isset($_SESSION['username']))
{
    $username = 'guest';
} //!isset($_SESSION['username'])
else
{
    $username = $_SESSION['username'];
}
$sql      = sprintf("SELECT kuota FROM tb_pengguna WHERE username = '%s'", $username);
$data     = $db->query($sql);
$pengguna = $data->fetch_assoc();
if ($pengguna['kuota'] == NULL)
{
    $kuotapengguna = 'unlimited';
} //$pengguna['kuota'] == NULL
else
{
    $kuotapengguna = $pengguna['kuota'];
}
$sql           = sprintf("SELECT * FROM tb_materi WHERE hash = '%s'", $_GET['hash']);
$data          = $db->query($sql);
$jumlah_materi = $data->num_rows;
if($jumlah_materi == 0)
{
    echo $cx_error->code('e404');
    echo $cx_error->code('nodata');
    die;
}


$materi = $data->fetch_assoc();

if($materi['status'] == 2)
{
	echo '<div class="alert alert-warning">Materi ini telah dihapus</div>';
	if($user['status_INT'] >= 2){exit();}
}

//input favorit
if($user['status_INT'] < 2)
{
  if(isset($_GET['favorit']))
  {

    if($_GET['favorit'] == 1)
    {
      $sql = sprintf('INSERT INTO tb_materi_favorit (id_pengguna,id_materi) values(%d,"%s")',$user['uid'],$materi['hash']);
      $input_favorit = $db2->query($sql);
    }
    elseif($_GET['favorit'] == 0){
      $sql = sprintf('DELETE FROM tb_materi_favorit WHERE id_pengguna = %d AND id_materi = "%s" ',$user['uid'],$materi['hash']);
      $input_favorit = $db2->query($sql);
    }

    //periksa hasil
    if($input_favorit->rowCount() > 0)
    {
      echo 'Materi Favorit Berhasil diubah';
      header("refresh:5;url=" . $go->to('materi', 'lihat',$_GET['hash']));
      exit();
    }
    elseif($input_favorit->rowCount() == 0)
    {
      echo 'terdapat kesalahan';
      //kirim logs ke adm
    }

    exit();
  }
}

$ukuran        = number_format($materi['ukuranfile'] / 1000, 2) . ' KB';
//mengambil extensi file jika file tidak embed
if (!empty($materi['konten']))
{
	$file = $lokasi_upload ."/" . $materi['konten'];
	$konten = $url_upload ."/" . $materi['konten'];
	
    $finfo       = finfo_open(FILEINFO_MIME_TYPE);
    $fileextensi = finfo_file($finfo, $file); //berdasarkan MIME
    //    $fileextensi = pathinfo($materi['konten'],PATHINFO_EXTENSION);     
} //!empty($materi['konten'])
//jika deskripsinya kosong
if (empty($materi['deskripsi']))
{
    $materi['deskripsi'] = '<i>Tidak Ada Deskripsi Materi</i>';
} //empty($materi['deskripsi'])
//buat kunci untuk donlut
$hashkunci = $engine->hashacak(16);
$sql       = sprintf("UPDATE `tb_pengguna` SET `kunci`= '%s' WHERE `username` = '%s'", $hashkunci . $materi['hash'], $username);
$db->query($sql);
?>


<?php
  //fungsi favorit
    $tag['class_panel-favorit'] = $tag['menu_peringatan'] = NULL;
    if($user['status_INT'] <= 2)
    {
      $sql = sprintf('SELECT * FROM tb_materi_favorit WHERE id_pengguna = %d AND id_materi = "%s"',
                      1,$_GET['hash']);
      $data_materi_favorit = $db2->query($sql);
      $materi_favorit['jumlah'] = $data_materi_favorit->rowCount();
      
      if($materi_favorit['jumlah'] > 0 )
      {
        $tag['class_panel-favorit'] = 'panel-favorit';
        $tag['menu_favorit'] = '<li><a href="'.$url['request'].'&favorit=0"><i class="fa fa-heart" style="color:#FF1493"></i> Hapus Sbg Favorit </a></li>';
      }
      else
      {
        $tag['menu_favorit'] = '<li><a href="'.$url['request'].'&favorit=1"><i class="fa fa-heart"></i> Tandai Sbg Favorit </a></li>';
      }
    }

    else
    {
        $tag['menu_favorit'] = '<li><a class="list-group-item disabled" href="favorit"><i class="fa fa-heart"></i> Tdk dpt dijadikan favorit </a></li>';
        $tag['menu_peringatan'] = '<li align="center" style="font-size:small;"> <a class="list-group-item disabled">Beberapa menu tidak tersedia<br> karena anda belum <i>Login</i></a></li>';
    }
?>

<div class="row">
<div class="panel panel-default <?php echo $tag['class_panel-favorit'] ?>">
<div id="materi-konten" style="background:#000;">
          <p style="color:#fff; position:absolute; margin:auto; right:50%; top:50%; z-index:-1;">Mohon Tunggu...</p>
          <?php
//jika embed youtube
if (empty($materi['konten']))
{
	echo sprintf('<iframe width="100%%" 
						 height="380" 
						 src="%s?showinfo=0&modestbranding=1&controls=2" 
						 frameborder="0" allowfullscreen>			
				 </iframe>'
				 ,$materi['embed_konten']);

} //empty($materi['konten'])
else
{
    if ($fileextensi == $tipefile_yangdiperbolehkan[0])
    {
		echo sprintf('<object data="materirender.php?hash=%s"
							width="100%%" 
							height="380px" 
							style="display:block">
					</object>', $_GET['hash']);

    } //$fileextensi == 'application/pdf'
    elseif ($fileextensi == $tipefile_yangdiperbolehkan[1])
    {
    	echo sprintf('<video width="100%%" 
	 				 height="380px" controls>
        			<source src="%s" type="video/mp4">
		        	Your browser does not support the video tag. 
					</video>',$konten);
    } 
	elseif ($fileextensi == $tipefile_yangdiperbolehkan[2])
    {
    	echo sprintf('<div style="width:100%%; height:380px; background:#337ab7; color:#fff;padding:20%%;">
						<div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-word-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Dokumen Word</div>
                                    <div>Materi ini hanya dapat diunduh dan diakses pada perangkat lunak Microsoft&reg; Office Word	
								</div>

                                </div>

                            </div>
<p style="font-size: x-small;display: block;position: relative;bottom: -100px;padding: 0 45px;text-align: center;">Untuk dapat mengunduh, Pilih menu <b>Pilihan</b> dibawah</p>
					</div>');
    } 
	
} //end jikaembed youtube
?>
</div> <!-- materi konten -->




        <div class="panel-footer">
          <div class="header">
            <h4 style="display:inline">
              <?php
if (strlen($materi['judul']) >= 30)
{
    echo substr(strip_tags($materi['judul']), 0, 30) . ' ...';
} //strlen($materi['judul']) >= 30
else
{
    echo $materi['judul'];
}
?>
            </h4>
          </div>
          
          <?php include 'tbl_opsi.php'; ?>
          <p><?php echo $materi['deskripsi'];?></p>
        </div>


  
    <script>
  var lastScrollTop = 0;
$(window).scroll(function(event){
   var st = $(this).scrollTop();
   var turunkebawah = 0;
   
        $("#cd_posisi").text(lastScrollTop);
   if (st > lastScrollTop){
       // downscroll code
    turunkebawah = lastScrollTop;
    $("#cd_turun").text(turunkebawah);
        $("nav#nav_f").css("position", "relative");   
                $("div.laman").css("margin-top", "0px");                           
    if(turunkebawah > 50)
    {
      $("nav#nav_f").css("display", "none");        
    }
        
   } else {
      // upscroll code
       $("nav#nav_f").css("display", "block");     
     $("nav#nav_f").css("position", "fixed"); 
       $("div.laman").css("margin-top", "20px");           
   }
   lastScrollTop = st;
});
  </script>





</div> <!-- panel -->




   <hr />
      <section id="kirimkomentar" style="min-height:100px;">
        <?php
$_SESSION['materi_hash'] = NULL;
$_SESSION['materi_hash'] = $materi['hash'];
echo $template->inputkomentar();
?>
      



<section id="komentar" style="min-height:100px;">
     <div class="panel panel-primary"> 
        <?php
$sql                 = sprintf("SELECT * FROM tb_diskusi WHERE tid = '%s' AND tipe = 2 ORDER BY timestamp DESC", $materi['hash']);
$data                = $db2->query($sql);
$totaljumlahkomentar = $data->rowCount();
$limit               = 5;
if (isset($_GET['offset']))
{
    $offset = 'OFFSET ' . $_GET['offset'] * $limit;
} //isset($_GET['offset'])
else
{
    $offset = 'OFFSET 0';
}
$sql            = sprintf("SELECT * FROM tb_diskusi WHERE tid = '%s' ORDER BY timestamp DESC LIMIT %s %s", $materi['hash'], $limit, $offset);
$data           = $db2->query($sql);
$jumlahkomentar = $data->rowCount();
echo sprintf('

                   <div class="panel-heading"><h5 class="header" style="font-size:18px;">Komentar (%s dari %s)</h5></div>', $jumlahkomentar, $totaljumlahkomentar);
echo '<div class="panel-body" style="width:100%; margin:auto; background: whitesmoke;" class="koment">';
while ($komentar = $data->fetch())
{
    //komentar 
    $kutipan_pengguna = $template->parseuser($template->parent_to_uid($komentar['parent']));
    $kutipan          = array(
        'isi' => $komentar['kutipan'],
        'uid' => $kutipan_pengguna['uid'],
        'username' => $kutipan_pengguna['username']
    );
    echo $template->komentar(array('user'=>$template->parseuser($komentar['uid']), 'komentar' =>$komentar, 'kutipan' => $kutipan));
} //$komentar = $data->fetch()
if($jumlahkomentar ==0 ){echo '<p style="width:100%;text-align:center;">tidak ada data<p>';}
?>


</div> <!-- end akhir isi komentar -->
        <?php
if($jumlahkomentar >0)
{		
	$daftarhalaman = array(
		'totaljumlah' => $totaljumlahkomentar,
		'offset' => $offset,
		'limit' => $limit
	);
	echo $template->daftarhalaman($daftarhalaman, 'style=padding-left:10%; class="panel-footer"');
}
?>
        </div>
      </section>
</div> <!-- row -->