<?php

namespace Test\AppBundle\Service\Message;

use AppBundle\Constants\Event;
use AppBundle\DTO\Response\ApiResponse;
use AppBundle\Entity\Message;
use AppBundle\Event\NewMessageEvent;
use AppBundle\Service\Message\SendMessage;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SendMessageTest extends TestCase
{
    private $dispatcher;

    private $sendMessage;

    public function setUp()
    {
        $this->dispatcher = m::mock(EventDispatcherInterface::class);
        $this->sendMessage = new SendMessage($this->dispatcher);
    }

    public function testSendMessageSendTheMessageAndReturnsSuccessData()
    {
        $message = new Message();
        $message->setContactRef('test-contact-ref')
            ->setMessage('Test Message');

        $event = new NewMessageEvent($message);

        $this->dispatcher->shouldReceive('dispatch')
            ->once()
            ->with(Event::EVENT_NEW_MESSAGE_SEND, equalTo($event));

        $result = call_user_func($this->sendMessage, 'test-contact-ref', 'Test Message');
        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertTrue($result->getSuccess());
        $this->assertEquals(200, $result->getHttpCode());
    }

    public function testSendMessageReturnsErrorDataWhenDispatcherThrowsAnException()
    {
        $message = new Message();
        $message->setContactRef('test-contact-ref')
            ->setMessage('Test Message');

        $event = new NewMessageEvent($message);

        $this->dispatcher->shouldReceive('dispatch')
            ->once()
            ->with(Event::EVENT_NEW_MESSAGE_SEND, equalTo($event))
            ->andThrow(new \Exception('Error message', '500'));

        $result = call_user_func($this->sendMessage, 'test-contact-ref', 'Test Message');
        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertFalse($result->getSuccess());
        $this->assertEquals(500, $result->getHttpCode());
    }


    public function tearDown()
    {
        m::close();
    }

}