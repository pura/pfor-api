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
 * Class SendRequest
 *
 * When A user send request to contact to other use, a new record is created using an event
 *
 * @package AppBundle\Service\Contact
 */
class SendRequest
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
     * SendRequest constructor.
     *
     * @param ValidatorInterface $connectRequstValidator
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(ValidatorInterface $connectRequstValidator, EventDispatcherInterface $eventDispatcher)
    {
        $this->connectRequestValidator = $connectRequstValidator;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param int $senderId
     * @param int $receiverId
     * @param mixed $content Haven't imlemented this yet but any sent content to deal with
     *
     * @return ApiResponse
     */
    public function __invoke($senderId, $receiverId, $content = null)
    {
        $response = new ApiResponse();

        if (!$this->connectRequestValidator->setReceiverId($receiverId)->validate()) {
            $response->setSuccess(false)
                ->setHttpCode(Response::HTTP_BAD_GATEWAY) //depends on strategy
                ->addError('We dont know who you are trying to connect to');

            return $response;
        }

        $contactRequest = new Entity\ContactRequest();
        $contactRequest->setSenderId($senderId)
            ->setReceiverId($receiverId);

        $event = new NewContactRequestEvent($contactRequest);

        try {
            $this->eventDispatcher->dispatch(Constants\Event::EVENT_NEW_CONTACT_REQUEST, $event);
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