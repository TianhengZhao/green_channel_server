<?php
header("Content-Type: text/html;charset=utf-8");
		include("conn/conn.php");
		$name = empty($_POST['newname']) ? '' : $_POST['newname'];
        $number = empty($_POST['newnumber']) ? '' : $_POST['newnumber'];
        $password = empty($_POST['password']) ? '' : $_POST['password'];
        $sex = empty($_POST['sex']) ? '' : $_POST['sex'];
        $birthday = empty($_POST['birthday']) ? '' : $_POST['birthday'];
        $position = empty($_POST['position']) ? '' : $_POST['position'];
        $memo = empty($_POST['memo']) ? '' : $_POST['memo'];
        $auth = empty($_POST['auth']) ? '' : $_POST['auth'];
      //判断编号是否已使用
      $sql=mysqli_query($conn, "select F01 from personnel_info where F01='$number'");
      $info=mysqli_fetch_array($sql);
      if($info!=false){
        echo "<script language='javascript'>alert('该编号已使用!');history.back();</script>"; 
        exit;
      }
      //判断是否有数据为空
      if($name==''||$number==''||$password==''||$sex==''||$birthday==''||$position==''||$memo==''||$auth==''){
          echo "<script language='javascript'>alert('各项信息均不能为空!');history.back();</script>"; 
          exit;
      }  
      //将图片存入指定地点
     if(!empty($_FILES['input_file']['name']) ){
            $file=$_FILES['input_file']['tmp_name'];
            $destination="personnel_pic/".time().substr($_FILES['input_file']['name'],strrpos($_FILES['input_file']['name'],'.'));
            move_uploaded_file($file,$destination);
        }
      else{
           echo "<script language='javascript'>alert('请选择图片!');history.back();</script>"; 
          exit;
      }
      //将数据插入数据库
      $query=mysqli_query($conn, "INSERT INTO personnel_info(F01,F02,F03,F04,F05,F06,F07,F08,F09) VALUES ('$number','$name','$position','$auth','$sex','$birthday','$password','$destination','$memo')");
if($query==true){  
      echo "<script language='javascript'>alert('信息添加成功!');window.location.href='personnel.php';</script>";  
  }else{
  	echo "<script language='javascript'>alert('信息添加失败!');</script>"; 
  	exit;
}      
?>