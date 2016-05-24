<?php

	if(!isset($_GET['act']))
	{
		$_GET['act'] = NULL;
	}

	switch($_GET['act'])
	{
		case 'lihat':
		include $engine->view('materi/lihat');
		break;

		case 'list':
		include $engine->view('materi/list');
		break;		
		case 'favorit':
		include $engine->view('materi/favorit');
		break;		

		//jika manipulasi materi
		case 'baru':
		case 'ubah':
		include $engine->view('materi/manipulasi');
		break;

		//jika manipulasi kategori materi
		case 'kategori': 
		include $engine->view('materi/kategori/list');
		break;		

		case 'kategori-list': 
		include $engine->view('materi/kategori');
		break;		

		case 'kategori-baru':
		case 'kategori-edit':
		include $engine->view('materi/manipulasi_kategori');
		break;

		case 'kategori-lihat': 
		include $engine->view('materi/kategori/lihat');
		break;		
		default:
		echo $cx_error->code('404');
	}