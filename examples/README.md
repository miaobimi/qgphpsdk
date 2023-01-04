
### 业务购买成功后在用户中心拿到你的Authkey和Authpwd
```
$authkey = '你的Authkey';
$authpwd = '你的Authpwd';
```

### 动态独享(更多接口请查看DymanicAlone.php)
``` javascript
// 1. 使用提取IP资源接口提取到IP  存入文件
<?php
ignore_user_abort();//关闭浏览器后，继续执行php代码
set_time_limit(0);//程序执行时间无限制
while(true){
    $result = Api::allocate(['Key' => $authkey]); //更多参数 请看DymanicAlone.php
    if($result['Code'] == 0){
        unlink('ip.txt');
        foreach ($result['Data'] as $v) {
            file_put_contents('ip.txt', $v['IP'].':'.$v['port'].PHP_EOL, FILE_APPEND);
        }
    }else{
        file_put_contents('error.txt', date('Y-m-d H:i:s').':'.$result['Msg'].PHP_EOL, FILE_APPEND);
    }
    sleep(40); //动态独享40s刷新一次IP池，请求频率1请求/s
}

?>

//2. 取出代理IP发起爬取请求
<?php
ignore_user_abort();//关闭浏览器后，继续执行php代码
set_time_limit(0);//程序执行时间无限制

$delay = 10; //爬虫每隔10s 爬取一次目标站点

while(true){
    $ips = explode(PHP_EOL, trim(file_get_contents('ip.txt')));
    $curl = new \Curl\Curl();
    //将发起IP添加到白名单后，可不需要账密验证
    $curl->setOpt(CURLOPT_PROXYUSERPWD, $authkey.':'.$authpwd);
    $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
    $curl->setOpt(CURLOPT_SSL_VERIFYHOST, FALSE);
    $curl->setOpt(CURLOPT_PROXYTYPE, 'HTTP');
    $targetUrl = 'https://d.qg.net/ip'; //爬取的目标站点

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
?>
```

### 动态独占(更多接口请查看DymanicExcusive.php)
``` javascript
//1. 申请独占资源
$result = Api::monopolizeResources(['Key' => $authkey]); //更多参数 请看DymanicExcusive.php
//2. 查询可用独占资源(需要不断查询)
$result = Api::getMonopolizeResources(['Key' => $authkey]); //更多参数 请看DymanicExcusive.php
if(is_array($result['data']) && count($result['data']) > 0){
    $targetUrl = 'https://d.qg.net/ip'; //爬取的目标站点
    $ipArr = [];
    foreach ($result['data'] as $v) {
        if(!empty($v['ip'])){
            $ipArr[] = $v['ip'];
        }
    }
    if(count($ipArr) > 0){
        $curl = new \Curl\Curl();
        //将发起IP添加到白名单后，可不需要账密验证
        $curl->setOpt(CURLOPT_PROXYUSERPWD, $authkey.':'.$authpwd);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, FALSE);
        $curl->setOpt(CURLOPT_PROXYTYPE, 'HTTP');
        foreach ($ipArr as $ip) {
            $_temp = explode(':', $ip);
            //3. 使用代理IP发起爬取请求
            $curl->setOpt(CURLOPT_PROXY, $_temp[0]);
            $curl->setOpt(CURLOPT_PROXYPORT, $_temp[1]);
            $curl->get($targetUrl);
            if ($curl->error) {
                var_dump($curl->error_message);
            } else {
                var_dump($curl->response);
            }
            //4. 获取到数据之后你的逻辑

        }
    }
    
}else{
    var_dump($result);die;
}

```


### 动态共享(更多接口请查看DymanicShare.php)
``` javascript
// 1. 使用提取IP资源接口提取到IP
$result = Api::allocate(['Key' => $authkey]); //更多参数 请看DymanicShare.php
if($result['Code'] == 0){
    $curl = new \Curl\Curl();

    //将发起IP添加到白名单后，可不需要账密验证
    $curl->setOpt(CURLOPT_PROXYUSERPWD, $authkey.':'.$authpwd);
    $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
    $curl->setOpt(CURLOPT_SSL_VERIFYHOST, FALSE);
    $curl->setOpt(CURLOPT_PROXYTYPE, 'HTTP');
    $targetUrl = 'https://d.qg.net/ip'; //爬取的目标站点
    
    foreach ($result['Data'] as $v) {
        //2. 使用代理IP发起爬取请求
        $curl->setOpt(CURLOPT_PROXY, $v['IP']);
        $curl->setOpt(CURLOPT_PROXYPORT, $v['port']);
        $curl->get($targetUrl);
        if ($curl->error) {
            var_dump($curl->error_message);
        } else {
            var_dump($curl->response);
        }
        //3. 获取到数据之后你的逻辑
        
    }
    
}else{
    var_dump($result);die;
}
```

### 隧道(更多接口请查看Tunnel.php)
``` javascript
//用户中心查看隧道地址端口
$tunnelUrl = 'tunnel.qg.net';
$tunnelPort = '666';
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
$curl->get($targetUrl);
if ($curl->error) {
    var_dump($curl->error_message);
} else {
    var_dump($curl->response);
}
// 获取到数据之后你的逻辑
    
 
```
