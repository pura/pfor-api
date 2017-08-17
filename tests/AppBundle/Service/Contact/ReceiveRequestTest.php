<?php

namespace Test\AppBundle\Service\Contact;

use AppBundle\Constants\Event;
use AppBundle\DTO\Response\ApiResponse;
use AppBundle\Entity\ContactRequest;
use AppBundle\Event\NewContactRequestEvent;
use AppBundle\Service\Contact\ReceiveRequest;
use AppBundle\Service\Validator\ValidatorInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ReceiveRequestTest extends TestCase
{

    private $connectRequestValidator;

    private $dispatcher;

    private $receiveRequest;

    public function setUp()
    {
        $this->connectRequestValidator = m::mock(ValidatorInterface::class);
        $this->dispatcher = m::mock(EventDispatcherInterface::class);
        $this->receiveRequest = new ReceiveRequest($this->connectRequestValidator, $this->dispatcher);
    }

    public function testReceiveRequestReturnsErrorResponseWhenConnetRequestIsNotValid()
    {
        $this->connectRequestValidator->shouldReceive('setSenderId->validate')
            ->once()
            ->andReturn(false);

        $this->dispatcher->shouldReceive('dispatch')
            ->never();

        $result = call_user_func($this->receiveRequest, 1);

        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertFalse($result->getSuccess());
        $this->assertEquals(502, $result->getHttpCode());
    }

    public function testSendRequestReturnsSuccessResponseWhenConnetRequestIsValid()
    {
        $contactRequest = new ContactRequest();
        $contactRequest->setSenderId(1)
            ->setReceiverId(1)
            ->setStatus('accepted')
            ->setUniqueReference('AB-12-CD-EF');
        $event = new NewContactRequestEvent($contactRequest);

        $this->connectRequestValidator->shouldReceive('setSenderId')
            ->with(1)
            ->once()
            ->andReturn($this->connectRequestValidator);

        $this->connectRequestValidator->shouldReceive('validate')
            ->once()
            ->andReturn(true);

        $this->dispatcher->shouldReceive('dispatch')
            ->once()
            ->with(Event::EVENT_RECEIVE_CONACT_REQUEST, equalTo($event));

        $result = call_user_func($this->receiveRequest, 1);

        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertTrue($result->getSuccess());
        $this->assertEquals(200, $result->getHttpCode());
    }

    public function testSendRequestReturnsErrorResponseWhenConnetRequestIsValidButCouldNotDisptachAnEvent()
    {
        $contactRequest = new ContactRequest();
        $contactRequest->setSenderId(1)
            ->setReceiverId(1)
            ->setStatus('accepted')
            ->setUniqueReference('AB-12-CD-EF');
        $event = new NewContactRequestEvent($contactRequest);

        $this->connectRequestValidator->shouldReceive('setSenderId->validate')
            ->once()
            ->andReturn(true);

        $this->dispatcher->shouldReceive('dispatch')
            ->once()
            ->with(Event::EVENT_RECEIVE_CONACT_REQUEST, equalTo($event))
            ->andThrow(new \Exception('', 500));

        $result = call_user_func($this->receiveRequest, 1);

        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertFalse($result->getSuccess());
        $this->assertEquals(500, $result->getHttpCode());
    }

    public function tearDown()
    {
        m::close();
    }
}