<?php 
include $engine->func('login');
$sidebar_num = 0;

if(!isset($GLOBALS['sidebar_konten']))
{
    $GLOBALS['sidebar_konten'] = NULL;
}

if($GLOBALS['sidebar'] == FALSE)
{
    exit();
}
?>


<div id="sidebar" class="col-xs-12 col-md-3" style="margin-top:57px;">
      <br>
<?php
if($user['status_INT'] <= 2)
{
    include 'sidebar/materi_favorit.php';
    $sidebar_num ++;
}

?>

<?php
if(isset($_GET['sub']))
{
    $lokasi = $_GET['sub'];
}
else
{
    $lokasi = NULL;
}
if($user['status_INT'] == 99 AND !($lokasi == 'login')){
?>
    <div class="alert alert-info">
                        <i class="fa fa-info"> </i> Batasan fitur
                        <hr style="margin:1px 0px;">
                        
                            <p>Hi!, saat ini kamu belum login atau mungkin belum terdaftar. Untuk dapat menikmati seluruh layanan kami kamu diharuskan untuk mendaftar.</p>
                            <a class="btn btn-outline btn-info center-block" style="margin-top:10px;" href="#">Pelajari lebih lanjut</a>
                        
    </div>

<?php
}
?>

      
<?php
echo $GLOBALS['sidebar_konten'];
?>
      

</div> <!-- end of sidebar -->