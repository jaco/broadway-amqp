<?php

namespace CultuurNet\BroadwayAMQP;

interface ContentTypeLookupInterface
{
    /**
     * @param string $payloadClass
     * @param string $contentType
     * @return static
     */
    public function withContentType($payloadClass, $contentType);

    /**
     * @param string $payloadClass
     * @return string
     */
    public function getContentType($payloadClass);
}
