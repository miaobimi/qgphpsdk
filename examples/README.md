### 业务购买成功后在用户中心拿到你的Authkey和Authpwd
```
    $authkey = '你的Authkey';
    $authpwd = '你的Authpwd';
```

### 动态独享
``` 
    // 1. 使用提取IP资源接口提取到IP
    $result = Api::allocate(['Key' => $authkey]); //更多参数 请看文档后接口列表
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

            $curl->close();
        }
        
    }else{
        var_dump($result);die;
    }

```

### 动态独占
``` 
    // 1. 申请独占资源
    $result = Api::monopolizeResources(['Key' => $authkey]); //更多参数 请看文档后接口列表
    if($result['Code'] == 0){
        //2. 查询可用独占资源
        $result = Api::getMonopolizeResources(['Key' => $authkey]); //更多参数 请看文档后接口列表
        if($result['Code'] == 0){
            $targetUrl = 'https://d.qg.net/ip'; //爬取的目标站点
            $ipArr = [];
            foreach ($result['data'] as $v) {
                if(!empty($v['newest_ip'])){
                    $ipArr[] = $v['newest_ip'];
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
                    //2. 使用代理IP发起爬取请求
                    $curl->setOpt(CURLOPT_PROXY, $_temp[0]);
                    $curl->setOpt(CURLOPT_PROXYPORT, $_temp[1]);
                    $curl->get($targetUrl);
                    if ($curl->error) {
                        var_dump($curl->error_message);
                    } else {
                        var_dump($curl->response);
                    }
                    //3. 获取到数据之后你的逻辑



                    $curl->close();
                }
            }
            
        }else{
            var_dump($result);die;
        }
    }else{
        var_dump($result);die;
    }

```

```
 您可以在examples目录下找到更全面的API接口
```
