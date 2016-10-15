<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="shortcut icon" href="/images/favicon.png">
	<title>Check</title>
	
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-4.0.0-alpha.3.min.css">
	<link rel="stylesheet" type="text/css" href="/css/common.css">
	
	<base target="_self">
</head>

<body>

<br>

<div class="container">
	<div class="text-xs-center">
		<img src="#" height="30%" width="90%"/>
	</div></div>

<br>

<div class="container">
	
	<h4 class="text-xs-center"><?php echo $event->name; ?></h4>
	<hr>
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">开始时间</h5>
		<h5 class="col-xs-8 text-xs-left"><?php echo $event->start_time ?></h5>
	</div>
	
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">结束时间</h5>
		<h5 class="col-xs-8 text-xs-left"><?php echo $event->end_time ?></h5>
	</div>
	
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">地址</h5>
		<h5 class="col-xs-8 text-xs-left"><?php echo $event->place ?></h5>
	</div>
	
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">主办方</h5>
		<h5 class="col-xs-8 text-xs-left"><?php echo $event->host ?></h5>
	</div>
	
	<hr>
	
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">防伪信息</h5>
	</div>
	
	<div class="text-xs-center">
		<img src="#" height="150" width="90%"/>
	</div>
	
	<hr>
	
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">查询信息</h5>
	</div>
	
	
	
</div>


<script src="/js/jquery-3.1.0.min.js"></script>
<script src="/js/tether-1.3.3.min.js"></script>
<script src="/js/bootstrap-4.0.0-alpha.3.min.js"></script>
<script src="/js/jquery.md5.js"></script>

<script type="text/javascript">
	$(document).ready(function ()
	{
		
	});
</script>

</body>
