<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");
$query="select F01,F02 from personnel_info,position_info where personnel_info.F03=position_info.H01 and position_info.H02='前亭收费员'";
//查询收费员编号与姓名
 $result = mysqli_query($conn, $query);
$i=0;//收费员个数
while($info=mysqli_fetch_array($result)){
    $person_num[$i]=$info[0];  
    $person[$i]=$info[0].$info[1];   
    $i++;
}
$total_per=$i;
$num=5;
$mon=array();//二维数组初始化
$thisday=date("w");
$end=date('Y-m-d');//今天
$start=date('Y-m-d' ,strtotime((-1*$thisday+1).'day'));//本周一     
for($i=1;$i<=$num;$i++){ 
    for($t=0;$t<$total_per;$t++){
        $mon[$i][$t]=0;  
        $query="select E07 from clearance_vehicle_info where E02 between '$start' and '$end' and E15=$person_num[$t]";//查询该收费员一周减免金额
        $result = mysqli_query($conn, $query);
        while($info=mysqli_fetch_array($result)){ 
            $mon[$i][$t]+=$info[0];//计算一周某个收费员减免总金额
        }
        //echo $start.'~'.$end.'收费员'.$person_num[$t].'收钱'.$mon[$i][$t].'<br>';
    }
     $end=date('Y-m-d' ,strtotime((-($i-1)*7-$thisday).'day'));
     $start=date('Y-m-d',strtotime((-7*$i-$thisday+1).'day'));
}
$arr[0]=$total_per;
$arr[1]=$person;  
$arr[2]=$mon;
mysqli_close($conn); 
echo json_encode($arr);
?>