
<center>
	<form method=get name=search_form action="<?php echo $_SERVER['PHP_SELF'];?>">  
		<br> <?php   echo "<b>   Class Search Page </b>"  ?>
		<br>
		<?php
		$crsName = isset($_GET['crsName']) ? trim($_GET['crsName']) : "";
		$crsNumber = isset($_GET['crsNumber']) ? trim($_GET['crsNumber']) : "";
		$instName = isset($_GET['instName']) ? trim($_GET['instName']) : "";
		$clsTime = isset($_GET['clsTime']) ? trim($_GET['clsTime']) : "";
		$semYear = isset($_GET['semYear']) ? trim($_GET['semYear']) : "";
		?>
		<br> 
			<table align="center">
			    <tr><td> <input type="hidden" name="page"  value="CourseSearch" /></td></tr>
			    <tr><td align="left">Term </td> <td align="left"> <select name = "semYear">  <?php getAllSemester($semYear);?> </select></td></tr> 
				<tr><td align="left">Course Number </td><td> <input type="text" name="crsNumber" value="<?php echo "$crsNumber";?>"> </td></tr>
				<tr><td align="left">Course Name   </td><td> <input type="text" name="crsName" value= "<?php echo "$crsName";?>"></td></tr>
				<tr><td align="left">Instructor Name </td><td> <input type="text" name="instName" value="<?php echo "$instName";?>"></td></tr>
				<tr><td align="left">Class time </td><td> <input type="text" name="clsTime" value="<?php echo "$clsTime";?>"></td></tr>	
			</table>
			<table align="center">
            	<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            	    <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="20px"><input type=submit  value=" Search "></td>
                    <td> &nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="20px"><input type=reset value= " Reset " onclick=" clear()" ></td>
                </tr>		
             </table>	

	</form>
</center>

<?php 

if(($crsNumber|| $crsName || $instName || $clsTime) && $semYear)
{

	$query = "select distinct Semester,Year,SectionId,Cname,Cno,SectionNo,Fname,Lname,Size,Status,Description ";
	$query .= "from section_details where 1=1  ";
	
	$wherePart = "";
	if( $crsNumber )
        $wherePart .= parseCourseNumber($crsNumber);
	
	if( $crsName)
		$wherePart .= parseCourseName($crsName);
        
    if($instName)
	   $wherePart .= parseInstrName($instName);

	if($clsTime)
		$wherePart .= parseClassTime($clsTime);
	
	if($semYear)
		$wherePart .= parseSemYear($semYear); 
	
	$query .= $wherePart." order by Year desc, Semester, Cno, SectionNo";

	//echo "<hr> Query = $query ";
	$result = executeQuery($query);

    echo "<hr> Search Result";
    if(mysql_num_rows($result) > 0)
	   showSectionTable($result);
	else
	   echo "- No Items Found !!";
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

function parseSemYear($semYear)
{
	$where = "";
	$Year = substr($semYear, 0, 4);
	$semester = substr($semYear, 4, 1);
	$where = " AND Year = ".$Year." AND Semester = '".$semester."'";
 return $where;
}
function parseInstrName($searchName){
    $where = ""; 
    if(!empty($searchName)){
			if(strchr($searchName," ")){
				$names = explode(" ",$searchName);
				$where .= " AND ( Fname like '%".$names[0]."%' OR  Lname like '%".$names[1]."%' )";
			}
			else
				$where .= " AND (Fname like '%".$searchName."%' OR  Lname like '%".$searchName."%' )";
    }
    return $where;
}

function parseCourseNumber($searchCrsNumber){
    $where = "";
 		if(!empty($searchCrsNumber))
			$where .= " AND Cno = ".$searchCrsNumber;
    return $where;
}

function parseCourseName($searchCrsName){
	$where = "";
		if(!empty($searchCrsName))
			$where .= " AND Cname like '%".$searchCrsName."%' ";
		
	return $where;
}


 function parseClassTime($searchClsTime){
    $where = "";
    if(!empty($searchClsTime)){
			if(strchr($searchClsTime,"-")){
				$times = explode("-", $searchClsTime); //Seperate fromTime and toTime
				$fromTime = $times[0];
				if(strchr($times[1]," ")){
					$timenDays = explode(" ",$times[1]);
					$toTime = $timenDays[0];
					$where .= " AND TIME_TO_SEC('".$fromTime."') <= TIME_TO_SEC(fromTime) and TIME_TO_SEC('".$toTime."') >= TIME_TO_SEC(toTime)";
					$days =  explode(",",$timenDays[1]);
					foreach ($days as &$day)
						$where .= " AND SectionId in (select SectionId  from section_times where Day like '%".$day."%')";
				}
				else
				$where .= " AND TIME_TO_SEC('".$times[0]."') <= TIME_TO_SEC(fromTime) and TIME_TO_SEC('".$times[1]."') >= TIME_TO_SEC(toTime)";
				}
			else
				$where .= " AND TIME_TO_SEC('".$times[0]."') <= TIME_TO_SEC(fromTime)";
	
	}   
	
	return $where;    

}

function showSectionTable($resultSet){
?>
	<table align="center" border="1">
	<tr><th>Year&Sem</th><th>Class No</th><th>Course Title</th><th>Course#</th><th>Section#</th><th>Instructor</th>
	<th>Location  and  Schedule</th><th>Size</th><th>Status</th><th>Quick Options</th></tr>

		<?php  while ($record = mysql_fetch_assoc($resultSet)) { ?>
			<tr><td><?php  echo $record['Year'].$record['Semester'];?></td>
			    <td><?php echo $record['SectionId'];?></td>
				<td><?php  echo $record['Cname'] ;?></td>
				<td><?php  echo $record['Cno'] ;?></td>
				<td><?php  echo $record['SectionNo'] ;?></td>
				<td><?php  echo $record['Fname']." ".$record['Lname'];?></td>
				<td><?php  showTimeOfSection($record['SectionId']) ?></td>
				<td><?php  echo $record['Size'];?></td>
				<td><?php  echo $record['Status'];?></td>
				<td><a href="<?php echo $_SERVER['PHP_SELF']."?page=NewRegistration&clsNumber=".$record['SectionId'];?>">Register</a>
					<a href="<?php echo $_SERVER['PHP_SELF']."?page=SectionEnrollment&clsNumber=".$record['SectionId'];?>"> List</a> </td>
			</tr>
		<?php } ?>
		</table>
<?php 
}

function showTimeOfSection($SectionId)
{
	$query = "select Location,Day,fromTime,toTime from section_times where SectionId = ".$SectionId;
	$resultSet = executeQuery($query);
	?><table border="0">  
	<?php while ($record = mysql_fetch_assoc($resultSet)){  ?>
			 <tr> <td> <?php echo $record['Location'].":".$record['Day']." ".substr($record['fromTime'],0,5)."-".substr($record['toTime'],0,5); ?> </td></tr>
			 <?php } ?>
	  </table>  
			<?php 
}
function getAllSemester($semYear){
	
	$query = "select distinct(concat(year,semester)) as semYear, year,Semester from section order by year desc,semester desc";
	$resultSet = executeQuery($query);
	while ($record = mysql_fetch_assoc($resultSet)) { ?>
		<option value="<?php echo $record['semYear'];?>" <?php echo ($semYear==$record['semYear']?"selected":""); ?>><?php echo $record['semYear'];?></option>
	<?php  }
	
	return;	
} 
?>