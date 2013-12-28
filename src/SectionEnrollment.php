<center>
<form method=get name=sectionEnrollment action="<?php echo $_SERVER['PHP_SELF'];?>">
		<br> <?php   echo "<b>  View List of Enrolled Students </b>"  ?>
		<br>
		<?php
		$clsNumber = isset($_GET['clsNumber']) ? $_GET['clsNumber'] : "";
		?>
		<br> 
			<table align="center">
			    <tr><td> <input type="hidden" name="page"  value="SectionEnrollment" /></td></tr>
				<tr><td>Class Number </td><td> <input type="text" name="clsNumber" value="<?php echo "$clsNumber";?>"> </td></tr>
			</table>
			<table align="center">
            	<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            	    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="20px"><input type=submit  value=" Search "></td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="20px"><input type=reset value= " Reset " onclick="clear()"></td>
                </tr>		
             </table>	
	</form>
</center>
<?php 
if(!empty($clsNumber))
{

	$SectionId = $clsNumber;
	$query = "Select S.Sno,Fname,Lname,Class,NetID,mail,Phone,Sex,Bdate,Street,City,State,Zip,Dno ";
	$query .= "from Student S,Grade_Report G  where S.Sno = G.Sno and G.SectionId =".$SectionId;
	$query .= " order by Fname,Lname";

	//echo "Query = $query <hr>";
	$result = executeQuery($query);

	echo "<br> <br> Search Results ";
	if(mysql_num_rows($result) > 0){
		echo "Total <b><font color=\"black\">".mysql_num_rows($result)."</b></font> Students Registered For This Class <br><br>";
		showSectionEnrollmentTable($result);
	}
	else
		echo "- No Student Registered For This Class !!";
}


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

function showSectionEnrollmentTable($resultSet){
	$i = 1;
	?>
	<table align="center" border="1">
	<tr><th>SrNo</th><th>StudentNo</th><th>Name</th><th>Class</th><th>NetID</th><th>email</th>
	<th>Phone</th><th>Sex</th><th>Bdate</th><th>Dno</th></tr>

		<?php  while ($record = mysql_fetch_assoc($resultSet)) { ?>
			<tr><td><?php  echo $i++ ?></td>
				<td><?php  echo $record['Sno'];?></td>
				<td><?php  echo $record['Fname']." ".$record['Lname'];?></td>
				<td><?php  echo $record['Class'];?></td>
				<td><?php  echo $record['NetID'];?></td>
				<td><?php  echo $record['mail'];?></td>
				<td><?php  echo $record['Phone'];?></td>
				<td><?php  echo $record['Sex'];?></td>
				<td><?php  echo $record['Bdate'];?></td>
				<td><?php  echo $record['Dno'];?></td>
			</tr>
		<?php } ?>
		</table>
<?php 
}
?>
</center>