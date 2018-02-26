<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher\tests;


use xutl\pusher\contracts\ChannelInterface;
use xutl\pusher\contracts\PushInterface;
use xutl\pusher\Pusher;
use xutl\pusher\PusherManager;
use xutl\pusher\support\Config;

class PusherManagerTest extends TestCase
{
    public function testGetPusher()
    {
        $pusherManager = new PusherManager([]);
        $this->assertInstanceOf(Pusher::class, $pusherManager->getPusher());
    }
}


class DummyChannelForTest implements ChannelInterface
{
    public function getName()
    {
        return 'name';
    }

    public function send(PushInterface $push, Config $config)
    {
        return 'send-result';
    }
}


class DummyInvalidChannelForTest
{
    // nothing
}
