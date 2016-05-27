<?php 
if(isset($_GET['act']))
{
            switch($_GET['act'])
            {
            case 'list':
            include 'list.php'; 
            break;
        
            case 'lihat':
            include 'forum.php'; 
            break;
        
            case 'baru':
            case 'edit':	
            include 'manipulasi.php'; break;
            
            default :
            echo $cx_error->code('404');
            }	
}
else{
    echo $cx_error->code('404');
}

?>
