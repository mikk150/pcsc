<?php
namespace mikk150\pcsc;

/**
*
*/
class Reader
{
    /**
     * @var string
     */
    public $readerName;

    /**
     * closure that will be called, if Smart Card has been connected
     * @var \Closure
     */
    public $onConnect;

    /**
     * closure that will be called, if Smart Card has been disconnected
     * @var \Closure
     */
    public $onDisconnect;

    /**
     * @var Connection
     */
    public $connection;

    /**
     * @var Context
     */
    private $context;

    public function __construct(Context $context, $reader)
    {
        $this->context=$context;
        $this->readerName=$reader;
    }

    /**
     * tries to get Connection to Smart Card
     * @return Connection|false if connection was established, then returns Connection object, otherwise false
     */
    public function getConnection()
    {
        if ($this->connection && $this->connection->getStatus()) {
            return $this->connection;
        } else if ($this->connection && !$this->connection->getStatus()) {
            if (is_callable($this->onDisconnect)) {
                call_user_func($this->onDisconnect, $this->connection);
            }

            $this->connection = null;
        }

        if (($connection = scard_connect($this->context->getSContext(), $this->readerName))) {
            $this->connection = new Connection($this, $connection);

            if (is_callable($this->onConnect)) {
                call_user_func($this->onConnect, $this->connection);
            }

            return $this->connection;
        }
        return false;
    }
}
