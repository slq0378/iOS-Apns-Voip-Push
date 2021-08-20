<?php
   function send_push_message($isVOIP,$product) {
        // pem格式推送证书文件路径
        $certFilePath = '/Users/xxx/Desktop/Push/apns.pem';
        // $certFilePath = '/Users/xxx/Desktop/Push/voip.pem';
        // 推送证书密码，没有密码则留空
        $certPwd = '123456';
        // 设备token
        $token = '12c9592a3b64a65f51d4c51b7d97acca9d166ad0c35sdfaf';// apns
        // $token = '602d4a16e8c992b0b516750913a634ce1a08d1363fadsfa';// voip
        // 证书id ，注意这里不是boundid，不过apns证书的id一般和boundid一样，voip证书id一般是boundid.voip，可以去钥匙串查看证书id
        $bundleId = 'com.xxx';//apns
        // $bundleId = 'com.xxx.voip';//voip
        if($isVOIP == true){
            echo("voip push").PHP_EOL;
            $certFilePath = '/Users/xxx/Desktop/Push/voip.pem';
            $certPwd = 'Hz123456';
            $token = '0f66e843c2f584efb73cbdf80c4f32034cb4441d9f2fdasgf';// voip
            $bundleId = 'com.xxx.voip';//voip
        }else{
            echo('apns push').PHP_EOL;
        }

        $url = "https://api.development.push.apple.com:443/3/device/{$token}";
        if($product){
            echo('product').PHP_EOL;
            $url = "https://api.push.apple.com:443/3/device/{$token}";
        }else{
            echo('development').PHP_EOL;
        }
        // 请求头
        $headers = [
            "apns-topic:{$bundleId}",
            "apns-expiration:1"
        ];
        // 请求体
        $payload = [
            'aps' => [
                'alert' => [
                    'title' => '2This is title',
                    "subtitle"=> "Five Card Draw",
                    'body' => '2This is content',
                ],
                "image-url"=>'https://tva1.sinaimg.cn/large/008i3skNgy1gtmd6b4whhj60fq0g6tb502.jpg',
                'identifier'=>'12321',
                "media"=>'image',
                "mutable-content"=> 1,//  Notification Service Extension 需要设置
            ],
        ];
        $payload = json_encode($payload);

        // 发出请求
        $ch = curl_init();
        // 请求配置
        $options = [
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0, // http 版本
            CURLOPT_SSLCERT => $certFilePath, // 证书
            CURLOPT_SSLCERTPASSWD => $certPwd,// 证书密码
            CURLOPT_URL => $url,// url地址
            CURLOPT_HTTPHEADER => $headers,// 请求头
            CURLOPT_POST => true, // post请求
            CURLOPT_POSTFIELDS => $payload, // 请求体
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ];
        curl_setopt_array($ch, $options);
        $responseBody = curl_exec($ch); // 执行请求
        $errno = curl_errno($ch);
        if ($errno) {
            exit("cURL errno:{$errno}, error:" . curl_error($ch));
        }
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        var_dump($responseCode, $responseBody); // 成功的话 200
        echo $responseCode;
    }
    // 发送请求
    send_push_message(false,false);
?>
