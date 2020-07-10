<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");


$query = "SELECT * FROM fresh_produce_info order by A01 asc";
$result = mysqli_query($conn, $query);//从信息表读取数据
$total = mysqli_num_rows($result);//计算记录总数

$cur = empty($_POST['curpage']) ? 1 : $_POST['curpage'];
$size = empty($_POST['pageSize']) ? 7: $_POST['pageSize'];

$sp=($cur-1)*$size+1;//本页起始记录

$i=1;

while($i<$sp){//起始记录之前的记录
    $i++;
   
    $perinfo= mysqli_fetch_array($result);
}
$info=array();

if($cur*$size<=$total){//满一页
for($i=0;$i<$size;$i++){
    $info=mysqli_fetch_array($result);
   $arr['info'][] = array(
        'A01' => $info[0],
        'A02' => $info[1],
        'A04' => $info[3],
        'A05' => $info[4],
        'A06' => $info[5],
        
       
     );
}
}
else{     //不满一页
    for($i=0;$i<$total%$size;$i++){
         $infoo=mysqli_fetch_array($result);
        //echo "<script>alert($infoo['F01']);</script>";
         $arr['info'][] = array(
        'A01' => $infoo[0],
        'A02' => $infoo[1],
        'A04' => $infoo[3],
        'A05' => $infoo[4],
        'A06' => $infoo[5],
     );
}
}
$arr['total'] = $total;
mysqli_close($conn); 
echo json_encode($arr);


?>