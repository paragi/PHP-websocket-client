<?php
require "./websocket_client.php";
$server = 'echo.websocket.org';
$message = "hello server";

echo "Connecting to server: $server \n";
if( $sp = websocket_open($server, 80,'',$errstr, 10, false, true) ) {
  echo "Sending message to server: '$message' \n";
  websocket_write($sp,$message);
  echo "Server responed with: '" . websocket_read($sp,$errstr) ."'\n";
}else {
  echo "Failed to connect to server\n";
  echo "Server responed with: $errstr\n";
}

?>
