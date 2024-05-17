<?php

namespace App\Posts\Application;

use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;

/*
 * Endpoint para la obtención de todos los posts en bd.
 * */
final class GetAllPosts extends PostAction
{
    /**
     * @OA\Get(
     *     path="/posts",
     *     tags={"Posts"},
     *     summary="Obtiene todos los posts existentes en la base de datos.",
     *     security={{"bearerAuth": {}}},
     *       @OA\Response(
     *          response="200",
     *          description="Lista de posts",
     *          @OA\JsonContent(
     *              @OA\Examples(
     *                  example="0",
     *                  summary="Encontrados posts!",
     *                      value={
     *                      {
     *                          "id": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
     *                          "dateTime": "dateTime",
     *                          "title": "string",
     *                          "excerpt": "string",
     *                          "url": "string",
     *                          "slug": "string",
     *                          "thumbnail_url": "string",
     *                          "cats": "collection",
     *                          "status": "string",
     *                      }
     *                  }
     *              ),
     *              @OA\Examples(
     *                  example="1",
     *                  summary="No se encontraron posts",
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
        $posts = $this->repository->getAll();
        return $this->respondWithData($posts);
    }
}
