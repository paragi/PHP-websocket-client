## Websocket client for PHP

Use PHP to connect to at websocket service.
These 3 methods make the websocket negotiation and connection and handle the hybi10 frame encoding required.

Example 1:
```php
if( $sp = new \Paragi\PhpWebsocket\Client('echo.websocket.org',80) ) {
   $sp->write("hello server");
   echo "Server responed with: " . $sp->read($errstr);
}
```


Example 2, using a session cookie and setting timeout:
```php
$headers = ["Cookie: SID=".session_id()];
$sp = new \Paragi\PhpWebsocket\Client('echo.websocket.org',80,$headers,$errstr,16);
if($sp){
   $bytes_written = $sp->write("hello server");
   if($bytes_written){
     $data = $sp->read($errstr);
     echo "Server responed with: " . $errstr ? $errstr : $data;
   }
}
```

Example 3, using SSL
```php
if( $sp = new \Paragi\PhpWebsocket\Client('echo.websocket.org',443,'',$errstr, 10,true) ) {
   $sp->write("hello server");
   echo "Server responed with: " . $sp->read($errstr);
}
```

# Methods:

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


# Contribute

Please let me know if there is any problems with the code.
Any contributions are accepted, if the code looks nice, not bloated and otherwise reasonable.

# License: MIT: Free
