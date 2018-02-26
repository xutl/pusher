<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher;

use xutl\pusher\contracts\ChannelInterface;
use xutl\pusher\contracts\PushInterface;

/**
 * Class MessagePush
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class Push implements PushInterface
{
    /**
     * @var array
     */
    protected $channels = [];

    /**
     * @var string
     */
    protected $target;

    /**
     * @var string
     */
    protected $targetValue;

    /**
     * @var string
     */
    protected $deviceType;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Message constructor.
     *
     * @param array $attributes
     * @param string $type
     */
    public function __construct(array $attributes = [], $type = PushInterface::TYPE_NOTICE)
    {
        $this->type = $type;
        foreach ($attributes as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Return the push target.
     *
     * @param ChannelInterface|null $channel
     * @return string
     */
    public function getTarget(ChannelInterface $channel = null)
    {
        return $this->target;
    }

    /**
     * @param string $target
     * @return $this
     */
    public function setTarget(string $target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * Return the push target value.
     *
     * @param ChannelInterface|null $channel
     * @return string
     */
    public function getTargetValue(ChannelInterface $channel = null)
    {
        return $this->targetValue;
    }

    /**
     * Set the push target value.
     *
     * @param string $targetValue
     * @return string
     */
    public function setTargetValue($targetValue)
    {
        $this->targetValue = $targetValue;
        return $this;
    }

    /**
     * Return the push device type.
     *
     * @param ChannelInterface|null $channel
     * @return string
     */
    public function getDeviceType(ChannelInterface $channel = null)
    {
        return $this->deviceType;
    }

    /**
     * Set the push device type.
     *
     * @param string $deviceType
     * @return string
     */
    public function setDeviceType($deviceType)
    {
        return $this->deviceType = $deviceType;
    }

    /**
     * Return the push type.
     *
     * @param ChannelInterface|null $channel
     * @return string
     */
    public function getType(ChannelInterface $channel = null)
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Return the title id of message.
     *
     * @param \xutl\pusher\contracts\ChannelInterface|null $channel
     * @return string
     */
    public function getTitle(ChannelInterface $channel = null)
    {
        return $this->title;
    }

    /**
     * Return the title id of message.
     *
     * @param string $title
     * @return string
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Return push content.
     * @param ChannelInterface|null $channel
     * @return string
     */
    public function getBody(ChannelInterface $channel = null)
    {
        return $this->body;
    }

    /**
     * @param mixed $content
     * @return $this
     */
    public function setBody($content)
    {
        $this->body = $content;
        return $this;
    }

    /**
     * @param ChannelInterface|null $channel
     * @return array
     */
    public function getData(ChannelInterface $channel = null)
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * @param array $channels
     *
     * @return $this
     */
    public function setChannels(array $channels)
    {
        $this->channels = $channels;
        return $this;
    }

    /**
     * @param $property
     * @return string
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }


}