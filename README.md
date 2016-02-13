# pcsc for PHP

```php
$context = new mikk150\pcsc\Context;

/**
 * @var mikk150\pcsc\Reader[]
 */
$readers=$context->getReaders();

foreach ($readers as $reader) {
    $reader->onConnect = function (mikk150\pcsc\Connection $connection) {
        echo 'connected'.PHP_EOL;
    };
    $reader->onDisconnect = function (mikk150\pcsc\Connection $connection) {
        echo 'disconnected'.PHP_EOL;
    };
}

while (true) {
    foreach ($readers as $reader) {
        $reader->getConnection();
        //You can use connection here, or you can just use closures to reader
    }
}
```