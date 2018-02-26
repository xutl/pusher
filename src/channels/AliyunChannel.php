<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher\channels;

use xutl\pusher\ChannelException;
use xutl\pusher\contracts\PushInterface;
use xutl\pusher\support\Config;
use xutl\pusher\traits\HasHttpRequest;

/**
 * Class AliyunChannel
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class AliyunChannel extends Channel
{
    use HasHttpRequest;

    const SIGNATURE_METHOD_HMACSHA1 = 'HMAC-SHA1';
    const SIGNATURE_METHOD_HMACSHA256 = 'HMAC-SHA256';
    const ENDPOINT_FORMAT = 'JSON';
    const ENDPOINT_VERSION = '2016-08-01';
    const ENDPOINT_URL = 'https://cloudpush.aliyuncs.com';
    const ENDPOINT_SIGNATURE_METHOD = 'HMAC-SHA1';
    const ENDPOINT_SIGNATURE_VERSION = '1.0';

    /**
     * Get channel name.
     *
     * @return string
     */
    public function getName()
    {
        return 'aliyun';
    }

    /**
     * Send a message.
     *
     * @param PushInterface $push
     * @param \xutl\pusher\support\Config $config
     * @return array
     * @throws \xutl\pusher\ChannelException
     */
    public function send(PushInterface $push, Config $config)
    {
        $params = [
            'AccessKeyId' => $config->get('accessId'),
            'Format' => self::ENDPOINT_FORMAT,
            'SignatureMethod' => self::ENDPOINT_SIGNATURE_METHOD,
            'SignatureVersion' => self::ENDPOINT_SIGNATURE_VERSION,
            'SignatureNonce' => uniqid(),
            'Timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
            'Version' => self::ENDPOINT_VERSION,
            'Action' => 'Push',
            'AppKey' => $config->get('appKey'),
            'Target' => $push->getTarget(),
            'TargetValue' => $push->getTargetValue(),
            'DeviceType' => $push->getDeviceType(),
            'PushType' => $push->getType(),
            'Title' => $push->getTitle(),
            'Body' => $push->getBody(),
        ];

        $params['Signature'] = $this->generateSign($params);
        $result = $this->post(self::ENDPOINT_URL, $params);
        if ('OK' != $result['Code']) {
            throw new ChannelException($result['Message'], $result['Code'], $result);
        }
        return $result;
    }

    /**
     * Generate Sign.
     *
     * @param array $params
     *
     * @return string
     */
    protected function generateSign($params)
    {
        ksort($params);
        $accessKeySecret = $this->config->get('accessKey');
        $stringToSign = 'POST&%2F&' . urlencode(http_build_query($params, null, '&', PHP_QUERY_RFC3986));
        return base64_encode(hash_hmac('sha1', $stringToSign, $accessKeySecret . '&', true));
    }
}