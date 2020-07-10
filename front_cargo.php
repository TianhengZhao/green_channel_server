  <?php
session_start();
header("Content-Type: text/html;charset=utf-8");  
include("conn/conn.php");
$id = empty($_POST['id']) ? 'void' : $_POST['id'];//车牌
$in_date = empty($_SESSION['date']) ? false : $_SESSION['date'];
$in_time = empty($_SESSION['time']) ? false : $_SESSION['time'];
$in_toll = empty($_POST['in_toll']) ? 'void' : $_POST['in_toll'];//入关收费站
$cut_mon = empty($_POST['cut_mon']) ? 'void' : $_POST['cut_mon'];//减免金额
$axle = empty($_POST['axle']) ? 'void' : $_POST['axle'];//车轴数
$weight = empty($_POST['weight']) ? 'void' : $_POST['weight'];//车重
$cargo_num = empty($_POST['cargo_num']) ? 'void' : $_POST['cargo_num'];//鲜活农产品编号
$personnel = empty($_POST['personnel']) ? 'void' : $_POST['personnel'];//收费员
$tel = empty($_POST['tel']) ? 'void' : $_POST['tel'];//电话
$width = empty($_POST['width']) ? 'void' : $_POST['width'];//宽度
$way = empty($_POST['way']) ? 'void' : $_POST['way'];//车道号

if(preg_match('/^02[0-3]./',$cargo_num)|| preg_match('.,02[0-3].',$cargo_num)|| preg_match('/^019./',$cargo_num)|| preg_match('.,019.',$cargo_num))  //活物
     $query= "update clearance_vehicle_info set E01='$id',E04='$in_toll',E07='$cut_mon',E08='0',E09='$axle',E10='$weight',E11='$cargo_num',E14='0',E15='$personnel',E18='2',E19='$tel',E20='$width',E23='$way'  where E02='$in_date' and E03='$in_time'";
else {
    $result = mysqli_query($conn, "select E18 from clearance_vehicle_info where E02='$in_date' and E03='$in_time'");
    $info=mysqli_fetch_array($result);
    if($info[0]=='100')
        $query= "update clearance_vehicle_info set E01='$id',E04='$in_toll',E07='$cut_mon',E09='$axle',E10='$weight',E11='$cargo_num',E15='$personnel',E18='1',E19='$tel',E20='$width',E23='$way'  where E02='$in_date' and E03='$in_time'";   //检测
    else  if($info[0]=='200')
        $query= "update clearance_vehicle_info set E01='$id',E04='$in_toll',E07='$cut_mon',E08='0',E09='$axle',E10='$weight',E11='$cargo_num',E14='0',E15='$personnel',E18='0',E19='$tel',E20='$width',E23='$way'  where E02='$in_date' and E03='$in_time'";   //不检测
}
$result = mysqli_query($conn, $query);
$arr['result']=$result;


$query= "INSERT INTO car_toll_collector(L01,L02,L03) VALUES ('$in_date','$id','$personnel')";
 $result = mysqli_query($conn, $query);
mysqli_close($conn); 
echo json_encode($arr);
?>
