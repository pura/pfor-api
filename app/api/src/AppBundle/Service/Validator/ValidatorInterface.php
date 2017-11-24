<?php

namespace AppBundle\Service\Validator;

/**
 * Interface ValidatorInterface
 * @package AppBundle\Service\Validator
 */
interface ValidatorInterface
{
    /**
     * @return bool
     */
    public function validate() : bool;
}