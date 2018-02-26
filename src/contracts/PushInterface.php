<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher\contracts;

/**
 * Interface PushInterface
 * @package xutl\pusher
 */
interface PushInterface
{
    //推送类型
    const TYPE_NOTICE = 'NOTICE';
    const TYPE_MESSAGE = 'MESSAGE';

    //推送目标
    const TARGET_DEVICE = 'DEVICE';
    const TARGET_ACCOUNT = 'ACCOUNT';
    const TARGET_ALIAS = 'ALIAS';
    const TARGET_TAG = 'TAG';
    const TARGET_ALL = 'ALL';

    /**
     * Return the push target.
     *
     * @param ChannelInterface|null $channel
     * @return string
     */
    public function getTarget(ChannelInterface $channel = null);

    /**
     * Return the push target value.
     * @param ChannelInterface|null $channel
     * @return string
     */
    public function getTargetValue(ChannelInterface $channel = null);

    /**
     * Return the push device type.
     * @param ChannelInterface|null $channel
     * @return string
     */
    public function getDeviceType(ChannelInterface $channel = null);

    /**
     * Return the push type.
     *
     * @param ChannelInterface|null $channel
     * @return string
     */
    public function getType(ChannelInterface $channel = null);

    /**
     * Return the title id of message.
     *
     * @param \xutl\pusher\contracts\ChannelInterface|null $channel
     * @return string
     */
    public function getTitle(ChannelInterface $channel = null);

    /**
     * Return message body.
     *
     * @param \xutl\pusher\contracts\ChannelInterface|null $channel
     * @return string
     */
    public function getBody(ChannelInterface $channel = null);

    /**
     * Return the template data of message.
     *
     * @param \xutl\pusher\contracts\ChannelInterface|null $channel
     * @return array
     */
    public function getData(ChannelInterface $channel = null);

    /**
     * Return message supported channels.
     *
     * @return array
     */
    public function getChannels();
}