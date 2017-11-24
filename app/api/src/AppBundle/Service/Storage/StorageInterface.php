<?php

namespace AppBundle\Service\Storage;

/**
 * Interface StorageInterface
 *
 * @package AppBundle\Service\Storage
 */
interface StorageInterface
{
    /**
     * @param string $key
     * @param mixed $data
     *
     * @return $this
     */
    public function store($key, $data);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function fetch($key);
}