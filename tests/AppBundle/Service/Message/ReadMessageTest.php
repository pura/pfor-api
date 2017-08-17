<?php

namespace Test\AppBundle\Service\Message;

use AppBundle\DTO\Response\ApiResponse;
use AppBundle\Entity\Message;
use AppBundle\Service\Message\ReadMessage;
use AppBundle\Service\Storage\StorageInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ReadMessageTest extends TestCase
{
    private $storage;

    private $readMessage;

    public function setUp()
    {
        $this->storage = m::mock(StorageInterface::class);
        $this->readMessage = new ReadMessage($this->storage);
    }

    public function testReadMessageReadsTheMessageAndReturnsData()
    {
        $message = new Message();
        $message->setMessage('Test Message');

        $this->storage->shouldReceive('fetch')
            ->with('key.for.message.building.strategy-ref-of-current-connection')
            ->once()
            ->andReturn($message);

        $result = call_user_func($this->readMessage, '-ref-of-current-connection');
        $this->assertInstanceOf(ApiResponse::class, $result);
        $this->assertTrue($result->getSuccess());
        $this->assertEquals(200, $result->getHttpCode());
        $this->assertEquals(['Test Message'], $result->getData());
    }

    public function testReadMessageReturnsErrorWhenStorageIsUnreachable()
    {
        $this->markTestIncomplete('Test to be complete and behaviour to be added');
    }

    public function tearDown()
    {
        m::close();
    }

}