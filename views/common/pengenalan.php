<div class="row">
<?php

if(!isset($_SESSION['login']))

{

?>

<div class="alert alert-info alert-dismissable" style="background:#fff;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                
                    
                        <h3>Halo, Selamat datang di <?php echo $situs['judul']; ?> </h3>
                        <div class="panel-body">
                            <p>Di English Course kami membantu orang-orang untuk dapat berbagi pengetahuan mengenai sastra dan bahasa inggris melalui :
                            <ul>
                            <li><b>Guru</b> dapat membuat materi, memberikan kuis dan mengelola kelas</li>
                            <li><b>Murid</b> dapat melihat materi-materi yang telah disajikan dan menyelesaikan kuis latihan </li>
                            </ul>

                            Untuk informasi lebih lanjut kamu dapat mengklik tombol <b>Pelajari lebih lanjut</b> dibawah ini
                            </p>

                        </div>
                        <a class="btn btn-outline btn-info" href="#">Pelajari lebih lanjut</a>

                            </div>

<?php

}

?>
</div>