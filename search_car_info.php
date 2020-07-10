<?php
header("Content-Type: text/html;charset=utf-8");  
include("conn/conn.php");
$opt1 = empty($_POST['opt1']) ? 'void' : $_POST['opt1'];//车牌查询
$opt2 = empty($_POST['opt2']) ? 'void' : $_POST['opt2'];//车轴数
$opt3 = isset($_POST['opt3']) ?  $_POST['opt3']:'void';//起始时间
$opt4 = empty($_POST['opt4']) ? 'void' : $_POST['opt4'];//终止时间
$opt5 = empty($_POST['opt5']) ? 'void' : $_POST['opt5'];//入关收费站查询
$opt6 = empty($_POST['opt6']) ? 'void' : $_POST['opt6'];//货物类型查询
$opt7 = empty($_POST['opt7']) ? 'void' : $_POST['opt7'];//违规情况查询

$flag=0;
$str=' ';
if($opt1!='void'){
     $flag=1;
     $str=$str."E01='$opt1'";  
}
if($opt2!='void'){
    if($flag)
    $str=$str."and E09='$opt2'";
    else {$str=$str."E09='$opt2'";$flag=1;}
}
if($opt3!='void'){
    if($flag)
    $str=$str."and E02 between '$opt3' and '$opt4' ";
    else {$str=$str."E02 between '$opt3' and '$opt4' ";$flag=1;}
}
if($opt5!='void'){
    if($flag)
    $str=$str."and E04='$opt5'";
    else {$str=$str."E04='$opt5'";$flag=1;}
}
if($opt7!='void'){
    if($flag)
    $str=$str."and E08='$opt7'";
    else {$str=$str."E08='$opt7'";$flag=1;}
}
if($opt6!='void'){
    switch($opt6)
    {
        case "无货物000":$num="000";break;
        case "白菜类001":$num="001";break;
        case "甘蓝类002":$num="002";break;
        case "根菜类003":$num="003";break;
        case "绿叶菜类004":$num="004";break;
        case "葱蒜类005":$num="005";break;
        case "茄果类006":$num="006";break;
        case "豆类007":$num="007";break;
        case "瓜类008":$num="008";break;
        case "水生蔬菜009":$num="009";break;
        case "新鲜食用菌010":$num="010";break;
        case "多年生和杂类蔬菜011":$num="011";break;
        case "仁果类012":$num="012";break;
        case "核果类013":$num="013";break;
        case "浆果类014":$num="014";break;
        case "柑橘类015":$num="015";break;
        case "热带及亚热带水果016":$num="016";break;
        case "什果类017":$num="017";break;
        case "瓜果类018":$num="018";break;
        case "水产品019":$num="019";break;
        case "其它水产品020":$num="020";break;
        case "家畜021":$num="021";break;
        case "家禽022":$num="022";break;
        case "其他023":$num="023";break;
        case "024":$num="024";break;
        case "025":$num="025";break;   
    }
    if($flag){$str=$str."and (E11 regexp '^$num' or E11 regexp '.,$num.')";}//正则表达式
    else{$str=$str." E11 regexp '^$num' or E11 regexp '.,$num.'";$flag=1;}
}

$total=0;

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

if($str!=' '){
    $query='select E01,E02,E04,E07,E08,E10,E11,E14,E15 from clearance_vehicle_info where'.$str;
 $result = mysqli_query($conn, $query);//从人员信息表读取数据
 $total = mysqli_num_rows($result);//计算记录总数
 while($info=mysqli_fetch_array($result)){
     
          $temp=cargo_num($info[6]);
          $str='';
          for($t=0;$t<sizeof($temp);$t++){
              $cargo=mysqli_query($conn,"SELECT A02 FROM fresh_produce_info where A01='$temp[$t]'");
              $cargoarr=mysqli_fetch_array($cargo);
                  if($t==0) $str=$cargoarr[0];
                  else $str=$str.','.$cargoarr[0];}
$arr['info'][] = array(
        'E01' => $info[0],
        'E02' => $info[1],
        'E04' => $info[2],
        'E07' => $info[3],
        'E08' => $info[4],
        'E10' => $info[5],
        'E11' => $str,
        'E14' => $info[7],
        'E15' => $info[8],
        );}
}

$arr['total'] = $total;
mysqli_close($conn); 
echo json_encode($arr);
?>
