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
$num=7;
$mon=array();//二维数组初始化
$temp=date('Y-m-d' ,strtotime('+1day'));       
for($i=$num;$i>0;$i--){
    $temp=date('Y-m-d',strtotime((-1)*($i-1).'day'));//获得日期
    
    
    for($t=0;$t<$total_per;$t++){
        $mon[$i][$t]=0;  
        $query="select E07 from clearance_vehicle_info where E02='$temp' and E15=$person_num[$t]";//查询该收费员某天减免金额
        $result = mysqli_query($conn, $query);
        
        while($info=mysqli_fetch_array($result)){ 
            $mon[$i][$t]+=$info[0];//计算某天某个收费员减免总金额
        }
      //  echo $temp.'日收费员'.$person_num[$t].'收钱'.$mon[$i][$t].'<br>';
    }
}
$arr[0]=$total_per;
$arr[1]=$person;  

$arr[2]=$mon;
mysqli_close($conn); 
echo json_encode($arr);
?>