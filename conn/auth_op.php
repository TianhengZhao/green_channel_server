<?php
include("conn.php");
    session_start();
    $num= empty($_SESSION['number']) ? "" : $_SESSION['number'];
    if($num){
        $query=mysqli_query($conn, "select F04 from personnel_info where F01='$num' ");
        $myauth=mysqli_fetch_array($query);
        if($myauth[0]!="00"){ 
            echo "<script language='javascript'>alert('对不起，您没有该操作权限!');history.back();</script>"; 
        }
       
    }else echo "<script language='javascript'>alert('对不起，操作失败!');history.back();</script>"; 
   
    
?>	