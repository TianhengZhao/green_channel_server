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
    
</head>
<!-------------------------------------------js部分，显示人员信息，分页------------------------------------>
<script>
   get_personnel_info(); 
   function get_personnel_info(){
        $.ajax({                                      //第一个ajax 取得总记录数
            type:"POST",
            url:"get_personnel_info.php",
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
  

function systemActivity_list(){  //第二个ajax 获取新一页记录
    $.ajax({
            type:"POST",
            url:"get_personnel_info.php",
            data:{curpage:$('.pageCurrent').html(),pageSize:7},
            dataType: 'json',     
            success:function(json){ 
                 var info = json.info;
                    var html="";     
             for(var i=0;i<info.length;i++){
                      pic_src=info[i].F08;
                     if(info[i].F05==0) {info[i].F05="男";}
                        else{info[i].F05="女";   }                           
                    html+='<tr><td>'+info[i].F01+'</td> <td>'+info[i].F02+'</td><td>'+info[i].F03+'</td><td>'+info[i].F04+'</td><td>'+info[i].F05+'</td><td>'+info[i].F06+'</td><td>'+info[i].F07+'</td><td><button class="btn mybtn" onclick="change(this)">修改</button><button class="btn mybtn deletedData" onclick="del(this)">删除</button></td></tr>';
                    }
                   $("#Allactivities tbody").html(html);
                },
         error: function (e) {
            alert("Error!" + e.responseText);
        }   
});};
    $(function(){systemActivity_list();});
    
    function change(a){          //修改数据按钮
        var index=a.parentNode.parentNode.rowIndex;
        var table=document.getElementById('Allactivities');
        var num= table.rows[index].cells[0].innerHTML;
        window.location.href='change_personnel_form.php?number='+num;                //修改函数 需要一个参数
    };
    function add(){              //添加数据按钮
         window.location.href='add_personnel_form.php'; 
    };
    function del(a){            //删除数据按钮
        var index=a.parentNode.parentNode.rowIndex;
        var table=document.getElementById('Allactivities');
         var num= table.rows[index].cells[0].innerHTML;
        table.deleteRow(index);//删除页面显示信息
         $.ajax({               //删除数据库中对应信息
            type:"POST",
            url:"delete_personnel_info.php",
            data:{number:num},
            dataType: 'json',     
            success:function(json){ 
                var page=$(".totalRecords").html();//修改修改记录个数
                $(".totalRecords").html(page-1);
                if(json.result==true){alert("删除失败");}
               
            }
         });
    };
</script>
<body class="bg">
<!------------------------------------- 导航栏 --------------------------------->  
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
            <li class="active"><a href="#">人员信息管理</a></li>
            <li><a href="cargo_info.php">货物信息管理</a></li>
            <li><a href="car_info.php">车辆信息管理</a></li>
            <li><a href="print.php">打印报表</a></li>
        </ul>
    </div>
    </div>
</nav>
 <!------------------------------------- 人员信息界面 ---------------------------------> 
    <div>
  <button class="btn mybtn" onclick="add()">添加新人员信息</button>  
        </div>
    <br>
    <img  src="" id="image" />
<table id ="Allactivities"class ="table table-hover text-center table-bordered blue">          
    <thead>                  
        <tr>                                            
            <th>编号</th>                      
            <th>姓名</th> 
            <th>职务</th>
            <th>权限</th>
            <th>性别</th>
            <th>出生日期</th>
            <th>密码</th>
            <th>操作</th>
        </tr>
    </thead>          
    <tbody></tbody>          
    <tfoot>                  
        <tr>                       
            <td class="center" nowrap ="true" colspan="8">  
                <div id="page_turn" >
                    共<span class="totalRecords"></span>人&nbsp;
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