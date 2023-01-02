<?php

include '../vendor/autoload.php';
    
use qgproxy\Api;

/**
 * 动态独占demo
 */

try {

    //========提取独占资源=============================================================================
    $params = [
        'Key' => 'xxx',
        // 'Num' => 1, //申请数量，默认为1
        // 'AreaCode' => '', //区域编号(https://www.qg.net/doc/1439.html)
        // 'Operator' => '', //运营商 1:电信,2:移动,3:联通,4:BGP
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::monopolizeResources($params); 
    var_dump($result);die;

    //=======查询可用独占资源==============================================================================
    $params = [
        'Key' => 'xxx',
        // 'UUIDs' => '', //独占资源编号uuid，用逗号隔开
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::getMonopolizeResources($params); 
    var_dump($result);die;

    //=======重拨独占资源==============================================================================
    $params = [
        'Key' => 'xxx',
        'UUIDs' => '', //独占资源编号uuid，用逗号隔开
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::redialMonopolizeResources($params); 
    var_dump($result);die;

    //=======释放独占资源==============================================================================
    $params = [
        'Key' => 'xxx',
        'UUIDs' => '', //独占资源编号uuid，用逗号隔开
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::releaseMonopolizeResources($params); 
    var_dump($result);die;

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

    //========查询空闲独占资源=============================================================================
    $params = [
        'Key' => 'xxx',
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::getIdleMonopolizeResources($params);
    var_dump($result);die;

} catch (\Throwable $th) {
    var_dump($th->getMessage());
}