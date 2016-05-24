<div class="container">
<div class="row">
<?php
if($_GET['act'])
{
	switch($_GET['act'])
	{
		case 'balas';
		include $engine->view('diskusi/balas');
	}
}
?>
</div>
</div>