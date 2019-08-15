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

    /** @var \DateTime */
    private $date;

    /** @var Ville */
    private $commune;

    /** @var \DateTime */
    private $updatedAt;

    public function __construct(array $data)
    {
        $this->date = \DateTime::createFromFormat("d/m/Y", $data['today'])->setTime(0, 0, 0);
        $this->commune = new Ville($data['commune']);
        $this->updatedAt = \DateTime::createFromFormat("j/m \à H:i", $data['maj']);
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
        return html_entity_decode(
            sprintf(
                "%s%sC",
                str_replace(static::DEG, '', $temperature),
                static::DEG
            )
        );
    }

    protected function formatVitesse(string $vitesse): string
    {
        return sprintf(
            "%s %s",
            str_replace(static::VITESSE, '', $vitesse),
            static::VITESSE
        );
    }

    protected function formatPression(string $pression): string
    {
        return sprintf(
            "%s %s",
            str_replace(static::PRESSION, '', $pression),
            static::PRESSION
        );
    }

    protected function formatDistance(string $distance)
    {
        return sprintf(
            "%s %s",
            number_format(
                (float) str_replace(static::DISTANCE, '', $distance),
                3,
                ',',
                ' '
            ),
            static::DISTANCE
        );
    }
}
