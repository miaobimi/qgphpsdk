<?php

namespace qgsdk;

class Api
{
    const Url = '';
    const AllocateUrl = self::Url . '/allocate';
    const ExtractUrl = self::Url . '/extract';
    const QueryUrl = self::Url . '/query';
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

    public static function query(array $params = [])
    {
        return file_get_contents(self::QueryUrl . '?' . http_build_query($params));
    }

    public static function addWhitelist(array $params = [])
    {
        return file_get_contents(self::WhitelistAddUrl . '?' . http_build_query($params));
    }

    public static function delWhitelist(array $params = [])
    {
        return file_get_contents(self::WhitelistDelUrl . '?' . http_build_query($params));
    }

    public static function queyrWhitelist(array $params = [])
    {
        return file_get_contents(self::WhitelistQueryUrl . '?' . http_build_query($params));
    }

    public static function infoQuota(array $params = [])
    {
        return file_get_contents(self::InfoQuotaUrl . '?' . http_build_query($params));
    }

    public static function resources(array $params = [])
    {
        return file_get_contents(self::ResourcesUrl . '?' . http_build_query($params));
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
