<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Zieru Chan" >
    <title><?php echo $situs['judul']; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/bootstrap-themes.css" type="text/css" rel="stylesheet">        
    <link href="<?php echo $url['url']?>/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo $url['url']?>/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Social Buttons CSS -->
    <link href="<?php echo $url['url']?>/bower_components/bootstrap-social/bootstrap-social.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo $url['url']?>/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $url['url']?>/dist/css/sb-admin-2.css" rel="stylesheet">
<!-- Custom CSS -->
    <link href="<?php echo $url['url']?>/dist/css/chanx.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="<?php echo $url['url']?>/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo $url['url']?>/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
 <script src="<?php echo $url['url']?>/js/jquery-2.1.4.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    
</head>
    
<body>
<div id="peringatan-layar-kecil">
<p>MAAF BROWSER / PERAMBAN YANG ANDA GUNAKAN TIDAK DIDUKUNG DIKARENAKAN MEMILIKI RESOLUSI LAYAR YANG KECIL, SEHINGGA BEBERAPA FUNGSI SITUS TIDAK DAPAT BERJALAN DENGAN BAIK</p>
</div>
<?php include 'menu.php' ?>
<?php if(!isset($_GET['sub'])){
		$fix_layout = 'padding-left:10px;';
//		$fix_layout = null;
	}
	else
	{
		$fix_layout =null;
		}
?>


<div id="wrapper">
    <script>
    $(document).ready(function() {
        var tinggi_layar = $(window).height();
        var tinggi_header = $("#nav_f").height();
        var tinggi_footer = $("#contact").height();
        $(".laman").css("min-height", tinggi_layar - (tinggi_header + tinggi_footer));

    });  
    </script>


    
    <div id="page-wrapper" class="col-xs-12 col-sm-12 col-md-9" style="margin-top:57px;">