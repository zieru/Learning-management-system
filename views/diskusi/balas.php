

<section id="balaskomentar" style="min-height:100px;">

  <h2 class="header">Balas Komentar</h2>

<?php

  $sql = sprintf('SELECT * FROM tb_diskusi WHERE fid = "%s"',$_GET['hash']);

  $data = $db2->query($sql);

  $_SESSION['tid'] = $_GET['tid'];

  $_SESSION['diskusi_hash'] = $_GET['hash'];

  $komentar = $data->fetch();

  $_SESSION['kutipan'] = $komentar['konten'];

?>

  <div class="row" style="padding-left:10%;padding-right:10%;">

    <form action="<?php echo $go->to('proses'); ?>" method="post" id="balas">

      <div class="form-group">

        <textarea class="form-control" name="isikomentar"  rows="5"  data-provide="markdown" ></textarea>

        <div class="lainnya" style="display:block;">

          <button class="btn btn-default lainnya" type="submit" name="balasdiskusi">Kirim</button>

        </div>

      </div>

    </form>   

  </div>

  <p>Membalas Komentar :</p>

 <?php

  echo $template->komentar($template->parseuser($komentar['uid']),$komentar); 

 ?> 

</section>

