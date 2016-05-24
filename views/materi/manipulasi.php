
<script>
$(document).ready(function() {
    var metode_upload = null;
    
    $("#metode_upload").change(function(){
        metode_upload = $("#metode_upload").val();
        if(metode_upload == 1)
        {
            $("#unggahmateri").css("display", "block");
            $("#embedyoutube").css("display", "none");                      
        }
        if(metode_upload == 2)
        {
            $("#embedyoutube").css("display", "block");                 
            $("#unggahmateri").css("display", "none");          
        }
    });

});  
</script>
<br>
<?php
if ($_GET['act'] == 'baru')
{
    $manipulasi['judul']       = 'Menambah Materi Baru';
    $manipulasi['tombolkirim'] = 'materibaru';
    $manipulasi['tombolhapus'] = null;
    $nilai['judul']            = $nilai['urutan'] = $nilai['deskripsi'] = NULL;
} //$_GET['act'] == 'baru'
else
{
    $manipulasi['judul']       = 'Mengedit Materi';
    $manipulasi['tombolkirim'] = 'materiedit';
    $manipulasi['tombolhapus'] = $input->button('hapus', $go->to('proses&act=hapusmateri&hash=' . $_GET['hash']));

    //mengambil data record yang telah ada didatabase
    $datamateri                = $db2->prepare('SELECT * FROM tb_materi WHERE hash = (:hash)');  
    $datamateri->bindValue(':hash', $_GET['hash']);
    $datamateri->execute();

    if($datamateri->rowCount() == 0)
    {
      echo $cx_error->code('e404');
      die;
    }
    
    foreach ($datamateri as $recordmateri);
    $nilai['judul']     = $recordmateri['judul'];
    $nilai['urutan']    = $recordmateri['urutan'];
    $nilai['deskripsi'] = $recordmateri['deskripsi'];

    if(!$recordmateri['konten'] == NULL)
    {
      $nilai['metode_upload'] = 1; //metode upload berkas
    }
    else
    {
      $nilai['metode_upload'] = 2; //metode embed
    }
    
}
?>

  <div class="panel panel-default">
    <header class="panel-heading bg-theme-gradient">
    <div class="row">
    <div class="col-xs-9"><h2><?php echo $manipulasi['judul'];?></h2></div>
    <div class="col-xs-3 text-right"><i class="glyphicon glyphicon-book fa-5x text-right"></i></div>
    </div>
    </header>
    <div id='editor' class="panel-body">

      <form style="padding:15px;"class="form-horizontal" data-collabel="2" data-label="color" action="<?php
echo $go->to('proses');
if ($_GET['act'] == 'ubah')
{
    echo sprintf('&hash=%s', $_GET['hash']);
} //$_GET['act'] == 'ubah'
?>" method="post" enctype="multipart/form-data">
        <?php
if ($_GET['act'] == 'edit')
{
    echo '<input type="hidden" name="hash" value="<?php echo $_GET[hash] ?>">';
} //$_GET['act'] == 'edit'
?>

<?php 
  echo $input->text2($properti = array(
                                'form-group' => TRUE,
                                'name' => 'judul',
                                'id' => 'judul',
                                'class' => 'form-control',
                                'value' => $nilai['judul'],
                                'label-samping' => 'Judul'));

?>
        

        <!-- //form-group-->        
        <div class="form-group input-group">
          <span class="input-group-addon">Kategori</span>
          <select class="form-control" name="kategori" id="kategori">
          <option value="0">Tidak ada kategori</option>
          <?php 
          $sql = "SELECT * FROM tb_materi_kategori";
          $get_datakategori = $db2->query($sql);
          while($datakategori = $get_datakategori->fetch())
          {
          ?>
          <option value="<?php echo $datakategori['id']?>"><?php echo $datakategori['nama_kategori'];?></option>
          <?php
          }

          ?>
          </select>
          
        </div>
        
        <!-- //form-group-->
        
        <div class="form-group">
          <label class="control-label col-md-2"><span class="color">Urutan/BAB</span></label>
            <input type="text" name="urutan"    value="<?php echo $nilai['urutan']; ?>">
        </div>
        
        <!-- //form-group-->
        
        <div class="form-group input-group">
          <span class="input-group-addon">Deksripsi</span>
          
            <textarea class="form-control" name="deskripsi" rows="5" data-provide="markdown" data-hidden-buttons="cmdHeading" style="resize: none;" ><?php
echo $nilai['deskripsi'];
?></textarea>
          
        </div>
        
        <!-- //form-group-->
          <div class="form-group input-group">          

<?php
$selected_metode_kosong = $selected_metode_unggah = $selected_metode_embed_youtube = null;
if($_GET['act'] == 'baru')
{
  $selected_metode_kosong = "selected";
  error_log(print_r('metode berhasil',true));
}
else
{
  if($nilai['metode_upload'] == 1)
  {
    $selected_metode_unggah = "selected";
  }
  elseif ($nilai['metode_upload'] == 2) 
  {

    $selected_metode_embed_youtube = "selected";
  }

}

?>
  <span class="input-group-addon">Modul</span>
  <select id="metode_upload" name="metode_upload" class="form-control">
    <option value="0" disabled <?php echo $selected_metode_kosong ?> >-- MOHON DIPILIH METODE PENGINPUTAN MODUL --</option>
    <option value="1" <?php echo $selected_metode_unggah ?>>Unggah Berkas</option>
    <option value="2" <?php echo $selected_metode_embed_youtube ?>>Embed Youtube</option>
  </select>      
  <hr>
  

          
          <div id="unggahmateri" style="display:none;  margin-bottom:0px" class="panel panel-yellow">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-9">
                  <span class="card-title huge">Unggah Berkas</span>  
                  <p>Unggah berkas dokumen yang akan dijadikan bahan materi</p>  
                </div>

                <div class="col-xs-3 text-right">         
                   <i class="fa fa-file fa-5x"></i>         
                </div>
              </div><!--row -->

              <p class="small">Ukuran maksimum adalah : 2000000Kb <br>
                Tipe berkas yang diperbolehkan : PDF,DOCX,DOC,MP4
              </p>

              </div><!--Panel heading-->

            <div class="panel-footer"><input type="file" name="fileToUpload"></div>
          </div><!-- Panel -->



          <div id="embedyoutube" style="display:none; margin-bottom:0px" class="panel panel-red">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-9">
                  <span class="card-title huge">Video YouTube</span>  
                  <p>Tampilkan video dari youtube sebagai bahan materi</p>  
                </div>

                <div class="col-xs-3 text-right">         
                   <i class="fa fa-file fa-5x"></i>         
                </div>
              </div><!--row -->

              <p class="small"><b>Gunakan <i>http://</i> pada setiap awalan URL Embed, </b>Pastikan url embed benar dan video dapat diakses, dikarenakan saat ini sistem kami tidak dapat melakukan validasi yang anda lakukan,
              </p>
              
              </div><!--Panel heading-->

            <div class="panel-footer"><input type="text" style="width:100%;" name="embed_url" placeholder="'Paste'-kan link embed disini"></div>
          </div><!-- Panel -->            
        </div>

        <br>
        <div class="lainnya panel-footer" style="margin:0px -30px -30px -30px;">
          <button class="btn btn-success lainnya" type="submit" name="<?php
echo $manipulasi['tombolkirim'];
?>">Kirim</button>
        <span class="small"> * field harus diisi</span>
          <?php
echo $manipulasi['tombolhapus'];
?> 
        </div>
      </form>
    </div>
  </div>