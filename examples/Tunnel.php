<?php

include '../vendor/autoload.php';
    
use qgproxy\Api;

/**
 * 隧道demo
 */

try {

    //=======添加白名单==============================================================================
    $params = [
        'Key' => 'xxx',
        // 'IP' => '', //IP地址;多个用,分隔
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::addWhitelist($params);  
    var_dump($result);die;

    //=======删除白名单==============================================================================
    $params = [
        'Key' => 'xxx',
        // 'IP' => '', //IP地址;多个用,分隔
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::delWhitelist($params);
    var_dump($result);die;

    //========查询白名单=============================================================================
    $params = [
        'Key' => 'xxx',
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::queyrWhitelist($params);
    var_dump($result);die;

} catch (\Throwable $th) {
    var_dump($th->getMessage());
}