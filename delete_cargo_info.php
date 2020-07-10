<?php
header("Content-Type: text/html;charset=utf-8");
		include("conn/conn.php");
        $number = empty($_POST['number']) ? '' : $_POST['number'];
 
     $query = "delete from fresh_produce_info where A01='$number'";
    $result = mysqli_query($conn, $query);
mysqli_close($conn); 
echo json_encode($result);
?>