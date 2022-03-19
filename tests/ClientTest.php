<?php

use Paragi\PhpWebsocket\Client;
use Paragi\PhpWebsocket\ConnectionException;
use PHPUnit\Framework\TestCase;

/**
 * Test for Client
 *
 * @author Trismegiste
 */
class ClientTest extends TestCase
{

    const testServerDomain = '127.0.0.1';
    const testServerPort = 9999;

    public function testConnectToLocalEchoingServer()
    {
        try {
            $obj = new Client(self::testServerDomain, self::testServerPort);
            $this->assertInstanceOf(Client::class, $obj);
        } catch (\Paragi\PhpWebsocket\ConnectionException $e) {
            $this->assertTrue(false, 'Unable to connect to test server. Did you forget to launch the test server ?');
        }
    }

    public function getMessage(): array
    {
        return [
            ["hello server"],
            ["Here's a binary \x01\x02\x03"],
            ['So Long, and Thanks for All the Fish']
        ];
    }

    /**
     * @dataProvider getMessage
     */
    public function testExample(string $message)
    {
        $sut = new Client(self::testServerDomain, self::testServerPort, '', $errstr, 3, false);
        $written = $sut->write($message);
        $this->assertNotFalse($written, 'Unable to write to ' . self::testServerDomain);
        $response = $sut->read($errstr);
        $this->assertEquals($message, $response);
    }

    public function testUnknowHost()
    {
        $this->expectException(ConnectionException::class);
        $this->expectExceptionMessage('getaddrinfo failed');
        new Client('yoloserver.unknown');
    }

    public function testNotAWebsocketServer()
    {
        $this->expectException(ConnectionException::class);
        $this->expectExceptionMessage('upgrade connection');
        new Client('twitter.com');
    }

}
