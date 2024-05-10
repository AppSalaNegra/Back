<?php

declare(strict_types=1);

namespace App\Shared;

final class OpenApiSpecification
{
/**
 *
 * @OA\Info(
 *     version="1.0.0",
 *     title="Sala negra API Documentation",
 *     description="HTTP methods included in Sala Negra back-end API",
 *     @OA\Contact(name="Martín Ramonda Sáenz"),
 * ),
 * @OA\Server(
 *      url="https://localhost:8080",
 *      description="Sala Negra App API"
 *  ),
 *
 * @OA\SecurityScheme(
 *       securityScheme="bearerAuth",
 *       name="bearer",
 *       type="http",
 *       in="header",
 *       scheme="bearer",
 *       bearerFormat="JWT",
 *   ),
 **/
}
