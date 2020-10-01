<?php

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */

declare(strict_types=1);

namespace App\Meteo;

final class LastTenDays extends Meteo
{
    /** @var string[] */
    private $dates = [];
    
    /** @var string[] */
    private $temperaturesMin = [];
    
    /** @var string[] */
    private $temperaturesMax = [];

    /** @var string[] */
    private $temperaturesMoyennes = [];
    
    /** @var string */
    private $station;
    
    /** @var string[] */
    private $humiditesRelatives = [];
    
    /** @var string[] */
    private $vitesses = [];

    /** @var string[] */
    private $rafales = [];

    /** @var string[] */
    private $directions = [];

    /** @var string[] */
    private $precipitations = [];

    /** @var string[] */
    private $probabilites = [];

    /** @var string[] */
    private $pluiesMax = [];

    /** @var string[] */
    private $nebulosites = [];

    /** @var string[] */
    private $heuresEnsoleillement = [];
    
    /** @var string[] */
    private $rosees = [];
    
    /** @var string[] */
    private $chaleurs = [];

    public function __construct(array $data)
    {
        parent::__construct($data);

        for ($i = 1; $i <= 10; $i++) {
            $this->dates[] = $this->removeHtml($data['dateJ' . $i]);
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->temperaturesMin[] = $this->formatTemperature($this->removeHtml($data['tmin' . $i]));
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->temperaturesMax[] = $this->formatTemperature($this->removeHtml($data['tmax' . $i]));
        }
        for ($i = 1; $i <= 7; $i++) {
            $this->temperaturesMoyennes[] = $this->formatTemperature($this->removeHtml($data['moy' . $i]));
        }
        $this->station = $data["stn"];
        for ($i = 1; $i <= 10; $i++) {
            $this->humiditesRelatives[] = $data['hum' . $i];
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->vitesses[] = $this->formatVitesse($data['vit' . $i]);
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->rafales[] = $this->formatVitesse($this->removeHtml($data['vitMax' . $i]));
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->directions[] = $this->removeHtml($data['dir' . $i]);
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->precipitations[] = $this->removeHtml($data['quan' . $i]);
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->probabilites[] = $data['prob' . $i];
        }
        for ($i = 1; $i <= 7; $i++) {
            $this->pluiesMax[] = $this->removeHtml($data['pmax' . $i]);
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->nebulosites[] = $this->removeHtml($data['neb' . $i]);
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->heuresEnsoleillement[] = $data['ensol' . $i];
        }
        for ($i = 1; $i <= 7; $i++) {
            $this->rosees[] = $this->formatTemperature($data['rose' . $i]);
        }
        for ($i = 1; $i <= 10; $i++) {
            $this->chaleurs[] = $this->formatTemperature($this->removeHtml($data['chal' . $i]));
        }
    }

    /** @return string[] */
    public function getDates(): array
    {
        return $this->dates;
    }

    /** @return string[] */
    public function getTemperaturesMin(): array
    {
        return $this->temperaturesMin;
    }

    /** @return string[] */
    public function getTemperaturesMax(): array
    {
        return $this->temperaturesMax;
    }

    /** @return string[] */
    public function getTemperaturesMoyennes(): array
    {
        return $this->temperaturesMoyennes;
    }

    public function getStation(): string
    {
        return $this->station;
    }

    /** @return string[] */
    public function getHumiditesRelatives(): array
    {
        return $this->humiditesRelatives;
    }

    /** @return string[] */
    public function getVitesses(): array
    {
        return $this->vitesses;
    }

    /** @return string[] */
    public function getRafales(): array
    {
        return $this->rafales;
    }

    /** @return string[] */
    public function getDirections(): array
    {
        return $this->directions;
    }

    /** @return string[] */
    public function getPrecipitations(): array
    {
        return $this->precipitations;
    }

    /** @return string[] */
    public function getProbabilites(): array
    {
        return $this->probabilites;
    }

    /** @return string[] */
    public function getPluiesMax(): array
    {
        return $this->pluiesMax;
    }

    /** @return string[] */
    public function getNebulosites(): array
    {
        return $this->nebulosites;
    }

    /** @return string[] */
    public function getHeuresEnsoleillement(): array
    {
        return $this->heuresEnsoleillement;
    }

    /** @return string[] */
    public function getRosees(): array
    {
        return $this->rosees;
    }

    /** @return string[] */
    public function getChaleurs(): array
    {
        return $this->chaleurs;
    }

    /** @return mixed[] */
    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'dates' => $this->getDates(),
                'temperaturesMin' => $this->getTemperaturesMin(),
                'temperaturesMax' => $this->getTemperaturesMax(),
                'temperaturesMoyennes' => $this->getTemperaturesMoyennes(),
                'station' => $this->getStation(),
                'humiditesRelatives' => $this->getHumiditesRelatives(),
                'vitesses' => $this->getVitesses(),
                'rafales' => $this->getRafales(),
                'directions' => $this->getDirections(),
                'precipitations' => $this->getPrecipitations(),
                'probabilites' => $this->getProbabilites(),
                'pluiesMax' => $this->getPluiesMax(),
                'nebulosites' => $this->getNebulosites(),
                'heuresEnsoleillement' => $this->getHeuresEnsoleillement(),
                'rosees' => $this->getRosees(),
                'chaleurs' => $this->getChaleurs(),
            ]
        );
    }
}
