<?php

namespace qgproxy;

class Api
{
    const Url = 'https://proxy.qg.net';
    const AllocateUrl = self::Url . '/allocate';
    const ExtractUrl = self::Url . '/extract';
    const QueryUrl = self::Url . '/query';
    const ReleaseUrl = self::Url . '/release';
    const ReplaceUrl = self::Url . '/replace';
    const MonopolizeResourcesUrl = self::Url . '/monopolize_resources';
    const NewestIpsUrl = self::Url . '/monopolize_resources/newest_ips';
    const IdleUrl = self::Url . '/monopolize_resources/idle';
    const WhitelistAddUrl = self::Url . '/whitelist/add';
    const WhitelistDelUrl = self::Url . '/whitelist/del';
    const WhitelistQueryUrl = self::Url . '/whitelist/query';
    const InfoQuotaUrl = self::Url . '/info/quota';
    const ResourcesUrl = self::Url . '/resources';

    /**
     * 提取IP资源
     *
     * @param array $params
     * @return array
     */
    public static function allocate(array $params = []): array
    {
        $result = file_get_contents(self::AllocateUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 获取IP资源池
     *
     * @param array $params
     * @return array
     */
    public static function extract(array $params = []): array
    {
        $result = file_get_contents(self::ExtractUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 查询IP资源
     *
     * @param array $params
     * @return array
     */
    public static function query(array $params = [])
    {
        $result = file_get_contents(self::QueryUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 释放IP资源
     *
     * @param array $params
     * @return array
     */
    public static function release(array $params = [])
    {
        $result = file_get_contents(self::ReleaseUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 更换IP资源
     *
     * @param array $params
     * @return array
     */
    public static function replace(array $params = [])
    {
        $result = file_get_contents(self::ReplaceUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 申请独占资源
     *
     * @param array $params
     * @return array
     */
    public static function monopolizeResources(array $params = [])
    {
        $options = [
            'http' => [
              'method' => 'POST',
              'header' => 'Content-type:application/x-www-form-urlencoded',
              'content' => $params,
              'timeout' => 60 // 超时时间（单位:s）
            ]
        ];
        $result = file_get_contents(self::MonopolizeResourcesUrl . '?' . http_build_query($params), false, $options);
        return json_decode($result, true) ?? [];
    }

    /**
     * 查询可用独占资源
     *
     * @param array $params
     * @return array
     */
    public static function getMonopolizeResources(array $params = [])
    {
        $result = file_get_contents(self::MonopolizeResourcesUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }


    /**
     * 重拨独占资源
     *
     * @param array $params
     * @return array
     */
    public static function redialMonopolizeResources(array $params = [])
    {
        $options = [
            'http' => [
              'method' => 'PUT',
              'header' => 'Content-type:application/x-www-form-urlencoded',
              'content' => $params,
              'timeout' => 60 // 超时时间（单位:s）
            ]
        ];
        $result = file_get_contents(self::NewestIpsUrl . '?' . http_build_query($params), false, $options);
        return json_decode($result, true) ?? [];
    }

    /**
     * 释放独占资源
     *
     * @param array $params
     * @return array
     */
    public static function releaseMonopolizeResources(array $params = [])
    {
        $options = [
            'http' => [
              'method' => 'DELETE',
              'header' => 'Content-type:application/x-www-form-urlencoded',
              'content' => $params,
              'timeout' => 60 // 超时时间（单位:s）
            ]
        ];
        $result = file_get_contents(self::MonopolizeResourcesUrl . '?' . http_build_query($params), false, $options);
        return json_decode($result, true) ?? [];
    }

    /**
     * 查询空闲独占资源
     *
     * @param array $params
     * @return array
     */
    public static function getIdleMonopolizeResources(array $params = [])
    {
        $result = file_get_contents(self::IdleUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 添加白名单
     *
     * @param array $params
     * @return array
     */
    public static function addWhitelist(array $params = [])
    {
        $result = file_get_contents(self::WhitelistAddUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 删除白名单
     *
     * @param array $params
     * @return array
     */
    public static function delWhitelist(array $params = [])
    {
        $result = file_get_contents(self::WhitelistDelUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 查询白名单
     *
     * @param array $params
     * @return array
     */
    public static function queyrWhitelist(array $params = [])
    {
        $result = file_get_contents(self::WhitelistQueryUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 查询通道配额
     *
     * @param array $params
     * @return array
     */
    public static function infoQuota(array $params = [])
    {
        $result = file_get_contents(self::InfoQuotaUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 区域查询
     *
     * @param array $params
     * @return array
     */
    public static function resources(array $params = [])
    {
        $result = file_get_contents(self::ResourcesUrl . '?' . http_build_query($params));
        return json_decode($result, true) ?? [];
    }

    /**
     * 请求
     *
     * @param [type] $targetUrl 目标站点
     * @param [type] $proxyIp   代理ip
     * @param [type] $proxyPort  代理端口
     * @param [type] $proxyUser   authKey(key)
     * @param [type] $proxyPassword  authpwd(密码)
     * @return void
     */
    public static function sendRequest($targetUrl, $proxyIp, $proxyPort, $proxyUser, $proxyPassword)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, $proxyIp);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyUser . ':' . $proxyPassword);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
