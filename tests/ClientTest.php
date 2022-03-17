<?php

/**
 * Test for Client
 *
 * @author Trismegiste
 */
class ClientTest extends PHPUnit\Framework\TestCase
{

    const testServer = 'echo.websocket.events';  // echo.websocket.org is no longer available

    protected $sut;

    protected function setUp(): void
    {
        $this->sut = new \Paragi\PhpWebsocket\Client();
    }

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
        $sp = $this->sut->websocket_open(self::testServer, 80, '', $errstr, 10, false);
        $this->assertNotFalse($sp, 'Unable to connect to ' . self::testServer);

        $written = $this->sut->websocket_write($sp, $message);
        $this->assertNotFalse($written, 'Unable to write to ' . self::testServer);

        $response = $this->sut->websocket_read($sp, $errstr);
        $this->assertStringContainsString($message, $response);
    }

}
