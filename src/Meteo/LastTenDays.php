<?php
/**
 * @author BaBeuloula <info@babeuloula.fr>
 */
declare(strict_types=1);

namespace App\Meteo;

final class LastTenDays extends Meteo
{
    /** @var array */
    private $dates = [];
    
    /** @var array */
    private $temperaturesMin = [];
    
    /** @var array */
    private $temperaturesMax = [];

    /** @var array */
    private $temperaturesMoyennes = [];
    
    /** @var string */
    private $station;
    
    /** @var array */
    private $humiditesRelatives = [];
    
    /** @var array */
    private $vitesses = [];

    /** @var array */
    private $rafales = [];

    /** @var array */
    private $directions = [];

    /** @var array */
    private $precipitations = [];

    /** @var array */
    private $probabilites = [];

    /** @var array */
    private $pluiesMax = [];

    /** @var array */
    private $nebulosites = [];

    /** @var array */
    private $heuresEnsoleillement = [];
    
    /** @var array */
    private $rosees = [];
    
    /** @var array */
    private $chaleurs = [];

    public function __construct(array $data)
    {
        parent::__construct($data);

        for($i = 1; $i <= 10; $i++) {
            $this->dates[] = $this->removeHtml($data['dateJ'.$i]);
        }
        for($i = 1; $i <= 10; $i++) {
            $this->temperaturesMin[] = $this->formatTemperature($this->removeHtml($data['tmin'.$i]));
        }
        for($i = 1; $i <= 10; $i++) {
            $this->temperaturesMax[] = $this->formatTemperature($this->removeHtml($data['tmax'.$i]));
        }
        for($i = 1; $i <= 7; $i++) {
            $this->temperaturesMoyennes[] = $this->formatTemperature($this->removeHtml($data['moy'.$i]));
        }
        $this->station = $data["stn"];
        for($i = 1; $i <= 10; $i++) {
            $this->humiditesRelatives[] = $data['hum'.$i];
        }
        for($i = 1; $i <= 10; $i++) {
            $this->vitesses[] = $this->formatVitesse($data['vit'.$i]);
        }
        for($i = 1; $i <= 10; $i++) {
            $this->rafales[] = $this->formatVitesse($this->removeHtml($data['vitMax'.$i]));
        }
        for($i = 1; $i <= 10; $i++) {
            $this->directions[] = $this->removeHtml($data['dir'.$i]);
        }
        for($i = 1; $i <= 10; $i++) {
            $this->precipitations[] = $this->removeHtml($data['quan'.$i]);
        }
        for($i = 1; $i <= 10; $i++) {
            $this->probabilites[] = $data['prob'.$i];
        }
        for($i = 1; $i <= 7; $i++) {
            $this->pluiesMax[] = $this->removeHtml($data['pmax'.$i]);
        }
        for($i = 1; $i <= 10; $i++) {
            $this->nebulosites[] = $this->removeHtml($data['neb'.$i]);
        }
        for($i = 1; $i <= 10; $i++) {
            $this->heuresEnsoleillement[] = $data['ensol'.$i];
        }
        for($i = 1; $i <= 7; $i++) {
            $this->rosees[] = $this->formatTemperature($data['rose'.$i]);
        }
        for($i = 1; $i <= 10; $i++) {
            $this->chaleurs[] = $this->formatTemperature($this->removeHtml($data['chal'.$i]));
        }
    }

    public function getDates(): array
    {
        return $this->dates;
    }

    public function getTemperaturesMin(): array
    {
        return $this->temperaturesMin;
    }

    public function getTemperaturesMax(): array
    {
        return $this->temperaturesMax;
    }

    public function getTemperaturesMoyennes(): array
    {
        return $this->temperaturesMoyennes;
    }

    public function getStation(): string
    {
        return $this->station;
    }

    public function getHumiditesRelatives(): array
    {
        return $this->humiditesRelatives;
    }

    public function getVitesses(): array
    {
        return $this->vitesses;
    }

    public function getRafales(): array
    {
        return $this->rafales;
    }

    public function getDirections(): array
    {
        return $this->directions;
    }

    public function getPrecipitations(): array
    {
        return $this->precipitations;
    }

    public function getProbabilites(): array
    {
        return $this->probabilites;
    }

    public function getPluiesMax(): array
    {
        return $this->pluiesMax;
    }

    public function getNebulosites(): array
    {
        return $this->nebulosites;
    }

    public function getHeuresEnsoleillement(): array
    {
        return $this->heuresEnsoleillement;
    }

    public function getRosees(): array
    {
        return $this->rosees;
    }

    public function getChaleurs(): array
    {
        return $this->chaleurs;
    }

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
