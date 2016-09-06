<?php

namespace CultuurNet\BroadwayAMQP\Message;

use Broadway\Domain\DateTime;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use PhpAmqpLib\Message\AMQPMessage;

class DeliveryModePropertiesFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_validates_the_injected_delivery_mode()
    {
        $invalidDeliveryMode = 'PERSISTENT';
        $this->setExpectedException(\InvalidArgumentException::class);
        new DeliveryModePropertiesFactory($invalidDeliveryMode);
    }

    /**
     * @test
     */
    public function it_sets_delivery_mode_based_on_the_injected_mode()
    {
        $domainMessage = new DomainMessage(
            'af2e7491-9e40-45e0-8a09-22b5c4f3e366',
            1,
            new Metadata(),
            new \stdClass(),
            DateTime::now()
        );

        $nonPersistentFactory = new DeliveryModePropertiesFactory(AMQPMessage::DELIVERY_MODE_NON_PERSISTENT);

        $this->assertEquals(
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_NON_PERSISTENT],
            $nonPersistentFactory->createProperties($domainMessage)
        );
    }
}
