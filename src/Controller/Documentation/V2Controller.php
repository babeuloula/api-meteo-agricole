<?php
/**
 * @author BaBeuloula <info@babeuloula.fr>
 */
declare(strict_types=1);

namespace App\Controller\Documentation;

use Symfony\Component\HttpFoundation\Response;

class V2Controller
{
    /** @var string */
    private $kernelProjectDir;

    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    public function __invoke(): Response
    {
        return new Response(file_get_contents($this->kernelProjectDir."/docs/v2/index.html"));
    }
}
