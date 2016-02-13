<?php
namespace mikk150\pcsc;

/**
*
*/
class Context
{
    /**
     * PSCS context
     * @var resource (PC/SC Context)
     */
    private $context;

    public function __construct()
    {
        $this->context = scard_establish_context();
    }

    /**
     * Gets all readers from this context
     * @return Reader[] found readers
     */
    public function getReaders()
    {
        $contextReaders = scard_list_readers($this->context);

        $readers=[];
        foreach ($contextReaders as $reader) {
            $readers[] = new Reader($this, $reader);
        }
        return $readers;
    }

    /**
     * Gets context, do not use in your application
     * @return resource (PC/SC Context)
     */
    public function getSContext()
    {
        return $this->context;
    }

    public function __destruct()
    {
        scard_release_context($this->context);
    }
}
