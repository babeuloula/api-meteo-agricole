<?php

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */

declare(strict_types=1);

namespace App\Meteo;

class Meteo implements \JsonSerializable
{
    protected const DEG = "&deg;";
    protected const VITESSE = "km/h";
    protected const PRESSION = "hPa";
    protected const DISTANCE = "km";
    protected const PRECIPITATION = "mm";

    /** @var \DateTime */
    private $date;

    /** @var Ville */
    private $commune;

    /** @var \DateTime */
    private $updatedAt;

    /** @param mixed[] $data */
    public function __construct(array $data)
    {
        $date = \DateTime::createFromFormat("d/m/Y H:i:s", $data['today'] . " 00:00:00");
        $this->date = (false === $date instanceof \DateTime) ? new \DateTime() : $date;

        $this->commune = new Ville($data['commune']);

        $updatedAt = \DateTime::createFromFormat("j/m \à H:i", $data['maj']);
        $this->updatedAt = (false === $updatedAt instanceof \DateTime) ? new \DateTime() : $updatedAt;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getCommune(): Ville
    {
        return $this->commune;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /** @return mixed[] */
    public function jsonSerialize(): array
    {
        return [
            'date' => $this->getDate()->format(\DateTime::RFC3339),
            'commune' => $this->getCommune(),
            'updatedAt' => $this->getUpdatedAt()->format(\DateTime::RFC3339),
        ];
    }

    /** @param int|string $temperature */
    protected function formatTemperature($temperature): string
    {
        return trim(
            html_entity_decode(
                sprintf(
                    "%s%sC",
                    trim(str_replace(static::DEG, '', (string) $temperature)),
                    static::DEG
                )
            )
        );
    }

    protected function formatVitesse(string $vitesse): string
    {
        return trim(
            sprintf(
                "%s %s",
                trim(str_replace(static::VITESSE, '', $vitesse)),
                static::VITESSE
            )
        );
    }

    protected function formatPression(string $pression): string
    {
        return trim(
            sprintf(
                "%s %s",
                trim(str_replace(static::PRESSION, '', $pression)),
                static::PRESSION
            )
        );
    }

    protected function formatDistance(string $distance): string
    {
        return trim(
            sprintf(
                "%s %s",
                trim(
                    number_format(
                        (float) str_replace(static::DISTANCE, '', $distance),
                        3,
                        ',',
                        ' '
                    )
                ),
                static::DISTANCE
            )
        );
    }

    protected function formatPrecipitation(string $precipitation): string
    {
        return trim(
            sprintf(
                "%s %s",
                trim(str_replace(static::PRECIPITATION, '', $precipitation)),
                static::PRECIPITATION
            )
        );
    }

    protected function removeHtml(string $string): string
    {
        return trim(
            strip_tags(
                str_replace('<br />', ' ', $string)
            )
        );
    }
}
