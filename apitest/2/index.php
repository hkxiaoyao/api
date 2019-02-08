<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8"/>
	<title>API测试</title>
    <link href="./testapi/bootstrap.min.css" rel="stylesheet">
    <link href="./testapi/font-awesome.min.css" rel="stylesheet">
    <link href="./testapi/site.min.css?v3" rel="stylesheet">
	<script src="jquery.js" type="text/javascript"></script>
	<style type="text/css">
		.mb20{margin-bottom:20px}
		.title{display:inline-block;width:150px;text-align:right}
		.w100{width:100px}
		.mr10{margin-right:10px}
	</style>
</head>
<body>
<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-12">
            <div class="row" >
                <div class="col-xs-1 col-lg-4">
                    <h1>接口测试</h1>
                    <div class="thumbnail">
		<div class="mb20">
			<b>client_name：默认即可</b><input name="client_name" type="text" value="ANDROID" class="form-control" />
		</div>
		<div class="mb20">
            <b>client_version：默认即可</b><input name="client_version" type="text" value="4.0" class="form-control" />
		</div>
		<div class="mb20">
            <b>api_debug：默认为空即可</b><input name="api_debug" type="text"  value="" class="form-control" />
		</div>
		<div class="mb20">
            <b>请填URL</b><input name="client_url" type="text" value="http://" class="form-control" />
		</div>
		<div class="mb20">
            <b>参数</b><label class="title"><input name="api_key" type="text"  value="" class="w100"/>：</label><input name="api_value" type="text"  value=""/>

		</div>
		<div class="mb20">
            <label class="title"></label><input type="button" value="测试" id="submit" class="mr10"/><input type="button" value="添加参数" id="add"/>
		</div>







		<div id="message"></div>

                    </div>


    </div>
            </div>
        </div>
    </div>
</div>


<div class="blog-masthead">
    <div class="container">
        <nav class="blog-nav">
            <p class="blog-nav-item">&copy; Company 2019 BY 逍遥</p>
        </nav>
    </div>
</div>




		<script type="text/javascript">
			$("#add").click(function() {
				var $parent = $(this).parent();
				var $clone = $parent.prev().clone();
				$clone.find(':text').val('');
				$clone.insertBefore($parent);
			});
			$("#submit").click(function() {
				var api_keys = {
					api_debug:$('input[name=api_debug]').val(),
					client_url:$('input[name=client_url]').val()
				};
				$('input[name=api_key]').map(function() {
					var key = $.trim($(this).val());
					var value = $.trim($(this).parent().next().val());
					var repeat = {};
					if(key !== '') {
						repeat[key] = value;
						api_keys = $.extend(api_keys, repeat);
					}
				});
				//提交到test文件中
				$.post('test.php', api_keys, function(data) {
					$("#message").html(data);
				});
			});
		</script>
</body>
</html>