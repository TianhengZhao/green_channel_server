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

<link rel="stylesheet" href="bootstrap-3.3.7-dist/bootstrap-3.3.7-dist/css/bootstrap.min.css"> 
    
	<script src="jquery/jquery-3.4.1.min.js"></script>
     <script src="Highcharts-7.2.0/code/highcharts.js"></script>
	<script src="bootstrap-3.3.7-dist/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<!-------------------------------------js部分------------------------------------->
<script>
    $(document).ready(function(){
        time();
    });
/*-----------------------------------按时间统计-----------------------------------*/
function time(){
       time_date();
      document.getElementById('option').innerHTML='<div class="radio-inline"><label><input type="radio" name="time_radios" id="optionsRadios1" value="date" onclick="time_date()" checked>按日期统计 </label></div><div class="radio-inline"><label><input type="radio" name="time_radios" id="optionsRadios2" onclick="time_week()" value="week" >按星期统计</label></div><div class="radio-inline"><label><input type="radio" name="time_radios" id="optionsRadios3" onclick="time_month()" value="month"> 按月份统计</label></div>'  ;
     
};
 /*-----------------------------------按时间-日期统计-----------------------------------*/
function time_date(){                                 
    var myDate = new Date();
    var today=myDate.toLocaleDateString();//今天日期
    var info0=new Array;
    var info1=new Array;
        var info2=new Array;
      $.ajax({                                  //获得坐标                                  
            type:"POST",
            url:"get_sta_info1.php",
            async:false,
            data:{},                              
            dataType: 'JSON',
            success:function(json){ 
               info0=json[0];
                info1=json[1];
                info2=json[2];
            }
      });
     var xAxis = {
      categories: [getNextDate(today, -9),getNextDate(today, -8),getNextDate(today, -7),getNextDate(today, -6),getNextDate(today, -5),getNextDate(today, -4),getNextDate(today, -3),getNextDate(today, -2),getNextDate(today, -1),today]//横坐标
   };
      var title = {                          //标题
      text: '按日期统计绿通情况'   
   };
   var subtitle = {                            //副标题
      text: 'Green channel statistics by date'
   };
   
    var yAxis = {                               //纵轴
      title: {
         text: '车辆个数'
      },
      plotLines: [{
         value: 0,
         width: 1,
         color: '#808080'
      }],
    allowDecimals:false
   }; 

  var tooltip = {                                //纵轴单位
      valueSuffix: '辆'
   };

   var legend = {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
   };
 
   var series =  [                                //坐标点
       {
         name: '违规车辆数',
         data:[info0['10'],info0['9'],info0['8'],info0['7'],info0['6'],info0['5'],info0['4'],info0['3'],info0['2'],info0['1']]
      }, 
      {
         name: '绿通车辆数',
         data: [info2['10'],info2['9'],info2['8'],info2['7'],info2['6'],info2['5'],info2['4'],info2['3'],info2['2'],info2['1']]
      },
      {
         name: '总通过车辆数',
         data: [info1['10'],info1['9'],info1['8'],info1['7'],info1['6'],info1['5'],info1['4'],info1['3'],info1['2'],info1['1']]
      }
      
   ];

   var json = {};

   json.title = title;
   json.subtitle = subtitle;
   json.xAxis = xAxis;
   json.yAxis = yAxis;
   json.tooltip = tooltip;
   json.legend = legend;
   json.series = series;

   $('#chart').highcharts(json);
}; 
/*-----------------------------------按时间-星期统计------------------------------------*/  
function time_week(){
     var myDate = new Date();
    var today=myDate.toLocaleDateString();//今天日期
    var thisweek=myDate.getDay();
    var info0=new Array;
    var info1=new Array;
        var info2=new Array;
      $.ajax({                                  //获得坐标                                  
            type:"POST",
            url:"get_sta_info1-1.php",
            async:false,
            data:{},                              
            dataType: 'JSON',
            success:function(json){ 
               info0=json[0];
                info1=json[1];
                info2=json[2];
               
            }
      });
     var xAxis = {
      categories: [getNextDate(today, (-1)*thisweek-27)+'-'+getNextDate(today, (-1)*thisweek-21),
                   getNextDate(today, (-1)*thisweek-20)+'-'+getNextDate(today, (-1)*thisweek-14),
                   getNextDate(today, (-1)*thisweek-13)+'-'+getNextDate(today, (-1)*thisweek-7),
                   getNextDate(today, (-1)*thisweek-6)+'-'+getNextDate(today, (-1)*thisweek),
                   getNextDate(today, (-1)*thisweek+1)+'-'+today  ]//横坐标
   };
      var title = {                          //标题
      text: '按星期统计绿通情况'   
   };
   var subtitle = {                            //副标题
      text: 'Green channel statistics by week'
   };
   
    var yAxis = {                               //纵轴
      title: {
         text: '车辆个数'
      },
      plotLines: [{
         value: 0,
         width: 1,
         color: '#808080'
      }],
    allowDecimals:false
   }; 

  var tooltip = {                                //纵轴单位
      valueSuffix: '辆'
   };

   var legend = {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
   };
 
   var series =  [                                //坐标点
       {
         name: '违规车辆数',
         data:[info0['4'],info0['3'],info0['2'],info0['1'],info0['0']]
      }, 
      {
         name: '绿通车辆数',
         data: [info2['4'],info2['3'],info2['2'],info2['1'],info2['0']]
      },
      {
         name: '总通过车辆数',
         data: [info1['4'],info1['3'],info1['2'],info1['1'],info1['0']]
      }
      
   ];

   var json = {};

   json.title = title;
   json.subtitle = subtitle;
   json.xAxis = xAxis;
   json.yAxis = yAxis;
   json.tooltip = tooltip;
   json.legend = legend;
   json.series = series;

   $('#chart').highcharts(json);
};
/*-----------------------------------按时间-月份统计------------------------------------*/  
function time_month(){
     var myDate = new Date();
    var month=myDate.getMonth();
    var info0=new Array;
    var info1=new Array;
    var info2=new Array;
      $.ajax({                                  //获得坐标                                  
            type:"POST",
            url:"get_sta_info1-2.php",
            async:false,
            data:{},                              
            dataType: 'JSON',
            success:function(json){ 
               info0=json[0];
                info1=json[1];
                info2=json[2];
            },
           error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert(XMLHttpRequest.status);
                        alert(XMLHttpRequest.readyState);
                        alert(textStatus);
                    }
      });
    var mon=new Array;
    for(var i=0;i<5;i++){
        if(month==0) month=12;
        mon[i]=month;
        month=mon[i]-1;
    }
    
   var xAxis = {
      categories: [ mon[4]+'月', mon[3]+'月', mon[2]+ '月',  mon[1]+'月', mon[0]+'月','本月']//横坐标
   };
      var title = {                          //标题
      text: '按月份统计绿通情况'   
   };
   var subtitle = {                            //副标题
      text: 'Green channel statistics by month'
   };
   
    var yAxis = {                               //纵轴
      title: {
         text: '车辆个数'
      },
      plotLines: [{
         value: 0,
         width: 1,
         color: '#808080'
      }],
    allowDecimals:false
   }; 

  var tooltip = {                                //纵轴单位
      valueSuffix: '辆'
   };

   var legend = {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
   };
 
   var series =  [                                //坐标点
       {
         name: '违规车辆数',
         data:[info0['5'],info0['4'],info0['3'],info0['2'],info0['1'],info0['0']]
      }, 
      {
         name: '绿通车辆数',
         data: [info2['5'],info2['4'],info2['3'],info2['2'],info2['1'],info2['0']]
      },
      {
         name: '总通过车辆数',
         data: [info1['5'],info1['4'],info1['3'],info1['2'],info1['1'],info1['0']]
      }
      
   ];

   var json = {};

   json.title = title;
   json.subtitle = subtitle;
   json.xAxis = xAxis;
   json.yAxis = yAxis;
   json.tooltip = tooltip;
   json.legend = legend;
   json.series = series;

   $('#chart').highcharts(json);
};
 //按入口收费站统计-------------------------------------------------------------------  
function toll(){
     document.getElementById('option').innerHTML='';
      $.ajax({                                  //获得坐标                                  
            type:"POST",
            url:"get_sta_info2.php",
            async:false,
            data:{},                              
            dataType: 'JSON',
            success:function(json){ 
               
                info=json; 
               
            }
      });
    var chart = {
      type: 'column'
   };

     var xAxis = {
      categories: ['1','2'],//横坐标
        crosshair: true

   };
      var title = {                          //标题
      text: '按入关收费站统计绿通情况'   
   };
   var subtitle = {                            //副标题
      text: 'Green channel statistics by entry gate'
   };
   
    var yAxis = { //纵轴
         min: 0,
          

      title: {
         text: '车辆个数'
      },
   }; 

  var tooltip = {                                //纵轴单位
       headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
         '<td style="padding:0"><b>{point.y} 辆</b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true

   };

   var plotOptions = {
      column: {
         pointPadding: 0.2,
         borderWidth: 0
      }
   };  
   var credits = {
      enabled: false
   };

 
   var series =  [                                //坐标点
       {
         name: '违规车辆数',
         data:[info[0],info[2]]
      }, 
      {
         name: '绿通车辆数',
         data: [info[1],info[3]]
      }
    
   ];

   var json = {};

   json.chart = chart; 
   json.title = title;   
   json.subtitle = subtitle; 
   json.tooltip = tooltip;
   json.xAxis = xAxis;
   json.yAxis = yAxis;  
   json.series = series;
   json.plotOptions = plotOptions;  
   json.credits = credits;
   


   $('#chart').highcharts(json);
    };
//按货物类型统计-------------------------------------------------------------------  
function cargotype(){
        document.getElementById('option').innerHTML='';
         $.ajax({                                  //获得坐标                                  
            type:"POST",
            url:"get_sta_info3.php",
            async:false,
            data:{},                              
            dataType: 'JSON',
            success:function(json){ 
               
                info0=json[0]; //绿通
                info1=json[1]; //违规
               
            }
      });
    var chart = {
      type: 'column'
   };

     var xAxis = {
      categories: [
       "白菜类001",
        "甘蓝类002",
        "根菜类003",
         "绿叶菜类004",
        "葱蒜类005",
        "茄果类006",
         "豆类007",
         "瓜类008",
         "水生蔬菜009",
         "多年生和杂类蔬菜011",
         "仁果类012",
         "核果类013",
         "浆果类014",
        "柑橘类015",
         "热带及亚热带水果016",
        "什果类017",
         "瓜果类018",
        "水产品019",
         "其它水产品020",
         "家畜021",
         "家禽022",
         "其他023",
        "024",
        "025" ],//横坐标
        crosshair: true

   };
      var title = {                          //标题
      text: '按货物类型统计绿通情况'   
   };
   var subtitle = {                            //副标题
      text: 'Green channel statistics by cargo type'
   };
   
    var yAxis = { //纵轴
         min: 0,
          

      title: {
         text: '车辆个数'
      },
   }; 

  var tooltip = {                                //纵轴单位
       headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
         '<td style="padding:0"><b>{point.y} 辆</b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true

   };

   var plotOptions = {
      column: {
         pointPadding: 0.2,
         borderWidth: 0
      }
   };  
   var credits = {
      enabled: false
   };

 
   var series =  [                                //坐标点
       {
         name: '违规车辆数',
         data:[info0[1],info0[2],info0[3],info0[4],info0[5],info0[6],info0[7],info0[8],info0[9],info0[10],info0[11],info0[12],info0[13],info0[14],info0[15],info0[16],info0[17],info0[18],info0[19],info0[20],info0[21],info0[22],info0[23],info0[24],info0[25]]
      }, 
      {
         name: '绿通车辆数',
         data: [info1[1],info1[2],info1[3],info1[4],info1[5],info1[6],info1[7],info1[8],info1[9],info1[10],info1[11],info1[12],info1[13],info1[14],info1[15],info1[16],info1[17],info1[18],info1[19],info1[20],info1[21],info1[22],info1[23],info1[24],info1[25]]
      }
    
   ];
   var json = {};
   json.chart = chart; 
   json.title = title;   
   json.subtitle = subtitle; 
   json.tooltip = tooltip;
   json.xAxis = xAxis;
   json.yAxis = yAxis;  
   json.series = series;
   json.plotOptions = plotOptions;  
   json.credits = credits;
   $('#chart').highcharts(json);
    };
//按车型统计------------------------------------------------------------------- 
function cartype(){
    document.getElementById('option').innerHTML='';
     $.ajax({                                  //获得坐标                                  
            type:"POST",
            url:"get_sta_info4.php",
            async:false,
            data:{},                              
            dataType: 'JSON',
            success:function(json){ 
               info=json;              
            }
      });
     var xAxis = {
      categories: ['大型普通货车','中型普通货车','小型普通货车','大型厢式货车','中型厢式货车','小型厢式货车','大型封闭货车','中型封闭货车','小型封闭货车','大型罐式货车','中型罐式货车','小型罐式货车','大型平板货车','中型平板货车','小型平板货车','大型集装厢车','中型集装厢车','小型集装厢车']//横坐标
   };
      var title = {                          //标题
      text: '按车型统计绿通情况'   
   };
   var subtitle = {                            //副标题
      text: 'Green channel statistics by vehicle model'
   };
   
    var yAxis = {                               //纵轴
      title: {
         text: '车辆个数'
      },
      plotLines: [{
         value: 0,
         width: 1,
         color: '#808080'
      }],
    allowDecimals:false
   }; 

  var tooltip = {                                //纵轴单位
      valueSuffix: '辆'
   };

   var legend = {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
   };
 
   var series =  [                                //坐标点
      
      {
         name: '绿通车辆数',
         data: [info[0],info[1],info[2],info[3],info[4],info[5],info[6],info[7],info[8],info[9],info[10],info[11],info[12],info[13],info[14],info[15],info[16],info[17]]
      },
      
   ];

   var json = {};

   json.title = title;
   json.subtitle = subtitle;
   json.xAxis = xAxis;
   json.yAxis = yAxis;
   json.tooltip = tooltip;
   json.legend = legend;
   json.series = series;

   $('#chart').highcharts(json);
};  
//按收费员统计------------------------------------------------------------------- 
function staff(){
     staff_date();
      document.getElementById('option').innerHTML='<div class="radio-inline"><label><input type="radio" name="time_radios"  value="date" onclick="staff_date()" id="ra1" checked>按日期统计 </label></div><div class="radio-inline"><label><input type="radio" name="time_radios"  onclick="staff_week()" id="ra2"  value="week" >按星期统计</label></div><div class="radio-inline"><label><input type="radio" name="time_radios"  onclick="staff_month()" id="ra3" value="month"> 按月份统计</label></div>'  ;
};
/*-----------------------------------按收费员-日期统计-----------------------------------*/
function staff_date(){
     var myDate = new Date();
    var today=myDate.toLocaleDateString();//今天日期
    var person_num=new Array;
    var person_name=new Array;
    var total=0;
    var mon=new Array;
      $.ajax({                                                                   
            type:"POST",
            url:"get_sta_info5.php",
            async:false,
            data:{},                              
            dataType: 'JSON',
            success:function(json){ 
              total=json[0];
                person=json[1];             
                mon=json[2];
            }
      });
       var chart = {
      type: 'column'
   };
     var xAxis = {
      categories: [getNextDate(today, -6),getNextDate(today, -5),getNextDate(today, -4),getNextDate(today, -3),getNextDate(today, -2),getNextDate(today, -1),today],//横坐标
          crosshair: true
   };
      var title = {                          //标题
      text: '按日期统计收费员收费情况'   
   };
   var subtitle = {                            //副标题
      text: 'Collect fees by date'
   };
   
    var yAxis = { //纵轴
         min: 0,
      title: {
         text: '收费金额'
      },
   }; 

 var tooltip = {                                //纵轴单位
       headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
         '<td style="padding:0"><b>{point.y} 元</b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true

   };

   var plotOptions = {
      column: {
         pointPadding: 0.2,
         borderWidth: 0
      }
   };  
   var credits = {
      enabled: false
   };  
    var name=' ';
    var da=' ';
    var gross=new Array;
    var str='[';
   for(var i=0;i<total;i++)                   //收费员人数不一定，柱数依据数据库中取出的收费员人数变化，先拼成字符串形式
       {             
         name='"name":"'+person[i]+'",' ;
         da='"data":'+'['+mon[1][i]+','+mon[2][i]+','+mon[3][i]+','+mon[4][i]+','+mon[5][i]+','+mon[6][i]+','+mon[7][i]+']';
          gross[i]='{'+name+da+'}';
           if(i!=total-1) gross[i]=gross[i]+ ' , ';
           str=str+gross[i];
       }
       str=str+']'    
   var jsondata=eval('(' + str + ')');      //将收费员柱数与纵坐标从字符串转换为json格式

   var series = jsondata;                               //坐标点  
        
   var json = {};
   json.chart = chart; 
   json.title = title;   
   json.subtitle = subtitle; 
   json.tooltip = tooltip;
   json.xAxis = xAxis;
   json.yAxis = yAxis;  
   json.series = series;
   json.plotOptions = plotOptions;  
   json.credits = credits;
   $('#chart').highcharts(json);
};
 /*-----------------------------------按收费员-星期统计-----------------------------------*/  
function staff_week(){
     var myDate = new Date();
    var today=myDate.toLocaleDateString();//今天日期
     var thisweek=myDate.getDay();
    var person_num=new Array;
    var person_name=new Array;
    var total=0;
    var mon=new Array;
      $.ajax({                                                                   
            type:"POST",
            url:"get_sta_info5-1.php",
            async:false,
            data:{},                              
            dataType: 'JSON',
            success:function(json){ 
              total=json[0];
                person=json[1];             
                mon=json[2];
            }
      });
       var chart = {
      type: 'column'
   };
     var xAxis = {
      categories: [getNextDate(today, (-1)*thisweek-27)+'-'+getNextDate(today, (-1)*thisweek-21),
                   getNextDate(today, (-1)*thisweek-20)+'-'+getNextDate(today, (-1)*thisweek-14),
                   getNextDate(today, (-1)*thisweek-13)+'-'+getNextDate(today, (-1)*thisweek-7),
                   getNextDate(today, (-1)*thisweek-6)+'-'+getNextDate(today, (-1)*thisweek),
                   getNextDate(today, (-1)*thisweek+1)+'-'+today  ],//横坐标
          crosshair: true
   };
      var title = {                          //标题
      text: '按星期统计收费员收费情况'   
   };
   var subtitle = {                            //副标题
      text: 'Collect fees by week'
   };
   
    var yAxis = { //纵轴
         min: 0,
      title: {
         text: '收费金额'
      },
   }; 

 var tooltip = {                                //纵轴单位
       headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
         '<td style="padding:0"><b>{point.y} 元</b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true

   };

   var plotOptions = {
      column: {
         pointPadding: 0.2,
         borderWidth: 0
      }
   };  
   var credits = {
      enabled: false
   };  
    var name=' ';
    var da=' ';
    var gross=new Array;
    var str='[';
   for(var i=0;i<total;i++)                   //收费员人数不一定，柱数依据数据库中取出的收费员人数变化，先拼成字符串形式
       {             
         name='"name":"'+person[i]+'",' ;
         da='"data":'+'['+mon[5][i]+','+mon[4][i]+','+mon[3][i]+','+mon[2][i]+','+mon[1][i]+']';
          gross[i]='{'+name+da+'}';
           if(i!=total-1) gross[i]=gross[i]+ ' , ';
           str=str+gross[i];
       }
       str=str+']'    
   var jsondata=eval('(' + str + ')');      //将收费员柱数与纵坐标从字符串转换为json格式

   var series = jsondata;                               //坐标点  
        
   var json = {};
   json.chart = chart; 
   json.title = title;   
   json.subtitle = subtitle; 
   json.tooltip = tooltip;
   json.xAxis = xAxis;
   json.yAxis = yAxis;  
   json.series = series;
   json.plotOptions = plotOptions;  
   json.credits = credits;
   $('#chart').highcharts(json);
};
/*-----------------------------------按收费员-月份统计-----------------------------------*/ 
function staff_month() {
      var myDate = new Date();
     var month=myDate.getMonth();
    var person_num=new Array;
    var person_name=new Array;
    var total=0;
    var mon=new Array;
      $.ajax({                                                                   
            type:"POST",
            url:"get_sta_info5-2.php",
            async:false,
            data:{},                              
            dataType: 'JSON',
            success:function(json){ 
              total=json[0];
                person=json[1];             
                mon=json[2];
            }
      });
       var chart = {
      type: 'column'
   };
      var mont=new Array;
    for(var i=0;i<5;i++){
        if(month==0) month=12;
        mont[i]=month;
        month=mont[i]-1;
       
    }
    
     var xAxis = {
      categories:[ mont[4]+'月', mont[3]+'月', mont[2]+'月',  mont[1]+'月', mont[0]+'月','本月'],//横坐标
          crosshair: true
   };
      var title = {                          //标题
      text: '按月份统计收费员收费情况'   
   };
   var subtitle = {                            //副标题
      text: 'Collect fees by month'
   };
   
    var yAxis = { //纵轴
         min: 0,
      title: {
         text: '收费金额'
      },
   }; 

 var tooltip = {                                //纵轴单位
       headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
      pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
         '<td style="padding:0"><b>{point.y} 元</b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true

   };

   var plotOptions = {
      column: {
         pointPadding: 0.2,
         borderWidth: 0
      }
   };  
   var credits = {
      enabled: false
   };  
    var name=' ';
    var da=' ';
    var gross=new Array;
    var str='[';
   for(var i=0;i<total;i++)                   //收费员人数不一定，柱数依据数据库中取出的收费员人数变化，先拼成字符串形式
       {             
         name='"name":"'+person[i]+'",' ;
         da='"data":'+'['+mon[6][i]+','+mon[5][i]+','+mon[4][i]+','+mon[3][i]+','+mon[2][i]+','+mon[1][i]+']';
          gross[i]='{'+name+da+'}';
           if(i!=total-1) gross[i]=gross[i]+ ' , ';
           str=str+gross[i];
       }
       str=str+']'    
   var jsondata=eval('(' + str + ')');      //将收费员柱数与纵坐标从字符串转换为json格式

   var series = jsondata;                               //坐标点  
        
   var json = {};
   json.chart = chart; 
   json.title = title;   
   json.subtitle = subtitle; 
   json.tooltip = tooltip;
   json.xAxis = xAxis;
   json.yAxis = yAxis;  
   json.series = series;
   json.plotOptions = plotOptions;  
   json.credits = credits;
   $('#chart').highcharts(json);
}
function getNextDate(date, day) {                 //获取当前日期的前几天或后几天
　　var dd = new Date(date);
　　dd.setDate(dd.getDate() + day);
　　var y = dd.getFullYear();
　　var m = dd.getMonth() + 1 < 10 ? "0" + (dd.getMonth() + 1) : dd.getMonth() + 1;
　　var d = dd.getDate() < 10 ? "0" + dd.getDate() : dd.getDate();
　　return  m + "/" + d+ "/" + y;
};

function sta(a){
    var con=a.value; 
    switch(con){
      case "按时间统计":time();break;
      case "按入关收费站统计":toll();
            break;
      case "按货物类型统计":cargotype();
            break;
      case "按车型统计":cartype();
            break;
     
      case "按收费员统计":staff();
            break;
              }  
};
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
　　　　　　var div_print=document.getElementById("chart");
　　　　　　bt.onclick=function(){
　　　　　　　　printdiv(div_print);
　　　　　　};
　　　　};

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
<!------------------------------------- 功能按钮 --------------------------------->
 <div class="col-sm-3 btn-group">
  <button class="btn mybtn" onclick="window.location.href='car_info.php'">数据浏览</button>  
        
   <button class="btn mybtn" onclick="window.location.href='search_car_info_form.php'">数据查询</button>  
  <button class="btn mybtn active">数据统计</button>  
        </div>
  
<!----------------------------------统计类型----------------------------------------->
 <div class='col-sm-3'>
                 <select class="form-control" id="opt" name="opt" onchange="sta(this)">
                 <option>按时间统计</option>
                 <option>按入关收费站统计</option>
                 <option>按货物类型统计</option>
                 <option>按车型统计</option>
                
                 <option>按收费员统计</option>
                 </select>
    </div> 
    <br>
    <br>
    <div class="row"> 
        <div class='col-sm-6 col-sm-offset-3'>
             <div id='option' class='col-sm-10 col-sm-offset-2'></div>  
             <br>
    <br>
              <div  id="chart"> </div>
             
              <button type="button" class="btn mybtn col-sm-offset-4 col-xs-offset-4 hidden-xs" id="pr">打印统计数据</button>
            </div>
    </div>

    
 </body>
</html>