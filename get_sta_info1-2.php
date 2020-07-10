<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");

$info0=array();
$info1=array();
$info2=array();
$num=6;
$da=date('Y-m-d');
$start=date('Y-m-01');//本月第一天
$end=$da;//今天
for($i=0;$i<$num;$i++){
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
     $da=$start;
     $temp=getlastMonthDays($da);//获得上个月第一天和最后一天日期
     $start=$temp[0];
     $end=$temp[1];
     
}
function getlastMonthDays($date){   //这**什么情况  函数中变量前必须不能有空格
$timestamp=strtotime($date);
$firstday=date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)-1).'-01'));
$lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
return array($firstday,$lastday);
}
 $arr[0]=$info0;
$arr[1]=$info1;
$arr[2]=$info2;
mysqli_close($conn); 
echo json_encode($arr);
?>