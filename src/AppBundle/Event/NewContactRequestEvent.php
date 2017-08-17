<?php

namespace AppBundle\Event;

use AppBundle\Entity\ContactRequest;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewContactRequestEvent
 *
 * Event to execute when new request is sent for contact
 *
 * @package AppBundle\Event
 */
class NewContactRequestEvent extends Event implements PushforEventInterface
{
    /**
     * @var ContactRequest
     */
    protected $newContactRequest;

    /**
     * NewContactRequestEvent constructor.
     *
     * @param ContactRequest $request
     */
    public function __construct(ContactRequest $request)
    {
        $this->newContactRequest = $request;
    }

    /**
     * @return ContactRequest
     */
    public function getEvent()
    {
        return $this->newContactRequest;
    }
}