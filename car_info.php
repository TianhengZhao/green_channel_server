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
<!-------------------------------------------js部分，显示车辆信息，分页------------------------------------>
<script>
   get_car_info(); 
   function get_car_info(){
        $.ajax({                                      //第一个ajax 取得总记录数
            type:"POST",
            url:"get_car_info.php",
            data:{curpage:$('.pageCurrent').html(),pageSize:7},
            dataType: 'json',
            success:function(json){
            
                    
                    var total=json.total;//总记录数
                    var curp=1;//当前页
                    var opt;//选择框当前页
                    var perpage=7;//每页显示记录数
                    
                    
                    $(".totalRecords").html(total);//显示总记录数
                    $(".pageCurrent").html(curp);
            
                    
                    var option='';
                    //计算总页数
                    if(total % perpage==0){
                        opt=parseInt(total/perpage);
                        for(var i=1;i<=opt;i++){
                            option+='<option value'+i+'>'+i+'</option>';
                        }
                    }
                    else{
                        opt=parseInt(total/perpage)+1;
                        for(var i=1;i<=opt;i++){
                            option+='<option value'+i+'>'+i+'</option>';
                        }
                    }
                    $(".totalPages").text(opt);
                    $("#gotoPage").html(option);

            },
        });
    };
   
$("pages>li:first-child").addClass("active");
    var pc=$(".pageCurrent").html();
    
//获取select值    
function getId(value){
    pc=value;
    $(".pageCurrent").text(pc);
    systemActivity_list();  
};
//首页  
function first(){
   
    pc=1;
    $(".pageCurrent").text(pc);
    $("#gotoPage").val(pc);
    systemActivity_list(); 
};
    
//上一页
function prev(){
   
    if(parseInt($(".pageCurrent").text())>1){
        pc=parseInt($(".pageCurrent").text())-1;
    }
    else pc=1;
    $(".pageCurrent").text(pc);
    $("#gotoPage").val(pc);
    systemActivity_list(); 
};
//下一页
function next(){
   
    if(parseInt($(".pageCurrent").text())<parseInt($(".totalPages").text())){
        pc=parseInt($(".pageCurrent").text())+1;
    }
    else pc=$(".totalPages").text();
    $(".pageCurrent").text(pc);
    $("#gotoPage").val(pc);
    systemActivity_list(); 
};
//末页
function last(){
    
    pc=$(".totalPages").text();
    $(".pageCurrent").text(pc);
    $("#gotoPage").val(pc);
    systemActivity_list(); 
    
};                  
  
var pic;//存储图片路径
function systemActivity_list(){  //第二个ajax 获取新一页记录
    $.ajax({
            type:"POST",
            url:"get_car_info.php",
            data:{curpage:$('.pageCurrent').html(),pageSize:7},
            dataType: 'json',     
            success:function(json){ 
                
                 var info = json.info;
                    var html="";
                
             for(var i=0;i<info.length;i++){                          
                    html+='<tr><td>'+info[i].E01+'</td> <td>'+info[i].E02+'</td><td>'+info[i].E04+'</td><td>'+info[i].E07+'</td><td>'+info[i].E10+'</td><td>'+info[i].E11+'</td><td>'+info[i].E14+'</td><td>'+info[i].E15+'</td></tr>';
                    }
                   $("#Allactivities tbody").html(html);
                },
         error: function (e) {
            alert("Error!" + e.responseText);
        }   
});};
   $(function(){systemActivity_list();});
</script>
<!------------------------------------- 导航栏 ---------------------------------> 
<body class="bg">
<nav class="navbar mynav" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
           <button type="button"  class=" navbar-toggle" data-toggle="collapse"
				data-target="#example-navbar-collapse" style="background-color:#eee;">
			<span class="sr-only">切换导航</span>
			<span class="icon-bar" style="background-color:gray;"></span>
			<span class="icon-bar" style="background-color:gray;"></span>
			<span class="icon-bar" style="background-color:gray;"></span>
            
            
		</button>
          
          
          <img  id="mainlogo" src="tool_pic/logo.png" width='50' height='50'>
          &nbsp;&nbsp;
           <a class="navbar-brand " href="#">绿色通道管理系统</a>
      </div>
      <div class="collapse navbar-collapse" id="example-navbar-collapse">
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
  <!------------------------------------- 人员信息界面 ---------------------------------> 
    <div class="btn-group">
  <button class="btn mybtn active">数据浏览</button>  
        
   <button class="btn mybtn" onclick="window.location.href='search_car_info_form.php'">数据查询</button>  
  <button class="btn mybtn" onclick="window.location.href='sta_car_info_form.php'">数据统计</button>  
        </div>
    <br>
    <br>
<table id ="Allactivities"class ="table text-center table-bordered blue">          
    <thead>                  
        <tr>                                            
            <th>车牌</th>                      
            <th>通关时间</th> 
            <th>入关收费站</th>
            <th>减免金额（元）</th>
            <th>车重（吨）</th>
            <th>货物</th>
            <th>处罚金额（元）</th>
            <th>收费员</th>
        </tr>
    </thead>          
    <tbody></tbody>          
    <tfoot>                  
        <tr>                       
            <td class="center" nowrap ="true" colspan="8">  
                <div id="page_turn" >
                    共<span class="totalRecords"></span>条记录&nbsp;
                    共<span class="totalPages"></span>页&nbsp;
                    当前第<span class="pageCurrent"></span>页&nbsp;
                 <span>
                   <a href='#' id="firstPage" onclick="first()">首页</a>
                     <a href='#' id="prevPage" onclick="prev()">上一页</a>
                     <a href='#' id="nextPage" onclick="next()">下一页</a>
                     <a href='#' id="lastPage" onclick="last()">末页</a>
                     <select id="gotoPage" onchange="getId(value)"></select>
                    </span>  
                   
                </div>   
            </td>
        </tr>
    </tfoot>
    </table>  
    </body>
</html>