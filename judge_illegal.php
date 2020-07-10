<?php
header("Content-Type: text/html;charset=utf-8");  
include("conn/conn.php");
$result=0;
$query="select E02,E03 from clearance_vehicle_info where E21=1 and E08=2";//后亭已知该车辆违规
$result = mysqli_query($conn, $query);
$info=mysqli_fetch_array($result);
if ($info[0]!=NULL) {
     echo json_encode(array('code'=>'200','success'=>'获取数据成功','date'=>$info[0],'time'=>$info[1]));
    $query="update clearance_vehicle_info set E08=1 where E02='$info[0]' and E03='$info[1]'";
    $result = mysqli_query($conn, $query);
    exit();  
}
else{
    echo json_encode(array('code'=>'400','success'=>'获取数据失败'));
}
exit(); 
mysqli_close($conn); 
?>
