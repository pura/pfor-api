<?php

namespace AppBundle\Service\Message;

use AppBundle\DTO\Response\ApiResponse;
use AppBundle\Entity\Message;
use AppBundle\Event\NewMessageEvent;
use AppBundle\Constants;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class SendMessage
 *
 * Sends the message
 *
 * @package AppBundle\Service
 */
class SendMessage
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * SendMessage constructor.

     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param $contactRef
     * @param mixed $content
     * @return ApiResponse
     */
    public function __invoke($contactRef, $content = null)
    {
        //TODO: validates the $contactRef to check if they have been contacted ...

        $response = new ApiResponse();

        $message = new Message();
        $message->setContactRef($contactRef)
            ->setMessage($content);

        //TODO: Throw an event to send this message to queue and store it in storage

        $event = new NewMessageEvent($message);

        try {
            $this->eventDispatcher->dispatch(Constants\Event::EVENT_NEW_MESSAGE_SEND, $event);
        } catch (\Exception $e) {
            $response->setSuccess(false)
                ->setHttpCode($e->getCode())
                ->addError ($e->getMessage()); //TODO: add proper message

            return $response;
        }

        $response->setHttpCode(Response::HTTP_OK)
            ->setSuccess(true);

        return $response;
    }
}