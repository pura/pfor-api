<?php

namespace Test\AppBundle\Service\Contact;

use AppBundle\Constants\Event;
use AppBundle\DTO\Response\ApiResponse;
use AppBundle\Entity\ContactRequest;
use AppBundle\Event\NewContactRequestEvent;
use AppBundle\Service\Contact\SendRequest;
use AppBundle\Service\Validator\ValidatorInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SendRequestTest extends TestCase
{
    private $connectRequestValidator;

    private $dispatcher;

    private $sendRequest;

    public function setUp()
    {
        $this->connectRequestValidator = m::mock(ValidatorInterface::class);
        $this->dispatcher = m::mock(EventDispatcherInterface::class);
        $this->sendRequest = new SendRequest($this->connectRequestValidator, $this->dispatcher);
    }

    public function testSendRequestReturnsErrorResponseWhenConnetRequestIsNotValid()
    {
        $this->connectRequestValidator->shouldReceive('setReceiverId->validate')
            ->once()
            ->andReturn(false);

        $this->dispatcher->shouldReceive('dispatch')
            ->never();

        $result = call_user_func($this->sendRequest, 1, 2);

        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertFalse($result->getSuccess());
        $this->assertEquals(502, $result->getHttpCode());
    }

    public function testSendRequestReturnsSuccessResponseWhenConnetRequestIsValid()
    {
        $contactRequest = new ContactRequest();
        $contactRequest->setSenderId(1)
            ->setReceiverId(2);
        $event = new NewContactRequestEvent($contactRequest);

        $this->connectRequestValidator->shouldReceive('setReceiverId')
            ->with(2)
            ->once()
            ->andReturn($this->connectRequestValidator);

        $this->connectRequestValidator->shouldReceive('validate')
            ->once()
            ->andReturn(true);

        $this->dispatcher->shouldReceive('dispatch')
            ->once()
            ->with(Event::EVENT_NEW_CONTACT_REQUEST, equalTo($event));

        $result = call_user_func($this->sendRequest, 1, 2);

        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertTrue($result->getSuccess());
        $this->assertEquals(200, $result->getHttpCode());
    }

    public function testSendRequestReturnsErrorResponseWhenConnetRequestIsValidButCouldNotDisptachAnEvent()
    {
        $contactRequest = new ContactRequest();
        $contactRequest->setSenderId(1)
            ->setReceiverId(2);
        $event = new NewContactRequestEvent($contactRequest);

        $this->connectRequestValidator->shouldReceive('setReceiverId->validate')
            ->once()
            ->andReturn(true);

        $this->dispatcher->shouldReceive('dispatch')
            ->once()
            ->with(Event::EVENT_NEW_CONTACT_REQUEST, equalTo($event))
            ->andThrow(new \Exception('', 500));

        $result = call_user_func($this->sendRequest, 1, 2);

        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertFalse($result->getSuccess());
        $this->assertEquals(500, $result->getHttpCode());
    }

    public function tearDown()
    {
        m::close();
    }
}