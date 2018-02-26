<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher;

use InvalidArgumentException;
use xutl\pusher\contracts\ChannelInterface;
use xutl\pusher\contracts\PushInterface;
use xutl\pusher\support\Config;

/**
 * Class PushManager
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class PusherManager
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
     * @param PushInterface|array $push 消息内容
     * @param array $channels 指定渠道
     * @return array
     * @throws NoChannelAvailableException
     */
    public function send($push, array $channels = [])
    {
        return $this->getPusher()->send($push, $channels);
    }

    /**
     * Create a channel.
     *
     * @param string|null $name
     * @return ChannelInterface
     */
    public function channel($name)
    {
        //$name = $name ?: $this->getDefaultChannel();
        if (!isset($this->channels[$name])) {
            $this->channels[$name] = $this->createChannel($name);
        }
        return $this->channels[$name];
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
    public function getPusher()
    {
        return $this->pusher ?: $this->pusher = new Pusher($this);
    }

    /**
     * Create a new driver instance.
     *
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return ChannelInterface
     */
    protected function createChannel($name)
    {
        $className = $this->formatChannelClassName($name);
        $channel = $this->makeChannel($className, $this->config->get("channels.{$name}", []));

        if (!($channel instanceof ChannelInterface)) {
            throw new InvalidArgumentException(sprintf('Channel "%s" not inherited from %s.', $name, ChannelInterface::class));
        }

        return $channel;
    }

    /**
     * Make channel instance.
     *
     * @param string $channel
     * @param array  $config
     * @return ChannelInterface
     */
    protected function makeChannel($channel, $config)
    {
        if (!class_exists($channel)) {
            throw new InvalidArgumentException(sprintf('Channel "%s" not exists.', $channel));
        }
        return new $channel($config);
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
        return __NAMESPACE__ . "\\channels\\{$name}Channel";
    }
}