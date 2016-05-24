<?php

		if(isset($_GET['hash']))

		{

			$sql = sprintf('SELECT * FROM tb_pengguna WHERE username = "%s"',$_GET['hash']);
			$data = $db2->query($sql);

			if($data->rowCount() == 0)
			{
				echo $cx_error->code('user_not_found');
				die;
			}

			$profil = $data->fetch();

		}

		else

		{

			echo $cx_error->code(404);

			die;

		}

?>

<div class="row center" style="padding-top:10px; margin: 10px 0;
    ">
  <div class="col-sm-2 col-md-3 full-10" style="">
    <div class="komentar_pengguna" style="height:150px; background: #fff;border: #ccc 1px solid; text-align:center;"> <img src="<?php echo random_gravatar('220', $profil['email']); ?>" class="circle" width="auto" height="150px">
      <h2 class="header">@<?php echo $profil['username']; ?></h2>
      <p class="text-muted"><i><?php echo $profil['displayname'];?></i></p>
    </div>
  </div>
  <div class="col-sm-7 col-md-9 isi-komen-materi">
    <div class="panel panel-primary">
      <div class="panel-heading"> Profil Pengguna
        <?php
						echo $template->tombol($tombolproperti = array(
										'label' => 'Ubah',
										'aksi' => 'ubahakun',
										'style' => 'float:right;',
										'hash' => $_GET['hash']
										))
		?>
      </div>
      <div class="panel-body"> 
      <table class="table table-hover">
                                        <tr>
                                            <td width="150" id="field" class="text-muted">Nama Tampilan  </td>
                                            <td style="font-weight:bold;">: <?php echo $profil['displayname']?></td>
                                        </tr>
                                        <tr>
                                            <td width="150" id="field" class="text-muted">Nama Pengguna</td>
                                            <td style="font-weight:bold;">: @<?php echo $profil['username']?></td>
                                        </tr>
                                        <tr>
                                            <td width="150" id="field" class="text-muted">Lokasi</td>
                                            <td style="font-weight:bold;">: <?php echo $profil['alamat']?></td>
                                        </tr>
	                                    <tr>
                                            <td width="150" id="field" class="text-muted">Tentang Saya</td>
                                            <td style="font-weight:bold;">: <?php echo $profil['tentang']?></td>
                                        </tr>                                        

                                </table>
      </div>
    </div>
    
    
        <div class="panel panel-primary panel-favorit" style="box-shadow:0px 3px 5px #FF1493">
        <div class="panel-heading">
        <i class="fa fa-heart"></i>
        Materi yang disukai <i>@<?php echo $profil['username'] ?></i>
        </div>
        <div class="panel-body">
        <?php
		include 'config/koneksi.php';
		
		$sql = sprintf('SELECT a.id,a.id_materi, a.id_pengguna,b.hash,b.judul,b.konten,b.status,b.tipe
                        FROM tb_materi_favorit a
                        LEFT JOIN tb_materi b
                        ON a.id_materi = b.hash
                        WHERE a.id_pengguna= %s',$profil['uid']);  
		$kueri = $db2->query($sql);
		$jumlah_materi = $kueri->rowCount();
		
		if($jumlah_materi == 0 )
		{
			echo 'tidak ada data';
		}
		while($materi = $kueri->fetch())
		{	
			$materi['ukuran_kotak'] = 'col-md-5 col-sm-3 col-xs-6';
			echo $template->materidaftar($materi);
		}
		?>
        </div>
        </div>
    
    
  </div>
</div>
