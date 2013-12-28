<?php 
$menu = array(); 
$menu['home'] = 'Home'; 
$menu['CourseSearch'] = 'CourseSearch'; 
$menu['NewRegistration'] = 'New Registration';
$menu['CancelRegistration'] = 'Cancel Registration';
$menu['SectionEnrollment'] = 'Registered Students';
$menu['GenerateTranscript'] = 'Generate Transcript';
$menu['Help'] = 'Help';
$title='Home'; //Default title
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="logo.ico">
<?php
function generateMenu()    { 
    global $menu,$default,$title;     
                        		$page = isset($_GET['page']) ? $_GET['page'] : $default; 
                        		$arr = array();
                        		    foreach ($menu as $link=>$item){ 
                        		        $class=''; 
                        		        if ($link==$page) { 
                        		            $class='class="selected"'; 
                        		            $title=$item; 
                        		        } 
                        		        $l = "<a href=\"?page=".$link."\" ".$class.">".$item."</a>";
                        		      array_push($arr,$l);
                        		      
                                   }                       
?> 
<title>Academic Manager - <?php echo $title; ?></title> 
</head> 
<?php
return $arr;
}  ?>

<body style="margin:0px; text-align:center;"> 
<table cellpadding="0px" cellspacing="0px" >
 <tr> <td style="background-image: url(pic/rightmain.jpg);">
    <table border="0px" cellpadding="0px" cellspacing="0px" style="width:1100px">
     <tr> <!-- this row  print system name -->
         <td style="width:20%; background-image:url(pic/topleftimage.bmp); background-repeat:repeat-x; text-align:left; height: 7px;" >
         <td style="width:80%; background-image:url(pic/toprightimage.jpg); color:white; font-family:Times New Roman; font-size:medium; text-align:center; height: 7px;">
             <b style="font-weight: bold;">
             <span style="font-size:20pt; text-align:center; color: white;"> Academic Manager </span></b><br/>
             <b style="color: white"> University Of Texas At Dallas. </b>
         </td> 
     </tr> 
     <tr style="height:100%;">
        <td style="width:20%; background-color:#8b4482; border-color:Black; text-align:left; vertical-align:top;">
        </td>
        <td style="width:80%; text-align:left; vertical-align:top;">
            <table cellpadding="0px" cellspacing="0px" >     
                <tr>  
                    <td width="100%">   
                            <table cellpadding="20%" cellspacing="0px" border="black" >
                    		<tr align="center" valign="middle">      
	                           <?php  $menuList = generateMenu(); 
	                           		foreach ($menuList as $key=>$menuitem){ ?>
										<td width="200px" height="10px">
										  <?php echo $menuitem;?> 
										</td>
							   <?php } ?> 	            
	                        </tr>
                    	    </table>   
	                </td>  
               </tr>
               <tr valign="top" align="center">                                                        
                  <td width="100%" style="height:550px; ">
                  <?php
                    	$default = 'home'; 
                    	$page = isset($_GET['page']) ? $_GET['page'] : $default; 
                    	if (!file_exists($page.'.php'))    { 
                    	    $page = $default; 
                    	}
                    	//echo "Page = $page.php";
                    	include($page.'.php'); //And now it's on child page!
                    ?>
                  </td>
              </tr>
             </table>                                    
         </td>
      </tr>
    </table>
   </td>
 </tr>
</table>
</body> 
</html>
