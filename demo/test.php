<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

include __DIR__ . '/../vendor/autoload.php';

use xutl\pusher\PusherManager;
use xutl\pusher\contracts\PushInterface;

$config = [
    // HTTP 请求的超时时间（秒）
    'timeout' => 5.0,
    // 可用的网关配置
    'channels' => [
        'aliyun' => [
            'accessId' => '123123',
            'accessKey' => '123123',
            'appKey' => '24599484',
        ],
    ],
];

$pusherManager = new PusherManager($config);


$pusherManager->send([
    'pushType' => PushInterface::TYPE_MESSAGE,
    'target' => PushInterface::TARGET_ALL,
    'targetValue' => 'all',
    'title' => '测试推送标题',
    'body' => '123123',
    'data' => [
        'code' => 123123
    ],
]);