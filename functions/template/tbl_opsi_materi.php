<div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                        Pilihan
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
<div class=" dropdown-header header-nav-current-user css-truncate">
                    <b>Materi </b>
                    </div>                 
                                              <?php
                                              $tampilkan_tbl_download = FALSE;
                                              if(!empty($fileextensi))
                                              {
                                                if($fileextensi == 'application/pdf' AND $user['status_INT'] < 2)
                                                {
                                                  $tampilkan_tbl_download = TRUE;
                                                }
                                              }
                                              
                                              if($tampilkan_tbl_download == TRUE)
                                              {
                                              ?>          
                                                       <li><a data-toggle="modal" data-target="#md-donlot" href=""><i class="glyphicon glyphicon-download-alt"></i> Unduh (<?php echo $ukuran;?>)</a></li>
                                            <?php
                                              }
                                              else
                                              {
                                                      echo '<li><a class="list-group-item disabled" href="#"><i class="glyphicon glyphicon-download-alt "></i> Tdk dapat diunduh</a></li>';
                                              }
                                            ?>


                                        <?php
                                            echo $tag['menu_favorit'];
                                            echo $tag['menu_peringatan'];
                                        ?>

                                        <!-- Menu Admin -->
                                        <?php
                                      echo $template->tombol($tombolproperti = array(
                                          'label' => 'Edit',
                                          'aksi' => 'ubahmateri',
                                          'hash' => $materi['hash'],
                                          'tipe' => 'menulist',
                                          'custom_awal' => '<li class="divider"></li><div class=" dropdown-header header-nav-current-user css-truncate">
                    <b> Administrasi </b>Materi
                    </div>',
                                          'custom_akhir' => ''
                                      ));
                                      ?>
                                    </ul>
                                </div>
                            </div>