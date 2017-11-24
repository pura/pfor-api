<?php

namespace AppBundle\EventListener;

use AppBundle\Event\PushforEventInterface;
use AppBundle\Service\Storage\StorageInterface;

/**
 * Class NewContactRequestListener
 *
 * Listens to an event when New Contact request is sent
 *
 * @package AppBundle\EventListener
 */
class NewContactRequestListener
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
    public function onNewContactRequest(PushforEventInterface $event)
    {
        $newContactRequest = $event->getEvent();

        $this->storage->store('a.key.build.using.key.building.strategy', $newContactRequest);

        //TODO: catch and throw any exception here depending on Storage behaviour

        //push to queue etc..

        //TODO: Log here
    }
}