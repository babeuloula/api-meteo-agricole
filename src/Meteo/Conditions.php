<?php
/**
 * @author BaBeuloula <info@babeuloula.fr>
 */
declare(strict_types=1);

namespace App\Meteo;

final class Conditions extends Meteo
{
    /** @var string */
    private $temps;
    
    /** @var string */
    private $temperature;
    
    /** @var string */
    private $temperatureRessentie;
    
    /** @var string */
    private $rosee;
    
    /** @var string */
    private $vitesse;
    
    /** @var string */
    private $direction;

    /** @var string */
    private $nebulosite;

    /** @var string */
    private $humiditeRelative;
    
    /** @var string */
    private $pressionAtmospherique;
    
    /** @var string */
    private $distanceVisibilite;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->temps = $data["resume"];
        $this->temperature = $this->formatTemperature($data["temperature"]);
        $this->temperatureRessentie = $this->formatTemperature($data["ress"]);
        $this->rosee = $this->formatTemperature($data["rose"]);
        $this->vitesse = $this->formatVitesse($data["vit"]);
        $this->direction = $data["dir"];
        $this->nebulosite = $data["neb"];
        $this->humiditeRelative = $data["humid"];
        $this->pressionAtmospherique = $this->formatPression($data["press"]);
        $this->distanceVisibilite = $this->formatDistance($data["visi"]);
    }

    public function getTemps(): string
    {
        return $this->temps;
    }

    public function getTemperature(): string
    {
        return $this->temperature;
    }

    public function getTemperatureRessentie(): string
    {
        return $this->temperatureRessentie;
    }

    public function getRosee(): string
    {
        return $this->rosee;
    }

    public function getVitesse(): string
    {
        return $this->vitesse;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function getNebulosite(): string
    {
        return $this->nebulosite;
    }

    public function getHumiditeRelative(): string
    {
        return $this->humiditeRelative;
    }

    public function getPressionAtmospherique(): string
    {
        return $this->pressionAtmospherique;
    }

    public function getDistanceVisibilite(): string
    {
        return $this->distanceVisibilite;
    }

    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'temps' => $this->getTemps(),
                'temparature' => $this->getTemperature(),
                'temperatureRessentie' => $this->getTemperatureRessentie(),
                'rosee' => $this->getRosee(),
                'vitesse' => $this->getVitesse(),
                'direction' => $this->getDirection(),
                'nebulosite' => $this->getNebulosite(),
                'humiditeRelative' => $this->getHumiditeRelative(),
                'pressionAtmospherique' => $this->getPressionAtmospherique(),
                'distanceVisibilite' => $this->getDistanceVisibilite(),
            ]
        );
    }
}
