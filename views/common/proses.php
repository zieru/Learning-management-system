	<br>
<?php
$error = $pesan = null;

if (isset($_POST['daftar'])) {
	include $engine->config('koneksi');

	// validasi
	// username

	if (empty($_POST['username']) AND empty($_POST['password']) AND empty($_POST['password']) AND empty($_POST['password2']) AND empty($_POST['display_name'])) {
		echo 'Mohon Isi semua form';
		die;
	} else {
		$registrasi = array(
			'username' => $_POST['username'],
			'password' => md5($_POST['password']),
			'password2' => md5($_POST['password2']),
			'jumlahpassword' => strlen($_POST['password']),
			'email' => $_POST['email'],
			'display_name' => $_POST['display_name'],
		);

		// validasi
		// username

		$sql = sprintf('SELECT username FROM tb_pengguna WHERE username = "%s"', $registrasi['username']);
		$data = $db2->query($sql);
		if ($data->rowCount() == 1) {
			echo 'username sudah ada';
			die;
		}

		// sandi

		if ($registrasi['password'] === $registrasi['password2']) {

			// cek jumlah password

			if ($registrasi['jumlahpassword'] < $akun['minpassword']) {
				echo sprintf('kata sandi minimal 6 karakter ', $akun['minpassword']);
				die;
			}
		} else {
			echo 'kata sandi tidak sama';
			die;
		}
	} //End VALIDASI
	$sql = sprintf('INSERT INTO tb_pengguna (username,password,email,displayname) values("%s","%s","%s","%s")', $registrasi['username'], $registrasi['password'], $registrasi['email'], $registrasi['display_name']);
	$data = $db->query($sql);
	if ($data->rowCount() == 1) {
		$pesan = 'sukses';
	}
} //END DAFTAR PROSES

// MULAI PROSES MANIPULASI MATERI

if (isset($_POST['materibaru'])) {
	$id_materi = $engine->hashacak();
	$error .= $template->validasiinput(array(
		'judul' => 'Judul Materi',
		'nilai' => $_POST['judul'],
		'kosong' => false,
		'min-max' => '6-64',
	));
	$error .= $template->validasiinput($properti = array(
		'judul' => 'kelas',
		'nilai' => $_POST['kelas'],
		'kosong' => FALSE,
		'min-max' => '1-6',
	));

	//cek jika metode upload 1

	if(isset($_POST['metode_upload']))
	{
		if($_POST['metode_upload'] == 1)
		{
			$error .= $template->validasiinput($properti = array(
				'judul' => 'dokument',
				'nilai' => $_FILES['fileToUpload'],
				'folder' => "upload",				
				'upload_file' => TRUE,
				'ukuranfile_min-max' => '1-200000',
				'tipe_file' => 'PDF,DOCX,DOC,MP4',
			));
		}
	}
	else
	{
		$error .= 'tidak ada metode upload yang dipilih !'. PHP_EOL;
	}

	if (!empty($error)) {
		echo '<h5> Terdapat Kesalahan </h5>' . $error;
	}


	//mulai proses simpan file dan catat kedatabase
	if (empty($error)) {

		//properti upload / embed materi
		$waktuupload = time();			
		$hash = $db2->quote($id_materi);
		$judul = $db2->quote($_POST['judul']);
		$kategori = $db2->quote($_POST['kategori']);
		$deskripsi = $db2->quote($_POST['deskripsi']);
		$kelas = $db2->quote($_POST['kelas']);
		$urutan = $db2->quote($_POST['urutan']);

    	if($_POST['metode_upload'] == 1)
    	{
			// pproses file (1) sebelum dimasukkan
			// proses file

			// contoh nama file yang diupload '87-171-1-SM.pdf'
			// nama file (asli) = 87-171-1-SM.pdf yang diupload
			$originalfile = basename($_FILES["fileToUpload"]["name"]);
			$tipe = $db2->quote($_FILES["fileToUpload"]["type"]);
			$simpanfile = $waktuupload . '_' . md5($originalfile); //nama filedienkripsi 1448173768_9d43b5edbe14f5371c8d1edb6672cc31

			// target file yg akan disimpan keserver 'uploads/9d43b5edbe14f5371c8d1edb6672cc31'
			$target = $lokasi_upload . '/'.$simpanfile;
			// lokasi+nama file yg diupload sementara (mentah)
			
			$embed_sumber = $embed_konten = 'NULL';
			$tmp_name = $_FILES["fileToUpload"]["tmp_name"];
			$checksum = $db2->quote(md5_file($tmp_name));
			$ukuran = $_FILES['fileToUpload']['size'];
			$konten = $db2->quote($simpanfile); //konten merupakan PATH file yang diupload, bukan yang embed kk	
		}
		elseif($_POST['metode_upload'] == 2)
		{
			//echo 'konten youtube : '. $_POST['embed_url'];
			$tipe = $checksum = $ukuran = $konten = 'NULL';
			$embed_sumber = 1;
			$embed_konten = $db2->quote($_POST['embed_url']);
		}
		else
		{
			die('kesalahan tidak ada metode unggah yang dipilih !.');
		}


		//eksekusi kuery catat dalam database
		$sql = "INSERT INTO tb_materi
    (hash,judul,kategori,deskripsi,kelas,urutan,konten,tipe,checksum,waktuupload,ukuranfile,diskusi,embed_sumber,embed_konten,status)    values($hash,$judul,$kategori,$deskripsi,$kelas,$urutan,$konten,$tipe,$checksum,$waktuupload,$ukuran,1,$embed_sumber,$embed_konten,1)";
	
    	error_log(print_r($sql,true));

		$data = $db2->query($sql);
		if ($data->rowCount = 1) 
		{
			//jika metode unggah berkas, maka upload
			if($_POST['metode_upload'] == 1)
			{
				move_uploaded_file($tmp_name, $target);
			}

			$pesan .= 'Materi Telah ditambahkan';
			$redirect = array(
							"url" => $go->to('materi', 'list'),
							"timeout" => 5);
		} 
		else 
		{
			$pesan .= 'Terjadi Kesalahan Fatal, File tidak tersimpan didatabase';
		}
	} else {
		$pesan .= $error;
	}
}

// proses edit materi dari database dan juga file

if (isset($_POST['materiedit'])) {
	$error .= $template->validasiinput($properti = array(
		'judul' => 'Judul Materi',
		'nilai' => $_POST['judul'],
		'kosong' => FALSE,
		'min-max' => '6-64',
	));
	$error .= $template->validasiinput($properti = array(
		'judul' => 'kelas',
		'nilai' => $_POST['kelas'],
		'kosong' => FALSE,
		'min-max' => '1-6',
	));
	if (empty($error)) {

		// mengambil data record yang telah ada didatabase (data saat ini/current)

		$datamateri = $db2->prepare('SELECT * FROM tb_materi WHERE hash = (:hash)');
		$datamateri->bindValue(':hash', $_GET['hash']);
		$datamateri->execute();
		$recordmateri = $datamateri->fetch();

		// periksa jika data ada

		if ($datamateri->rowCount() == 1) {

			// cek jika ada materi yang diupload maka update file juga

			if ($_FILES["fileToUpload"]["error"] == 0) {
				$adayangdiupload = TRUE;

				// validasi dulu

				$error .= $template->validasiinput($properti = array(
					'judul' => 'dokument',
					'nilai' => $_FILES['fileToUpload'],
					'upload_file' => TRUE,
					'folder' => $lokasi_upload .'/',
					'ukuranfile_min-max' => '1-200000',
					'tipe_file' => 'PDF,DOCX,DOC,MP4',
				));
				if (empty($error)) //jika gada error barulah diupload
				{

					// hapus dulu file yanglama
					// mulai hapus file
		
					if (!unlink($recordmateri['konten'])) {
						$pesan .= "FIle Gagal dihapus";
						$error = 1;
					} else {
						$pesan .= "File Dihapus";
					}
				}

				// jika tidak ada masalah maka kita upload file yang baru

			} //akhir periksa variable $_FILES
		} //akhir periksa data
	} //jika tidak ada error diiinput
	else {
		echo '<h5> Terdapat Kesalahan </h5>' . $error;
	}

	if (empty($error)) {

		// pproses file (1) sebelum dimasukkan
		// proses file

		$waktuupload = time();
		$folder = 'uploads/';

		// contoh nama file yang diupload '87-171-1-SM.pdf'
		// nama file (asli) = 87-171-1-SM.pdf yang diupload

		$originalfile = basename($_FILES["fileToUpload"]["name"]);
		$extensi = strtoupper($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
		$simpanfile = $waktuupload . '_' . md5($originalfile); //nama filedienkripsi 1448173768_9d43b5edbe14f5371c8d1edb6672cc31
		$original = $folder . $originalfile;

		// target file yg akan disimpan keserver 'uploads/9d43b5edbe14f5371c8d1edb6672cc31'

		$target = $folder . $simpanfile . '.' . $extensi;

		// lokasi+nama file yg diupload sementara (mentah)

		$tmp_name = $_FILES["fileToUpload"]["tmp_name"];
		$editmateri = $db2->prepare('
								    UPDATE tb_materi SET
								    `judul` = (:judul),
								    `deskripsi` = (:deskripsi),
								    `kelas` = (:kelas),
								    `urutan` = (:urutan),
								    `diskusi` = "1"
								    (:fileyangdiupload)
								    WHERE `hash` = (:hash)
								    ');
		$editmateri->bindValue(":judul", $_POST['judul']);
		$editmateri->bindValue(":deskripsi", $_POST['deskripsi']);
		$editmateri->bindValue(":kelas", $_POST['kelas']);
		$editmateri->bindValue(":urutan", $_POST['urutan']);
		$editmateri->bindValue(":hash", $_GET['hash']);
		if (isset($adayangdiupload)) {
			$konten = $db2->quote($target);
			$checksum = $db2->quote(md5_file($tmp_name));
			$ukuran = $_FILES['fileToUpload']['size'];
			$x = sprintf('konten = %s,
    checksum = %s,
    waktuupload =  %s,
    $ukuranfile = %s', $konten, $checksum, $waktuupload, $ukuran);
			$editmateri->bindValue(":fileyangdiupload", $_POST['hash']);
		}
		$editmateri->execute();
		$editmateri->debugDumpParams();
		if ($editmateri->rowCount = 1) {
			if (isset($adayangdiupload)) {
				move_uploaded_file($tmp_name, $target);
			}

			$pesan .= 'Materi Telah diperbarui';
		} else {
			$pesan .= 'Terjadi Kesalahan Fatal, File tidak tersimpan didatabase';
		}
	}
}

// proses hapus materi dari database dan juga file

if (isset($_GET['act']) AND $_GET['act'] == "hapusmateri") {

	// mengambil data record yang telah ada didatabase

	$datamateri = $db2->prepare('SELECT * FROM tb_materi WHERE hash = (:hash)');
	$datamateri->bindValue(':hash', $_GET['hash']);
	$datamateri->execute();

	// periksa jika data ada
	if ($datamateri->rowCount() == 1) {
		foreach ($datamateri as $recordmateri);
		// mulai hapus file (jika melalui meteode unggah berkas)
		error_log(print_r($recordmateri['konten'],true));
		/*
		if(($recordmateri['konten'] !== "NULL"))		
		{
			if (!unlink($lokasi_upload . '/'.$recordmateri['konten'])) {
				$pesan .= "FIle Gagal dihapus, karna file tidak ditemukan <Br>";
			} else {
				$pesan .= "File Dihapus";
			}
		}
		*/

		
		// mulai hapus dari database
		if (empty($error)) {
			$datamateri = $db2->prepare('UPDATE tb_materi SET status = 2 WHERE hash = (:hash)');
			$datamateri->bindValue(':hash', $_GET['hash']);
			$datamateri->execute();
			if ($datamateri->rowCount() == 1) {
				$pesan .= 'Berhasil dihapus dari database';
			} else {
				$pesan .= 'gagal dihapus dari database';
			}
		} //hapus dari databse
	} //periksa data
	else {
		$pesan .= 'ERROR, terjadi kesalahan, kemungkinan data telah terhapus dari database';
	}
	
	$redirect["url"] = $go->to("materi","list");
} //akhir hapus materi


if (isset($_POST['kirimkategorimateri']))
{	
	$nama_kategori = $deksripsi_kategori = NULL;	
	$nama_kategori = $_POST['nama_kategori'];
	$deskripsi_kategori = $_POST['deksripsi_kategori'];
	$sql = sprintf('INSERT INTO tb_materi_kategori (nama_kategori,deskripsi_kategori,publikasi)
    values("%s","%s",1)', $nama_kategori,$deksripsi_kategori,1);
	$data = $db2->query($sql);
	if ($data->rowCount() == 1) {
		$pesan = 'kategori telah ditambahkan';
		$redirect["url"] = $go->to('materi', 'kategori');
	}
}


// akhir materimanipulasi

if (isset($_POST['kirimkomentar'])) {
	include $engine->config('koneksi');
	$error = NULL;
	$isi = $db2->quote($_POST['isikomentar']);
	$isikomentar = strip_tags($isi,'<blockquote>');
	$error .= $template->validasiinput(array(
		'judul' => 'Teks Balasan Topik',
		'nilai' => $isikomentar,
		'kosong' => false,
		'min-max' => '3-4094',
	));
	
	if($error == NULL)
	{
		$sql = sprintf('INSERT INTO
    tb_diskusi (fid,uid,tid,tipe,konten,timestamp,publikasi)
    values("%s","%s","%s",2,%s,"%s",2)', $engine->hashacak(16, 1), $_SESSION['uid'], $_SESSION['materi_hash'], $isikomentar, time());
		$data = $db2->query($sql);
		if ($data->rowCount() == 1) {
			$pesan = 'Komentar telah diterima';
			$redirect["url"] = $go->to('materi','lihat',$_SESSION['materi_hash']);
			}	
	}
	else
	{
		$pesan = sprintf('<div style="font-size:14px;">
							<h3 style="text-align:center;">KESALAHAN !</h3>

							<div style="text-align:left; background:#fff; padding:10px; margin-bottom:30px;">
														<p>Terdapat beberapa kesalahan berikut :</p>
														%s</div>
							Tidak akan ada data yang disimpan														
							</div>
							',$error);
		$redirect["timeout"] = 320;
		$redirect["url"] = $go->to('materi','lihat',$_SESSION['materi_hash']);
	}
	

	$_SESSION['materi_hash'] = NULL;
}

// proses pada diskusi (forum)

if (isset($_POST['diskusibaru'])) {
	include $engine->config('koneksi');

	$judul = $db2->quote($_POST['judul']);
	$isi = strip_tags($_POST['isi'],'<blockquote>');
	$id_diskusi = $engine->hashacak(16, 1);
	$sql = sprintf('INSERT INTO
    tb_diskusi (fid,uid,tid,tipe,judul,konten,timestamp,publikasi)
    values("%s","%s","%s",1,%s,"%s","%s",2)', $id_diskusi, $_SESSION['uid'], null, $judul, $isi, time());
	$data = $db2->query($sql);
	if ($data->rowCount() == 1) {
		$pesan = 'Forum telah dikirim';
		$redirect["url"] = $go->to('forum', 'lihat', $id_diskusi);
	}
} //diskusi baru

if (isset($_POST['diskusi_balas'])) {
	include $engine->config('koneksi');
	$error = NULL;
	$isi = strip_tags($_POST['isi'],'<blockquote>');
	$error .= $template->validasiinput(array(
		'judul' => 'Teks Balasan Topik',
		'nilai' => $isi,
		'kosong' => false,
		'min-max' => '3-4094',
	));
	
	$id_diskusi = $engine->hashacak(16, 1);
	$tid = $_POST['tid'];
	
	if($error == NULL)
	{	
		$sql = sprintf('INSERT INTO
		tb_diskusi (fid,uid,tid,tipe,judul,konten,timestamp,publikasi)
		values("%s","%s","%s",0,"%s","%s","%s",2)', $id_diskusi, $_SESSION['uid'], $tid, null, $isi, time());
		$data = $db2->query($sql);
		echo '<br />';
		echo $sql;
		if ($data->rowCount() == 1) {
			$pesan = 'Balasan Telah Dikirim';
			$redirect["url"] = $go->to('forum', 'lihat', $tid);
		}
	}
	else
	{
		$pesan = sprintf('<div style="font-size:14px;">
							<h3 style="text-align:center;">KESALAHAN !</h3>

							<div style="text-align:left; background:#fff; padding:10px; margin-bottom:30px;">
														<p>Terdapat beberapa kesalahan berikut :</p>
														%s</div>
							Tidak akan ada data yang disimpan														
							</div>
							',$error);
		$redirect["timeout"] = 320;
		$redirect["url"] = $go->to('forum', 'lihat', $tid);
	}
} //diskusi baru

if (isset($_POST['balasdiskusi'])) {
	include $engine->config('koneksi');

	$id_diskusi = $engine->hashacak(16, 1);
	$isikomentar = 	$isi = strip_tags($_POST['isikomentar'],'<blockquote>');
	$kutipan = $db2->quote($_SESSION['kutipan']);
	$tid = $_SESSION['tid'];

	// mendeteksi tipe dari balasan

	$sql = sprintf('SELECT tipe FROM tb_diskusi WHERE fid = "%s"', $_SESSION['diskusi_hash']);
	$data = $db2->query($sql);
	$tipe = $data->fetch();
	$tipe = $tipe['tipe'];
	echo $sql;
	echo 'hola = ' . $tipe . '<br />';
	if ($tipe = 0) {
		$tipebalasan = 0; //tipe reply forum
	} else {
		$tipe = 2;
	}

	$sql = sprintf('INSERT INTO
    tb_diskusi (fid,uid,tid,parent,tipe,konten,timestamp,publikasi,kutipan)
    values("%s","%s","%s","%s",%s,%s,"%s",0,"%s")', $id_diskusi, $_SESSION['uid'], $tid, $_SESSION['diskusi_hash'], $tipebalasan, $isikomentar, time(), $kutipan);
	$data = $db2->query($sql);
	echo $sql;
	if ($data->rowCount() == 1) {
		$pesan = 'Komentar telah diterima';
		$sql = sprintf('SELECT * FROM tb_diskusi WHERE fid = "%s"', $id_diskusi);
		$data = $db2->query($sql);
		$diskusi = $data->fetch();
		if ($diskusi['tipe'] == 0) {
			$sub = 'forum';
		} else {
			$sub = 'materi';
		}

		// $redirect = header("refresh:5;url=".$go->to($sub,'lihat',$diskusi['tid']));

		echo '<br />' . $diskusi['tid'];
	}

	$_SESSION['diskusi_hash'] = NULL;
}

// user

if (!empty($_GET['act']) AND !empty($_GET['hash'])) {
	if ($_GET['act'] == 'hapususer') {
		$sql = sprintf('DELETE FROM tb_pengguna WHERE uid= "%s"', $_GET['hash']);
		$data = $db2->query($sql);
		echo $sql;
		$pesan = 'User Berhasil dihapus';
	}
}

if (isset($_POST['ubahprofil'])) {
	$password = md5($_POST['password']);
	$sql = "SELECT * FROM tb_pengguna WHERE username='$_POST[username]' AND password='$password'";
	$data = $db2->query($sql);
	if ($data->rowCount() == 1) {
		$sql = "UPDATE tb_pengguna SET displayname = '$_POST[displayname]',
    alamat = '$_POST[alamat]',
    email = '$_POST[email]',
    jeniskelamin = '$_POST[jeniskelamin]'
    WHERE username = '$_POST[username]'
    ";
		$db2->query($sql);
	}

	$redirect = header("refresh:5;url=" . $go->to('profil', 'lihat', $_POST['username']));
	$pesan = 'mengubah profil';
}



if (!empty($redirect["url"])) {
	
	if(empty($redirect["timeout"])) {$redirect["timeout"] = 5;}
	if(empty($redirect["ukuran_pesan"])) {$redirect["ukuran_pesan"] = 'huge';}
	
	
	echo 
	'
	<div class="col-lg-10" style="margin:0 8%;">
	<div class="panel panel-success">
                        <div class="panel-heading">
						
						<div class="row" style="padding:5px;">
                                <div class="text-center">
                                    <div class="'.$redirect['ukuran_pesan'].'">'.$pesan.'</div>
									Mohon tunggu sebentar, Anda akan dialihkan ke halaman selanjutnya.
                                </div>
                            </div>
								
                        </div>
                        <a href="'.$redirect['url'].'">
                            <div class="panel-footer">
                                <span class="pull-left">Jika anda tidak dialihkan dalam beberapa saat, mohon klik disini </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
	</div>
	';
	header("refresh:".$redirect["timeout"].";url=" . $redirect["url"]);
}

?>
