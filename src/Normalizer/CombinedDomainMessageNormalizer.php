<?php

namespace CultuurNet\BroadwayAMQP\Normalizer;

use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;

class CombinedDomainMessageNormalizer implements DomainMessageNormalizerInterface
{
    /**
     * @var array
     */
    protected $normalizers;

    /**
     * CombinedDomainMessageNormalizer constructor.
     */
    public function __construct()
    {
        $this->normalizers = [];
    }

    /**
     * @param \CultuurNet\BroadwayAMQP\Normalizer\DomainMessageNormalizerInterface $normalizer
     * @return \CultuurNet\BroadwayAMQP\Normalizer\CombinedDomainMessageNormalizer
     */
    public function withNormalizer(DomainMessageNormalizerInterface $normalizer)
    {
        $c = clone $this;

        foreach ($normalizer->getSupportedEvents() as $payloadType) {
            $c->normalizers[$payloadType] = $normalizer;
        }

        return $c;
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedEvents()
    {
        return array_keys($this->normalizers);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(DomainMessage $domainMessage)
    {
        $payloadType = get_class($domainMessage->getPayload());

        if (isset($this->normalizers[$payloadType])) {
            /* @var DomainMessageNormalizerInterface $normalizer */
            $normalizer = $this->normalizers[$payloadType];
            return $normalizer->normalize($domainMessage);
        }

        return new DomainEventStream(array($domainMessage));
    }
}
