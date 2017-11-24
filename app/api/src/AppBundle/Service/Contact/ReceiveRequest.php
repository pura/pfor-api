<?php

namespace AppBundle\Service\Contact;
use AppBundle\DTO\Response\ApiResponse;
use AppBundle\Constants;
use AppBundle\Entity;
use AppBundle\Event\NewContactRequestEvent;
use AppBundle\Service\Validator\ValidatorInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Receive
 *
 * When A user receives a request to contact to them, and they accept/reject the request
 *
 * @package AppBundle\Service\Contact
 */
class ReceiveRequest
{
    /**
     * @var ValidatorInterface
     */
    protected $connectRequestValidator;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * ReceiveRequest constructor.
     *
     * @param ValidatorInterface $connectRequestValidator
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(ValidatorInterface $connectRequestValidator, EventDispatcherInterface $eventDispatcher)
    {
        $this->connectRequestValidator = $connectRequestValidator;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param int $senderId
     * @param int $receiverId
     * @param mixed $content Haven't imlemented this yet but any sent content to deal with
     *
     * @return ApiResponse
     */
    public function __invoke(int $senderId, $content = null)
    {
        $response = new ApiResponse();

        if (!$this->connectRequestValidator->setSenderId($senderId)->validate()) {
            $response->setSuccess(false)
                ->setHttpCode(Response::HTTP_BAD_GATEWAY) //depends on strategy
                ->addError('I don\'t know who you are I\'m afraid.');

            return $response;
        }

        $myId = 1; //TODO: this is has to come from security Context or any user service provided current user detail

        $contactRequest = new Entity\ContactRequest();
        $contactRequest->setSenderId($senderId)
            ->setReceiverId($myId)
            ->setStatus(Entity\ContactRequest::STATUS_ACCEPTED) //Status will be it's own entity and dealt differently in real life though..
            ->setUniqueReference('AB-12-CD-EF'); //again there has to be a separate service dealing with this reference

        $event = new NewContactRequestEvent($contactRequest); //realised would have been better to inject as dependency trading with setters and getters vs __constructor injection

        try {
            $this->eventDispatcher->dispatch(Constants\Event::EVENT_RECEIVE_CONACT_REQUEST, $event);
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