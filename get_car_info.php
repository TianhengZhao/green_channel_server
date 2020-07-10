<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");
$query = "SELECT * FROM clearance_vehicle_info order by E02 desc";
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
$infoo=array();
$temp=array();
function cargo_num($cargos){
$res=array();  
if(strlen($cargos)>6){        //一辆车有多种菜品
$to=(int)(strlen($cargos)/7+1); //计算菜品种数
for($t=0;$t<$to;$t++){                  //取得每种菜品的编号 
$num=substr($cargos,$t*7,6);
$res[$t]=$num;
}  
}
else{                           //单一菜品
$res[0]=$cargos;
    }
return $res;
};
    if($cur*$size<=$total){//满一页
       for($i=0;$i<$size;$i++){
          $info=mysqli_fetch_array($result);
          $temp=cargo_num($info[10]);
          $str='';
          for($t=0;$t<sizeof($temp);$t++){
              $cargo=mysqli_query($conn,"SELECT A02 FROM fresh_produce_info where A01='$temp[$t]'");
              $cargoarr=mysqli_fetch_array($cargo);
                  if($t==0) $str=$cargoarr[0];
                  else $str=$str.','.$cargoarr[0];
          }
      $arr['info'][] = array(
        'E01' => $info[0],
        'E02' => $info[1],
        'E04' => $info[3],
        'E07' => $info[6],
        'E10' => $info[9],
        'E11' => $str,
        'E14' => $info[13],
        'E15' => $info[14],    
     );
}
}
else{     //不满一页
    for($i=0;$i<$total%$size;$i++){ 
         $infoo=mysqli_fetch_array($result);
         $temp=cargo_num($infoo[10]);
         $str='';
         for($t=0;$t<sizeof($temp);$t++){
              $cargo=mysqli_query($conn,"SELECT A02 FROM fresh_produce_info where A01='$temp[$t]'");
              $cargoarr=mysqli_fetch_array($cargo);
                  if($t==0) $str=$cargoarr[0];
                  else $str=$str.','.$cargoarr[0];
          }
         $arr['info'][] = array(
        'E01' => $infoo[0],
        'E02' => $infoo[1],
        'E04' => $infoo[3],
        'E07' => $infoo[6],
        'E10' => $infoo[9],
        'E11' => $str,
        'E14' => $infoo[13],
        'E15' => $infoo[14],
     );
}
}

$arr['total'] = $total;
mysqli_close($conn); 
echo json_encode($arr);


?>
