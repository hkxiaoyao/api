<html xmlns="http://blog.csdn.net/sinat_35861727?viewmode=contents">
 
<head>
	<meta http-equiv = "Content-Type" content = "text/html;charset = utf8">
	<meta name = "description" content = "提交表单">
	<title>API接口请求表单</title>
</head>
	<style type="text/css">
		.key1{
			width:100px;
		}
		.value1{
			width:230px;
			margin:0 0 0 10px;
		}
		.main{
			margin:0 auto;
			width:450px;
			height:auto;
			background:lightgray;
			padding:40px 40px;
		}
		.refer{
			width:100px;
			height:24px;
		}
		.url{
			width:350px;
		}
	</style>
<body>
 
<div class="main">
	<form method="POST" action="post.php" target="_blank">
		<p>请求地址：<input class="url" type="text" name="curl" placeholder="API接口地址"></p>
		<p>参　数1： <input class="key1" type="text" name="key1" placeholder="参数名">
					 <input class="value1" type="text" name="value1" placeholder="参数值"></p>
		<p>参　数2： <input class="key1" type="text" name="key2" placeholder="参数名">
					 <input class="value1" type="text" name="value2" placeholder="参数值"></p>
		<p>参　数3： <input class="key1" type="text" name="key3" placeholder="参数名">
					 <input class="value1" type="text" name="value3" placeholder="参数值"></p>
		<p>参　数4： <input class="key1" type="text" name="key4" placeholder="参数名">
					 <input class="value1" type="text" name="value4" placeholder="参数值"></p>
		<p>参　数5： <input class="key1" type="text" name="key5" placeholder="参数名">
					 <input class="value1" type="text" name="value5" placeholder="参数值"></p>
		<p>参　数6： <input class="key1" type="text" name="key6" placeholder="参数名">
					 <input class="value1" type="text" name="value6" placeholder="参数值"></p>
		<p>请求方式: <select name="method">
			<option value="POST">POST请求</option>
			<option value="GET">GET请求</option>
		</select></p>
		<p style="text-align:center;"><input class="refer" type="submit" value="提交"></p>
	</form>
</div>
</body>
 
 
</html>
