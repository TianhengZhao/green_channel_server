<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");
$info0=array();
$info1=array();
$info2=array();
$num=10;
$temp=date('Y-m-d' ,strtotime('+1day'));
for($i=$num;$i>0;$i--){
    $temp=date('Y-m-d',strtotime((-1)*($i-1).'day'));//获得日期
  $query="select * from clearance_vehicle_info where E02='$temp' and E08='1'";
  $result = mysqli_query($conn, $query);//从信息表读取违纪车辆
  $total = mysqli_num_rows($result);//计算违纪车辆总数   
    $info0[$i]=$total;
    
    $query="select * from clearance_vehicle_info where E02='$temp' and E08='0' and E11!='000'";
  $result = mysqli_query($conn, $query);//从信息表读取绿通车辆
  $total = mysqli_num_rows($result);//计算绿通车辆
    $info2[$i]=$total;
    
  $query="select * from clearance_vehicle_info where E02='$temp' ";
  $result = mysqli_query($conn, $query);//从信息表读取车辆总数
  $total = mysqli_num_rows($result);//计算车辆总数
    $info1[$i]=$total;
}
$arr[0]=$info0;
$arr[1]=$info1;
$arr[2]=$info2;
mysqli_close($conn); 
echo json_encode($arr);

?>