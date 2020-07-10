<?php
session_start();

handle_login();	
	function handle_login() {
		include("conn/conn.php");
		$num = empty($_POST['num']) ? '' : $_POST['num'];
       
        $_SESSION['number'] = $num ;
       
		$password = empty($_POST['password']) ? '' : $_POST['password'];
        $result = false;
        if (($num!="")&&($password!="")){
	    $query=mysqli_query($conn, "select F02 from personnel_info where F01='$num' AND F07='$password'");
        $result=mysqli_fetch_array($query);
        }
		if ($result!=false) {
           echo "<script>window.location.href='main.php';</script>";
            //?number=".$_SESSION['number']."
            exit;
		} else {
			 echo "<script>alert('编号或密码有误，请重新输入！');</script>";
			require "login_form.php";
		}		
	}
	
	
	
?>
