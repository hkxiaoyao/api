<?php
if (!isset($_POST['submit'])) {
?>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>接口测试</title>
    <link href="./testapi/bootstrap.min.css" rel="stylesheet">
    <link href="./testapi/font-awesome.min.css" rel="stylesheet">
    <link href="./testapi/site.min.css?v3" rel="stylesheet">
    <script src="./testapi/jquery-1.6.4.js"></script>
</head>
<body>
<?php
}else{
    header('Content-type:text/html;charset=utf-8');
    function fly_curl($url, $postFields = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.1)');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        //curl_setopt($ch,CURLOPT_HTTPHEADER,array("Expect:"));
        if (is_array($postFields) && count($postFields)>0)
        {
            $postBodyString = "";
            $postMultipart = false;
            foreach ($postFields as $k => $v)
            {
                if("@" != substr($v, 0, 1))//判断是不是文件上传
                {
                    $postBodyString .= "$k=" . urlencode($v) . "&";
                }
                else//文件上传用multipart/form-data，否则用www-form-urlencoded
                {
                    $postMultipart = true;
                }
            }
            unset($k, $v);
            if ($postMultipart)
            {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            }
            else
            {
                //var_dump($postBodyString);
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
            }
        }
        $reponse = curl_exec($ch);
        var_dump($reponse);exit;
        //return curl_getinfo($ch);
        if (curl_errno($ch))
        {
            throw new Exception(curl_error($ch),0);
        }
        else
        {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode)
            {
                throw new Exception($reponse,$httpStatusCode);
            }
        }
        curl_close($ch);
        return $reponse;
    }
    function microtime_float(){
        list ($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    $start = $end = 0;
    if (isset($_POST['submit'])) {
        if (strstr($_POST['url'], '?')) {
            $url = sprintf("%s&auth=%s", $_POST['url'], $auth);
        } else {
            $url = sprintf("%s?auth=%s", $_POST['url'], $auth);
        }
        $param = array();
        if (isset($_POST['param'])) {
            foreach($_POST['param'] as $k => $item) {
                if (!empty($item['method']) && !empty($item['name'])) {
                    $param[$item['method']][$item['name']] = $item['value'];
                }
            }
        }

        if (isset($param['get']) && !empty($param['get'])) {
            foreach ($param['get'] as $name => $value) {
                $url = sprintf("%s&%s=%s", $url, $name, $value);
            }
        }
        $post_data = null;
        if (isset($param['post']) && !empty($param['post'])) {
            $post_data = $param['post'];
        }

        $start =  microtime_float();
        $return = fly_curl($url, $post_data);
        $content = json_decode(urldecode($return), TRUE);
        if ( ! $content) {
            $content = $return;
        }
        $end =  microtime_float();
    }
}
?>


<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-12">
            <div class="row" >
                <div class="col-xs-1 col-lg-4">
                    <h1>接口测试</h1>
                    <div class="thumbnail">
                        <form class="form-signin" action="" method="post">
                            <b>请填URL</b>:
                            <input value="<?php echo isset($_POST['url'])?$_POST['url']:'http://';?>" class="form-control" placeholder="填写完整地址，以http://开头" type="text" name="url" required><br>
                            <b>请求方式</b>:
                            <label><input <?php if($item['method']=='get'):?>checked<?php endif;?> value="get" type="radio" name="param[<?php echo $k;?>][method]">get</label>
                            <label><input <?php if($item['method']=='post'):?>checked<?php endif;?> value="post" type="radio" name="param[<?php echo $k;?>][method]">post</label><br />
                            <?php if (isset($_POST['param']) && !empty($_POST['param'])) :?>
                                <?php foreach ($_POST['param'] as $k => $item) :?>
                                    <?php if (!empty($item['method']) && !empty($item['name'])) :?>
                                        <div class="thumbnail">
                                            <b>参数name</b>:
                                            <input value="<?php echo $item['name'];?>" placeholder="请填写" type="text" name="param[<?php echo $k;?>][name]">
                                            <b>参数value</b>:
                                            <input value="<?php echo $item['value'];?>" placeholder="请填写" type="text" name="param[<?php echo $k;?>][value]"><br>
                                            <a href="#" onclick="del_param(this)">删除</a>
                                        </div>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endif;?>

                            <input type="button" name="add_param" id="add_param" value="添加参数" class="btn btn-lg btn-primary btn-block"><br />
                            <input type="submit" name="submit" value="测试" class="btn btn-lg btn-primary btn-block"><br />
                        </form>
                    </div>
                </div>
                <div class="col-xs-1 col-lg-8">
                    <?php
                    if (isset($_POST['submit'])) {
                        echo "<pre>";
                        echo "请求时间:";
                        var_dump($end - $start);

                        echo "<br />请求url:";
                        isset($url) && var_dump($url);

                        echo "<br />请求参数:";
                        isset($param) && var_dump($param);

                        echo "<hr />结果：";
                        if (isset($content['result'])) {
                            echo "<br />code:";
                            var_dump($content['result']['code']);
                            echo "message:";
                            var_dump($content['result']['message']);
                            echo "data:";
                            var_dump($content['result']['data']);
                        } else {
                            echo $content;
                        }

                        echo "</pre>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <hr />
</div>
<div class="blog-masthead">
    <div class="container">
        <nav class="blog-nav">
            <p class="blog-nav-item">&copy; Company 2014 modify 2016</p>
        </nav>
    </div>
</div>
</body>
</html>

<script>
    $("#add_param").click(function(){
        var input_len = $("form input").size();
        input_len++;
        $(this).before('\
                <div class="thumbnail">\
                <b>参数name</b>:\
                <input value="" placeholder="请填写" type="text" name="param['+ input_len +'][name]">\
                <b>参数value</b>:\
                <input value="" placeholder="请填写" type="text" name="param['+ input_len +'][value]"><br>\
                <a href="#" onclick="del_param(this)">删除</a>\
                </div>\
                ');
    });
    function del_param(obj) {
        $(obj).parent().remove();
    }
</script>
