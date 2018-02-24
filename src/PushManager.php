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
 * Class PushManager
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class PushManager
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Pusher
     */
    protected $pusher;

    /**
     * @var array 渠道列表
     */
    protected $channels = [];

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * Send a message.
     *
     * @param string|array $to
     * @param PushInterface|array $message
     * @param array $gateways
     * @return array
     */
    public function send($to, $message, array $gateways = [])
    {
        return $this->getPusher()->send($to, $message, $gateways);
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return Pusher
     */
    public function getMessenger()
    {
        return $this->pusher ?: $this->pusher = new Pusher($this);
    }

    /**
     * Format channel name.
     *
     * @param string $name
     * @return string
     */
    protected function formatChannelClassName($name)
    {
        if (class_exists($name)) {
            return $name;
        }
        $name = ucfirst(str_replace(['-', '_', ''], '', $name));
        return __NAMESPACE__ . "\\channels\\{$name}";
    }
}