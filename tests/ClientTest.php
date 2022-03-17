<?php

/**
 * Test for Client
 *
 * @author Trismegiste
 */
class ClientTest extends PHPUnit\Framework\TestCase
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
        $sut = new \Paragi\PhpWebsocket\Client(self::testServer, 80, '', $errstr, 10, false);
        $written = $sut->write($message);
        $this->assertNotFalse($written, 'Unable to write to ' . self::testServer);
        $response = $sut->read($errstr);
        $this->assertStringContainsString($message, $response);
    }

}
