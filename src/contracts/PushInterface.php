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
    const TYPE_NOTICE = 'NOTICE';

    const TYPE_MESSAGE = 'MESSAGE';

    /**
     * Return the push type.
     *
     * @return string
     */
    public function getPushType();

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