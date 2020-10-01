<?php

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */

declare(strict_types=1);

namespace App\Service\MeteoApi;

use App\Meteo\Conditions;
use App\Meteo\LastTenDays;
use App\Meteo\LastTwoDays;
use App\Meteo\Ville;
use App\Service\Http\HttpClient;
use App\Service\JsonDecoder\JsonDecoder;
use GuzzleHttp\RequestOptions;

final class MeteoApi
{
    private const SEARCH = "autocomplete/autocomplete_ajax_test.php";
    private const METEO = "meteo-ajax-5days-NEW.php";
    private const TYPE_CONDITIONS = "conditions";
    private const TYPE_JOURS = "jours";
    private const TYPE_HEURE = "heure";

    /** @var HttpClient */
    private $client;
    /** @var JsonDecoder */
    private $jsonDecoder;

    public function __construct(HttpClient $client, JsonDecoder $jsonDecoder)
    {
        $this->client = $client;
        $this->jsonDecoder = $jsonDecoder;
    }

    /** @return mixed[] */
    public function search(string $term): array
    {
        $response = $this->client->getClient()->request(
            'GET',
            static::SEARCH,
            [
                RequestOptions::QUERY => [
                    'term' => $term,
                ],
            ]
        );

        return array_map(
            function (array $data): Ville {
                return new Ville($data['value']);
            },
            $this->jsonDecoder->decode(
                $response->getBody()->getContents()
            )
        );
    }

    public function conditions(string $term): Conditions
    {
        return new Conditions($this->meteo($term, static::TYPE_CONDITIONS));
    }

    public function lastTenDays(string $term): LastTenDays
    {
        return new LastTenDays($this->meteo($term, static::TYPE_JOURS));
    }

    public function lastTwoDays(string $term): LastTwoDays
    {
        return new LastTwoDays($this->meteo($term, static::TYPE_HEURE));
    }

    /** @return mixed[] */
    private function meteo(string $term, string $type): array
    {
        $response = $this->client->getClient()->request(
            'GET',
            static::METEO,
            [
                RequestOptions::QUERY => [
                    'commune' => $term,
                    $type => true,
                ],
            ]
        );

        return $this->jsonDecoder->decode(
            $response->getBody()->getContents()
        );
    }
}
