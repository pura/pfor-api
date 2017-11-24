<?php

namespace AppBundle\Event;

use AppBundle\Entity\Message;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewMessageEvent
 *
 * Event to execute when new message is sent to contact
 *
 * @package AppBundle\Event
 */
class NewMessageEvent extends Event implements PushforEventInterface
{
    /**
     * @var Message
     */
    protected $message;

    /**
     * NewMessageEvent constructor.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getEvent()
    {
        return $this->message;
    }
}