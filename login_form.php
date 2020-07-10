<!doctype html>
<html lang="en">
	
<head>
<!-- param, meta, styles, scripts -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>欢迎登陆</title>
<link href="css/styles.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<script>
     window.onload = function(){
    var oForm = document.getElementById('form');
    var oUser = document.getElementById('num');
    var oPswd = document.getElementById('password');
    var oRemember = document.getElementById('save');
    //页面初始化时，如果帐号密码cookie存在则填充
    if(getCookie('num') && getCookie('password')){
      oUser.value = getCookie('num');
      oPswd.value = getCookie('password');
      oRemember.checked = true;
    }
    //复选框勾选状态发生改变时，如果未勾选则清除cookie
    oRemember.onchange = function(){
      if(!this.checked){
        delCookie('num');
        delCookie('password');
      }
    };
    //表单提交事件触发时，如果复选框是勾选状态则保存cookie
    oForm.onsubmit = function(){
      if(oRemember.checked){ 
        setCookie('num',oUser.value,7); //保存帐号到cookie，有效期7天
        setCookie('password',oPswd.value,7); //保存密码到cookie，有效期7天
      }
    };
  };
  //设置cookie
  function setCookie(name,value,day){
    var date = new Date();
    date.setDate(date.getDate() + day);
    document.cookie = name + '=' + value + ';expires='+ date;
  };
  //获取cookie
  function getCookie(name){
    var reg = RegExp(name+'=([^;]+)');
    var arr = document.cookie.match(reg);
    if(arr){
      return arr[1];
    }else{
      return '';
    }
  };
  //删除cookie
  function delCookie(name){
    setCookie(name,null,-1);
  };
</script>
<body class="bg1">
    <div class="container">
        <div class="text-center">
            <img id="logo" src="tool_pic/logo.png" width='100' height='100'>&nbsp;<div class='heading'>绿色通道管理系统</div></div>
       <div class="col-sm-6 col-sm-offset-3" id="login">
        <form action="login.php" method="POST" id='form' role="form" class="form-horizontal">
            <div class="form-group">
                <label for="num" class=" col-sm-3 control-label">编号:</label>
                <div class="col-sm-7 ">
                <input type="text" class="form-control main" id="num" name="num">
                </div>     
            </div>
            <br>
            <div class="form-group">
                <label for="password" class=" col-sm-3 control-label">密码:</label>
                <div class="col-sm-7">
                <input type="password" id="password" name="password" class="form-control main" >
                </div>
            </div>
             <br>
            <div class="checkbox">
              <label  class="checkbox-inline col-sm-offset-3 ">
              <input class="col-sm-4" type="checkbox" id="save" onclick="savePassword()">记住密码
              </label>
	       </div>
            <br>
           <div class="form-group">     
              <button type="submit" class="btn btn-primary  center-block bt" >登陆</button>
           </div>
    </form>    
    </div>
    </div>
</body>
</html>
