<?php
if($_SERVER['SERVER_NAME'] == "localhost")
{
	$db = new mysqli("127.0.0.1", "root", "", "learning");	
	$db2 = new PDO('mysql:host=127.0.0.1;port=3306;dbname=learning;charset=UTF8;','root',''); //pindah ke pdo	
}
else
{
	//$db2 = new PDO('mysql:host=127.0.0.1;port=3306;dbname=chanx_learning;charset=UTF8;','root','zierong7'); //pindah ke pdo
	//$db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set Errorhandling to Exception
	$db = new mysqli("127.0.0.1", "chanx_learning", "zierong7", "chanx_learning");
	//$db2 = new KoneksiPDO('mysql:host=127.0.0.1;port=3306;dbname=learning;charset=UTF8;','root','');
	$db2 = new PDO('mysql:host=127.0.0.1;port=3306;dbname=chanx_learning;charset=UTF8;','chanx_learning','zierong7'); //pindah ke pdo
} //end of if (serversite)



$db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
{
    
          if(!$db)
		  {
           echo $db->errorInfo();
           } 
		   else {
            $dbstate = array(
            "status" => "1",
            "kode" => $db2->errorCode(),
            "pesan" => " koneksi ke database berhasil "
            );
 }
 
 
 $sql = 'SELECT * FROM tb_materi';
 $data = $db2->query($sql);
}
?>
