<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");


$query = "SELECT * FROM personnel_info order by F01 asc";//按编号升序显示
$result = mysqli_query($conn, $query);//从人员信息表读取数据
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
    $match0 = "SELECT H02 FROM position_info where H01='$info[2]'";//查职位表中该职位编号对应的职位名称
    $result0 = mysqli_query($conn, $match0);
    $re0=mysqli_fetch_array($result0);
    $match1 = "SELECT G02 FROM operating_authorization where G01='$info[3]'";//查权限表中该权限编号对应的权限名称
    $result1 = mysqli_query($conn, $match1);
    $re1=mysqli_fetch_array($result1);
   $arr['info'][] = array(
        'F01' => $info[0],
        'F02' => $info[1],
        'F03' => $re0[0],
        'F04' => $re1[0],
        'F05' => $info[4],
        'F06' => $info[5],
        'F07' => $info[6],
        'F08' => $info[7],
     );
}
}
else{     //不满一页
    for($i=0;$i<$total%$size;$i++){
         $infoo=mysqli_fetch_array($result);
         $match0 = "SELECT H02 FROM position_info where H01='$infoo[2]'";//查职位表中该职位编号对应的职位名称
    $result0 = mysqli_query($conn, $match0);
    $re0=mysqli_fetch_array($result0);
    $match1 = "SELECT G02 FROM operating_authorization where G01='$infoo[3]'";//查权限表中该权限编号对应的权限名称
    $result1 = mysqli_query($conn, $match1);
    $re1=mysqli_fetch_array($result1);
         $arr['info'][] = array(
        'F01' => $infoo[0],
        'F02' => $infoo[1],
        'F03' => $re0[0],
        'F04' => $re1[0],
        'F05' => $infoo[4],
        'F06' => $infoo[5],
        'F07' => $infoo[6],
        'F08' => $infoo[7],
     );
}
}
$arr['total'] = $total;
mysqli_close($conn); 
echo json_encode($arr);


?>