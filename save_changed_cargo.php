<?php
header("Content-Type: text/html;charset=utf-8");
		include("conn/conn.php");
		$name = empty($_POST['name']) ? '' : $_POST['name'];
        $number = empty($_POST['number']) ? '' : $_POST['number'];
        $number_ori = empty($_POST['number_ori']) ? '' : $_POST['number_ori'];
        $var = empty($_POST['var']) ? '' : $_POST['var'];
        $sort = empty($_POST['sort']) ? '' : $_POST['sort'];
        $water = empty($_POST['water']) ? '' : $_POST['water'];
        $density = empty($_POST['density']) ? '' : $_POST['density'];
   
    
          
      //判断是否有数据为空

      if($name==''||$number==''||$sort==''||$water==''||$density==''||$var==''){
          echo "<script language='javascript'>alert('各项信息均不能为空!');</script>"; 
          exit;
      } 
     if($number!=$number_ori){
      //将数据插入数据库
         $query=mysqli_query($conn, "select * from fresh_produce_info where A01=$number");
         if($query){echo "<script language='javascript'>alert('已有该编号菜品信息!');</script>"; 
                   }
         else{
               if(!empty($_FILES['input_file']['name']) ){
                  $file=$_FILES['input_file']['tmp_name'];
                  $destination="fresh_produce_pic/".time().substr($_FILES['input_file']['name'],strrpos($_FILES['input_file']['name'],'.'));
                  move_uploaded_file($file,$destination);
                  $query=mysqli_query($conn, "update fresh_produce_info set A01='$number' A02='$name',A04='$sort',A05='$water',A06='$density' A07='$destination' where A01=$number_ori"); }
                else{
                    $query=mysqli_query($conn, "update fresh_produce_info set A01='$number' A02='$name',A04='$sort',A05='$water',A06='$density'  where A01=$number_ori");}
               }
     }
    else{
        if(!empty($_FILES['input_file']['name']) ){
                  $file=$_FILES['input_file']['tmp_name'];
                  $destination="fresh_produce_pic/".time().substr($_FILES['input_file']['name'],strrpos($_FILES['input_file']['name'],'.'));
                  move_uploaded_file($file,$destination);
                  $query=mysqli_query($conn, "update fresh_produce_info set A02='$name',A04='$sort',A05='$water',A06='$density' A07='$destination' where A01=$number_ori"); }
                else{
                    $query=mysqli_query($conn, "update fresh_produce_info set  A02='$name',A04='$sort',A05='$water',A06='$density'  where A01=$number_ori");}
        
      }
    if($query==true){  
                  echo "<script language='javascript'>alert('信息更新成功!');window.location.href='cargo_info.php';</script>";  
                }else{
  	              echo "<script language='javascript'>alert('信息更新失败!');hitory.back();</script>"; 
  	              exit;
               }

?>
