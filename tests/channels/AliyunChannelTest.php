<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\pusher\tests\channels;

use xutl\pusher\ChannelException;
use xutl\pusher\channels\AliyunChannel;
use xutl\pusher\Push;
use xutl\pusher\support\Config;
use xutl\pusher\tests\TestCase;

class AliyunChannelTest extends TestCase
{
    public function testGetName()
    {
        $this->assertSame('aliyun', (new AliyunChannel([]))->getName());
    }

    public function testSend()
    {
        $config = [
            'accessId' => 'mock-api-key',
            'accessKey' => 'mock-api-secret',
            'appKey' => 'mock-app-key',
        ];
        $channel = \Mockery::mock(AliyunChannel::class.'[post]', [$config])->shouldAllowMockingProtectedMethods();

        $expected = [
            'RegionId' => 'cn-hangzhou',
            'AccessKeyId' => 'mock-api-key',
            'Format' => 'JSON',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureVersion' => '1.0',
            // 'SignatureNonce' => uniqid(),
            // 'Timestamp' => date('Y-m-d\TH:i:s\Z'),
            'Action' => 'SendSms',
            'Version' => '2017-05-25',
            'PhoneNumbers' => strval(18888888888),
            'SignName' => 'mock-api-sign-name',
            'TemplateCode' => 'mock-template-code',
            'TemplateParam' => json_encode(['code' => '123456']),
        ];
        $channel->shouldReceive('post')
            ->with(AliyunChannel::ENDPOINT_URL, \Mockery::on(function ($params) use ($expected) {
                if (empty($params['Signature'])) {
                    return false;
                }

                unset($params['SignatureNonce'], $params['Timestamp'], $params['Signature']);

                ksort($params);
                ksort($expected);

                return $params == $expected;
            }))
            ->andReturn([
                'Code' => 'OK',
                'Message' => 'mock-result',
            ], [
                'Code' => 1234,
                'Message' => 'mock-err-msg',
            ])
            ->twice();

        $message = new Push([
            'template' => 'mock-template-code',
            'data' => ['code' => '123456'],
        ]);

        $config = new Config($config);

        $this->assertSame([
            'Code' => 'OK',
            'Message' => 'mock-result',
        ], $channel->send($message, $config));

        $this->expectException(ChannelException::class);
        $this->expectExceptionCode(1234);
        $this->expectExceptionMessage('mock-err-msg');

        $channel->send($message, $config);
    }
}
