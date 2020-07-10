<?php
header("Content-Type: text/html;charset=utf-8");  
include("conn/conn.php");
$id = empty($_POST['id']) ? 'void' : $_POST['id'];//车牌
$weight = empty($_POST['weight']) ? 'void' : $_POST['weight'];//车重
$personnel = empty($_POST['personnel']) ? 'void' : $_POST['personnel'];//收费员
$type = empty($_POST['type']) ? 'void' : $_POST['type'];//车型
$in_date = empty($_POST['in_date']) ? 'void' : $_POST['in_date'];//入关日期
$in_time = empty($_POST['in_time']) ? 'void' : $_POST['in_time'];//入关时间
$weather_exa=0;//0不检 1检
 $query="select * from illegal_vehicle where K02='$id'";//判断是否曾经违纪
 $result = mysqli_query($conn, $query);
if($result) $weather_exa=1;

if($weather_exa!=1){
$query="select L03 from car_toll_collector where L02='$id'";
 $result = mysqli_query($conn, $query);
 $total = mysqli_num_rows($result);//计算该车经过总次数
$per_num=0;
while($info=mysqli_fetch_array($result)){//计算当前收费员对其收费次数
    if($info[0]==$personnel)
        $per_num++;
}
    if($per_num>=$total/2)  $weather_exa=1;
}

if($weather_exa!=1){
    if(0<=rand(0, 100)&&rand(0, 100)<=25)//随机值
        $weather_exa=1;
}
if($weather_exa==1)
    $query= "INSERT INTO clearance_vehicle_info(E01, E02, E03, E04, E05, E06, E07, E08, E09, E10, E11, E12, E13, E14, E15, E16, E17, E18, E19, E20, E21, E22, E23, E24) VALUES ( NULL, '$in_date', '$in_time', '', NULL, NULL, NULL, '', NULL, NULL, '', '', '', NULL, '', '', '', '100', '', NULL, '', '', '', '')";//检测
else $query= "INSERT INTO clearance_vehicle_info(E01, E02, E03, E04, E05, E06, E07, E08, E09, E10, E11, E12, E13, E14, E15, E16, E17, E18, E19, E20, E21, E22, E23, E24) VALUES ( NULL, '$in_date', '$in_time', '', NULL, NULL, NULL, '', NULL, NULL, '', '', '', NULL, '', '', '', '200', '', NULL, '', '', '', '')";//不检测
 $result = mysqli_query($conn, $query);
$arr['db']=$result;
$arr['result']=$weather_exa;
mysqli_close($conn); 
echo json_encode($arr);
?>
