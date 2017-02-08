##This is 3 simple functions, to implement a websocket client for PHP

Example:
```<?php
$headers = ["Cookie: SID=".session_id()];
$sp = websocket_open('example.com',80,$headers,$errstr,16);
if($sp){
   $bytes_written = websocket_write($sp,"hello server");
   if($bytes_written){
     $data = websocket_read($sp,$errstr);
     echo "Server responed with: " . $errstr ? $errstr : $data;
   }
}
```

#Functions:
Open websocket connection
**resource websocket_open(string $host [,int $port [,array $additional_headers [,string &error_string ,[, int $timeout]]]]
  
**host**
   A host URL. It can be a domain name like www.example.com or an IP address,  with port number. Local host example: 127.0.0.1:8080
    
**port**  
    
**headers** (optional)
    additional HTTP headers to attach to the request.   For example to parse a session cookie: "Cookie: SID=" . session_id()  
    
**error_string** (optional)
    A referenced variable to store error messages, i any
    
**timeout** (optional)
    The maximum time in seconds, a read operation will wait for an answer from 
    the server. Default value is 10 seconds.

**returns** a resource handle or false.


Write to websocket
  
**int websocket_write(resource $handle, string $data ,[boolean $final])
  
Write a chunk of data through the websocket, using hybi10 frame encoding
  
**handle**
    the resource handle returned by websocket_open, if successful
    
**data**
    Data to transport to server
    
**final** (optional)
    indicate if this block is the final data block of this request. Default true  


Read from websocket
**string websocket_read(resource $handle [,string &error_string])
  
read data from the server, using hybi10 frame encoding
  
**handle**
    the resource handle returned by websocket_open, if successful

**error_string** (optional)
    A referenced variable to store error messages, i any

Note:
    - This implementation waits for the final chunk of data, before returning.
    - Reading data while handling/ignoring other kind of packages
    

#Contribute
Please let me know if there is any problems with the code.
Any contributions are accepted, if the code looks ok.


#License: MIT: Free


