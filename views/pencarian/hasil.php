<?php
$pesan_error = $kueri_forum = $union = $kueri_materi = NULL;
$tidak_ada_opsi_pencarian = 1;
if(isset($_GET['o_forum']) AND $_GET['o_forum'] == "on")
{
	$kueri_forum = sprintf('SELECT
								"forum" AS sub,
								a.`timestamp` AS waktu,
								a.judul AS judul,
								a.fid AS id,
								a.tipe AS tipe,
								NULL AS embed_sumber,
								"Diskusi" AS kategori_id,
								"Diskusi" as kategori
							FROM
								tb_diskusi a
							WHERE
								a.judul LIKE "%%%s%%"
							AND a.tipe = 1',$keyword);

	$tidak_ada_opsi_pencarian = 0;
}


if(isset($_GET['o_pdf']) AND $_GET['o_pdf'] == "on" OR
   isset($_GET['o_word']) AND $_GET['o_word'] == "on" OR
   isset($_GET['o_video']) AND $_GET['o_video'] == "on")
{
	if(!empty($kueri_forum))
	{
		$union = "UNION ALL";
	}

	$kueri_filter_materi =  NULL;


	$i =0;
	while($i < sizeof($tipefile_yangdiperbolehkan))
	{
		if(isset($_GET[$tipefile_yangdiperbolehkan_tag[$i]]) AND $_GET[$tipefile_yangdiperbolehkan_tag[$i]] == "on")
		{
			if($kueri_filter_materi == NULL){
				$kueri_filter_materi .= sprintf('b.judul LIKE "%%%s%%" AND tipe="%s"',$keyword,$tipefile_yangdiperbolehkan[$i]);
			}
			else{$kueri_filter_materi .=sprintf('OR 
												 b.judul LIKE "%%%s%%" AND tipe="%s"',$keyword,$tipefile_yangdiperbolehkan[$i]);}
		}	

		$i++;
	}	


	if(isset($_GET["o_video"]) AND $_GET["o_video"] == "on")
	{
		if($kueri_filter_materi == NULL){
			$kueri_filter_materi .= sprintf('b.judul LIKE "%%%s%%" AND embed_sumber=1',$keyword);
		}
		else{$kueri_filter_materi .=sprintf('OR 
											 b.judul LIKE "%%%s%%" AND embed_sumber=1',$keyword);
		}
	}		

	$kueri_materi = sprintf('SELECT
							"materi" AS sub,
							b.waktuupload AS waktu,
							b.judul AS judul,
							b.hash AS id,
							b.tipe AS tipe,
							b.embed_sumber AS embed_sumber,
							c.id AS kategori_id,
							c.nama_kategori as kategori
						FROM
							tb_materi b
						LEFT JOIN tb_materi_kategori c ON b.kategori = c.id
						WHERE
							 %s 
						ORDER BY
							waktu ASC',$kueri_filter_materi);
	$tidak_ada_opsi_pencarian = 0;
}



if(!empty($keyword) AND $tidak_ada_opsi_pencarian == 0)
{
	echo sprintf('<h3 style="margin-top: 0px;">Hasil pencarian <b><i>%s</i></b></h3> <hr>',$keyword);	
	$sql = sprintf('
	%s
	%s
	%s
			',$kueri_forum,$union,$kueri_materi);	
	//echo $sql;
	$jumlah = 0;
	foreach($db2->query($sql) AS $row)
	{
		$jumlah ++;

    	$hasil = $row;

    			//cari ikontipe
		switch($row['tipe'])
		{
			case "1":
			$hasil['thumb'] = '<i class="fa fa-fw fa-comment" ></i>';    
			break;
			case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
            $hasil['thumb'] = '<i class="fa fa-fw fa-file-word-o" ></i>';    
            break;
            case "video/mp4" :
            $hasil['thumb'] = '<i class="fa fa-fw fa-youtube-play" ></i>';    
            break;  
            case "application/pdf":
            $hasil['thumb'] = '<i class="fa fa-fw fa-file-pdf-o" ></i>';    
            break;
            default:
            $hasil['thumb'] = '<i class="fa fa-fw fa-file-o" ></i>';    
		}

		if(!empty($row['embed_sumber']))
        {
            switch($row['embed_sumber'])
            {
                case "1":
                $hasil['thumb'] = '<i class="fa fa-fw fa-youtube-play"></i>';    
                break;  
            }
        }

		
		if($row['kategori_id'] == NULL){$row['kategori'] = "Tdk ada kategori";}

		$hasil['kategori_list'] = '<span class="pull-right text-muted small">'.$row['kategori'].'</span>';
    	$hasil['judul_list'] = $hasil['thumb'] . ' '.$row['judul'] . $hasil['kategori_list'];
    	$hasil['aksi_list'] = $go->to($row['sub'], 'lihat', $row['id']);
    	
    	echo $template->daftar_list($hasil);
	}


	if($jumlah < 1)
	{
		echo "<p class='alert alert-info'><i class='fa fa-info-circle fa-fw'></i> Tidak ada hasil <p></p>";
	}

}
else
{
	if($tidak_ada_opsi_pencarian = 1)
	{
		$pesan_error .= "Untuk memulai pencarian, harap masukkan kata kunci minimal <b>3 karakter</b> pada kolom pencarian";
	}
	else
	{
		$pesan_error .= "Tidak ada opsi pencarian yang dipilih, maka tidak akan pernah ada hasil";
	}

		echo "<p class='alert alert-info'><i class='fa fa-info-circle fa-fw'></i>.".$pesan_error."</p>";
}


?>