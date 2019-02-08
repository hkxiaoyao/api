<?php
	//$root = 'http://api.1ddian.cn/';//可自定义域名
    $url= $_REQUEST['client_url'];
	//用curl实现Post请求，可跨域
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $_REQUEST);  //传送参数
    ob_start();
    curl_exec($ch);
    $result = ob_get_contents() ;
    ob_end_clean();
    print_r(json_decode($result)); //中文返回的是unicode编码，decode后方便阅读
?>