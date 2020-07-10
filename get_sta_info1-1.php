<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");
$info0=array();
$info1=array();
$info2=array();
$num=5;
$thisday=date("w");
$today=date('Y-m-d');
$temp=date('Y-m-d' ,strtotime((-1*$thisday+1).'day'));//本周一
         //读取本周一到今日数据
        $query="select * from clearance_vehicle_info where E02 between '$temp' and '$today'  and E08='1'";
        $result = mysqli_query($conn, $query);//从信息表读取违纪车辆
        $total = mysqli_num_rows($result);//计算违纪车辆总数   
        $info0[0]=$total;
        
        $query="select * from clearance_vehicle_info where E02 between '$temp' and '$today' and E08='0' and E11!='000'";
        $result = mysqli_query($conn, $query);//从信息表读取绿通车辆
        $total = mysqli_num_rows($result);//计算绿通车辆
        $info2[0]=$total;
    
        $query="select * from clearance_vehicle_info where E02 between '$temp' and '$today' ";
        $result = mysqli_query($conn, $query);//从信息表读取车辆总数
        $total = mysqli_num_rows($result);//计算车辆总数
        $info1[0]=$total;

for($i=1;$i<$num;$i++){//1 7 8 14
    
        $end=date('Y-m-d' ,strtotime((-($i-1)*7-$thisday).'day'));
        $start=date('Y-m-d',strtotime((-7*$i-$thisday+1).'day'));
      // echo $start.' '.$end.'<br>';
        $query="select * from clearance_vehicle_info where E02 between '$start' and '$end'  and E08='1'";
        $result = mysqli_query($conn, $query);//从信息表读取违纪车辆
        $total = mysqli_num_rows($result);//计算违纪车辆总数   
        $info0[$i]=$total;
        
        $query="select * from clearance_vehicle_info where E02 between '$start' and '$end' and E08='0' and E11!='000'";
        $result = mysqli_query($conn, $query);//从信息表读取绿通车辆
        $total = mysqli_num_rows($result);//计算绿通车辆
        $info2[$i]=$total;
    
        $query="select * from clearance_vehicle_info where E02 between '$start' and '$end' ";
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