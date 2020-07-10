<!DOCTYPE html>
<!----------------连接数据库，打开session会话---------------------------->

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
<script>
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
    }
    var date = GetRequest().date;
    var time = GetRequest().time;
    get_info();

    function get_info() {
        $.ajax({
            type: "POST",
            url: "final_print_info.php",
            data: {
                date: date,
                time: time
            }, //将得到的编号作为数据传入到php中    需修改为按钮参数
            dataType: 'JSON',
            success: function(json) {
                info = json;
                var html = '<tr><td>入关时间：' + date + ' ' + time + '</td> <td>货物：' + info[1] + '</td></tr><tr><td>收费员：' + info[3] + '</td><td>入关收费站:' + info[0] + '</td></tr><tr><td>罚款金额:' + info[4] + '元' +
                    '</td></tr><tr><td>透视图像' + info[2] + '</td></tr>';
                $("#final tbody").html(html);


            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(XMLHttpRequest.status);
                alert(XMLHttpRequest.readyState);
                alert(textStatus);
            }
        });
    };

    function printdiv(printpage) { //打印查询结果
        var newstr = printpage.innerHTML;
        var oldstr = document.body.innerHTML;
        document.body.innerHTML = newstr;
        window.print();
        document.body.innerHTML = oldstr;
        return false;
    };
    window.onload = function() {
        var bt = document.getElementById("pr");
        var div_print = document.getElementById("table");
        bt.onclick = function() {
            printdiv(div_print);
        };
    };

</script>

<body>
    <div id="table">
        <h3 id="print_head" class="">吉林省高速公路绿色通道违规车辆罚款报告单</h3>

        <table class="table text-center table-bordered blue" id='final'>

            <tbody>


            </tbody>
        </table>
    </div>
    <button type="button" class="btn mybtn col-sm-offset-4 col-xs-offset-4 hidden-xs" id="pr">打印</button>

</body>

</html>
