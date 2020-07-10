<!DOCTYPE html>
<!----------------连接数据库，打开session会话---------------------------->
<?php 
 session_start();//在此之前不能有任何输出
include("conn/conn.php");

?>
<html lang="en">

<head>
    <!-- param, meta, styles, scripts -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>绿色通道管理系统</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>





<!-- 根据session中登陆者编号，从数据库中读取人员信息,可以这样吗？？ -->
<script>
    window.onload = function() {
        function GetRequest() {
            var url = location.search; //获取url中"?"符后的字串
            var theRequest = new Object();
            if (url.indexOf("?") != -1) {
                var str = url.substr(1);
                strs = str.split("&");
                for (var i = 0; i < strs.length; i++) {
                    theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
                }
            }
            return theRequest;
        };

        var num = GetRequest().number;

        $.ajax({
            type: "POST",
            url: "main_info.php",
            data: {}, //number:num},
            dataType: 'json',
            success: function(json) {

                var info = json.info;
                document.getElementById('image').src = info[0].F08;
                document.getElementById('info1').innerHTML = info[0].F02;
                if (info[0].F05 == 1) document.getElementById('info2').innerHTML = '女'
                else document.getElementById('info2').innerHTML = '男';
                document.getElementById('info3').innerHTML = info[0].F06;
                document.getElementById('info4').innerHTML = info[0].F03;
            },
            error: function(e) {
                alert("Error!" + e.responseText);
            }
        });
    }

    //轮询 是否为违规夹带货车
    var getting = {
        url: 'judge_illegal.php',
        dataType: 'json',
        success: function(res) {
            if (res.code == 200) {
                console.log(res);

                if (confirm("有车辆违规！请打印违规报告单！")) {
                    window.location.href = 'print_illegal.php?date=' + res.date + '&time=' + res.time;
                }
            } else {
                console.log(res);
            }
        }
    };
    //关键在这里，Ajax定时访问服务端，不断获取数据 ，这里是10秒请求一次。
    window.setInterval(function() {
        $.ajax(getting)
    }, 10000);

</script>

<body class="bg">

    <!------------------------------- 导航栏 --------------------------------->
    <nav class="navbar  mynav " role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">


                <button type="button" class=" navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse" style="background-color:#eee;">
                    <span class="sr-only">切换导航</span>
                    <span class="icon-bar" style="background-color:gray;"></span>
                    <span class="icon-bar" style="background-color:gray;"></span>
                    <span class="icon-bar" style="background-color:gray;"></span>


                </button>


                <img id="mainlogo" src="tool_pic/logo.png" width='50' height='50'>
                &nbsp;&nbsp;
                <a class="navbar-brand " href="#">绿色通道管理系统</a>
            </div>
            <div class="collapse navbar-collapse" id="example-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">主页</a></li>
                    <li><a href="personnel_info.php">人员信息管理</a></li>
                    <li><a href="cargo_info.php">货物信息管理</a></li>
                    <li><a href="car_info.php">车辆信息管理</a></li>
                    <li><a href="print.php">打印报表</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--------------------------------- 展示个人信息 ---------------------------------->


    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>个人信息</h2>
                <br>
                <h4>照片:</h4>
                <div> <img id='image' src='' height="300" width="230" /> </div>
            </div>
            <br><br>
            <div class="col-md-7 bor">
                <h4>姓名:<span id='info1' class="maininfo"></span></h4>
                <br>
                <h4>性别:<span id='info2' class="maininfo"></span></h4>
                <br>
                <h4>出生日期:<span id='info3' class="maininfo"></span></h4>
                <br>
                <h4>职务:<span id='info4' class="maininfo"></span></h4>
                <br>
            </div>
        </div>
    </div>
</body>

</html>
