<?php
/**
 * @author BaBeuloula <info@babeuloula.fr>
 */
declare(strict_types=1);

namespace App\Controller\Meteo;

use App\Service\MeteoApi\MeteoApi;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LastTwoDaysController
{
    /** @var MeteoApi */
    private $meteoApi;

    public function __construct(MeteoApi $meteoApi)
    {
        $this->meteoApi = $meteoApi;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $term = $request->query->get('commune', null);

        if (false === is_string($term)) {
            return new JsonResponse([
                'message' => "Paramètre 'commune' manquant."
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($this->meteoApi->lastTwoDays($term));
    }
}
