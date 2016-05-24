<?php
if($_GET['act'])
{
	echo $_GET['act'];
	switch ($_GET['act'])
	{
		case 'lihat':
		include $engine->view('user/profil/lihat');
		break;
		case 'edit':
		include $engine->view('user/profil/edit');
		break;
	}
	
}
?>