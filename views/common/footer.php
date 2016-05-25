</div> <!-- page wrapper-->


<?php include 'sidebar.php'; ?>
    
    <script>
	var lastScrollTop = 0;
$(window).scroll(function(event){
   var st = $(this).scrollTop();
   var turunkebawah = 0;
   
   	    $("#cd_posisi").text(lastScrollTop);
   if (st > lastScrollTop){
       // downscroll code
		turunkebawah = lastScrollTop;
 		$("#cd_turun").text(turunkebawah);
				$("nav#nav_f").css("position", "relative");	  
                $("div.laman").css("margin-top", "0px");                           
		if(turunkebawah > 50)
		{
			$("nav#nav_f").css("display", "none");	   	 	
		}
				
   } else {
      // upscroll code
  	   $("nav#nav_f").css("display", "block");	   
	   $("nav#nav_f").css("position", "fixed");	
       $("div.laman").css("margin-top", "20px");           
   }
   lastScrollTop = st;
});
	</script>



<?php 
    if(isset($debug))
    {

        $debug_pesan = sprintf('<pre>%s</pre>',$debug);   
    }
    else
    {
        $debug_pesan = null;
    }

    
    
    if(file_exists(ini_get('error_log')))
    {
        //$debug_file = file_get_contents(ini_get('error_log'));
    }
    else
    {
        $debug_file = NULL;    
    }
    //$debug_pesan .= $debug_file;

   

/*
    echo '
    <div id="chanxdebug" style="padding:5px; box-shadow: 0 5px 12px rgba(0,0,0,.175);background-image:url(img/menu_tembuspandang.png); width:400px; height:150px; overflow:scroll; position:fixed; right:0px; bottom:10px; z-index:3;">
        CHANX Debug <a style="font-size: x-small; float:right;" href="'.$engine->uri('request').'&bersihkan_log=1"> Clear LOG</a>
        <hr style="margin:2px 0;">
        '.$debug_pesan.'
        <br>    
        Posisi = <p id="cd_posisi"></p>
        turun = <p id="cd_turun"></p>
    </div>', PHP_EOL;       
*/
?>  

</div> <!-- WRAPPER-->




    

</body>
</html>
  <!-- Page-Level Demo Scripts - Notifications - Use for reference -->
    <script>

    $('.judul_materi_panel').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    </script>