<?php
header("Content-Type: text/html;charset=utf-8");
		include("conn/conn.php");
		$name = empty($_POST['name']) ? '' : $_POST['name'];
        $number = empty($_POST['number']) ? '' : $_POST['number'];
        $password = empty($_POST['password']) ? '' : $_POST['password'];
        $sex = empty($_POST['sex']) ? '' : $_POST['sex'];
        $birthday = empty($_POST['birthday']) ? '' : $_POST['birthday'];
        $position = empty($_POST['position']) ? '' : $_POST['position'];
        $memo = empty($_POST['memo']) ? '' : $_POST['memo'];
        $auth = empty($_POST['auth']) ? '' : $_POST['auth'];
      //判断是否有数据为 
       echo $sex;
       if($sex=='1')$sex='0';
       else $sex='1';
      if($name==''||$number==''||$password==''||$sex==''||$birthday==''||$position==''||$memo==''||$auth==''){
          echo "<script language='javascript'>alert('各项信息均不能为空!');</script>"; 
          exit;
      }  
      //将图片存入指定地点
    
     if(!empty($_FILES['input_file']['name']) ){
            $file=$_FILES['input_file']['tmp_name'];
            $destination="personnel_pic/".time().substr($_FILES['input_file']['name'],strrpos($_FILES['input_file']['name'],'.'));
            move_uploaded_file($file,$destination);
            $query=mysqli_query($conn, "update personnel_info set F02='$name',F03='$position',F04='$auth',F05='$sex',F06='$birthday',F07='$password',F08='$destination',F09='$memo'  where F01=$number");//将数据插入数据库
        }
      else{
           $query=mysqli_query($conn, "update personnel_info set F02='$name',F03='$position',F04='$auth',F05='$sex',F06='$birthday',F07='$password',F09='$memo'  where F01=$number");
      }
      
      
if($query==true){  
      echo "<script language='javascript'>alert('信息更新成功!');window.location.href='personnel_info.php';</script>";  
  }else{
  	echo "<script language='javascript'>alert('信息更新失败!');hitory.back();</script>"; 
  	
}      
?>
