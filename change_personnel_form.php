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
     function imgPreview(fileDom,i) { 
         
         var file = fileDom.files[0]; 
         console.log(file);
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
         }
     get_info();  
     function get_info(){
          $.ajax({                                      
            type:"POST",
            url:"change_personnel.php",
            data:{number:GetRequest().number},                              //将得到的编号作为数据传入到php中 
            dataType: 'JSON',
            success:function(json){
                 var info=json;          
               $("#name").val(info['F02']);
                $("#number").val(info['F01']);
                 $("#number0").val(info['F01']);
                $("#password").val(info['F07']);
                var i=info['F05'];
                document.form1.sex[i].checked=true;
                                
                
                $("#birthday").val(info['F06']);
                $("#position").val(info['F03']);
                $("#auth").val(info['F04']);
                $("#memo").text(info['F09']);
               document.getElementById('show').src=info['F08'];             
            },
        
          });
     };
</script>
    
<body class="bg">
    <h3 class="header">修改人员信息</h3>
<div class="container">
  <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="save_changed_personnel.php" name="form1">
<!-------------------------------左侧信息输入---------------------------------------->
    <div class="row">
      <div class="col-sm-7">
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label">名字</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="name" name="name">
		</div>
	</div>
    
	<div class="form-group">
		<label for="number" class="col-sm-2 control-label">编号</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="number0" name="number0" disabled>
		</div>
	</div> 
    <input type="hidden" class="form-control" id="number" name="number" >     
    <div class="form-group">
      <label for="inputPassword" class="col-sm-2 control-label">密码</label>
      <div class="col-sm-5">
        <input type="password" class="form-control" id="password" placeholder="请输入密码" name="password">
      </div>
    </div>
    <div class="radio form-group">
        <label class="col-sm-2 control-label">性别</label>
        <label class="radio-inline">
          <input type="radio" name="sex" id="optionsRadios1" value="1"  >男
        </label>
        <label class="radio-inline">
        <input type="radio" name="sex" id="optionsRadios2"  value="2">女
        </label>
          </div>
          <br>
    <div class="form-group">
        <label class="col-sm-2 control-label">出生日期</label>
        <div class="col-sm-5">
            <input type="date" class="form-control" name="birthday" id="birthday">
        </div>
    </div>
    
    <div class="form-group">
      <label for="position" class="col-sm-2 control-label">职务</label>
      <div class="col-sm-5">
        <select class="form-control" name="position" id="position">
          <option value="00">站长</option>
          <option value="01">副站长</option>
          <option value="02">前亭收费员</option>
        <option value="03">后亭验货员</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="memo" class="col-sm-2 control-label">备注</label>
        <div class="col-sm-5">
          <textarea class="form-control" rows="3" name="memo" id="memo"></textarea>
        </div>
    </div>  
    </div>
<!---------------------------------右侧-------------------------------------->
<div class="col-sm-5">
     <div class="form-group">
      <label for="auth" class="col-sm-2 control-label">权限</label>
    <div class="col-sm-6">
        <select class="form-control" name="auth" id="auth">
          <option value="00">操作、查看</option>
          <option value="01">仅查看</option>
          <option value="02">无</option>
        </select>
      </div>
    </div>
    <br>
    <br>
    <input id="input_file" name="input_file" onchange="imgPreview(this,0)" type="file" accept='image/png, image/jpeg, image/jpg, image/svg, image/gif'>
    <label for="input_file" class='btn mybtn '>重选图片</label> 
    <br>
    <br>
    <img src="" id="show" class="col-sm-6 col-xs-6">

</div>
  
  </div>     
<!--------------------------------按钮---------------------------------------->
      <br> 
        <br>
    <div class="row btn-group col-sm-offset-5 col-xs-offset-5">
    <button type="submit" class="btn mybtn btn-lg">保存</button>
      <button type="button" class="btn mybtn btn-lg" onclick="history.back()">取消</button>
    </div>
      
      
       </form>
    </div>

    </body>