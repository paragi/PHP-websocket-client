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

    const testServer = 'echo.websocket.events';  // echo.websocket.org is no longer available

    public function getMessage(): array
    {
        return [
            ["hello server"]
        ];
    }

    /**
     * @dataProvider getMessage
     */
    public function testExample(string $message)
    {
        $sut = new Client(self::testServer, 80, '', $errstr, 10, false);
        $written = $sut->write($message);
        $this->assertNotFalse($written, 'Unable to write to ' . self::testServer);
        $response = $sut->read($errstr);
        $this->assertThat($response, $this->logicalOr(
                $this->stringContains('hello server'),
                $this->stringContains('sponsored by') // sometimes, the server answers with an advertisement
        ));
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
        new Client('twitter.com');
    }

}
