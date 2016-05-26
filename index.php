<?php
ob_start();
session_start();
define('CHANX',TRUE);
require_once 'config/config.php';
$tombol_kembali = NULL;
if(isset($_SESSION['last_url']) AND !empty($_SESSION['last_url']) AND $url['request'] != "/learning/index.php?")
{
  $tombol_kembali=  sprintf('<a href="%s"><i title="Kembali" class="fa fa-2x fa-arrow-left"></i></a>',$_SESSION['last_url']);
	
}

include 'functions/login.php';
include 'functions/perizinan.php';
include 'functions/template.php';
include 'views/common/head.php';
include $engine->view('common/menu-tool');

function shutdown()
{
    // This is our shutdown function, in 
    // here we can do any last operations
    // before the script is complete.
    global $engine; // deklarasi dua kali karena berada didalam function yang berbedda
    global $go;
    global $template;

if(isset($_GET['bersihkan_log']))
	{
		if(file_exists(ini_get('error_log')))
		{
		     //hapus log error
		    if (!unlink(ini_get('error_log')))
		    {
		      // ("log sdh cleaar");
		    }
		}
	}
}

register_shutdown_function('shutdown');


if(!isset($_GET['sub']))
{	
	include 'views/common/depan.php';
}
else
{
	switch($_GET['sub'])
	{
		case NULL:
		include 'views/common/depan.php';
		break;
		case 'test':
		include $engine->view('common/test');
		break;
		case 'proses':
		include $engine->view('common/proses');
		break;
		case 'login':
		include $engine->view('user/login');
		break;
		case 'register':
		include $engine->view('user/register');
		break;
		case 'pencarian':
		include $engine->view('pencarian/cari');
		break;		
		case 'diskusi':
		include $engine->view('diskusi/index');
		break;		
		case 'materi':
		include $engine->view('materi/index');
		break;
		case 'forum':
		include $engine->view('forum/index');
		break;		
		case 'profil':
		include $engine->view('user/profil/index');
		break;		
		default:
				echo $cx_error->code('404');		
	}
}


include  'views/common/footer.php';   
$_SESSION['last_url'] = $url['request'];	
?>
