<?php
namespace mikk150\pcsc;

/**
*
*/
class Connection
{
    /**
     * @var Reader
     */
    public $reader;

    /**
     * Connection
     * @var resource (PC/SC Connection)
     */
    private $connection;

    public function __construct(Reader $reader, $connection)
    {
        $this->connection = $connection;
        $this->reader = $reader;
    }

    /**
     * gets connection status
     * @return array|false connection status array, or false if not connected
     */
    public function getStatus()
    {
        return scard_status($this->connection);
    }

    /**
     * transmits APDU to Smart Card
     * @param  string $apdu APDU to transmit
     * @return string       response from Smart Card
     */
    public function send($apdu)
    {
        return scard_transmit($this->connection, $apdu);
    }
}
