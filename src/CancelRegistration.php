<center>
<form method=get name=unRegister_Course action="<?php echo $_SERVER['PHP_SELF'];?>">
		<br> <?php   echo "<b>    Registration Cancellation Form  </b>"  ?>
		<br>
		<?php
		$clsNumber = isset($_GET['clsNumber']) ? $_GET['clsNumber'] : "";
		$stdNumber = isset($_GET['stdNumber']) ? $_GET['stdNumber'] : "";
		?>
		<br> 
			<table align="center">
			    <tr><td> <input type="hidden" name="page"  value="CancelRegistration" /></td></tr>
			    <tr><td align="left">Class Number </td><td> <input type="text" name="clsNumber" value="<?php echo "$clsNumber";?>"> </td></tr>
				<tr><td align="left">Student Number </td><td> <input type="text" name="stdNumber" value="<?php echo "$stdNumber";?>"> </td></tr>
			</table>
			<table align="center">
            	<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            	    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="20px"><input type=submit  value=" Submit "></td>
                    <td> &nbsp;&nbsp;&nbsp;</td>
                    <td width="20px"><input type=reset value= " Reset " onclick="clear()"></td>
                </tr>		
             </table>	
	</form>
</center>
<?php 
if(!empty($clsNumber) && !empty($stdNumber))
{

	$SectionId = $clsNumber;
	$query = " from grade_report where SectionId = ".$clsNumber." AND Sno = ".$stdNumber;
	
	$SelectResult = executeQuery("Select * ".$query);
	
	echo "<br> <br>";
	if(!is_resource($SelectResult))
		echo "<b><font color=\"RED\">No Such Class Registration Exists, Please Check Input Data !!</b></font>";
	elseif ($record = mysql_fetch_assoc($SelectResult)){
			if($record['Grade'] != null)
				echo "<b><font color=\"RED\">  Cancellation Not Allowed !! <br/>Students Grade Already Exists For This Class</b></font>";
			elseif(mysql_num_rows($SelectResult) == 1){
				$DeletResult = executeQuery("Delete".$query);
				echo " Student ".$stdNumber." Successfully Dropped From Class ".$clsNumber." !!";
				}
			}
	else
		echo "<b><font color=\"RED\">Course Cancellation Failed !!</b></font>";
}


function executeQuery($query){
	$username="root";
	$password="";
	$database="university";
	$db_handle = mysql_connect("127.0.0.1",$username,$password);
	$db_found = mysql_select_db($database) or die( "Unable to select database");
	$Queryresult = mysql_query($query);
	//echo "Query = $query <hr>";
	mysql_close($db_handle);
	return $Queryresult;
}
?>
</center>