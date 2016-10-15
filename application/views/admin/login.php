<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="shortcut icon" href="/images/favicon.png">
	<title>login</title>
	
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-4.0.0-alpha.3.min.css">
	<link rel="stylesheet" type="text/css" href="/css/common.css">
	
	<base target="_self">
</head>

<body>

<div class="container">
	<br><br>
	<h3 class="text-xs-center">Login</h3>

</div>

<br>

<div class="container">
	
	<div class="form-group row">
		<label for="example-text-input" class="col-xs-2 col-form-label">Username</label>
		<div class="col-xs-10">
			<input class="form-control" type="text" name="username" id="input-username">
		</div>
	</div>
	
	<div class="form-group row">
		<label for="example-search-input" class="col-xs-2 col-form-label">Password</label>
		<div class="col-xs-10">
			<input class="form-control" type="password" name="password" id="input-password">
		</div>
	</div>
	
	<div class="btn btn-outline-primary" id="btn-login">Login</div>
</div>


<script src="/js/jquery-3.1.0.min.js"></script>
<script src="/js/tether-1.3.3.min.js"></script>
<script src="/js/bootstrap-4.0.0-alpha.3.min.js"></script>
<script src="/js/jquery.md5.js"></script>

<script type="text/javascript">
	$(document).ready(function ()
	{
		$("#btn-login").click(function ()
		{
			var username = $("#input-username").val();
			var password = $("#input-password").val();
			window.location.href = '/admin/auth?username=' + username + '&password=' + $.md5(password);
		});
	});
</script>

</body>
