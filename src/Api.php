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
    const MonopolizeResourcesUrl = self::Url . '/monopolies';
    const NewestIpsUrl = self::Url . '/monopolies/ips';
    const IdleUrl = self::Url . '/monopolies/idle';
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
        return self::sendRequest(self::AllocateUrl, $params);
    }

    /**
     * 获取IP资源池
     *
     * @param array $params
     * @return array
     */
    public static function extract(array $params = []): array
    {
        return self::sendRequest(self::ExtractUrl, $params);
    }

    /**
     * 查询IP资源
     *
     * @param array $params
     * @return array
     */
    public static function query(array $params = [])
    {
        return self::sendRequest(self::QueryUrl, $params);
    }

    /**
     * 释放IP资源
     *
     * @param array $params
     * @return array
     */
    public static function release(array $params = [])
    {
        return self::sendRequest(self::ReleaseUrl, $params);
    }

    /**
     * 更换IP资源
     *
     * @param array $params
     * @return array
     */
    public static function replace(array $params = [])
    {
        return self::sendRequest(self::ReplaceUrl, $params);
    }

    /**
     * 申请独占资源
     *
     * @param array $params
     * @return array
     */
    public static function monopolizeResources(array $params = [])
    {
        return self::sendRequest(self::MonopolizeResourcesUrl, $params, 'post');
    }

    /**
     * 查询可用独占资源
     *
     * @param array $params
     * @return array
     */
    public static function getMonopolizeResources(array $params = [])
    {
        return self::sendRequest(self::MonopolizeResourcesUrl, $params);
    }


    /**
     * 重拨独占资源
     *
     * @param array $params
     * @return array
     */
    public static function redialMonopolizeResources(array $params = [])
    {
        return self::sendRequest(self::NewestIpsUrl, $params, 'put');
    }

    /**
     * 释放独占资源
     *
     * @param array $params
     * @return array
     */
    public static function releaseMonopolizeResources(array $params = [])
    {
        return self::sendRequest(self::MonopolizeResourcesUrl, $params, 'delete');
    }

    /**
     * 查询空闲独占资源
     *
     * @param array $params
     * @return array
     */
    public static function getIdleMonopolizeResources(array $params = [])
    {
        return self::sendRequest(self::IdleUrl, $params);
    }

    /**
     * 添加白名单
     *
     * @param array $params
     * @return array
     */
    public static function addWhitelist(array $params = [])
    {
        return self::sendRequest(self::WhitelistAddUrl, $params);
    }

    /**
     * 删除白名单
     *
     * @param array $params
     * @return array
     */
    public static function delWhitelist(array $params = [])
    {
        return self::sendRequest(self::WhitelistDelUrl, $params);
        
    }

    /**
     * 查询白名单
     *
     * @param array $params
     * @return array
     */
    public static function queyrWhitelist(array $params = [])
    {
        return self::sendRequest(self::WhitelistQueryUrl, $params);
    }

    /**
     * 查询通道配额
     *
     * @param array $params
     * @return array
     */
    public static function infoQuota(array $params = [])
    {
        return self::sendRequest(self::InfoQuotaUrl, $params);
    }

    /**
     * 区域查询
     *
     * @param array $params
     * @return array
     */
    public static function resources(array $params = [])
    {
        return self::sendRequest(self::ResourcesUrl, $params);
    }

   
    public static function sendRequest(string $api, array $params = [], string $method = 'get'): array
    {
        $curl = new \Curl\Curl();
        $result = $curl->$method($api, $params);
        if ($result->error) {
            $curl->close();
            $msg = $result->error_message;
            if(!empty($result->response)){
                $msg = json_decode($result->response, true)['error'] ?? $result->error_message;
            }
            return ['Code' => $result->error_code, 'Msg' => $msg];
        }
        $curl->close();
        return json_decode($result->response, true) ?? [];
    }
}
