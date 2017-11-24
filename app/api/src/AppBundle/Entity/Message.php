<?php

namespace AppBundle\Entity;

/**
 * Class Message
 *
 * Entity for Message
 *
 * @package AppBundle\Entity
 */
class Message
{
    /**
     * @var string $contactRef
     */
    protected $contactRef;

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @return string
     */
    public function getContactRef()
    {
        return $this->contactRef;
    }

    /**
     * @param string $contactRef
     * @return Message
     */
    public function setContactRef($contactRef)
    {
        $this->contactRef = $contactRef;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }


}