<?php

namespace AppBundle\Service\Storage;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SessionStorage
 *
 * Storage Service using session
 *
 * @package AppBundle\Service\Storage
 */
class SessionStorage implements StorageInterface
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * SessionStorage constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $key
     * @param mixed $data
     */
    public function store($key, $data)
    {
        return $this->session->set($key, $data);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function fetch($key)
    {
        return $this->session->get($key);
    }
}