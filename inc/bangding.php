 <!--佛大新媒体协会的成绩查询 -->
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>绑定账号</title>
<!-- <meta name="description" content=""> -->
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<!-- <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" /> -->
<link rel="stylesheet" href="inc/css/weui.css">
<link rel="stylesheet" href="inc/css/jquery-weui.css">
</head>

<style type="text/css">
　 
</style>

<body>
<section class="login-form-wrap">
    <div align="center">
	    <img src="inc/images/show.png" style="width:100%;">
     <!--  <img src="images/show.png" style="width:550px;-webkit-box-shadow: 3px 3px 3px;-moz-box-shadow: 3px 3px 3px;box-shadow: 3px 3px 3px;border-radius:10px"> -->
    </div>
<!-- <h1>绑定教务系统</h1> -->

<!-- 这里其实应该加个检测数据库中是否有openid的 -->
<form class="login-form" method="post" action="<?php echo $url;?>">

<label >
  <div class="weui_cell">
	   <div class="weui_cell_hd"><label class="weui_label">学号</label></div>
	   <div class="weui_cell_bd weui_cell_primary">
	     <input class="weui_input" type="number" name="xuehao" required placeholder="请输入学号">
     </div>
  </div>
</label>

<label>
  <div class="weui_cell">
	   <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
	   <div class="weui_cell_bd weui_cell_primary">
	     <input class="weui_input" type="password" name="password" required placeholder="请输入密码">
     </div>
  </div>
</label>

<br>
<!-- <label>
<input type="password" name="password" required placeholder="密码">
</label> -->
<input type="hidden" name="openid" value="<?php 
	echo $openid=$_GET['id'];
?>">
	<input class="weui_btn weui_btn_primary" style="width:300px;"type="submit" value="绑定">
</form>


<!-- 呵呵呵呵呵呵我觉得一定会有人看这个的，我就是个小小的代码搬运工，技术牛逼的人就不要乱搞我这个了哈 -->
<!-- 我微信：caserest -->

</section>
<div style="text-align:center;margin:50px 0; font:normal 14px/24px 'MicroSoft YaHei';">

</div>
<?php require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(1255478933).'" width="0" height="0"/>';?>
</body>
</html>