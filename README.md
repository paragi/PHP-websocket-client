## Websocket client for PHP

Use PHP to connect to at websocket service.
Thise 3 functions makes the websocket negotiation and connection and handle the hybi10 frame encoding required.

Example 1:
```<?php
if( $sp = websocket_open('echo.websocket.org',80) ) {
   websocket_write($sp,"hello server");
   echo "Server responed with: " . websocket_read($sp,$errstr);
}
```


Example 2, using a session cookie and setting timeout:
```<?php
$headers = ["Cookie: SID=".session_id()];
$sp = websocket_open('echo.websocket.org',80,$headers,$errstr,16);
if($sp){
   $bytes_written = websocket_write($sp,"hello server");
   if($bytes_written){
     $data = websocket_read($sp,$errstr);
     echo "Server responed with: " . $errstr ? $errstr : $data;
   }
}
```

# Functions:

## websocket_open

Open websocket connection

`resource` websocket_open(`string` $host [,`int` $port [,`array` $additional_headers [,`string` &error_string ,[, `int` $timeout]]]] )

**host** A host URL. It can be a domain name like www.example.com or an IP address like local host: 127.0.0.1

**port**  The servers port number

**headers** (optional) additional HTTP headers to attach to the request. For example to parse a session cookie.

**error_string** (optional) A referenced variable to store error messages, if any.

**timeout** (optional) The maximum time in seconds, a read operation will wait for an answer from the server. Default value is 10 seconds.

**returns** a resource handle or false.


## websocket_write

Send data to server through the websocket, using hybi10 frame encoding.

`int` websocket_write(`resource` $handle, `string` $data [,`boolean` $final])

**handle** the resource handle returned by websocket_open, if successful

**data** Data to transport to server

**final** (optional) indicate if this block is the final data block of this request. Default true  

## websocket_read

Read data through websocket from the server, using hybi10 frame encoding.


`string` websocket_read(`resource` $handle [,`string` &error_string])


**handle** the resource handle returned by websocket_open, if successful.

**error_string** (optional) A referenced variable to store error messages, i any.

Note:
- This implementation waits for the final chunk of data, before returning.
- Reading data while handling/ignoring other kind of packages


# Contribute

Please let me know if there is any problems with the code.
Any contributions are accepted, if the code looks nice, not bloated and otherwise reasonable.

# License: MIT: Free
