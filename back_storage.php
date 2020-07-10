<?php
session_start();
header("Content-Type: text/html;charset=utf-8");  
include("conn/conn.php");
//$videochip = empty($_POST['videochip']) ? 'void' : $_POST['videochip'];
$num =empty($_POST['surveyor']) ? '' : $_POST['surveyor'];
//$in_date=empty($_POST['date']) ? '' : $_POST['date'];
//$in_time=empty($_POST['time']) ? '' : $_POST['time'];
$in_date = empty($_SESSION['date']) ? 'false' : $_SESSION['date'];
$in_time = empty($_SESSION['time']) ? 'false' : $_SESSION['time'];
$query= "update clearance_vehicle_info set E24='$num'  where E02='$in_date' and E03='$in_time'";//数据存不进去
$result = mysqli_query($conn, $query);

//$arr['re']=$result ;
//$arr['v']=$videochip ;
//$arr['num']=$num;
//$arr['date']=$in_date ;
//$arr['time']=$in_time ;

//$arr['result']=$result;
mysqli_close($conn); 
//echo json_encode($arr);
?>