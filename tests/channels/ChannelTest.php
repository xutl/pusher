<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher\tests\channels;

use xutl\pusher\contracts\PushInterface;
use xutl\pusher\channels\Channel;
use xutl\pusher\support\Config;
use xutl\pusher\tests\TestCase;

class ChannelTest extends TestCase
{
    public function testTimeout()
    {
        $channel = new DummyChannelForChannelTest(['foo' => 'bar']);

        $this->assertInstanceOf(Config::class, $channel->getConfig());
        $this->assertSame(5.0, $channel->getTimeout());
        $channel->setTimeout(4.0);
        $this->assertSame(4.0, $channel->getTimeout());

        $channel = new DummyChannelForChannelTest(['foo' => 'bar', 'timeout' => 12.0]);
        $this->assertSame(12.0, $channel->getTimeout());
    }

    public function testConfigSetterAndGetter()
    {
        $channel = new DummyChannelForChannelTest(['foo' => 'bar']);

        $this->assertInstanceOf(Config::class, $channel->getConfig());

        $config = new Config(['name' => 'overtrue']);
        $this->assertSame($config, $channel->setConfig($config)->getConfig());
    }
}

class DummyChannelForChannelTest extends Channel
{
    public function send(PushInterface $push, Config $config)
    {
        return 'mock-result';
    }
}