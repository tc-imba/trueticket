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
		<img src="/img/event/<?php echo $event->img; ?>" width="90%"/>
	</div>
</div>

<br>

<div class="container">
	
	<h4 class="text-xs-center"><?php echo $event->name; ?></h4>
	<hr>
	
	<?php if ($ticket->check_admin_id): ?>
		<div class="row">
			<h5 class="col-xs-4 text-xs-right">已验票于</h5>
			<h5 class="col-xs-8 text-xs-left"><?php echo $ticket->check_time; ?></h5>
		</div>
		<hr>
	<?php endif; ?>
	
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">开始时间</h5>
		<h5 class="col-xs-8 text-xs-left"><?php echo $event->start_time ?></h5>
	</div>
	
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">结束时间</h5>
		<h5 class="col-xs-8 text-xs-left"><?php echo $event->end_time; ?></h5>
	</div>
	
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">地址</h5>
		<h5 class="col-xs-8 text-xs-left"><?php echo $event->place; ?></h5>
	</div>
	
	<div class="row">
		<h5 class="col-xs-4 text-xs-right">主办方</h5>
		<h5 class="col-xs-8 text-xs-left"><?php echo $event->host; ?></h5>
	</div>
	
	<hr>
	
	<?php if ($type == 'admin'): ?>
		
		<div class="text-xs-center">
			<?php if ($ticket->check_admin_id): ?>
				<div class="btn btn-lg btn-danger disabled" id="check">已验票</div>
			<?php else: ?>
				<div class="btn btn-lg btn-outline-primary" id="check">验票</div>
			<?php endif; ?>
		</div>
	
	
	<?php else: ?>
		
		
		<div class="row">
			<h5 class="col-xs-4 text-xs-right">防伪信息</h5>
		</div>
		
		<div class="text-xs-center">
			<img src="/generate?str=<?php echo $ticket->money_id; ?>" width="90%"/>
		</div>
		
		<hr>
		
		<div class="row">
			<h5 class="col-xs-6 text-xs-center">查询时间</h5>
			<h5 class="col-xs-6 text-xs-center">查询位置</h5>
		</div>
		
		<?php foreach ($scan_list as $index => $scan): ?>
			
			<div class="row">
				<h5 class="col-xs-6 text-xs-center  "><?php echo $scan->CREATE_TIMESTAMP; ?></h5>
				<h5 class="col-xs-6 text-xs-center"><?php echo $scan->ip_str; ?></h5>
			</div>
		
		<?php endforeach; ?>
	
	
	<?php endif; ?>

</div>


<script src="/js/jquery-3.1.0.min.js"></script>
<script src="/js/tether-1.3.3.min.js"></script>
<script src="/js/bootstrap-4.0.0-alpha.3.min.js"></script>
<script src="/js/jquery.md5.js"></script>

<script type="text/javascript">
	$(document).ready(function ()
	{
		<?php if($type == 'admin'): ?>
		$("#check").click(function ()
		{
			$.ajax({
				url: '/admin/check',
				type: 'get',
				data: {data: '<?php echo $code;?>'},
				dataType: 'text',
				success: function (data)
				{
					alert(data);
				},
				error: function ()
				{
					alert('未知错误，请稍后重试');
				}
			});
		});
		<?php else:?>
		$.ajax({
			url: '/scan',
			type: 'get',
			data: {data: '<?php echo $code;?>'},
			dataType: 'text'
		});
		<?php endif;?>
	});
</script>

</body>
