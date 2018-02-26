<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher;

use xutl\pusher\contracts\PushInterface;
use xutl\pusher\support\Config;

/**
 * Class Pusher
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class Pusher
{
    const STATUS_SUCCESS = 'success';

    const STATUS_FAILURE = 'failure';

    /**
     * @var \xutl\pusher\PusherManager
     */
    protected $pushManager;

    /**
     * Messenger constructor.
     *
     * @param \xutl\pusher\PusherManager $pushManager
     */
    public function __construct(PusherManager $pushManager)
    {
        $this->pushManager = $pushManager;
    }

    /**
     * 发送
     * @param array|PushInterface $push
     * @param array $channels 渠道列表
     * @return array
     * @throws NoChannelAvailableException
     */
    public function send($push, array $channels = [])
    {
        $push = $this->formatPush($push);
        if (empty($channels)) {
            $channels = $push->getChannels();
        }
        if (empty($channels)) {
            $channels = $this->pushManager->getConfig()->get('channels', []);
        }
        $channels = $this->formatChannels($channels);
        $results = [];
        $isSuccessful = false;
        foreach ($channels as $channel) {
            try {
                $results[$channel] = [
                    'status' => self::STATUS_SUCCESS,
                    'result' => $this->pushManager->channel($channel)->send($push, new Config($channels[$channel])),
                ];
                $isSuccessful = true;
                break;
            } catch (ChannelException $e) {
                $results[$channel] = [
                    'status' => self::STATUS_FAILURE,
                    'exception' => $e,
                ];
                continue;
            }
        }
        if (!$isSuccessful) {
            throw new NoChannelAvailableException($results);
        }
        return $results;
    }

    /**
     * 格式化待推送内容
     * @param array|string|PushInterface $push
     * @return PushInterface
     */
    protected function formatPush($push)
    {
        if (!($push instanceof PushInterface)) {
            if (!is_array($push)) {
                $push = [
                    'type' => PushInterface::TYPE_NOTICE,
                    'target' => PushInterface::TARGET_ALL,
                    'targetValue' => 'all',
                    'title' => strval($push),
                    'body' => strval($push),
                ];
            }
            $push = new Push($push);
        }
        return $push;
    }

    /**
     * 格式化渠道
     * @param array $channels
     *
     * @return array
     */
    protected function formatChannels(array $channels)
    {
        $formatted = [];
        $config = $this->pushManager->getConfig();
        foreach ($channels as $channel => $setting) {
            if (is_int($channel) && is_string($setting)) {
                $channel = $setting;
                $setting = [];
            }
            $formatted[$channel] = $setting;
            $globalSetting = $config->get("channels.{$channel}", []);
            if (is_string($channel) && !empty($globalSetting) && is_array($setting)) {
                $formatted[$channel] = array_merge($globalSetting, $setting);
            }
        }
        return $formatted;
    }
}