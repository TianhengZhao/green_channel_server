<!DOCTYPE html>
<html lang="en">
<!----------------连接数据库，检查权限---------------------------->
<?php include("conn/conn.php");
  include("conn/auth_op.php");  
?>	
<head>
<!-- param, meta, styles, scripts -->
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>绿色通道管理系统</title>
<link rel="stylesheet" href="bootstrap-fileinput-master/css/fileinput.min.css" rel="stylesheet">
    <script rel="stylesheet" href="bootstrap-fileinput-master/js/fileinput.min.js"></script>
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
    </script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<!-------------------------------js部分----------------------------------------->
 <script>
     function imgPreview(fileDom,i) {        //判断是否支持FileReader     
         if(window.FileReader) {           
             var reader = new FileReader();  
         } 
         else {           
             alert("您的设备不支持图片预览功能，如需该功能请升级您的设备！");       
         }        //获取文件  
         var file = fileDom.files[0]; 
         console.log(file);
         if(window.FileReader) {              
             var fr = new FileReader();               
             fr.onloadend = function(e) {                     
                 document.getElementById("show").src = e.target.result;   //预览图片          
             };                  
             fr.readAsDataURL(file);  //也是利用将图片作为url读出          
         } 
        
     }
</script>
    
<body class="bg">
    <h3 class="header">添加新人员信息</h3>
<div class="container">
  <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="add_personnel.php" name="form1">
<!-------------------------------左侧信息输入---------------------------------------->
    <div class="row">
      <div class="col-sm-7">
	<div class="form-group">
		<label for="newname" class="col-sm-2 control-label">名字</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="newname" name="newname">
		</div>
	</div>
      
	<div class="form-group">
		<label for="newnumber" class="col-sm-2 control-label">编号</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="newnumber" name="newnumber">
		</div>
	</div> 
      
    <div class="form-group">
      <label for="inputPassword" class="col-sm-2 control-label">密码</label>
      <div class="col-sm-5">
        <input type="password" class="form-control" id="inputPassword" placeholder="请输入密码" name="password">
      </div>
    </div>
    <div class="radio form-group">
        <label class="col-sm-2 control-label">性别</label>
        <label class="radio-inline">
          <input type="radio" name="sex" id="optionsRadios1" value="1"  checked >男
        </label>
        <label class="radio-inline">
        <input type="radio" name="sex" id="optionsRadios2"  value="0">女
        </label>
          </div>
          <br>
    <div class="form-group">
        <label class="col-sm-2 control-label">出生日期</label>
        <div class="col-sm-5">
            <input type="date" class="form-control" name="birthday">
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
<!---------------------------------右侧照片上传-------------------------------------->
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
    <input id="input_file" name="input_file"  onchange="imgPreview(this,0)" type="file" accept='image/png, image/jpeg, image/jpg, image/svg, image/gif'>
    <label for="input_file" class='btn mybtn'>选择图片</label> 
    <br>
    <br>
    <img src="" id="show" class="col-sm-6 col-xs-6">

</div>
    
  </div>     
<!--------------------------------按钮---------------------------------------->
    <div class="row btn-group col-sm-offset-5">
    <button type="submit" class="btn  mybtn btn-lg" onclick="save()">保存</button>
      <button type="button" class="btn mybtn btn-lg" onclick="history.back()">取消</button>
    </div>
      
      
       </form>
    </div>

    </body>
</html>