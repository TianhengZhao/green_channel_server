<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");


$num=2;


  $query="select * from clearance_vehicle_info where E04='1' and E08='1'";
  $result = mysqli_query($conn, $query);//从信息表读取111违纪车辆
  $total = mysqli_num_rows($result);//计算111违纪车辆总数   
    $info[0]=$total;
    
    $query="select * from clearance_vehicle_info where E04='1' and E08='0' and E11!='000'";
  $result = mysqli_query($conn, $query);//从信息表读取111绿通车辆
  $total = mysqli_num_rows($result);//计算111绿通车辆
    $info[1]=$total;
    
  $query="select * from clearance_vehicle_info where E04='2' ";
  $result = mysqli_query($conn, $query);//从信息表读取112违纪车辆
  $total = mysqli_num_rows($result);//计算112违纪车辆
    $info[2]=$total;
    
    $query="select * from clearance_vehicle_info where E04='2' and E08='0' and E11!='000'";
  $result = mysqli_query($conn, $query);//从信息表读取112绿通车辆
  $total = mysqli_num_rows($result);//计算112绿通车辆
    $info[3]=$total;


mysqli_close($conn); 
echo json_encode($info);

?>