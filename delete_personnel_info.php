<?php
header("Content-Type: text/html;charset=utf-8");
		include("conn/conn.php");
 
        $number = empty($_POST['number']) ? '000' : $_POST['number'];

     $query = "delete from personnel_info where F01='$number'";
    $result = mysqli_query($conn, $query);
mysqli_close($conn); 
echo json_encode($result);
?>