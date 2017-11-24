<?php

namespace AppBundle\Entity;

/**
 * Class ContactRequest
 *
 * Entity for Contact Request
 *
 * @package AppBundle\Entity
 */
class ContactRequest
{
    /**
     * Created here for temporary use. Status should be an entity by itself.
     */
    const STATUS_ACCEPTED = 'accepted';

    /**
     * @var int $senderId
     */
    protected $senderId;

    /**
     * @var int $receiverId
     */
    protected $receiverId;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var string $uniqueReference Unique value assigned to this contact
     */
    protected $uniqueReference;

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param mixed $senderId
     * @return ContactRequest
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * @param mixed $receiverId
     * @return ContactRequest
     */
    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return ContactRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueReference()
    {
        return $this->uniqueReference;
    }

    /**
     * @param string $uniqueReference
     * @return ContactRequest
     */
    public function setUniqueReference($uniqueReference)
    {
        $this->uniqueReference = $uniqueReference;

        return $this;
    }
}