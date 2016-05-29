<?php
include $engine->config('koneksi');
class template
{
	
    public function validasiinput($properti)
    {
        $validasiinput = $error = null;               
        // properti validasi input kosong
        if (isset($properti['kosong']))
        {
            if ($properti['kosong'] == false)
            {
                if ($properti['nilai'] == "" OR strlen($properti['nilai']) > 0 AND strlen(trim($properti['nilai'])) == 0)
                {
                    $error[] = sprintf('<i><b>%s</b></i> Kosong dan Tidak Mengandung Karakter Apapun, atau juga dapat disebabkan karena tag html yang dilarang (ev701)', $properti['judul']);
                } //$properti['nilai'] == "" OR strlen($properti['nilai']) > 0 AND strlen(trim($properti['nilai'])) == 0
            } //$properti['kosong'] == false
            else
            {
            }
        } //akhir validasi jika kosong
        // properti validasi jika input kurang atau lebih banyak
        if (isset($properti['min-max']))
        {
            $minmax = explode('-', $properti['min-max']); //nilai dari min-max dipecah menjadi min dan max
            if (strlen($properti['nilai']) < $minmax[0] AND strlen($properti['nilai']) <= $minmax[1])
            {
                $error[] = sprintf('<i><b>%s</b></i> harus berisi karakter minimal %d karakter dan maksimal %d karakter (ev702)', $properti['judul'], $minmax[0], $minmax[1]);
            } //strlen($properti['nilai']) <= $minmax[0] AND strlen($properti['nilai']) <= $minmax[1]
        } //isset($properti['min-max'])
        if (isset($properti['upload_file']))
        {
            if ($properti['upload_file'] == true)
            {
                $extensi = strtoupper(pathinfo(basename($properti["nilai"]["name"]), PATHINFO_EXTENSION));
                // jika nama folder tidak diset
                if (!isset($properti['folder']))
                {
                    $error[] = 'Nama Folder belum ditentukan';
                } //!isset($properti['folder'])
                if (isset($properti['ukuranfile_min-max']))
                {
                    $minmax_filesize = explode('-', $properti['ukuranfile_min-max']); //nilai dari min-max dipecah menjadi min dan max
                    if (strlen($properti['nilai']['size']) <= $minmax_filesize[0] AND strlen($properti['nilai']['size']) <= $minmax_filesize[1])
                    {
                        $error[] = sprintf('<i><b>%s</b></i> Ukuran FIle minimal %d KB dan maksimal %d KB (ev712)', $properti['judul'], $minmax_filesize[0], $minmax_filesize[1]);
                    } //strlen($properti['nilai']['size']) <= $minmax_filesize[0] AND strlen($properti['nilai']['size']) <= $minmax_filesize[1]
                } //isset($properti['ukuranfile_min-max'])
                if (isset($properti['tipe_file']))
                {
                    $tipe_file        = explode(',', strtoupper($properti['tipe_file']));
                    $jumlah_tipe_file = sizeof($tipe_file);
                    $i                = 0;
                    $extensi_cocok    = false;
                    while ($i < $jumlah_tipe_file)
                    {
                        if ($tipe_file[$i] == $extensi)
                        {
                            $extensi_cocok = true;
                        } //$tipe_file[$i] == $extensi
                        $i++;
                    } //$i < $jumlah_tipe_file
                    if ($extensi_cocok == false)
                    {
                        $x = null;
                        foreach ($tipe_file as $tipe_file_tunggal)
                        {
                            $x .= sprintf(',<i><b>%s</b></i> ', $tipe_file_tunggal);
                        } //$tipe_file as $tipe_file_tunggal
                        $error[] = sprintf('File tipe %s Dilarang, hanya boleh %s', $extensi, $x);
                    } //$extensi_cocok == false
                } //isset($properti['tipe_file'])
            } //upload file == true
        } //isset($properti['upload_file'])
        if (!empty($error))
        {
            foreach ($error as $pesan)
            {
                $validasiinput .= '<li>' . $pesan . '</li>';
            } //$error as $pesan
        } //!empty($error)
        return $validasiinput;
    } //akhir validasiinput
    public function tombol($tombolproperti)
    {
        if (empty($tombolproperti['label']))
        {
            $tombolproperti['label'] = null;
        } //empty($tombolproperti['label'])
        if (empty($tombolproperti['label_class']))
        {
            $tombolproperti['label_class'] = null;
        } //empty($tombolproperti['label_class'])
        if (empty($tombolproperti['class']))
        {
            $tombolproperti['class'] = null;
        } //empty($tombolproperti['class'])
        if (empty($tombolproperti['style']))
        {
            $tombolproperti['style'] = null;
        } //empty($tombolproperti['style'])
        if (empty($tombolproperti['icon']))
        {
            $tombolproperti['icon'] = null;
        }

        global $izin, $input, $go;
        switch ($tombolproperti['aksi'])
        {
            case 'tambahmateri':
                $href = $go->to('materi', 'baru');
                break;
            case 'ubahmateri':
                $href = $go->to('materi', 'ubah', $tombolproperti['hash']);
                break;
            case 'hapusmateri':
                $href = $go->to('proses', 'hapusmateri', $tombolproperti['hash']);
                break;				
            case 'kategorimateri':
                $href = $go->to('materi', 'kategori-list');
                break;    
            case 'tambahforumdiskusi':
                $href = $go->to('forum', 'baru');
                break;
            case 'ubahforumdiskusi':
                $href = $go->to('forum', 'ubah', $tombolproperti['hash']);
                break;
            case 'ubahakun':
                $href = $go->to('profil', 'ubah', $tombolproperti['hash']);
                break;
        } //$tombolproperti['aksi']


        if (empty($tombolproperti['tipe']))
        {
            if ($izin[$tombolproperti['aksi']] == 1)
            {
                $tombol = $input->button($tombolproperti['label'], $href, $tombolproperti['label_class'], $tombolproperti['style'],'FALSE',$tombolproperti['icon']);
            } //$izin[$tombolproperti['aksi']] == 1
            else
            {
                $tombol = null;
            }
        } //empty($tombolproperti['tipe'])
        elseif($tombolproperti['tipe'] == 'menulist')
        {
            if ($izin[$tombolproperti['aksi']] == 1)
            {
                $tombol = '<li>'. $input->link($link = array(
                    'href' => $href,
                    'label' => $tombolproperti['label'],
                    'style' => $tombolproperti['style']
                )).'</li>';

                if(isset($tombolproperti['custom_awal']))
                {
                    $tombol = $tombolproperti['custom_awal'] . $tombol;
                }

                if(isset($tombolproperti['custom_akhir']))
                {
                    $tombol = $tombol . $tombolproperti['custom_akhir'];
                }


            } //$izin[$tombolproperti['aksi']] == 1
            else
            {
                $tombol = null;
            }
        }
        else
        {
            if ($izin[$tombolproperti['aksi']] == 1)
            {
                $tombol = '<li>'. $input->link($link = array(
                    'href' => $href,
                    'label' => $tombolproperti['label'],
                    'style' => $tombolproperti['style']
                )).'</li>';

               
            } //$izin[$tombolproperti['aksi']] == 1
            else
            {
                $tombol = null;
            }
        }

        return $tombol;
    }
    // MATERI
    public function validasiinputmateri($validasi, $post)
    {
        $validasiinputmateri = $error = null;
        // validasi jika kosong
        $field               = array(
            'judul',
            'kelas',
            'urutan'
        );
        $i                   = 0;
        while ($i < 3)
        {
            if ($post[$field[$i]] == "")
            {
                $error[] = $field[$i] . ' tidak boleh kosong';
            } //$post[$field[$i]] == ""
            $i++;
        } //$i < 3
        if (!empty($error))
        {
            $validasiinputmateri .= '<h5>Terdpat kesalahan</h5>';
            foreach ($error as $pesan)
            {
                $validasiinputmateri .= '<li>' . $pesan . '</li>';
            } //$error as $pesan
        } //!empty($error)
        return $validasiinputmateri;
    }
    public function materidaftar($materi)
    {
        global $go, $template;
        // fungsi penyingkataan judul
        $maxjudul = 64;
        if (strlen($materi['judul']) >= $maxjudul)
        {
            $str = substr(strip_tags($materi['judul']), 0, $maxjudul) . ' ...';
        } //strlen($materi['judul']) >= $maxjudul
        else
        {
            $str = $materi['judul'];
        }
        if (empty($materi['deskripsi']))
        {
            $materi['deskripsi'] = '<em>Tidak Ada Deskripsi Materi</em>';
        } //empty($materi['deskripsi'])

		//tombol materi
		
	$tombol_opsi =sprintf('
	<div class="pull-right" style="    left: -5px;
    top: -160px;
    position: relative">
  	<div class="btn-group">
    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
	<i class="fa fa-gear"></i> <span class="caret"></span> </button>
    <ul class="dropdown-menu pull-right" role="menu">
      <div class=" dropdown-header header-nav-current-user css-truncate"> <b>Materi </b> </div>

		<!-- Menu Admin -->
		%s
		
		%s
    </ul>
  </div>
</div>
',
$template->tombol($tombolproperti = array(
  'label' => 'Edit',
  'aksi' => 'ubahmateri',
  'hash' => $materi['hash'],
  'tipe' => 'menulist',
  'custom_awal' => '<li class="divider"></li><div class=" dropdown-header header-nav-current-user css-truncate">
<b> Administrasi </b>Materi
</div>',
  'custom_akhir' => ''
)),
$template->tombol($tombolproperti = array(
  'label' => 'Hapus',
  'aksi' => 'hapusmateri',
  'hash' => $materi['hash'],
  'tipe' => 'menulist'
)));
		
		
        //periksa jika kategori video atau berkas
        $materi['thumb'] = '<i class="fa fa-4x fa-file-o center-block" style="margin: 0 20%;"></i>';    

        if(!empty($materi['konten']))
        {
            //$finfo       = finfo_open(FILEINFO_MIME_TYPE);
            //$fileextensi = finfo_file($finfo, $materi['konten']);
            $fileextensi = $materi['tipe'];
            //tentukan jika materi video maka gambar thumbnya video
        
            switch($fileextensi)
            {
                case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                $materi['thumb'] = '<i class="fa fa-4x fa-file-word-o center-block" style="text-align:center;width:100%;"></i>';    
                break;
                case "video/mp4" :
                $materi['thumb'] = '<i class="fa fa-4x fa-youtube-play center-block" style="text-align:center;width:100%;"></i>';    
                break;  
                case "application/pdf":
                $materi['thumb'] = '<i class="fa fa-4x fa-file-pdf-o center-block" style="text-align:center;width:100%;"></i>';    
                break;  
            }
        }
        elseif(!empty($materi['embed_sumber']))
        {
            switch($materi['embed_sumber'])
            {
                case "1":
                $materi['thumb'] = '<i class="fa fa-4x fa-youtube-play center-block" style="text-align:center;width:100%;"></i>';    
                break;  
            }
        }


	if($materi['status'] == 2)
	{
		$materi_panel = 'panel-danger panel-materi-dihapus" title="materi telah dihapus';
	}
	else
	{
		$materi_panel = "panel-default";
	}

	if(!isset($materi['ukuran_kotak']))
	{
		$materi['ukuran_kotak'] = 'col-md-3 col-sm-3 col-xs-6';
	}

        $daftarmateri = sprintf('
	<div class="%s">
    <a href="%s" data-original-title="%s" data-toggle="tooltip" data-placement="top" >
    <div class="panel panel-materi %s ">
                        <div class="panel-body" style="padding: 30px 0px;background: #fff;height:100px;max-height:100px;">
                            %s
                        </div>

                       <div class="panel-footer judul_materi_panel" style="color:#fff;border-top:solid 2px #ccc;background:transparent; box-shadow: 0px -1px 30px #ccc;">              
                           <p class="footer-materi" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;"> %s</p>
                        </div>
						
												 
                    </div>
    </a>
  %s
      </div>', 
		$materi['ukuran_kotak'],
        // link lihat materi depan
            $go->to('materi', 'lihat', $materi['hash']), 
        // judul dean (asli)
            $materi['judul'],
		// warna panel berdasarkan status materi
			$materi_panel,
        // gambar thumbnail
            $materi['thumb'],
        // judul kartu depan )potong
            $str,
			$tombol_opsi
        );
        return $daftarmateri;
    }
    // akhir template materi


public function materikategori($materi)
    {
        global $go, $template;

        if(empty($materi['icon']))
        {
            $materi['icon'] = '<img src="assets/images/thumb_kategori.png" width="100%">';
        }

        $daftarmateri = sprintf('

    <div class="col-md-3 col-sm-3 col-xs-6">
    <a href="%s" style="background:#fff !important;">
    <div id="kategori-daftar" class="panel panel-default" style="background:#000;">
        <div class="panel-body panel-kategori">
            %s

            <p style="text-align:center;">%s</p>
        </div>

                    </div>
</a>
      </div>', 
      $go->to('materi', 'kategori-lihat', $materi['id']),
      $materi['icon'],
      $materi['nama_kategori']);
        return $daftarmateri;
    }
    // akhir template materikategori


//template daftar-list
public function daftar_list($data)
{
    global $go, $template;
        if(!isset($data['style']))
        {
            $data['style'] = NULL;
        }
        if (empty($materi['deskripsi']))
        {
            $materi['deskripsi'] = '<em>Tidak Ada Deskripsi Materi</em>';
        } //empty($materi['deskripsi'])
		
		if(empty($data['deskripsi_list']))
		{
			$data['deskripsi_list'] = NULL;	
		}
		
        $daftarforumdiskusi = sprintf('<div class="list-group-item" 	%s>
                                        <a href="%s">%s</a> 
										%s
                                        </div>',

            $data['style'],										
			$data['aksi_list'],                 
            $data['judul_list'],
			$data['deskripsi_list']
            
            /*
            ,
            $template->tombol($tombolproperti = array(
            'label' => 'Ubah',
            'aksi' => 'ubahforumdiskusi',
            'hash' => $data['fid'],
            'style' => 'style="float:right;"',
            'tipe' => 1))*/ );
        return $daftarforumdiskusi;
}


    
    public function parseuser($uid, $datayangdiambil = null)
    {
        global $db2;
        if (empty($datayangdiambil))
        {
            $ambil_field = '*';
        } //empty($datayangdiambil)
        else
        {
            $ambil_field = $datayangdiambil;
        }
        $sql       = sprintf("SELECT %s FROM tb_pengguna WHERE uid = '%s'", $ambil_field, $uid);
        $data      = $db2->query($sql);
        $parseuser = $data->fetch();
        if (!empty($datayangdiambil))
        {
            $parseuser = $parseuser[$datayangdiambil];
        } //!empty($datayangdiambil)
        return $parseuser;
    }
    public function kotaklistpengguna($user)
    {
        global $go;
        $gravatar          = random_gravatar('260', $user['email']);
        $kotaklistpengguna = sprintf('

			<div class="col-md-2 col-sm-3 col-xs-6">

            <div class="card" style="height:330px;">

			  <div class="card-image waves-effect waves-block waves-light" >

                        <img class="activator" src="%s"" height="200px">

                    </div>

					

              <div class="card-content">

			  

                        <span class="card-title activator grey-text text-darken-4">

                        <i class="mdi-navigation-more-vert right"></i></span>		

								

                <p>%s <br>(%s)</p>

				

					

				  <div class="card-footer">

					<a href="%s">Lihat Profil</a>	

					<a class="right" href="%s">Hapus</a>	

				  </div>

              </div>

			  

			   <div class="card-reveal">

                        <span class="card-title grey-text text-darken-4">Informasi Pengguna <i>(%s)</i><i class="mdi-navigation-close right"></i></span>

						<br>

                        <p>Nama : %s</p>

						<p>Username : %s</p>

						<p>Email : %s</p>

						<p>Alamat : %s</p>

						<p>Status : %s</p>												

                    </div>

            </div>

			</div>

		', $gravatar, $user['displayname'], $user['username'], $go->to('profil', 'lihat', $user['username']), $go->to('proses', 'hapususer', $user['uid']), $user['username'], $user['displayname'], $user['username'], $user['email'], $user['alamat'], $user['status']);
        return $kotaklistpengguna;
    }
    public function inputkomentar()
    {
        global $go, $izin, $db2, $template;
        $balasan_komentar_konten = $msg = $disable = null;
        if ($izin['kirimkomentarmateri'] == 0)
        {
            $disable = 'disabled="disable"';
            $msg     = 'Anda Harus Login Untuk dapat memberi komentar';
            $larangan_input = '';
        } //$izin['kirimkomentarmateri'] == 0
        else {
        		$larangan_input = '<small>*beberapa tag HTML dilarang, gunakan markdown sebagai penggantinya</small>';
        }
        if (!empty($_GET['balaskomentar']))
        {
            // ambil data balas komentar
            $sql                     = sprintf('SELECT * FROM tb_diskusi WHERE fid= "%s"', $_GET['balaskomentar']);
            $data                    = $db2->query($sql);
            $balasan_komentar        = $data->fetch();
            $balasan_komentar_konten = sprintf('<blockquote> Membalas Komentar : %s
%s
</blockquote>

<!-- KETIK BALASAN DAN HAPUS PESAN INI DISINI -->
		', $template->parseuser($balasan_komentar['uid'], 'username'), $balasan_komentar['konten']);
        } //!empty($_GET['balaskomentar'])
        $inputkomentar = sprintf('          

          <div class="panel panel-primary">
          <div class="panel-heading">Kirim Komentar</div>
            <form style="background:whitesmoke;" action="%s" method="post">

              <div class="form-group panel-body">

                <textarea class="form-control" %s

				 name="isikomentar"  rows="5"  data-provide="markdown" data-hidden-buttons="cmdHeading">%s</textarea>
              </div>


                <div class="panel-footer">
                  <button class="btn btn-success lainnya" type="submit" name="kirimkomentar" %s>Kirim</button>
						
                  %s
						%s
                </div>


            </form>

          </div>', $go->to('proses'), $disable, $balasan_komentar_konten, $disable, $msg,$larangan_input);
        return $inputkomentar;
    }
    public function komentar($var = null)
    {
        $user = $var['user'];
        $komentar = $var['komentar'];
        if(isset($var['kutipan'])){$kutipan = $var['kutipan'];}else{$kutipan = NULL;};
        if(isset($var['thread_diskusi'])){$thread_diskusi = $var['thread_diskusi'];}else{$thread_diskusi = NULL;};

        global $Parsedown;
        global $go, $db2, $izin;
        if (!empty($kutipan['isi']))
        {
            $kutipan            = sprintf('<pre class="kutipan"><p>Balasan dari <a href="%s">%s</a> > <a href="#komentar-%s">(lihat komentar asli)</a> <p> %s </pre>', $go->to('profil', 'lihat', $kutipan['uid']), $kutipan['username'], $komentar['parent'], $Parsedown->text($kutipan['isi']));
            $komentar['konten'] = $kutipan . $komentar['konten'];
        } //!empty($kutipan['isi'])



        if(!empty($thread_diskusi))
        {
            if(isset($var['thread_utama']))
            {
                $panel = 'panel panel-primary';
            }
            else
            {
                $panel = 'panel panel-default';   
            }

            $komentar = sprintf('

                <div class="row">
                     <div class="col-sm-2 full-10" style="width:60px; padding-top:20px;">
                        <div class="komentar_pengguna"><img src="%s" class="circle"></div>
                    </div>                

                <div class="col-sm-7 full-90" style="width:90%%">
                <div class="%s" id="komentar-%s">
                    <div class="panel-heading"><a href="%s"><b>%s</b></a> posting pada %s  <a class="btn btn-default fa fa-reply-all" style="float:right;" href="%s"> Balas</a></div>
                    <div class="panel-body" style="background:#fff;">%s</div>
                </div>
                </div>
                </div>
                ', random_gravatar('50', $user['email']), $panel,$komentar['fid'], $go->to('profil', 'lihat', $user['username']), $user['username'], date('M jS,Y h:i A', $komentar['timestamp']), $go->to($_GET['sub'], 'lihat', $_GET['hash'] . '&balaskomentar=' . $komentar['fid'] . '#balas'),$Parsedown->text($komentar['konten'])
                // $go->to('diskusi&tid='.$_GET['hash'],'balas',$komentar['fid']).'#balas'
                    );            
        }
        else
        {
            $komentar = sprintf('
    	<div class="row" id="komentar-%s" style="padding-bottom:10px; margin-right:0px;">
            <div class="col-sm-2 col-md-2 full-10" style="">

    		    <div class="komentar_pengguna" style="height: 100px;background: #fff;    border: #ccc 1px solid;">

    				<img src="%s" class="circle" width="auto" height="100px">

    			</div>

    		</div>



    		<div class="col-sm-7 col-md-10 isi-komen-materi" >
                <div class="card">
    				<h6 class="komenheader text-muted"><p class="namakomentar">
    				<a href="%s">%s</a></p> mengomentari pada %s
    				</h6>
                  <div class="card-content komenkonten">
                    <p>%s</p>
                  </div>
    			  <div class="komenfooter" style="border-top:1px solid #ccc; padding:5px;">
    			  <a href="%s"><i class="fa fa-reply"> Balas</i></a>
    			  </div>

                </div>

    		</div>

    	</div>	

    		', $komentar['fid'], random_gravatar('50', $user['email']), $go->to('profil', 'lihat', $user['username']), $user['username'], date('l jS  F Y h:i A', $komentar['timestamp']), $Parsedown->text($komentar['konten']), $go->to($_GET['sub'], 'lihat', $_GET['hash'] . '&balaskomentar=' . $komentar['fid'] . '#balas')
            // $go->to('diskusi&tid='.$_GET['hash'],'balas',$komentar['fid']).'#balas'
                );
        }
        return $komentar;
    }
    // fungsi yang digunakan untuk mengambil data UID dari tid yang dibalas
    // dengan cara : ambil tid user yang dibalas -> ambil uid
    public function parent_to_uid($parent)
    {
        global $go, $db2;
        $sql                      = sprintf('SELECT uid FROM tb_diskusi WHERE fid = "%s"', $parent);
        $data                     = $db2->query($sql);
        $diskusi_balasan_ambiluid = $data->fetch();
        return $diskusi_balasan_ambiluid['0'];
    }
    public function inputdiskusi($diskusi = null)
    {
        global $go, $izin, $input, $db2, $template;
        $konten_judul = $konten_isi = $msg = $disable = null;
        if ($izin['kirimkomentardiskusi'] == 0)
        {
            $disable = 'disabled="disable"';
            $msg     = 'Anda Harus Login Untuk dapat memberi komentar';
            $larangan_input = '';
        } //$izin['kirimkomentardiskusi'] == 0
        else {
        	$larangan_input = '<small>*beberapa tag HTML dilarang, gunakan markdown sebagai penggantinya</small>';
        }
        
        // deklarasi varibale input diskusi
        $input_judul = $balasan_komentar_konten = $balasan_komentar = $thread_id = $input_name = null;
        if (!empty($diskusi))
        {
            if ($diskusi['tipe'] == 'diskusibaru')
            {
                $input_judul = $input->label('judul', '', 'active');
                if ($_GET['act'] == 'baru')
                {
                    $input_judul .= "\n" . $input->text('judul', 'judul', 'validate valid" style="color:#000; width: 98%; " placeholder="Judul Forum Diskusi"', '');
                } //$_GET['act'] == 'baru'
                $input_name = $diskusi['tipe'];
            } //$diskusi['tipe'] == 'diskusibaru'
            elseif ($diskusi['tipe'] == 'diskusi_balas')
            {
                $input_name = $diskusi['tipe'];
                $thread_id  = "<input type='hidden' value='$_GET[hash]' name='tid'>";
            } //$diskusi['tipe'] == 'diskusi_balas'
        } //!empty($diskusi)
        // jika ubah diskusi
        if ($_GET['act'] == 'ubah')
        {
            $sql                  = sprintf('SELECT * FROM tb_diskusi WHERE fid = "%s"', $_GET['hash']);
            $data                 = $db2->query($sql);
            $dataeditforumdiskusi = $data->fetch();
            $konten_judul         = $dataeditforumdiskusi['judul'];
            $konten_isi           = $dataeditforumdiskusi['konten'];
            $input_judul .= "\n" . $input->text('judul', 'judul', 'validate valid', '', 'value="' . $konten_judul . '"');
        } //$_GET['act'] == 'ubah'
        if (!empty($_GET['balaskomentar']))
        {
            // ambil data balas komentar
            $sql                     = sprintf('SELECT * FROM tb_diskusi WHERE fid= "%s"', $_GET['balaskomentar']);
            $data                    = $db2->query($sql);
            $balasan_komentar        = $data->fetch();
            $balasan_komentar_konten = sprintf('<blockquote> Membalas Komentar : %s
%s
</blockquote>

<!-- KETIK BALASAN DAN HAPUS PESAN INI DISINI -->
		', $template->parseuser($balasan_komentar['uid'], 'username'), $balasan_komentar['konten']);
            $konten_isi              = $balasan_komentar_konten;
        } //!empty($_GET['balaskomentar'])

        if(!empty($input_judul))
        {
            $input_judul = '<div class="panel-heading">'. $input_judul.'</div>';
        }

        $inputdiskusi = sprintf('          
          <div id="balas" class="row" style="padding-left:5%%;padding-right:5%%;">        
            <form action="%s" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <div class="panel panel-default">
			     %s

				 %s
            
                <div class="panel-body">
                <textarea class="form-control" %s	 name="isi"  rows="5"  data-provide="markdown" data-hidden-buttons="cmdHeading">%s</textarea>
                </div>

                <div class="lainnya panel-footer" style="display:block;">

                  <input class="btn btn-success lainnya" type="submit" name="%s" %s value="Kirim">
					%s
				  %s

                </div>

              </div>
            </div>
            </form>

          </div>', $go->to('proses'), // form action
            $input_judul, 
            $thread_id, $disable, // disable untuk textarea
            $konten_isi, $input_name, $disable, // disable untuk input
            $msg,$larangan_input);
        return $inputdiskusi;
    }
    public function daftarhalaman($nilai, $style = null)
    {
        global $go;
        $urloffset = $go->to('materi', 'lihat', $_GET['hash']) . '&offset=';
        // untuk membuat aktif offset
        if (isset($_GET['offset']))
        {
            $offset_nilai = $_GET['offset'];
        } //isset($_GET['offset'])
        else
        {
            $offset_nilai = 0;
        }
        // mencari daftar halaaman agar dibagikan dengan offset
        $daftarhalaman_halaman = ceil($nilai['totaljumlah'] / $nilai['limit']); //bulatkan
        $daftarhalaman         = sprintf('<div %s>

								<ul class="pagination">

		', $style);
        $i                     = 0;
        while ($i < $daftarhalaman_halaman)
        {
            // membuat daftar offset aktif
            if ($offset_nilai == $i)
            {
                $aktif = 'class="default_color"';
            } //$offset_nilai == $i
            else
            {
                $aktif = null;
            }
            $daftarhalaman .= sprintf('<li><a %s href="%s">%s</a></li>', $aktif, $urloffset . $i, $i + 1);
            $i++;
        } //$i < $daftarhalaman_halaman
        $daftarhalaman .= '</ul>

					</div>	';
        return $daftarhalaman;
    }
}
$template = new template();
