<?php

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */

declare(strict_types=1);

namespace App\Service\Http;

use GuzzleHttp\Client;

final class HttpClient
{
    /** @var Client */
    private $client;

    public function __construct(string $baseUri)
    {
        $this->client = new Client(
            [
                'base_uri' => $baseUri
            ]
        );
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
