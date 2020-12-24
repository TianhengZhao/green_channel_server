<?php
include("conn/conn.php");
header("Content-Type: text/html;charset=utf-8");
$name = empty($_POST['name']) ? '' : $_POST['name'];
$number = empty($_POST['number']) ? '' : $_POST['number'];
$var = empty($_POST['var']) ? '' : $_POST['var'];
$sort = empty($_POST['sort']) ? '' : $_POST['sort'];
$water = empty($_POST['water']) ? '' : $_POST['water'];
$density = empty($_POST['density']) ? '' : $_POST['density'];
//判断编号是否已使用
$sql = mysqli_query( $conn, "select A01 from fresh_produce_info where A01='$number'" );
$info = mysqli_fetch_array($sql);
if ( $info != false ){
	echo "<script language='javascript'>alert('该编号已使用!');history.back();</script>"; 
        exit;
}
//判断是否有数据为空
if ( $name=='' || $number=='' || $var=='' || $sort=='' || $water=='' || $density=='' ){
	echo "<script language='javascript'>alert('各项信息均不能为空!');history.back();</script>"; 
        exit;
}  
//将图片存入指定地点
if ( !empty($_FILES['input_file']['name']) ){
	$file=$_FILES['input_file']['tmp_name'];
        $destination="fresh_produce_pic/".time().substr($_FILES['input_file']['name'], strrpos($_FILES['input_file']['name'],'.'));
        move_uploaded_file($file, $destination);
} else { 
	$destination = ' ';
}      
//将数据插入数据库
$qur = "INSERT INTO fresh_produce_info(A01,A02,A03,A04,A05,A06,A07) VALUES ";
$qur .= " ('$number', '$name', '$var', '$sort', '$water', '$density', '$destination') ";
$query = mysqli_query($conn, $qur);
if ($query = = true){
	echo "<script language='javascript'>alert('信息添加成功!');window.location.href='cargo_info.php';</script>";  
} else {
	echo "<script language='javascript'>alert('信息添加失败!');history.back();</script>"; 
  	exit;
}      
?>
