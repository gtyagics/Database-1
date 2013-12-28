<center>
<form method=get name=Register_Course action="<?php echo $_SERVER['PHP_SELF'];?>">
		<br> <?php   echo "<b>    New Registration Form   </b>"  ?>
		<br>
		<?php
		$clsNumber = isset($_GET['clsNumber']) ? $_GET['clsNumber'] : "";
		$stdNumber = isset($_GET['stdNumber']) ? $_GET['stdNumber'] : "";
		?>
		<br> 
			<table align="center">
			    <tr><td> <input type="hidden" name="page"  value="NewRegistration" /></td></tr>
				<tr><td align="left">Class Number </td><td> <input type="text" name="clsNumber" value="<?php echo "$clsNumber";?>"> </td></tr>
				<tr><td align="left">Student Number </td><td> <input type="text" name="stdNumber" value="<?php echo "$stdNumber";?>"> </td></tr>
			</table>
			<table align="center">
            	<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            	    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="20px"><input type=submit  value="Register"></td>
                    <td> &nbsp;&nbsp;</td>
                    <td width="20px"><input type=reset value= " Reset " onclick="clear()"></td>
                </tr>		
             </table>	
	</form>
</center>
<?php 
if(!empty($clsNumber) && !empty($stdNumber))
{
	$SectionId = $clsNumber;
	$query = "Insert into grade_report(SectionId,Sno) VALUES (".$clsNumber.",".$stdNumber.")";
		//echo "Query = $query <hr>";
	$result = executeQuery($query);

	echo "<br> <br> ";
	if($result==0)
		echo "<b><font color=\"RED\">Registration Failed !!</b></font>";
	else
		echo " Registeration Successfull  !! <br/> Student ".$stdNumber." successfully registered for class ".$clsNumber;		
}
//else 
	//echo "Please enter Valid Student No and Class No !";

function executeQuery($query){
	$username="root";
	$password="";
	$database="university";
	$db_handle = mysql_connect("127.0.0.1",$username,$password);
	$db_found = mysql_select_db($database) or die( "Unable to select database");
	$Queryresult = mysql_query($query);
	mysql_close($db_handle);
	return $Queryresult;
}
?>
</center>