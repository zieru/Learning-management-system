<div class="row">

<h1 class="page-header">Buat Kategori Materi Baru</h1>          
<form action="index.php?sub=proses" method="post">
  <div class="panel panel-default form-group">  

    <div class="panel-heading">
    <?php echo $input->text('nama_kategori', 'nama_kategori', 'validate valid" style="color:#000; width: 98%; " placeholder="Nama kategori"', '') ?>
    </div>

    <div class="panel-body">
    <textarea class="form-control" name="deksripsi_kategori" placeholder="Deskripsi kategori" name="isi"  rows="5"  data-provide="markdown" data-hidden-buttons="cmdHeading"></textarea>
    </div>

    <div class="panel-footer">
    <input class="btn btn-success lainnya" type="submit" name="kirimkategorimateri" value="Kirim">
    </div>

  </div>

</form>
</div>