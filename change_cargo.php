<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");
$arr=array();
$number = empty($_POST['number']) ? '001001' : $_POST['number'];
    $query = "SELECT * FROM fresh_produce_info WHERE A01='$number'";
    $result = mysqli_query($conn, $query);//从人员信息表读取数据
    $info=mysqli_fetch_array($result);
mysqli_close($conn); 
$flag=0;
$i=0;
foreach($info as $key=>$val){
    if($i>14) break;
    else{
        $i++;
    if($flag){
        $arr[$key]=$val;
        $flag=0;
    }
    else $flag=1;}
    
}
echo json_encode($arr);
?>