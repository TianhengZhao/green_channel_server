<?php
header("Content-Type: text/html;charset=utf-8"); 
include("conn/conn.php");
$query = "SELECT * FROM clearance_vehicle_info order by E02 desc";
$result = mysqli_query($conn, $query);//从信息表读取数据
$total = mysqli_num_rows($result);//计算记录总数
$i=0;
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
while($info=mysqli_fetch_array($result)){
    $arr[$i]['E01']=$info['E01'];
    $arr[$i]['E02']=$info['E02'];
    $arr[$i]['E04']=$info['E04'];
    $arr[$i]['E07']=$info['E07'];
    $arr[$i]['E10']=$info['E10'];
    
    $temp=cargo_num($info['E11']);    //将菜品编号转换为中文名称
    $str='';
    for($t=0;$t<sizeof($temp);$t++){
              $cargo=mysqli_query($conn,"SELECT A02 FROM fresh_produce_info where A01='$temp[$t]'");
              $cargoarr=mysqli_fetch_array($cargo);
                  if($t==0) $str=$cargoarr[0];
                  else $str=$str.','.$cargoarr[0];
          }
    $arr[$i]['E11']=$str;
    $arr[$i]['E14']=$info['E14'];
    $arr[$i]['E15']=$info['E15'];
    $i++;
}
mysqli_close($conn); 
echo json_encode($arr);

?>