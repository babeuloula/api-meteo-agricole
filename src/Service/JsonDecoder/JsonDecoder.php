<?php

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */

declare(strict_types=1);

namespace App\Service\JsonDecoder;

use Wizaplace\JsonDecoder\Decoder\AbstractJsonDecoder;

class JsonDecoder extends AbstractJsonDecoder
{
    public function __construct()
    {
        $this
            ->setAllowNull(false)
            ->setAssociative(true)
            ->setValidateDecodedData(false);
    }
}
