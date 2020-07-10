<!DOCTYPE html>
<html lang="en">
<!----------------连接数据库,检查权限---------------------------->
<?php include("conn/conn.php");
    include("conn/auth_exem.php");  
?>

<head>
    <!-- param, meta, styles, scripts -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>绿色通道管理系统</title>

    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<!------------------------------------- JS部分--------------------------------->
<script>
    function check(a) {
        var temp;
        temp = a.value;
        M = document.getElementById(temp);
        if (a.checked == true) {
            if (temp == 'opt3') {
                document.getElementById('opt4').disabled = false;
            }
            M.disabled = false;
        } else {
            if (temp == 'opt3') {
                document.getElementById('opt4').disabled = true;
            }
            M.disabled = true;
        }
    };
    $(function() {
        $('#search').click(function() {

            $.ajax({ //第一个ajax 取得总记录数
                type: "POST",
                url: "search_car_info.php",
                data: $('#form').serialize(),

                dataType: 'json',
                success: function(json) {
                    var info = json.info;
                    var html = "";
                    $("#Allactivities tbody").html(html);
                    console.log(json);

                    for (var i = 0; i < info.length; i++) {
                        html += '<tr><td>' + info[i].E01 + '</td> <td>' + info[i].E02 + '</td><td>' + info[i].E04 + '</td><td>' + info[i].E07 + '</td><td>' + info[i].E08 + '</td><td>' + info[i].E10 + '</td><td>' + info[i].E11 + '</td><td>' + info[i].E14 + '</td><td>' + info[i].E15 + '</td></tr>';
                    }
                    $("#Allactivities tbody").html(html);

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                }
            });

        });
    });

    function printdiv(printpage) { //打印查询结果
        var newstr = printpage.innerHTML;
        var oldstr = document.body.innerHTML;
        document.body.innerHTML = newstr;
        window.print();
        document.body.innerHTML = oldstr;
        return false;
    }
    window.onload = function() {
        var bt = document.getElementById("pr");
        var div_print = document.getElementById("print_div");
        bt.onclick = function() {
            printdiv(div_print);
        }
    }

</script>
<!------------------------------------- 导航栏 --------------------------------->

<body class="bg">
    <nav class="navbar mynav" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <img id="mainlogo" src="tool_pic/logo.png" width='50' height='50'>
                <a class="navbar-brand" href="#">绿色通道</a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                    <li><a href="main.php">主页</a></li>
                    <li><a href="personnel_info.php">人员信息管理</a></li>
                    <li><a href="cargo_info.php">货物信息管理</a></li>
                    <li class="active"><a href="#">车辆信息管理</a></li>
                    <li><a href="print.php">打印报表</a></li>

                </ul>
            </div>
        </div>
    </nav>
    <!------------------------------------- 界面选择按钮 --------------------------------->
    <div class="btn-group">
        <button class="btn mybtn" onclick="window.location.href='car_info.php'">数据浏览</button>
        <button class="btn mybtn active">数据查询</button>
        <button class="btn mybtn" onclick="window.location.href='sta_car_info_form.php'">数据统计</button>
    </div>

    <!------------------------------------- 查询选项表单 --------------------------------->
    <div class="container">
        <form class="form-horizontal" role="form" method="POST" action="##" id="form">
            <div class="row">
                <div class="col-sm-6">
                    <div class="checkbox">
                        <label class="checkbox-inline col-sm-2">
                            <input class="col-sm-2" type="checkbox" id="box1" value="opt1" onclick="check(this)">车牌查询
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="opt1" id="opt1" disabled="true">
                        </div>
                    </div>
                    <br>
                    <div class="checkbox">
                        <label class="checkbox-inline col-sm-2">
                            <input class="col-sm-2" type="checkbox" id="box2" value="opt2" onclick="check(this)">车轴数
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="opt2" name="opt2" disabled>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="checkbox">
                        <label class="checkbox-inline col-sm-2">
                            <input class="col-sm-2" type="checkbox" id="box3" value="opt3" onclick="check(this)">时间查询
                        </label>
                        <div class="col-sm-4">
                            <label class="checkbox-inline col-sm-8">起始时间</label>
                            <input type="date" class="form-control" name="opt3" id="opt3" disabled>
                        </div>
                        <div class="col-sm-4 col-sm-offset-1">
                            <label class="checkbox-inline col-sm-8">终止时间</label>
                            <input type="date" class="form-control" name="opt4" id="opt4" disabled>
                        </div>
                    </div>
                </div>
                <!------------------------------------右侧----------------------------------------------->
                <div class="col-sm-6">
                    <div class="checkbox">
                        <label class="checkbox-inline col-sm-3">
                            <input class="col-sm-2" type="checkbox" id="box5" value="opt5" onclick="check(this)">入关收费站查询
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="opt5" id="opt5" disabled="disabled">
                        </div>
                    </div>
                    <br>
                    <div class="checkbox">
                        <label class="checkbox-inline col-sm-3">
                            <input class="col-sm-2" type="checkbox" id="box6" value="opt6" onclick="check(this)">货物类型查询
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="opt6" id="opt6" disabled>
                                <option>无货物000</option>
                                <option>白菜类001</option>
                                <option>甘蓝类002</option>
                                <option>根菜类003</option>
                                <option>绿叶菜类004</option>
                                <option>葱蒜类005</option>
                                <option>茄果类006</option>
                                <option>豆类007</option>
                                <option>瓜类008</option>
                                <option>水生蔬菜009</option>
                                <option>新鲜食用菌010</option>
                                <option>多年生和杂类蔬菜011</option>
                                <option>仁果类012</option>
                                <option>核果类013</option>
                                <option>浆果类014</option>
                                <option>柑橘类015</option>
                                <option>热带及亚热带水果016</option>
                                <option>什果类017</option>
                                <option>瓜果类018</option>
                                <option>水产品019</option>
                                <option>其它水产品020</option>
                                <option>家畜021</option>
                                <option>家禽022</option>
                                <option>其他023</option>
                                <option>024</option>
                                <option>025</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="checkbox">
                        <label class="checkbox-inline col-sm-3">
                            <input class="col-sm-2" type="checkbox" id="box7" value="opt7" onclick="check(this)">违规情况查询
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="opt7" id="opt7" disabled>
                                <option>1</option>
                                <option>0</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <br>
            <!---------------------------------------按钮-------------------------------------------->
            <div class="row btn-group col-sm-offset-5">
                <button type="button" class="btn mybtn" id="search">查询</button>
                <button type="button" class="btn mybtn hidden-xs" id="pr">打印报表</button>
            </div>
        </form>
        <br>
        <!------------------------------------- 查询结果显示 --------------------------------->
        <div id="print_div" style="overflow:scroll;">
            <table id="Allactivities" class="table text-center table-bordered blue">
                <thead>
                    <tr>
                        <th>车牌</th>
                        <th>通关时间</th>
                        <th>入关收费站</th>
                        <th>减免金额</th>
                        <th>是否违规</th>
                        <th>车型</th>
                        <th>货物</th>
                        <th>处罚金额</th>
                        <th>收费员</th>
                    </tr>
                </thead>
                <tbody></tbody>

            </table>
        </div>
    </div>

</body>

</html>
