<?php 
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");
 session_start();
     $num= empty($_SESSION['number']) ? 'void' : $_SESSION['number'];
   
    $query=mysqli_query($conn, "select * from personnel_info where F01='$num' ");
    $info=mysqli_fetch_array($query);
    $pos=$info['F03'];
    
    $query=mysqli_query($conn, "select H02 from position_info where H01='$pos'");
    $pos=mysqli_fetch_array($query);
     
   
 $arr['info'][] = array(
        'F02' => $info[1],
        'F03' => $pos[0],
        'F05' => $info[4],
        'F06' => $info[5],
        'F08' => $info[7],
     );


   
 mysqli_close($conn); 
echo json_encode($arr);
?>