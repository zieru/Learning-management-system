<?php

		if($user['status'] == 'Admin') #4

		{
			$izin['tambahmateri'] = 1;
			$izin['ubahmateri'] = 1;	
			$izin['hapusmateri'] = 1;				
			$izin['kategorimateri'] = 1;

			$izin['tambahartikel'] = 1;

			$izin['tambahforumdiskusi'] = 1;
			$izin['ubahforumdiskusi'] = 1;			

			

			//akun profil

			$izin['ubahakun'] = 1;

			

			//kirim komentar

			$izin['kirimkomentarmateri'] = 1;

			$izin['kirimkomentardiskusi'] = 1;			

		}// #4

		elseif($user['status'] == 'User') #4.1

		{

			$izin['tambahmateri'] = 0;
			$izin['ubahmateri'] = 0;	
			$izin['hapusmateri'] = 0;				
			$izin['tambahartikel'] = 0;
			$izin['kategorimateri'] = 0;

			$izin['tambahforumdiskusi'] = 1;			

			$izin['ubahforumdiskusi'] = 0;

			

			

			//akun profil

			$izin['ubahakun'] = 1;

			

			//kirim komentar

			$izin['kirimkomentarmateri'] = 1;

			$izin['kirimkomentardiskusi'] = 1;			

		}// #4

		else

		{

			$izin['tambahmateri'] = 0;
			$izin['ubahmateri'] = 0;	
			$izin['hapusmateri'] = 0;							
			$izin['kategorimateri'] = 0;

			$izin['tambahartikel'] = 0;

			$izin['tambahforumdiskusi'] = 0;

			$izin['ubahforumdiskusi'] = 0;



			//akun profil

			$izin['ubahakun'] = 0;			

			

			//kirim komentar

			$izin['kirimkomentarmateri'] = 0;

			$izin['kirimkomentardiskusi'] = 0;						

		}

		

		



?>