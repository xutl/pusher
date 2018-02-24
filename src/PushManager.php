<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher;

class PushManager
{
    /**
     * @var Pusher
     */
    protected $pusher;

    /**
     * @var array 渠道列表
     */
    protected $channels = [];
}