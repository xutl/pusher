<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher;
use xutl\pusher\contracts\PushInterface;

/**
 * Class Pusher
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class Pusher
{
    /**
     * @var \xutl\pusher\PushManager
     */
    protected $pushManager;

    /**
     * Messenger constructor.
     *
     * @param \xutl\pusher\PushManager $pushManager
     */
    public function __construct(PushManager $pushManager)
    {
        $this->pushManager = $pushManager;
    }

    public function send($to, $message, array $channels = [])
    {
        $message = $this->formatMessage($message);

        
    }

    /**
     * 格式化消息
     * @param array|string|PushInterface $message
     * @return PushInterface
     */
    protected function formatMessage($message)
    {
        if (!($message instanceof PushInterface)) {
            if (!is_array($message)) {
                $message = [
                    'title' => strval($message),
                    'body' => strval($message),
                ];
            }
            $message = new Push($message);
        }
        return $message;
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