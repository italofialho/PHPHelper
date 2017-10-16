# USAGE

```php
<?php 
    $ftp = new FileTransferProtocol("HOST", "PORT (OPTIONAL/DEFAULT=21)", "USER", "PASS");
	// If you want debug result.
    $ftp = new FileTransferProtocol("HOST", "PORT (OPTIONAL/DEFAULT=21)", "USER", "PASS", "DEBUG(0/1)"); // Check public function getResult()
    $ftp->sendFile("remoteFolder", "localFolder");
?>
```