<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher\contracts;

use xutl\pusher\support\Config;

/**
 * 渠道接口
 * @package xutl\pusher
 */
interface ChannelInterface
{
    /**
     * Get channel name.
     *
     * @return string
     */
    public function getName();

    /**
     * Send a message.
     *
     * @param int|string|array $target
     * @param PushInterface $message
     * @param \xutl\pusher\support\Config $config
     * @return array
     * @throws \xutl\pusher\ChannelException
     */
    public function send($target, PushInterface $message, Config $config);
}