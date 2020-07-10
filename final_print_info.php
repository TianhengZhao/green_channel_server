<?php 
 session_start();//在此之前不能有任何输出
include("conn/conn.php");
 
$date = empty($_POST['date']) ? '' : $_POST['date'];
$time = empty($_POST['time']) ? '' : $_POST['time'];
$out_date= date("Y-m-d");
date_default_timezone_set("PRC");
$out_time= date("H:i:s");
$query="select E10 from clearance_vehicle_info where E02='$date' and E03='$time'";
$result = mysqli_query($conn, $query);
$info=mysqli_fetch_array($result);
$panalty=$info[0]*5;
 //计算处罚金额
$qu="update clearance_vehicle_info set E05='$out_date',E06='$out_time',E14='$panalty'  where E02='$date' and E03='$time'";//出关时间
$result = mysqli_query($conn, $qu);

$query="select E01,E19 from clearance_vehicle_info where E02='$date' and E03='$time'";
$result = mysqli_query($conn, $query);
$infoo=mysqli_fetch_array($result);
        
 mysqli_query($conn, "INSERT INTO illegal_vehicle(K02,K04) VALUES ('$infoo[0]','$infoo[1]')");//违纪车辆加入违纪表
   
    

$query="select E04,E11,E12,E15,E14 from clearance_vehicle_info where E02='$date' and E03='$time'";
$result = mysqli_query($conn, $query);
$info=mysqli_fetch_array($result);
$temp=cargo_num($info[1]);
$str='';
for($t=0;$t<sizeof($temp);$t++){
$cargo=mysqli_query($conn,"SELECT A02 FROM fresh_produce_info where A01='$temp[$t]'");
$cargoarr=mysqli_fetch_array($cargo);
if($t==0) $str=$cargoarr[0];
else $str=$str.','.$cargoarr[0];//获得菜品名称

}
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

$info[1]=$str;
mysqli_close($conn); 
echo json_encode($info);
?>
