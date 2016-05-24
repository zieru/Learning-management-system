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


$materi        = $data->fetch_assoc();
$ukuran        = number_format($materi['ukuranfile'] / 1000, 2) . ' KB';
//mengambil extensi file jika file tidak embed
if (!empty($materi['konten']))
{
    $finfo       = finfo_open(FILEINFO_MIME_TYPE);
    $fileextensi = finfo_file($finfo, $materi['konten']); //berdasarkan MIME
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

<br>
    <div class="row">
      <div class="materi">
      <div class="panel panel-default">
        <div id="materi-konten" style="background:#000;">
          <p style="color:#fff; position:absolute; margin:auto; right:50%; top:50%; z-index:-1;">Mohon Tunggu...</p>
          <?php
//jika embed youtube
if (empty($materi['konten']))
{
?>
          <iframe width="100%" height="380" src="<?php
    echo $materi['embed_konten'];
?>?showinfo=0&modestbranding=1&controls=2" frameborder="0" allowfullscreen></iframe>
          <?php
} //empty($materi['konten'])
else
{
    if ($fileextensi == 'application/pdf')
    {
?>
    <object data="materirender.php<?php
        echo sprintf('?hash=%s', $_GET['hash']);
?>" width="100%" height="380px" style="display:block"></object>
<?php
    } //$fileextensi == 'application/pdf'
    elseif ($fileextensi == 'video/mp4')
    {
?>
        <video width="100%" height="380px" controls>
        <source src="<?php
        echo $materi['konten'];
?>" type="video/mp4">
        Your browser does not support the video tag. </video>
<?php
    } //akhir chekc extensi jika file upload
} //end jikaembed youtube
?>
</div>
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
            <h2 class="right" style="margin:0">

</h2>


<div class="pull-right">
                                <div class="btn-group open">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                        Pilihan
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
<div class=" dropdown-header header-nav-current-user css-truncate">
                    <b>Materi </b>
                    </div>                                        
                                              <?php
                                              $tampilkan_tbl_download = FALSE;
                                              if(!empty($fileextensi))
                                              {
                                                if($fileextensi == 'application/pdf')
                                                {
                                                  $tampilkan_tbl_download = TRUE;
                                                }
                                              }
                                              
                                              if($tampilkan_tbl_download == TRUE)
                                              {
                                              ?>          
                                                       <li><a data-toggle="modal" data-target="#md-donlot" href=""><i class="glyphicon glyphicon-download-alt"></i> Download (<?php echo $ukuran;?>)</a></li>
                                            <?php
                                              }
                                              else
                                              {
                                                echo '<li><a href="#">Download tidak tersedia</a></li>';
                                              }
                                            ?>
                                        

                                        <!-- Menu Admin -->
                                        <?php
                                      echo $template->tombol($tombolproperti = array(
                                          'label' => 'Edit',
                                          'aksi' => 'ubahmateri',
                                          'hash' => $materi['hash'],
                                          'tipe' => 'menulist',
                                          'custom_awal' => '<li class="divider"></li><div class=" dropdown-header header-nav-current-user css-truncate">
                    <b> Administrasi </b>Materi
                    </div>',
                                          'custom_akhir' => ''
                                      ));
                                      ?>
                                    </ul>
                                </div>
                            </div>
          </div>
          <p><?php
echo $materi['deskripsi'];
?></p>
        </div>
      </div>
      <!-- card -->
      
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
echo '<div class="panel-body" style="width:100%; margin:auto" class="koment">';
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
?>
</div> <!-- end akhir isi komentar -->
        <?php
$daftarhalaman = array(
    'totaljumlah' => $totaljumlahkomentar,
    'offset' => $offset,
    'limit' => $limit
);
echo $template->daftarhalaman($daftarhalaman, 'style=padding-left:10%; class="panel-footer"');
?>
        </div>
      </section>
      </div>
      <!-- kirim komentar--> 
      
    </div>
    <!-- materi col-md-8 -->
    
      
    </div>


