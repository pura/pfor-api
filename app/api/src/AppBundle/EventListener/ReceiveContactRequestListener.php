<?php

namespace AppBundle\EventListener;

use AppBundle\Event\PushforEventInterface;
use AppBundle\Service\Storage\StorageInterface;

/**
 * Class ReceiveContactRequestListener
 *
 * Listens to an event when Contact request is received
 *
 * @package AppBundle\EventListener
 */
class ReceiveContactRequestListener
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * NewContactRequestListener constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param PushforEventInterface $event
     */
    public function onNewContactRequestReceive(PushforEventInterface $event)
    {
        $contactRequest = $event->getEvent();

        $this->storage->store('a.key.build.using.key.building.strategy', $contactRequest);

        //TODO: catch and throw any exception here depending on Storage behaviour

        //push to queue etc..

        //TODO: Log here
    }
}