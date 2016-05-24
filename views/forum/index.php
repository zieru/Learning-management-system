<?php 

if(isset($_GET['act']))

{

	switch($_GET['act'])

	{

		case 'list':

		include 'list.php'; break;

		case 'lihat':

		include 'forum.php'; break;

		case 'baru' OR 'edit':	

		include 'manipulasi.php'; break;

	}	

}

else{

				echo $cx_error->code('404');

	}

?>
