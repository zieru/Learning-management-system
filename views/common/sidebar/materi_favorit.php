<div class="panel panel-default panel-favorit" style="box-shadow:0px 3px 5px #FF1493">
                        <div class="panel-heading" style="font-size:24px;">
                          <i class="fa fa-heart"></i>  Materi Favorit
                        </div>
                        <div class="panel-body" style="padding:5px;">
                            <div class="list-group" style="margin-bottom:0px;">
<?php
include $engine->config('koneksi');


    
    $sql = sprintf('SELECT a.id,a.id_materi, a.id_pengguna,b.hash,b.judul
                        FROM tb_materi_favorit a
                        LEFT JOIN tb_materi b
                        ON a.id_materi = b.hash
                        WHERE a.id_pengguna= %s',$user['uid']);  
    $kueri = $db2->query($sql);
    $jumlah_materi = $kueri->rowCount();

    if($jumlah_materi > 5)
    {
        $limit = "4";    
        $sql = sprintf('SELECT a.id,a.id_materi, a.id_pengguna,b.hash,b.judul
                        FROM tb_materi_favorit a
                        LEFT JOIN tb_materi b
                        ON a.id_materi = b.hash
                        WHERE a.id_pengguna= %s
                        LIMIT %d ',$user['uid'],$limit);          
        $kueri = $db2->query($sql);
    }

if($jumlah_materi == 0 )
{
    echo '<p href="#" class="list-group-item">tidak ada data</p>';
}
while($materi_favorit = $kueri->fetch())
{

    $maxjudul = 20 ;
    if (strlen($materi_favorit['judul']) >= $maxjudul)
    {
        $str = substr(strip_tags($materi_favorit['judul']), 0, $maxjudul) . '...';
    } //strlen($materi['judul']) >= $maxjudul
    else
    {
        $str = $materi_favorit['judul'];
    }


    $materi_favorit['judul_list'] = $str;
    $materi_favorit['aksi_list'] = $go->to('materi', 'lihat', $materi_favorit['hash']);
    echo $template->daftar_list($materi_favorit);

}

if(isset($limit))
{
    echo $template->daftar_list(array(
                                'judul_list' => 'Lihat semua <i class="fa fa-angle-right"></i>',
                                'aksi_list' => $go->to('materi','favorit'),
                                'style' => 'style="text-align:center; color:#337ab7; font-weight:bold; background:rgb(248, 248, 248);"'
                                ));        
}

?>
</div>
                        </div>
                        <div class="panel-footer">
                           <i style="font-size:12px;">Terdapat <b><?php echo $jumlah_materi ?></b> materi yang ditandai</i>
                        </div>
    </div>