<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");

$query="select E11,E04 from clearance_vehicle_info ";
 $result = mysqli_query($conn, $query);
 $total = mysqli_num_rows($result);//计算车辆信息表总记录数 


for($i=1;$i<=25;$i++){
    $cargo1[$i]=0;                   //初始化每种菜品违规车辆数
    $cargo0[$i]=0;                   //初始化每种菜品绿通车辆数
}
for($i=1;$i<=$total;$i++){
     $info=mysqli_fetch_array($result);
     if(strlen($info[0])>6){        //一辆车有多种菜品
         $to=(int)(strlen($info[0])/7+1); //计算菜品种数
       
         for($t=0;$t<$to;$t++){                  //取得每种菜品的编号 
             $num=(int)substr($info[0],$t*7,3); 
             if($info[1]==1) {$cargo1[$num]++;}//违规
             else {$cargo0[$num]++;}//绿通
         }
         
     }
    else{                           //单一菜品
        $num=(int)substr($info[0],0,3);
        if($info[1]==1) $cargo1[$num]++;//违规
        else $cargo0[$num]++;//绿通
    }
}
$arr[0]=$cargo0;//绿通
$arr[1]=$cargo1;//绿通
mysqli_close($conn); 
echo json_encode($arr);
?>