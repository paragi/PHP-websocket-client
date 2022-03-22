## Websocket client for PHP

Use PHP to connect to at websocket service.
These 3 methods make the websocket negotiation and connection and handle the hybi10 frame encoding required.

Note : unlike the library ratchetphp/Pawl, this a synchronous library that could be used within 
blocking kernels like Symfony for example.

Example 1:
```php
try {
   $sp = new \Paragi\PhpWebsocket\Client('echo.websocket.org',80) );
   $sp->write("hello server");
   echo "Server responded with: " . $sp->read();
} catch (\Paragi\PhpWebsocket\ConnectionException $e) {
   echo "Something gets wrong ".$e->getMessage();
}
```


Example 2, using a session cookie and setting timeout:
```php
try {
    $headers = ["Cookie: SID=".session_id()];
    $sp = new \Paragi\PhpWebsocket\Client('echo.websocket.org',80,$headers,$errstr,16);
    $bytes_written = $sp->write("hello server");
    $data = $sp->read();
    echo "Server responded with: ". $data;
} catch (\Paragi\PhpWebsocket\ConnectionException $e) {
   echo "Something gets wrong ".$e->getMessage();
}
```

Example 3, using SSL
```php
try {
    $sp = new \Paragi\PhpWebsocket\Client('echo.websocket.org',443,'',$errstr, 10,true) ) {
    $sp->write("hello server");
    echo "Server responded with: " . $sp->read();
} catch (\Paragi\PhpWebsocket\ConnectionException $e) {
   echo "Something gets wrong ".$e->getMessage();
}
```

# Client class

## Constructor

Open websocket connection

__construct(`string` $host [, `int` $port [, `array` $additional_headers [, `string` &error_string [, `int` $timeout [, `resource` $context]]]]] )

**host** A host URL. It can be a domain name like www.example.com or an IP address like local host: 127.0.0.1

**port**  The servers port number

**headers** (optional) additional HTTP headers to attach to the request. For example to parse a session cookie.

**error_string** (optional) A referenced variable to store error messages, if any.

**timeout** (optional) The maximum time in seconds, a read operation will wait for an answer from the server. Default value is 10 seconds.

**context** (optional) A stream context resource created with stream_context_create() used to set various socket stream options.

## write

Send data to server through the websocket, using hybi10 frame encoding.

`int` write(`string` $data [,`boolean` $final])

**data** Data to transport to server

**final** (optional) indicate if this block is the final data block of this request. Default true  

## read

Read data through websocket from the server, using hybi10 frame encoding.

`string` read([`string` &error_string])

**error_string** (optional) A referenced variable to store error messages, i any.

Note:
- This implementation waits for the final chunk of data, before returning.
- Reading data while handling/ignoring other kind of packages

# Exception

If anything goes wrong (connection, write, read...), a ConnectionException is thrown back.
Please catch them all to return a comprehensive message (here's is a sample in a Symfony context) :
```php
try {
    $sp = new \Paragi\PhpWebsocket\Client($this->localIp, $this->wsPort, ['X-Pusher: Symfony']);
    $sp->write($data);
    $reading = $sp->read();
    $ret = "Server responded with: $reading";

    return new JsonResponse(['level' => 'success', 'message' => $ret], Response::HTTP_OK);
} catch (ConnectionException $ex) {
    return new JsonResponse(['level' => 'error', 'message' => $ex->getMessage()], Response::HTTP_SERVICE_UNAVAILABLE);
}
```

# Tests
Tests are running against a local echo server implemented with Ratchet. You'll have to manually start the server in ANOTHER process.
```bash
$ php tests/bin/echoserver.php
```
And now you can launch PhpUnit
```bash
$ vendor/bin/phpunit 
```

# Code coverage
With PhpDbg, just launch :
```bash
$ phpdbg -qrr vendor/bin/phpunit
$ firefox .coverage/index.html
```

# Contribute

Please let me know if there is any problems with the code.
Any contributions are accepted, if the code looks nice, not bloated and otherwise reasonable.

# License: MIT: Free

# TODO

* Achieving 100% Code Coverage