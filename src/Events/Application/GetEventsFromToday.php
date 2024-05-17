<?php

namespace App\Events\Application;

use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;

/*
 * Caso de uso sencillo que recoge todos los eventos que haya en la bd desde el día hoy
 * */
final class GetEventsFromToday extends EventAction
{
    /**
     * @OA\Get(
     *     path="/events/get",
     *     tags={"Events"},
     *     summary="Obtiene todos los eventos desde la fecha de hoy.",
     *     security={{"bearerAuth": {}}},
     *       @OA\Response(
     *          response="200",
     *          description="Lista de eventos",
     *          @OA\JsonContent(
     *              @OA\Examples(
     *                  example="0",
     *                  summary="Encontrados eventos!",
     *                      value={
     *                      {
     *                          "id": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
     *                          "startDateTime": "dateTime",
     *                          "finishDateTime": "dateTime",
     *                          "title": "string",
     *                          "excerpt": "string",
     *                          "url": "string",
     *                          "slug": "string",
     *                          "thumbnail_url": "string",
     *                          "cats": "collection",
     *                          "status": "string",
     *                          "hierarchy": "string",
     *                          "type": "string"
     *                      }
     *                  }
     *              ),
     *              @OA\Examples(
     *                  example="1",
     *                  summary="No se encontraron eventos",
     *                  value={}
     *              )
     *          )
     *       ),
     *       @OA\Response(response="401",description="UNAUTHENTICATED"),
     *     )
     *   )
     * )
     */
    protected function action(): Response
    {
        $events = $this->repository->getFromToday();
        return $this->respondWithData($events);
    }
}
