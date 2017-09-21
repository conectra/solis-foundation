<?php

namespace Solis\Foundation\Serializer\Encoder;

class EncoderContainer
{

    /**
     * @var AbstractEncoder
     */
    private $encoders;

    public function __construct(array $encoders = [])
    {
        $this->encoders = $encoders;
    }

    public function getEncoder($type)
    {
        $encoders = array_values(array_filter($this->encoders, function (AbstractEncoder $encoder) use ($type) {
            return $encoder->getType() == $type ?? false;
        }));

        return $encoders[0] ?? null;
    }
}
