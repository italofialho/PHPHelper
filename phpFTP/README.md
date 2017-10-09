# USAGE

```php
<?php 
    $ftp = new FileTransferProtocol("HOST", "USER", "PASS");
    // $ftp = new FileTransferProtocol("HOST", "USER", "PASS", "DEBUG(0/1)"); // Check public function getResult()
    $ftp->sendFile("remoteFolder", "localFolder");
?>
```