<?php
header("Content-Type: text/html;charset=utf-8");  
include("conn/conn.php");
$result=0;
 $query="select E02,E03,E18 from clearance_vehicle_info where E18=1 or E18=2";
 $result = mysqli_query($conn, $query);
 $info=mysqli_fetch_array($result);
if ($info[0]!=NULL) {
    if($info[2]==1)
    echo json_encode(array('code'=>'200','success'=>'获取数据成功','date'=>$info[0],'time'=>$info[1],'ex'=>$info[2]));//检测
    else echo json_encode(array('code'=>'300','success'=>'获取数据成功','date'=>$info[0],'time'=>$info[1],'ex'=>$info[2]));//蜜蜂活物
    $query="update clearance_vehicle_info set E18='0' where E02='$info[0]' and E03='$info[1]'";
    $result = mysqli_query($conn, $query);
    exit();
   
}
else{
    echo json_encode(array('code'=>'400','success'=>'获取数据失败'));
}
exit(); 
//$arr["date"]=$info[0];
//$arr["time"]=$info[1];
mysqli_close($conn); 
//echo json_encode($arr);
?>