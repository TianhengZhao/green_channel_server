<!--------------------------------------------修改人员信息主界面--------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<!----------------连接数据库,判断是否有操作权限---------------------------->
<?php include("conn/conn.php");
   include("conn/auth_op.php");   
?>	
<head>
<!-- param, meta, styles, scripts -->
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>绿色通道管理系统</title>

   
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
    </script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<!-------------------------------js部分 ----------------------------------------->
 <script>
     function imgPreview(fileDom) {        //判断是否支持FileReader     
         if(window.FileReader) {           
             var reader = new FileReader();  
         } 
         else {           
             alert("您的设备不支持图片预览功能，如需该功能请升级您的设备！");       
         }        //获取文件  
         var file = fileDom.files[0];      
         if(window.FileReader) {              
             var fr = new FileReader();               
             fr.onloadend = function(e) {                     
                 document.getElementById("show").src = e.target.result;             
             };                  
             fr.readAsDataURL(file);  //也是利用将图片作为url读出          
         } 
        
     };
  //获得url中的参数   
 function GetRequest() {
             var url = location.search; //获取url中"?"符后的字串
             var theRequest = new Object();
             if (url.indexOf("?") != -1) {
                 var str = url.substr(1);
                 strs = str.split("&");
                 for(var i = 0; i < strs.length; i ++) {
                     theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
                 }
             }
             return theRequest;
         };
     
var num=GetRequest().number;
     
     get_info();  
     function get_info(){
          $.ajax({                                      
            type:"POST",
            url:"change_cargo.php",
            data:{number:num},                              //将得到的编号作为数据传入到php中    需修改为按钮参数
            dataType: 'JSON',
            success:function(json){
                 var info=json;  
                $("#number_ori").val(num);
                
               $("#name").val(info['A02']);
                $("#number").val(info['A01']);
                $("#var").val(info['A03']);
                 $("#sort").val(info['A04']);
                $("#water").val(info['A05']);
                $("#density").val(info['A06']);
                document.getElementById('show').src=info['A07'];               
            },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert(XMLHttpRequest.status);
                        alert(XMLHttpRequest.readyState);
                        alert(textStatus);
                    }
          });
     };
</script>
    
<body class="bg">
    <h3 class="header">修改菜品信息</h3>
<div class="container">
  <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="save_changed_cargo.php" name="form1">
<!-------------------------------左侧信息输入---------------------------------------->
    <div class="row">
      <div class="col-sm-7">
         <input type="hidden" class="form-control" id="number_ori" name="number_ori" >
          <div class="form-group">
		    <label for="number" class="col-sm-2 control-label">编号</label>
		    <div class="col-sm-5">
			  <input type="text" class="form-control" id="number" name="number" >
		    </div>
	      </div> 
          
	      <div class="form-group">
		    <label for="name" class="col-sm-2 control-label">农产品学名</label>
		    <div class="col-sm-5">
			  <input type="text" class="form-control" id="name" name="name">
		    </div>
	      </div>
          
          <div class="form-group">
		    <label for="var" class="col-sm-2 control-label">产品种类</label>
		    <div class="col-sm-5">
			  <input type="text" class="form-control" id="var" name="var">
		    </div>
	      </div>
          
           <div class="form-group">
		    <label for="sort" class="col-sm-2 control-label">类别代码</label>
		    <div class="col-sm-5">
			  <input type="text" class="form-control" id="sort" name="sort">
		    </div>
	      </div>
           
           <div class="form-group">
		    <label for="water" class="col-sm-2 control-label">含水量（%）</label>
		    <div class="col-sm-5">
			  <input type="text" class="form-control" id="water" name="water">
		    </div>
	      </div>
          
           <div class="form-group">
		    <label for="density" class="col-sm-2 control-label">密度（g/cm³）</label>
		    <div class="col-sm-5">
			  <input type="text" class="form-control" id="density" name="density">
		    </div>
	      </div>   
    </div>
<!---------------------------------右侧-------------------------------------->
<div class="col-sm-5">
    <input id="input_file" name="input_file" type="file" onchange="imgPreview(this)" accept='image/png, image/jpeg, image/jpg, image/svg, image/gif'>
    <label for="input_file" class='btn mybtn ' >重选图片</label> 
    <br>
    <br>
    <img src="" id="show" name="show" class="col-sm-6 col-xs-6">

</div>
    
  </div>     
<!--------------------------------按钮---------------------------------------->
    <div class="row btn-group col-sm-offset-5">
    <button type="submit" class="btn mybtn btn-lg">保存</button>
      <button type="button" class="btn mybtn btn-lg" onclick="history.back()">取消</button>
    </div>
      
      
       </form>
    </div>

    </body>