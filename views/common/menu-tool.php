<?php





class menu{
	public function toolbar($properti){
		global $template,$tombol;
		switch ($properti) {
							case 'materi':
							$menu_tools = $template->tombol($tombolproperti = array(
															'custom_awal' => '
															<div class="btn-group">
															  <button type="button" style="margin-top:-10px;" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="TRUE" >
															   <span class="caret"></span> <i class="fa fa-gear"></i> 
															  </button>
															<ul class="dropdown-menu"> <li class="dropdown-header">MENU ADMINISTRATOR</li>  <li role="separator" class="divider"></li>',	
															'label' => 'Buat materi baru',
															'aksi' => 'tambahmateri',
															'style' => '',
															'tipe' => 'menulist')) . 
															$template->tombol($tombolproperti = array(
															'label' => 'Kelola kategori materi',
															'aksi' => 'kategorimateri',
															'style' => '',
															'tipe' => 'menulist',
															'custom-akhir'=> '
															</ul>
															</div>'));
							break;
						
							default:
							# code...
							break;

							}
	
		return $menu_tools;
	}
}




$menu = new menu();