
### 业务购买成功后在用户中心拿到你的Authkey和Authpwd
```
$authkey = '你的Authkey';
$authpwd = '你的Authpwd';
```

### 动态独享、动态共享(更多接口请查看DymanicAlone.php(动态独享)，DymanicShare.php(动态共享))
``` javascript
// 1. 使用提取IP资源接口提取到IP  存入文件
<?php
ignore_user_abort();//关闭浏览器后，继续执行php代码
set_time_limit(0);//程序执行时间无限制
while(true){
    $result = Api::allocate(['Key' => $authkey]); //更多参数 请看DymanicAlone.php(动态独享)，DymanicShare.php(动态共享)
    if($result['Code'] == 0){
        unlink('ip.txt');
        foreach ($result['Data'] as $v) {
            file_put_contents('ip.txt', $v['IP'].':'.$v['port'].PHP_EOL, FILE_APPEND);
        }
    }else{
        file_put_contents('error.txt', date('Y-m-d H:i:s').':'.$result['Msg'].PHP_EOL, FILE_APPEND);
    }
    sleep(40); //动态独享40s刷新一次IP池，请求频率1请求/s
    // sleep(62);//动态共享按时62s刷新一次IP池，请求频率1请求/s
    // sleep(20);//动态共享按量20s刷新一次IP池，请求频率1请求/s
}

//2. 取出代理IP发起爬取请求
<?php
ignore_user_abort();//关闭浏览器后，继续执行php代码
set_time_limit(0);//程序执行时间无限制

$delay = 10; //爬虫每隔10s 爬取一次目标站点

$curl = new \Curl\Curl();
$curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
$curl->setOpt(CURLOPT_SSL_VERIFYHOST, FALSE);
$curl->setOpt(CURLOPT_PROXYTYPE, 'HTTP');
//将发起IP添加到白名单后，可不需要账密验证
$curl->setOpt(CURLOPT_PROXYUSERPWD, $authkey.':'.$authpwd);
$targetUrl = 'https://d.qg.net/ip'; //爬取的目标站点
while(true){
    $ips = explode(PHP_EOL, trim(file_get_contents('ip.txt')));
    foreach ($ips as $v) {
        $temp = explode(':', $v);
        $ip = $temp[0];
        $port = $temp[1];
        $curl->setOpt(CURLOPT_PROXY, $ip);
        $curl->setOpt(CURLOPT_PROXYPORT, $port);
        $curl->get($targetUrl);
        if ($curl->error) {
            var_dump($curl->error_message);
        } else {
            var_dump($curl->response);
        }
        //3. 获取到数据之后你的逻辑
    }
    sleep($delay);
}
```

### 隧道(更多接口请查看Tunnel.php)
``` javascript
<?php
ignore_user_abort();//关闭浏览器后，继续执行php代码
set_time_limit(0);//程序执行时间无限制
//用户中心查看隧道地址端口
$tunnelUrl = 'tunnel.qg.net';
$tunnelPort = '666';
$delay = 10; //爬虫每隔10s 爬取一次目标站点

$curl = new \Curl\Curl();
//将发起IP添加到白名单后，可不需要账密验证
$curl->setOpt(CURLOPT_PROXYUSERPWD, $authkey.':'.$authpwd);
$curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
$curl->setOpt(CURLOPT_SSL_VERIFYHOST, FALSE);
$curl->setOpt(CURLOPT_PROXYTYPE, 'HTTP');

//如果想获取的IP重复 可以打上标记，如果为固定时长多通道产品可分别打不同的标记 如 channel-1 channel-2 channel-3 
$curl->setHeader('Proxy-TunnelID', 'channel-1');

//针对隧道每次请求换ip 产品 可以标记IP的存活时间
$curl->setHeader('Proxy-TTL', '10'); //Proxy-TTL指定该标记IP的存活时间(单位 秒)

$targetUrl = 'https://d.qg.net/ip'; //爬取的目标站点

// 使用隧道发起爬取请求
$curl->setOpt(CURLOPT_PROXY, $tunnelUrl);
$curl->setOpt(CURLOPT_PROXYPORT, $tunnelPort);

while(true){
    $curl->get($targetUrl);
    if ($curl->error) {
        var_dump($curl->error_message);
    } else {
        var_dump($curl->response);
    }
    // 获取到数据之后你的逻辑

    sleep($delay);
}
 
```
