<?php

include '../vendor/autoload.php';
    
use qgproxy\Api;

/**
 * 动态共享demo
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
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了IP提取鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::allocate($params); 
    var_dump($result);die;

    //========获取IP资源池============================================================================
    $params = [
        'Key' => 'xxx',
        // 'Num' => 1, //申请数量，默认为1
        // 'AreaId' => '', //区域编号(https://www.qg.net/doc/1439.html)
        // 'Isp' => '', //运营商ID;选填;默认查询全部
        // 'Detail' => 0, //查看详情，0为关闭，默认为0
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了IP提取鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::extract($params); 
    var_dump($result);die;

    //=======查询IP资源==============================================================================
    $params = [
        'Key' => 'xxx',
        // 'TaskID' => '', //任务ID;多个用,分隔;全部以”* “表示
        // 'Detail' => 0, //查看详情，0为关闭，默认为0
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::query($params); 
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

    //========通道配额=============================================================================
    $params = [
        'Key' => 'xxx',
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::infoQuota($params);
    var_dump($result);die;

    //=========区域查询============================================================================
    $params = [
        'Key' => 'xxx',
        // 'AreaId' => '', //区域编号(https://www.qg.net/doc/1439.html)
        // 'Isp' => '', //运营商ID;选填;默认查询全部
        // 'Status' => 0, //可用状态;0为不可用,1为可用;选填;默认全部
        // 'Pwd' => '', //AuthPwd 如果在用户中心开启了API鉴权 密钥密码模式  则需要传此参数
    ]; 
    $result = Api::resources($params);
    var_dump($result);die;

    //=====================================================================================

} catch (\Throwable $th) {
    var_dump($th->getMessage());
}