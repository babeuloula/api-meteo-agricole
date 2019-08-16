<?php
/**
 * @author BaBeuloula <info@babeuloula.fr>
 */
declare(strict_types=1);

namespace App\Meteo;

final class LastTwoDays extends Meteo
{
    /** @var array */
    private $dates = [];

    /** @var array */
    private $temps = [];
    
    /** @var array */
    private $temperatures = [];

    /** @var array */
    private $nebulosites = [];

    /** @var array */
    private $probabilites = [];

    /** @var array */
    private $precipitations = [];

    /** @var array */
    private $directions = [];

    /** @var array */
    private $vitesses = [];

    /** @var array */
    private $humiditesRelatives = [];

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->dates = array_map(
            function (string $jour): string {
                return $this->removeHtml($jour);
            },
            $data['jour']
        );
        $this->temps = array_map(
            function (string $temps): string {
                return (string) (new \SimpleXMLElement($temps))->div->attributes()['title'];
            },
            $data['icon']
        );
        $this->temperatures = array_map(
            function (string $temperature): string {
                $temperature = $this->removeHtml($temperature);
                $temperature = explode(" ", $temperature);

                return $this->formatTemperature($temperature[0]);
            },
            $data['temp']
        );
        $this->nebulosites = array_map(
            function (string $nebulosite): string {
                return $this->removeHtml($nebulosite);
            },
            $data['neb']
        );
        $this->probabilites = array_map(
            function (string $probabilite): string {
                return $probabilite;
            },
            $data['prob']
        );
        $this->precipitations = array_map(
            function (string $precipitation): string {
                $precipitation = explode(static::PRECIPITATION, $this->removeHtml($precipitation));

                return $this->formatPrecipitation($precipitation[0]);
            },
            $data['quant']
        );
        $this->directions = array_map(
            function (string $direction): string {
                return $this->removeHtml($direction);
            },
            $data['dirvent']
        );
        $this->vitesses = array_map(
            function (string $vitesse): string {
                $vitesse = explode(static::VITESSE, $this->removeHtml($vitesse));

                return $this->formatVitesse($vitesse[0]);
            },
            $data['speed']
        );
        $this->humiditesRelatives = array_map(
            function (string $humiditeRelative): string {
                return $this->removeHtml($humiditeRelative);
            },
            $data['humid']
        );
    }

    public function getDates(): array
    {
        return $this->dates;
    }

    public function getTemps(): array
    {
        return $this->temps;
    }

    public function getTemperatures(): array
    {
        return $this->temperatures;
    }

    public function getNebulosites(): array
    {
        return $this->nebulosites;
    }

    public function getProbabilites(): array
    {
        return $this->probabilites;
    }

    public function getPrecipitations(): array
    {
        return $this->precipitations;
    }

    public function getDirections(): array
    {
        return $this->directions;
    }

    public function getVitesses(): array
    {
        return $this->vitesses;
    }

    public function getHumiditesRelatives(): array
    {
        return $this->humiditesRelatives;
    }

    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'dates' => $this->getDates(),
                'temps' => $this->getTemps(),
                'temperatures' => $this->getTemperatures(),
                'nebulosites' => $this->getNebulosites(),
                'probabilites' => $this->getProbabilites(),
                'precipitations' => $this->getPrecipitations(),
                'directions' => $this->getDirections(),
                'vitesses' => $this->getVitesses(),
                'humiditesRelatives' => $this->getHumiditesRelatives(),
            ]
        );
    }
}
