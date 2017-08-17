<?php

namespace AppBundle\EventListener;

use AppBundle\Event\PushforEventInterface;
use AppBundle\Service\Storage\StorageInterface;

/**
 * Class MessageSendListener
 *
 * @package AppBundle\EventListener
 */
class MessageSendListener
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * MessageSendListener constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param PushforEventInterface $event
     */
    public function onNewMessageSent(PushforEventInterface $event)
    {
        $message = $event->getEvent();

        $this->storage->store('key.for.message.building.strategy', $message);
    }
}