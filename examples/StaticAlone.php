<?php

include '../vendor/autoload.php';
    
use qgproxy\Api;

/**
 * 静态独享demo
 */

try {

    //========提取IP资源=============================================================================
    $params = [
        'Key' => 'xxx',
        // 'Num' => 1, //申请数量，默认为1
        // 'AreaId' => '', //区域编号(https://www.qg.net/doc/1439.html)
        // 'Isp' => '', //运营商ID;选填;默认查询全部
        // 'Detail' => 0, //是否查看详情(可查看到具体的省市县信息)
        // 'Distinct' => 0, //去重，1为开启，默认为0，仅对动态IP有用
    ]; 
    $result = Api::allocate($params); 
    var_dump($result);die;

    //=======查询IP资源==============================================================================
    $params = [
        'Key' => 'xxx',
        // 'TaskID' => '', //任务ID;多个用,分隔;全部以”* “表示
        // 'Detail' => 0, //查看详情，0为关闭，默认为0
    ]; 
    $result = Api::query($params); 
    var_dump($result);die;

    //========释放IP=============================================================================
    $params = [
        'Key' => 'xxx',
        'IP' => '8.8.8.8', //节点IP，多个用“，”分隔，全部以”* “表示
        // 'TaskID' => '', //任务ID;多个用,分隔;全部以”* “表示
    ]; 
    $result = Api::release($params); 
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

    //========通道配额=============================================================================
    $params = [
        'Key' => 'xxx',
    ]; 
    $result = Api::infoQuota($params);
    var_dump($result);die;

    //=========区域查询============================================================================
    $params = [
        'Key' => 'xxx',
        // 'AreaId' => '', //区域编号(https://www.qg.net/doc/1439.html)
        // 'Isp' => '', //运营商ID;选填;默认查询全部
        // 'Status' => 0, //可用状态;0为不可用,1为可用;选填;默认全部
    ]; 
    $result = Api::resources($params);
    var_dump($result);die;

    //=====================================================================================

} catch (\Throwable $th) {
    var_dump($th->getMessage());
}