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
        // 'AreaCode' => '', //区域编号(调用区域查询接口获得)
        // 'Operator' => '', //运营商 1:电信,2:移动,3:联通,4:BGP
    ]; 
    $result = Api::monopolizeResources($params); 
    var_dump($result);die;

    //========使用代理IP=============================================================================
    
    // $targetUrl 目标站点
    // $proxyIp   代理ip
    // $proxyPort  代理端口
    // $proxyUser   authKey(key)
    // $proxyPassword  authpwd(密码)
    $result = Api::sendRequest($targetUrl, $proxyIp, $proxyPort, $proxyUser, $proxyPassword);
    var_dump($result);die;

    //=======查询可用独占资源==============================================================================
    $params = [
        'Key' => 'xxx',
        // 'UUIDs' => '', //独占资源编号uuid，用逗号隔开
    ]; 
    $result = Api::getMonopolizeResources($params); 
    var_dump($result);die;

    //=======重拨独占资源==============================================================================
    $params = [
        'Key' => 'xxx',
        'UUIDs' => '', //独占资源编号uuid，用逗号隔开
    ]; 
    $result = Api::redialMonopolizeResources($params); 
    var_dump($result);die;

    //=======释放独占资源==============================================================================
    $params = [
        'Key' => 'xxx',
        'UUIDs' => '', //独占资源编号uuid，用逗号隔开
    ]; 
    $result = Api::releaseMonopolizeResources($params); 
    var_dump($result);die;

    //=======添加白名单==============================================================================
    $params = [
        'Key' => 'xxx',
        // 'IP' => '', //IP地址;多个用,分隔
    ]; 
    $result = Api::addWhitelist($params);  
    var_dump($result);die;

    //=======删除白名单==============================================================================
    $params = [
        'Key' => 'xxx',
        // 'IP' => '', //IP地址;多个用,分隔
    ]; 
    $result = Api::delWhitelist($params);
    var_dump($result);die;

    //========查询白名单=============================================================================
    $params = [
        'Key' => 'xxx',
    ]; 
    $result = Api::queyrWhitelist($params);
    var_dump($result);die;

    //========查询空闲独占资源=============================================================================
    $params = [
        'Key' => 'xxx',
    ]; 
    $result = Api::getIdleMonopolizeResources($params);
    var_dump($result);die;

} catch (\Throwable $th) {
    var_dump($th->getMessage());
}