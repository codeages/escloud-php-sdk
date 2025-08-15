<?php

namespace ESCloud\SDK\Service;

use ESCloud\SDK\Exception\SDKException;

class MapService extends BaseService
{
    protected $host = 'map.edusoho.cn';

    protected $service = 'Map';

    /**
     * 将GPS坐标转换为百度经纬度坐标
     *
     * @param float $longitude
     * @param float $latitude
     * @return array|mixed
     * @throws SDKException
     * @throws \ESCloud\SDK\Exception\ResponseException
     * @throws \ESCloud\SDK\HttpClient\ClientException
     */
    public function wgs84ToBd09(float $longitude, float $latitude)
    {
        return $this->request('POST', '/api/v1/location/wgs84ToBd09', ['longitude' => $longitude, 'latitude' => $latitude]);
    }

    /**
     * 将高德/腾讯坐标转换为百度经纬度坐标
     *
     * @param float $longitude
     * @param float $latitude
     * @return array|mixed
     * @throws SDKException
     * @throws \ESCloud\SDK\Exception\ResponseException
     * @throws \ESCloud\SDK\HttpClient\ClientException
     */
    public function gcj02ToBd09(float $longitude, float $latitude)
    {
        return $this->request('POST', '/api/v1/location/gcj02ToBd09', ['longitude' => $longitude, 'latitude' => $latitude]);
    }

    /**
     * 计算一个中心点与其他一系列坐标点的距离
     *
     * @param float $longitude
     * @param float $latitude
     * @param array $targets
     * @return array|mixed
     * @throws SDKException
     * @throws \ESCloud\SDK\Exception\ResponseException
     * @throws \ESCloud\SDK\HttpClient\ClientException
     */
    public function distances(float $longitude, float $latitude, array $targets)
    {
        if (empty($targets)) {
            throw new SDKException('Targets is empty.');
        }
        foreach ($targets as $target) {
            if (empty($target) || !is_array($target) || !isset($target['longitude']) || !isset($target['latitude'])) {
                throw new SDKException('Targets is invalid.');
            }
        }

        return $this->request('POST', '/api/v1/location/distances', [
            'origin' => ['longitude' => $longitude, 'latitude' => $latitude],
            'targets' => $targets,
        ]);
    }

    /**
     * 获取地图服务状态
     *
     * @return array|mixed
     * @throws SDKException
     * @throws \ESCloud\SDK\Exception\ResponseException
     * @throws \ESCloud\SDK\HttpClient\ClientException
     */
    public function status()
    {
        return $this->request('GET', '/api/v1/tenant/status');
    }

    /**
     * 获取地图服务代理URL
     *
     * @return string
     */
    public function proxyUrl()
    {
        return '//'.$this->host.'/proxy/'.$this->getProxyToken();
    }

    public function getProxyToken()
    {
        return str_replace('Bearer ', '', $this->auth->makeRequestAuthorization('', '', 3600, true, $this->service));
    }
}
