<center>
	<form method=get name=transcript_form action="<?php echo $_SERVER['PHP_SELF'];?>">  
		<br> <?php   echo "<b>   Generate Transcript Page </b>"  ?>
		<br>
		<?php
		$sNo = isset($_GET['sNo']) ? trim($_GET['sNo']) : "";
		?>
		<br> 
			<table>
			    <tr><td> <input type="hidden" name="page"  value="GenerateTranscript" /></td></tr> 
				<tr><td align="left">Student Number </td><td> <input type="text" name="sNo" value="<?php echo "$sNo";?>"> </td></tr>
			</table>
			<table align="center">
            	<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            	    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="20px"><input type=submit  value=" Submit "></td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="20px"><input type=reset value= " Reset " onclick="clear()"></td>
                </tr>		
             </table>	
	</form>
</center>
<?php 

if(!empty($sNo) ){
	$query  = " select Fname,Minit,Lname from student where Sno = ".$sNo;
	$result = executeQuery($query);
	if(mysql_num_rows($result) == 1){
		echo "<hr>  <br /> <b> * UN-OFFICIAL TRANSCRIPT COPY * </b>";
		$name = mysql_fetch_assoc($result);
		echo "  <br /> <br /> Student Name : <b> ".$name['Fname']." ".$name['Minit']." ".$name['Lname']." </b>    .";
		echo "   Student Number : <b>".$sNo." </b>     .  Date :  ".date("M-d-Y");
		showTranscript($sNo);
		echo "  <br /> <br />   All The Best !!";
	}
	else
		echo " <br /> <br /> <b> <font color=\"RED\"> No Student Record Fount !! <br/> Please Enter Valid Student Number </b></font>";	
}

function showTranscript($sNo){

		//$query  = " select G.SectionId, G.Grade, C.Cname, C.Credits, S.Semester, S.Year  from grade_report G,section S,course C ";
		//$query .=  " where G.SectionId = S.SectionId AND S.Cno = C.Cno AND G.Grade IS NOT NULL And Sno = ".$sNo;
		$query = "select SectionId, Cname, Credits, Grade,Semester,Year from Transcript where Sno = ".$sNo;
		$result = executeQuery($query);
		if(mysql_num_rows($result) > 0){?>
		          <br />   <br />
				<table align="center" border="1">
				<tr><th>SrNo</th><th>Year&Semester</th><th>Course Title</th><th>Credit Hrs</th><th> Grade </th><th>Grade Points</th></tr> 
				<?php  $i = 1; $total_credits = 0;$GPA = 0;
			while ($record = mysql_fetch_assoc($result)) { ?>
			     <tr align="center">
				<td><?php  echo $i++;?></td>
				<td><?php  echo $record['Year'].$record['Semester'];?></td>
				<td align="left"><?php  echo $record['Cname'];?></td> 
				<td><?php  echo $record['Credits']; $total_credits += $record['Credits'];?></td>
				<td><?php  echo $record['Grade'];?></td>
				<td ><?php  echo calCredits($record['Grade']); $GPA += calCredits($record['Grade'])*$record['Credits']?></td> 
				</tr>
		 <?php } 
		  $GPA = ($GPA)/($total_credits); ?>
		 <tr><td></td><td></td><td><b> Grade Point Average </b></td><td></td><td></td><td align="center"> <b> <?php echo $GPA ?></td> </b>  </tr>
		 </table>
		 <?php 
		}
		else
			"No Grade Record Fount ! ";	 
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

function calCredits($rcvGrade){

	$grade = array("A" =>4.00,
				"A-" => 3.67,
				"B+" =>3.33,
				"B" => 3.00,
				"B-" =>3.67,
				"C+" =>2.33,
				"C" => 2.00);
	$result = $grade[$rcvGrade];
	return ($result);
}
?>
