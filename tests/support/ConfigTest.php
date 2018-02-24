<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher\tests\support;

use xutl\pusher\support\Config;
use xutl\pusher\tests\TestCase;

class ConfigTest extends TestCase
{
    public function testConfig()
    {
        $config = new Config([
            'foo' => 'bar',
            'bar' => [
                'screen_name' => 'aaa',
                'profile' => [
                    'id' => 9999,
                    'name' => 'test',
                ],
            ],
            'numbers' => [
                [
                    'id' => 1,
                    'number' => 1,
                ],
                [
                    'id' => 2,
                    'number' => 2,
                ],
            ],
        ]);

        $this->assertTrue(isset($config['foo']));

        $this->assertSame('bar', $config['foo']);
        $this->assertSame('bar', $config->get('foo'));
        $this->assertNull($config->get(null));

        $this->assertSame(9999, $config->get('bar.profile.id'));
        $this->assertSame('test', $config->get('bar.profile.name'));

        $this->assertSame(1, $config->get('numbers.0.id'));
        $this->assertSame(1, $config->get('numbers.0.number'));

        $this->assertSame(2, $config->get('numbers.1.id'));
        $this->assertSame(2, $config->get('numbers.1.number'));

        $config['foo'] = 'new-bar';
        $this->assertSame('new-bar', $config['foo']);

        unset($config['foo']);
        $this->assertNull($config['foo']);
    }
}
