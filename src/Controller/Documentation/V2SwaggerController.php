<?php

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */

declare(strict_types=1);

namespace App\Controller\Documentation;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class V2SwaggerController
{
    /** @var string */
    private $kernelProjectDir;

    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    public function __invoke(): Response
    {
        return new Response(file_get_contents($this->kernelProjectDir . "/docs/v2/swagger.yaml"));
    }
}
