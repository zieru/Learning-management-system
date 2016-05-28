<?php
$wew = 'wew';
$sidebar = TRUE;
$subdir = 'learning';
$url = array (
    "all" => "http://" . $_SERVER['HTTP_HOST'] . '/' . $subdir . $_SERVER['REQUEST_URI'], 
    "base" => "http://" . $_SERVER['HTTP_HOST'], 
    "url" => "http://" . $_SERVER['HTTP_HOST'] . '/' . $subdir,
    "sub" => "/". $subdir."/?",
    "request" => $_SERVER['REQUEST_URI']
);

$lokasi_folder = dirname(dirname(__FILE__)); //lokasi up dua folder ../config/
if(strtoupper(PHP_OS) == 'LINUX')
{
	$lokasi_upload = "/www/learning_uploads";
}
else
{
	$lokasi_upload = "D:\Data\WTServer\WWW\learning_uploads";	
}

$url_upload = $url['base']. "/learning_uploads/";
$mod_rewrite = TRUE;

$tipefile_yangdiperbolehkan = array("application/pdf","video/mp4","application/vnd.openxmlformats-officedocument.wordprocessingml.document");
$tipefile_yangdiperbolehkan_tag = array("o_pdf","o_video","o_word");

$situs = array(
'judul' => 'English First'
);


$situs['terms'] = '
PERATURAN UMUM BESERTA SYARAT DAN KETENTUAN (TERMS OF SERVICES) '.$situs['judul'].'
-------------------------------------------------------------------------------------------------------------

UMUM
---------
	Selamat datang di situs www.kaskus.co.id dan situs turunannya (“KASKUS”) milik PT Darta Media Indonesia ("DMI"). KASKUS sebagai situs komunitas online terbesar di Indonesia adalah situs yang berprinsip kebebasan menyatakan pendapat yang bertanggungjawab.
	Sebelum melakukan akses dan menggunakan KASKUS, kami menyarankan agar Anda membaca Peraturan Umum beserta Syarat dan Ketentuan terlebih dahulu. Dengan mengakses dan menggunakan KASKUS, Anda setuju untuk terikat dengan Peraturan Umum beserta Syarat dan Ketentuan ini. Jika Anda tidak menyetujui Peraturan Umum beserta Syarat dan Ketentuan yang ditetapkan di bawah ini, mohon tidak mengakses dan menggunakan KASKUS.
	Peraturan Umum beserta Syarat dan Ketentuan ini dapat kami ubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu. Keputusan yang diambil berdasarkan peraturan ini bersifat mutlak dan tidak dapat diganggu gugat.
';

$akun = array(
'minpassword' => 6, 
'maxpassword' => 32
);

class engine{
	public function uri ($parameter = null)
	{
		global $subdir;
		$url = array (
		    "url" => "http://" . $_SERVER['HTTP_HOST'] . '/' . $subdir,
		    "sub" => "/". $subdir."/?",
		    "request" => $_SERVER['REQUEST_URI']
			);

		$uri = $url[$parameter];

		return $uri;
	}


	public function hashacak($jumlah = null,$hurufbesar = null)
	{		
		if(empty($jumlah)){$jumlah=4;}
		
		if(empty($hurufbesar))
		{$huruf = '2346789ABCDEFGHJKLMNPRTUVWXYZ';}
		else{$huruf = '12346789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';}
		$hashacak = NULL;
			for ($i = 0; $i < $jumlah; $i++) {
				$hashacak .= $huruf[rand(0, strlen($huruf) - 1)];
			}	
		return $hashacak;	
	}
	public function config($name){
		global $lokasi_folder;
		$function = sprintf('%s/config/%s.php',$lokasi_folder,$name);
		return $function;
	}
	public function func($name){
		global $lokasi_folder;
		$function = sprintf('%s/functions/%s.php',$lokasi_folder,$name);
		
		return $function;
	}
	
	public function view($name){
		global $lokasi_folder;
		$function = sprintf('%s/views/%s.php',$lokasi_folder,$name);
		return $function;
	}
}

class cx_error{
	public function code($code,$desc=null){
		$e = '<style>
#page-wrapper {border-right:none; width:100%;};
</style>';
		$GLOBALS['sidebar'] = FALSE;
                $msg = null;
                $page_not_found = 'Page not found';
                if(empty($desc))
                {
                    $desc = 'Halaman yang anda minta tidak ditemukan';
                }
		switch ($code)
		{
                    case 'nodata':
                    $e .= '110';
                    $msg .= 'Record not found';    
                    break;
                
                    case 'emptyrecord':
                    $e .= '120';
                    $msg .= 'Record empty   ';    
                    break;                
                
                    case 'user_not_found':
                    $e .= 'Pengguna tidak terdaftar';
                    break;							
                
                    case 'e404':
                    Header("HTTP/1.0 404 Not Found");
                    $e .= '404';
                    $msg = $page_not_found;
                    break;
                
                    case '404':
                    header("HTTP/1.0 404 Not Found");
                    $e .= '404';
                    $msg = $page_not_found;
                    break;
                
                    default:
                    $e = NUll;
		}
		
		$error = sprintf('
                    
						<div class="" style="text-align:center; ">	
                                                <h1 style="font-size:84px;;">
                                                %s 
                                                </h1>
                                                
                                                <h1 style="margin-top:-15px;">
                                                Error %s 
                                                </h1>
                                                
                                                <hr>
                                                <h5 class="text-muted">
                                                %s
                                                </h5>
                                                
                                                
                                                <h5 class="text-muted small" style="margin-top:-5px;"><i>sebuah catatan kesalahan telah dilaporkan kepada administrator</i  ></h5>
                                                </div>',$e,$msg,$desc);

		return $error;
	}
	
}

class go{

	public function to($sub = null,$act = null,$hash = null){
	global $mod_rewrite,$url;
	
		if($mod_rewrite == FALSE){
			if(!empty($sub) AND !empty($act) AND !empty($hash))
			{
				$to = sprintf('index.php?sub=%s&act=%s&hash=%s',$sub,$act,$hash);
			}
			elseif(!empty($sub) AND !empty($act))
			{
				$to = sprintf('index.php?sub=%s&act=%s',$sub,$act);
			}
			elseif(!empty($sub))
			{
				$to = sprintf('index.php?sub=%s',$sub);
			}
			else
			{
				$to = Null;
			}
		}
		else {
			
			if(!empty($sub) AND !empty($act) AND !empty($hash))
			{
				$to = sprintf('%s/%s/%s/%s',$url['url'],$sub,$act,$hash);
			}
			elseif(!empty($sub) AND !empty($act))
			{
				$to = sprintf('%s/%s/%s',$url['url'],$sub,$act);
			}
			elseif(!empty($sub))
			{
				$to = sprintf('%s/%s',$url['url'],$sub);
			}
			else
			{
				$to = Null;
			}
		}
		
		return $to;
	}
	
}

class input{
	public function text($name,$id,$class = Null,$style = null,$lain = null){
		$input = sprintf('<input type="text" name="%s" id="%s" class="%s" style="%s" %s>',$name,$id,$class,$style,$lain);
        return $input;
    } 
	public function text2($properti = null){
		$properti_name = array('name','id','class','style','lainnya','form-group','label','pesan','label-samping','type','value');
		$i =0;
		while($i < sizeof($properti_name))
		{
			if(empty($properti[$properti_name[$i]]))
			{
				$properti[$properti_name[$i]] = NULL;
			}
			$i ++;
		}
		
						
		if($properti['type'] == NULL)
		{
			$properti['type'] = 'text';
		}
						
		$input = sprintf('<input type="%s" name="%s" id="%s" class="%s" style="%s" %s value="%s" >',
		$properti['type'],	
		$properti['name'],
		$properti['id'],
		$properti['class'],
		$properti['style'],
		$properti['lainnya'],
		$properti['value']
		);

		if($properti['form-group'] == TRUE)
		{
			$properti['form-group'] = 'form-group ';
			$datalabel = NULL;
			if(!$properti['label'] == NULL OR !$properti['label-samping'] == NULL )
			{
				if(!$properti['label-samping'] == NULL)
				{
					$properti['form-group'] .= 'input-group';
					$datalabel = '<span class="input-group-addon">'.$properti['label-samping'].'</span>';
				}					
			}


			$input = sprintf('<div class="%s">
											<p class="help-block">%s</p>
                                            %s
                                            %s
                                            
                                        </div>',
                                        $properti['form-group'],
                                        $properti['pesan'],
                                        $datalabel,
                                        $input);

		}

        return $input;
    } 
	
	public function email($name,$id,$class = Null){
		$input = sprintf('<input type="email" name="%s" id="%s" class="%s">',$name,$id,$class);
        return $input;
    } 
	public function password($name,$id,$class = Null){
		$input = sprintf('<input type="password" name="%s" id="%s" class="%s">',$name,$id,$class);
        return $input;
    } 
	public function label($for,$value,$class = Null){
		$input = sprintf('<label for="%s" class="%s">%s</label>',$for,$class,$value);
		return $input;
	}
	

	public function option2($properti)
	{
		$properti_name = array('name','id','option','value','selected','style','lainnya','form-group','label','pesan','label-samping');
		$i =0;
		while($i < sizeof($properti_name))
		{
			if(empty($properti[$properti_name[$i]]))
			{
				$properti[$properti_name[$i]] = NULL;
			}
			$i ++;
		}
		
		$selectedhtml = "";
		$input = sprintf('<select class="input-field" name="%s" style="%s">\n',$properti['name'],$properti['class']);
		foreach ($properti['option'] as $key => $val) {
			if($key == $properti['selected']) {$selectedhtml = "selected";}else{$selectedhtml= null;}
    			$input .= "<option value='$key' $selectedhtml>$val</option>\n";
		}
		$input .= "</select>\n";
		
		
		return $input;
	}


	public function option($name,$option,$selected = null, $class = null)
	{
		$selectedhtml = "";
		$input = sprintf('<select class="input-field" name="%s" style="%s">\n',$name,$class);
		foreach ($option as $key => $val) {
			if($key == $selected) {$selectedhtml = "selected";}else{$selectedhtml= null;}
    			$input .= "<option value='$key' $selectedhtml>$val</option>\n";
		}
		$input .= "</select>\n";
		
		
		return $input;
	}
	
	public function button($label,$href,$label_class=null,$style=null,$hanyalink=FALSE,$icon_tombol=NULL)
	{
		if($hanyalink== false)
		{
			$tombol_class = "btn btn-default";
		}
		else
		{
			$tombol_class="";
		}

		if(empty($icon_tombol))
		{
			$icon_tombol = "fa fa-pencil-square-o";
		}

		$input =sprintf('<a class="%s"  style="%s" href="%s"><i class="%s"></i>%s</a>',
		$tombol_class,	
		$style,
		$href,
		$icon_tombol,
		$label);
		return $input;
	}
	
	public function link($link)
	{
		if(empty($link['style'])){$link['style'] = null;}
		$input = sprintf('<a href="%s" %s><i class="fa fa-pencil-square-o"></i> %s</a> ',
		$link['href'],
		$link['style'],
		$link['label']
		);
		return $input;
	}
}


$engine = new engine();
$cx_error = new cx_error();
$go = new go();
$input= new input();


include $engine->func('Parsedown');
$Parsedown = new Parsedown();
function random_gravatar( $size = 100, $email = "" ){
    	$random_image = array('mm'); 
	return "http://www.gravatar.com/avatar/". md5(strtolower(trim($email))) ."?r=g&s=" . $size . "&d=" . $random_image[array_rand($random_image)];}

