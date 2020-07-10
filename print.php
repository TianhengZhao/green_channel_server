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
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
    </script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <!-------------------------------------------js部分，显示人员信息，分页------------------------------------>
<script>
   $(document).ready(function(){
      var myDate = new Date();
      var today=myDate.toLocaleDateString();//今天日期
      document.getElementById("print_date").innerHTML='打印日期：'+today;
  
        $.ajax({                                      //第一个ajax 取得总记录数
            type:"POST",
            url:"get_print.php",
            data:{},
            dataType: 'json',
            success:function(json){
                 var info = json;
                    var html="";
                
             for(var i=0;i<info.length;i++){                          
                    html+='<tr><td>'+info[i].E01+'</td> <td>'+info[i].E02+'</td><td>'+info[i].E04+'</td><td>'+info[i].E07+'</td><td>'+info[i].E10+'</td><td>'+info[i].E11+'</td><td>'+info[i].E14+'</td><td>'+info[i].E15+'</td></tr>';
                    }
                   $("#Allactivities tbody").html(html);
            }
        });
 });  
     function printdiv(printpage){                           //打印查询结果
　　　　　　var newstr = printpage.innerHTML; 
　　　　　　var oldstr = document.body.innerHTML; 
　　　　　　document.body.innerHTML =newstr; 
　　　　　　window.print(); 
　　　　　　document.body.innerHTML=oldstr; 
　　　　　　return false; 
　　　　} ;
window.onload=function(){
　　　　　　var bt=document.getElementById("pr");
　　　　　　var div_print=document.getElementById("div_print");
　　　　　　bt.onclick=function(){
　　　　　　　　printdiv(div_print);
　　　　　　};
　　　　};

    </script>
</head>
<body>
    <br>
<div class="col-sm-3 btn-group">
<button type="button" class="btn mybtn hidden-xs" id="pr">打印统计数据</button>
<button type="button" class="btn mybtn " onclick="history.back()">取消</button>
</div>
<br>
<div id="div_print">
<h3 id="print_head" class="">吉林省收费站绿色通道情况登记表</h3>
    <h5 id="print_date"class="col-sm-offset-10 col-xs-offset-9"></h5>
<table id ="Allactivities"class ="table text-center table-bordered blue">          
    <thead>                  
        <tr>                                            
            <th>车牌</th>                      
            <th>通关时间</th> 
            <th>入关收费站</th>
            <th>减免金额</th>
            <th>车重</th>
            <th>货物</th>
            <th>处罚金额</th>
            <th>收费员</th>
        </tr>
    </thead>          
    <tbody></tbody>   
    </table>
</div>
</body>
</html>