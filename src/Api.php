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
        return self::sendRequest(self::_buildUrl(self::QueryUrl, $params), $params);
    }

    /**
     * 释放IP资源
     *
     * @param array $params
     * @return array
     */
    public static function release(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::ReleaseUrl, $params), $params);
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
        return self::sendRequest(self::_buildUrl(self::MonopolizeResourcesUrl, $params), $params, 'post');
    }

    /**
     * 查询可用独占资源
     *
     * @param array $params
     * @return array
     */
    public static function getMonopolizeResources(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::MonopolizeResourcesUrl, $params), $params);
    }


    /**
     * 重拨独占资源
     *
     * @param array $params
     * @return array
     */
    public static function redialMonopolizeResources(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::NewestIpsUrl, $params), $params, 'put');
    }

    /**
     * 释放独占资源
     *
     * @param array $params
     * @return array
     */
    public static function releaseMonopolizeResources(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::MonopolizeResourcesUrl, $params), $params, 'delete');
    }

    /**
     * 查询空闲独占资源
     *
     * @param array $params
     * @return array
     */
    public static function getIdleMonopolizeResources(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::IdleUrl, $params), $params);
    }

    /**
     * 添加白名单
     *
     * @param array $params
     * @return array
     */
    public static function addWhitelist(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::WhitelistAddUrl, $params), $params);
    }

    /**
     * 删除白名单
     *
     * @param array $params
     * @return array
     */
    public static function delWhitelist(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::WhitelistDelUrl, $params), $params);
        
    }

    /**
     * 查询白名单
     *
     * @param array $params
     * @return array
     */
    public static function queyrWhitelist(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::WhitelistQueryUrl, $params), $params);
    }

    /**
     * 查询通道配额
     *
     * @param array $params
     * @return array
     */
    public static function infoQuota(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::InfoQuotaUrl, $params), $params);
    }

    /**
     * 区域查询
     *
     * @param array $params
     * @return array
     */
    public static function resources(array $params = [])
    {
        return self::sendRequest(self::_buildUrl(self::ResourcesUrl, $params), $params);
    }

   
    public static function sendRequest(string $api, array $params = [], string $method = 'get'): array
    {
        $curl = new \Curl\Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, FALSE);
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

    private function _buildUrl(string $url , array $params): string
    {
        if(isset($params['Pwd'])){
            return $url . '?Pwd='.trim($params['Pwd']);
        }
        return $url;
    }
}
