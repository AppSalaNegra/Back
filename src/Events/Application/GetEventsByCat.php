<?php

namespace App\Events\Application;

use App\Events\Domain\Exception\UnknowCategory;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

/*
 * Caso de uso para obtener los eventos de la base de datos que coincidan con la categoría proporcionada.
 * También comprueba que la categoría proporcionada sea válida.
 * */
final class GetEventsByCat extends EventAction
{
    /**
     * @OA\Get(
     *     path="/events/getByCat",
     *     tags={"Events"},
     *     summary="Obtiene eventos cuya categoría coincida con la pasada en la cabecera.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del evento a crear",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="cat", type="string", description="Categoría del evento")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Lista de eventos que incluyen esa categoría",
     *         @OA\JsonContent(
     *             @OA\Examples(
     *                 example="0",
     *                 summary="Encontrados eventos!",
     *                 value={
     *                     {
     *                         "id": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
     *                         "startDateTime": "dateTime",
     *                         "finishDateTime": "dateTime",
     *                         "title": "string",
     *                         "excerpt": "string",
     *                         "url": "string",
     *                         "slug": "string",
     *                         "thumbnail_url": "string",
     *                         "cats": "collection",
     *                         "status": "string",
     *                         "hierarchy": "string",
     *                         "type": "string"
     *                     }
     *                 }
     *             ),
     *             @OA\Examples(
     *                 example="1",
     *                 summary="No se encontraron eventos",
     *                 value={}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="400",description="Bad Request."),
     *     @OA\Response(response="401",description="UNAUTHENTICATED")
     *   )
     * )
     */
    protected function action(): Response
    {
        $data = $this->getFormData();
        $this->validateInput($data);

        $cat = $data['cat'];

        $events = $this->repository->getByCat($this->getCatCode($cat));
        return $this->respondWithData($events);
    }

    private function getCatCode(string $cat): string
    {
        return match ($cat) {
            'Destacado' => '13',
            'Familiares' => '8',
            'Música' => '9',
            'Teatro' => '5',
            'Canalla' => '7',
            'Especial' => '30',
            'Poesía' => '11',
            'Magia' => '6',
            default => throw new UnknowCategory($this->request),
        };
    }

    public function validateInput(array|null|object $data): void
    {
        if (empty($data['cat'])) {
            throw new HttpBadRequestException($this->request);
        }
    }
}
