<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");

$query="select B02 from fresh_produce_loading_models_info ";
 $result = mysqli_query($conn, $query);
 $total = mysqli_num_rows($result);//计算车辆信息表总记录数
for($i=0;$i<18;$i++){
    $arr[$i]=0;
}
while($info=mysqli_fetch_array($result)){
    switch($info[0]){
        case '0101':$arr[0]++;break;
        case '0102':$arr[1]++;break;
        case '0103':$arr[2]++;break;
        case '0201':$arr[3]++;break;
        case '0202':$arr[4]++;break;
        case '0203':$arr[5]++;break;
        case '0301':$arr[6]++;break;
        case '0302':$arr[7]++;break;
        case '0303':$arr[8]++;break;
        case '0401':$arr[9]++;break;
        case '0402':$arr[10]++;break;
        case '0403':$arr[11]++;break;
        case '0501':$arr[12]++;break;
        case '0502':$arr[13]++;break;
        case '0503':$arr[14]++;break;
        case '0601':$arr[15]++;break;
        case '0602':$arr[16]++;break;
        case '0603':$arr[17]++;break;
    }
}
mysqli_close($conn); 
echo json_encode($arr);
?>