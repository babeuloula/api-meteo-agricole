<?php

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */

declare(strict_types=1);

namespace App\Meteo;

final class Ville implements \JsonSerializable
{
    /** @var string */
    private $ville;

    /** @var ?string */
    private $codePostal;

    public function __construct(string $value)
    {
        $values = explode(' ', $value);

        $codePostal = (string) end($values);
        $codePostal = ltrim($codePostal, '(');
        $codePostal = rtrim($codePostal, ')');

        unset($values[\count($values) - 1]);
        $ville = $values;

        $this->ville = implode(" ", $ville);
        $this->codePostal = mb_strlen($codePostal) > 0 ? $codePostal : null;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    /** @return mixed[] */
    public function jsonSerialize(): array
    {
        return [
            'ville' => $this->getVille(),
            'codePostal' => $this->getCodePostal(),
        ];
    }
}
