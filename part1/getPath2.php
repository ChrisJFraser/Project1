<?php 

/*
purpose : Lamp2 Project 1, process reset web form
author(s) : Dana Amin, Chris Fraser, Darsh Bhatt
*/
  ?>


<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = intval($_GET['q']);

$con = mysqli_connect('localhost','dana','dana','LAMP2PROJECT');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}


$sql="DELETE FROM pt_endpoints  WHERE pt_id = '".$q."'";
$result = mysqli_query($con,$sql);

$sql="SELECT FROM pt_endpoints WHERE pt_id = '".$q."'";
$result = mysqli_query($con,$sql);

if($result !==""){
echo "Endpoint records sucessfully deleted"."<br>";
}

$sql="DELETE FROM pt_midpoints WHERE pt_id = '".$q."'";
$result = mysqli_query($con,$sql);

$sql="SELECT FROM pt_midpoints WHERE pt_id = '".$q."'";
$result = mysqli_query($con,$sql);

if($result !==""){
echo "Midpoint records sucessfully deleted"."<br>";
}
echo "Selected Path ID = ".$q;

$lines = array();

$file = fopen('../prm/path01.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
 //  $line[0] = '1004000018' in first iteration
//print_r($line[0][0]);
array_push($lines, $line);
}
/*
echo "<br>";echo "<br>";
echo "<br>";
//echo $lines[0][0];
$path_name = $lines[0][0];
echo "<br>";
//echo $lines[0][1];
$path_length = $lines[0][1];
echo "<br>";
//echo $lines[0][2];
$path_description = $lines[0][2];
echo "<br>";
//echo $lines[0][3];
$path_note = $lines[0][3];
echo "<br>";

*/
//-------------------Path Name

//echo $lines[0][0];
$path_name = $lines[0][0];
 
//string length  
if(strlen($path_name) > 100){
$sqlInsert = 0;
}//end 


if(!isset($path_name)){
$sqlInsert = 0;
}

//-------------------Path Length

echo "<br>";
//echo $lines[0][1];
$path_length = $lines[0][1];


//number size  
if($path_length >= 1 && $path_length <=100 ){
$sqlInsert = 0;
}//end 


if(!isset($path_length)){
$sqlInsert = 0;
}

//-------------------Path Desc
echo "<br>";
//echo $lines[0][2];
$path_desc = $lines[0][2];

if(strlen($path_desc) >100){
$sqlInsert = 0;
} 
if(!isset($path_desc)){
$sqlInsert = 0;
}

//-------------------Path Note
echo "<br>";
//echo $lines[0][3];
$path_note = $lines[0][3];

if(strlen($path_note) > 255){
$sqlInsert = 0;
}//end 



echo "pt_id =".$q."<br>";

//update statement
/*
$sql="SELECT FROM pt_endpoints WHERE pt_id = '".$q."'";
$result = mysqli_query($con,$sql);

*/
$path_length = 18.04;
$path_note = "update working";
$sql = "UPDATE paths SET pt_name= '".$path_name."',pt_length= '".$path_length."',pt_description= '".$path_desc."',pt_note= '".$path_note."' WHERE pt_id = '".$q."'";
$result = mysqli_query($con,$sql);


if ($con->query($sql) === TRUE) {
    //echo "Record updated successfully";
} else {
    echo "Error updating record: " . $con->error;
}


echo "<br>";

$beg_path = $lines[1][0];
echo "<br>";

$beg_grnd_ht = $lines[1][1];
echo "<br>";

$beg_ant_ht = $lines[1][2];
echo "<br>";

$end_path = $lines[2][0];
echo "<br>";

$end_grnd_ht = $lines[2][1];
echo "<br>";

$end_ant_ht = $lines[2][2];
echo "<br>";



// prepare and bind
$stmt = $con->prepare("INSERT INTO pt_endpoints (edpt_bgn_path_dist, edpt_bgn_ground_height, edpt_bgn_antenna_height, edpt_end_path_dist, edpt_end_ground_height,edpt_end_antenna_height,pt_id ) VALUES (?, ?, ?, ?, ? , ? , ?)");
$stmt->bind_param("ddddddi", $beg_path, $beg_grnd_ht,$beg_ant_ht, $end_grnd_ht,$end_path,$end_ant_ht,$q);
$stmt->execute();


//loop through rest of csv and insert it and echo it out

$id = $q;
for($x = 3; $x <17;$x++){
    	
       // echo  "<br>".$x."  ".$lines[$x][0]." "."<br>";
$mdpt_bgn_path_dist = $lines[$x][0];
//	echo  $x."  ".$lines[$x][1]." "."<br>";
$mdpt_ground_height = $lines[$x][1];
  //      echo  $x."  ".$lines[$x][2]." "."<br>";
$mdpt_terrain_type = $lines[$x][2];
    //    echo  $x."  ".$lines[$x][3]." "."<br>";
$obs_height= $lines[$x][3];
      //  echo  $x."  ".$lines[$x][4]."<br>"."<br>";
$obs_type = $lines[$x][4];



// prepare and bind
$stmt = $con->prepare("INSERT INTO pt_midpoints (mdpt_bgn_path_dist, mdpt_ground_height, mdpt_terrain_type, obs_height , obs_type ,pt_id ) VALUES (?, ?, ?, ?, ? , ? )");
$stmt->bind_param("ddsdsi", $mdpt_bgn_path_dist, $mdpt_ground_height,$mdpt_terrain_type, $obs_height,$obs_type,$q);
$stmt->execute();
}//end for 






mysqli_close($con);
?>
</body>
</html>

