<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

}

if(empty($_SESSION['login']) OR $_SESSION['login'] == FALSE) #1
{
		$user['uid'] = NULL;
		$user['username'] = 'Guest';
		$user['email'] = NULL;
		$user['displayname'] =	'Guest';
		$user['status'] =	NULL;
		$user['status_INT'] = 99;
		$user['tentang'] =	NULL;
		$user['kuota'] = 'guestmode';

	if(isset($_POST['login'])) 	//cek kondisi login setelah tombol login dipencet #2
		{			
			include $engine->config('koneksi');
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$sql = sprintf("SELECT * FROM tb_pengguna WHERE username = '%s' AND password = '%s'", $username , $password);
			$data = $db->query($sql);
			//jika user ada #3
			if(!empty($data->num_rows))
				{
					$row = $data->fetch_assoc();
					$_SESSION['login']=TRUE;
					$_SESSION['uid'] = $row['uid'];
					$_SESSION['username'] = $row['username'];
					$_SESSION['status'] = $row['status'];
					$_SESSION['displayname'] = $row['displayname'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['tentang'] = $row['tentang'];
					$_SESSION['kuota'] = $row['kuota'];
					$profil = array(
					'uid' => $_SESSION['uid'],
					'username' => $_SESSION['username'],
					);

					include 'head.php';
					header("location:index.php?psn_login=1"); //login berhasil kata sambutan welcome :D
				}#3	

			//jika user tidak ada	
			else #3.1
				{
					header("location:index.php?sub=login&psn_login=2"); //login tidak berhasil :(
				}#3.1

		}//akhir cek kondisi login #2

}//jika session login kossong #1


else //jika session login ada #1.2
	{
		//jika telah login
		$user['uid'] = $_SESSION['uid'];
		$user['username'] = $_SESSION['username'];
		$user['email'] = $_SESSION['email'];
		$user['displayname'] =	$_SESSION['displayname'] ;
		$user['status'] =	$_SESSION['status'] ;
		switch($user['status']){
			case "Admin":
			$user['status_INT'] = 1;
			break;
			case "User":
			$user['status_INT'] = 2;
			break;
			default:
			$user['status_INT'] = 99;
		}

		$user['tentang'] =	$_SESSION['tentang'] ;
		$user['kuota'] = $_SESSION['kuota'];
		$admin['forumdiskusi'] =	$admin['tambahartikel'] = $admin['tambahmateri'] = Null;

}//jika session login ada #1.2







// mulai GET['act']

if(isset($_GET['act'])) 

{

        //mulai GET['act'] = logout

	if($_GET['act'] == 'logout')

	{

		session_start();

		$_SESSION['login'] = Null; //set ke null 

		session_destroy(); // hancurkan session

		header("location:index.php?psn_login=10"); //redirek (kode:10=logout)

	}

} // end if act





//proses lupa password

if(isset($_POST['lupapassword1']))

	{
		include $engine->config('koneksi');
		$sql = sprintf("SELECT * FROM tb_pengguna WHERE username = '%s'", $_POST['username']);
		$data = $db->query($sql);

		if(!empty($data->num_rows))

		{
			$record = $data->fetch_assoc();
			$email = $record['email'];
			
			//periksa jika belum ada lupapassword kosong make buat baru, jika tidak maka dismpan kevariable
			if($record['kode_lupapassword'] == NULL)
			{
				$kodeuntuksql = sprintf('"%s:%s"',$engine->hashacak(16),time());
				$sql = sprintf("UPDATE tb_pengguna SET kode_lupapassword = $kodeuntuksql WHERE username = '$_POST[username]'");
								echo $sql;
				$data = $db->query($sql);
				$kodelupapassword_sekarang = $kodeuntuksql;
			}
			else
			{
				$kodelupapassword_sekarang = $record['kode_lupapassword'];
			}
			
			$kodelupapassword_sekarang_array = explode(":",$kodelupapassword_sekarang);
			//hitung jumlah waktu yang tersisa

			$kodelupapassword_sekarang_waktutempo = 120 - (time()-$kodelupapassword_sekarang_array['1'])/60;

			//jika tempo telah habis maka buat kode dan waktu baru
			if($kodelupapassword_sekarang_waktutempo == 0)

			{
				$kodedanwaktu = $engine->hashacak(16) .':'. time();
				$kodedanwaktu_array = explode(":",$kodedanwaktu);
				$kode = $kodedanwaktu_array['0'];
				$waktu = $kodedanwaktu_array['1'];

				$sql = sprintf('UPDATE tb_pengguna SET kode_lupapassword = "%s" WHERE username = "%s"',$kodedanwaktu, $_POST['username-lupapassword']);
	
				$simpankodelupapassword = $db2->query($sql);
	
				$simpankodelupapassword->rowCount();	

			} //akhir kondisi jika tempo telah habis


			$sql = sprintf('SELECT * FROM tb_pengguna WHERE username = "%s"', $_POST['username']);
			$data = $db2->query($sql);
			
			$record = $data->fetch();
			$kodelupapassword_baru = $record['kode_lupapassword'];
			$kodelupapassword_baru_array = explode(":",$kodelupapassword_sekarang);		
			$kode = $kodelupapassword_baru_array['0'];
			$waktu = $kodelupapassword_baru_array['1'];
			
			
			$to      = $email;
			$subject = 'Pengembalian Password';
			$message = 'hi untuk mengembalikan akun password massukkan kode berikut'. $kode;

			$headers = "From: ENGLISH COURSE <no-reply@learning.chanx.cf>";

			mail($to, $subject, $message, $headers);

			echo '<br>';

			echo 'Pengembalian password dikirim ';

			echo '<br>';

			echo sprintf('Harap segera periksa email anda segera, karena kode yang diperlukan untuk mengganti password hanya dapat berlaku kurang dari %d Menit',$kodelupapassword_sekarang_waktutempo);			
		}

		else

		{
			header("location:?sub=login&psn_login=11"); //redirek (kode:11=username tidak ditemukan)

		}

	}





//proses lupa password

if(isset($_POST['lupapassword_konfirmasi']))

	{

		include 'koneksi.php';

		$sql = sprintf("SELECT * FROM tb_pengguna WHERE username = '%s' AND kode_lupapassword LIKE '%s'", $_POST['username-lupapassword'], $_POST['kode-lupapassword'].'%' );

		$data = $db2->query($sql);

		$record = $data->fetch();

		if($data->rowCount() == 1)

		{

			$kodelupapassword_sekarang = $record['kode_lupapassword'];
			$kodelupapassword_sekarang_array = explode(":",$kodelupapassword_sekarang);			
			//hitung jumlah waktu yang tersisa
			$kodelupapassword_sekarang_waktutempo = 120 - (time()-$kodelupapassword_sekarang_array['1'])/60;
			
			if($kodelupapassword_sekarang_waktutempo == 0)

			{

				echo 'gagal, dikarenakan link sudah kadaluarsa';

			}

			else

			{



			$to      = $record['email'];
			$subject = 'Pengembalian Password, ENGLISH COURSE';
			$message = 'Hi, Password baru kamu adalah :'. 	$engine->hashacak(16);
			$headers = "From: FirstName LastName <no-reply@ENGLISHCOURSE.com>";

			mail($to, $subject, $message, $headers);

			echo '<br>';

			echo 'Pengembalian password dikirim ';

			echo '<br>';

			echo 'Terima kasih, kode anda benar, password sudah direset dan telah dikirim ke email anda ' . $record['email'];			

				

			}

		}

		

	}

	

?>