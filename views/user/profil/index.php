<?php
switch($_GET['act'])
{
	case 'lihat':
	include $engine->view('user/profil/lihat');break;
	case 'list':
	include $engine->view('user/profil/list');break;
	case 'ubah':
	include $engine->view('user/profil/edit');break;
	
}
?>
