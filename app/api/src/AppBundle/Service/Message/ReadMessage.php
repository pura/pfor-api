<?php

namespace AppBundle\Service\Message;

use AppBundle\DTO\Response\ApiResponse;
use AppBundle\Entity\Message;
use AppBundle\Event\NewMessageEvent;
use AppBundle\Constants;
use AppBundle\Service\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class ReadMessage
 *
 * Sends the message
 *
 * @package AppBundle\Service
 */
class ReadMessage
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * ReadMessage constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param $contactRef
     *
     * @return ApiResponse
     */
    public function __invoke($contactRef)
    {
        //TODO: validates the $contactRef to check if they have been contacted ...

        $response = new ApiResponse();

        /**
         * This is just for an example.. The message is read by queue or db or both or whatever the real mechanism is..
         */
        $message = $this->storage->fetch('key.for.message.building.strategy');

        $response->setHttpCode(Response::HTTP_OK)
            ->setSuccess(true)
            ->setData([$message->getMessage()]); //again in this, need to use serialiser or transformer to transform data to suitable format..

        return $response;
    }
}