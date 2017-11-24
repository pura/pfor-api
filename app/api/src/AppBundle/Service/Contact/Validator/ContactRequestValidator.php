<?php

namespace AppBundle\Service\Contact\Validator;

use AppBundle\Service\Validator\ValidatorInterface;

/**
 * Class ContactRequestValidator
 *
 * Validates the contact request
 *
 * @package AppBundle\Service\Contact\Validator
 */
class ContactRequestValidator implements ValidatorInterface
{
    public function setSenderId($senderId)
    {
        //TODO: TBI
        return $this;
    }

    public function setReceiverId($receiverId)
    {
        // TODO: TBI
        return $this;
    }

    public function validate(): bool
    {
        // TODO: Implement validate() method.

        return true;
    }
}