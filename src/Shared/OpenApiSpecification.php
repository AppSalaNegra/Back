<?php

declare(strict_types=1);

namespace App\Shared;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Sala negra API Documentation",
 *     description="HTTP methods included in Sala Negra back-end API",
 *     @OA\Contact(name="Martín Ramonda Sáenz"),
 * ),
 * @OA\Server(
 *      url="https://localhost:8080",
 *      description="Sala Negra App API"
 * ),
 * @OA\SecurityScheme(
 *       securityScheme="bearerAuth",
 *       name="bearer",
 *       type="http",
 *       in="header",
 *       scheme="bearer",
 *       bearerFormat="JWT",
 * ),
 * @OA\Schema(
 *      title="Category",
 *      schema="cat",
 *      type="object",
 *      @OA\Property(property= "id", type="integer", example=7),
 *      @OA\Property(property= "name",type="string", example="Canalla"),
 * ),
 * @OA\Schema(
 *        title="Event",
 *        schema="event",
 *        type="object",
 *        @OA\Property(property="id", type="string", format="uuid"),
 *        @OA\Property(property="startDateTime", type="string", format="date-time"),
 *        @OA\Property(property="finishDateTime", type="string", format="date-time"),
 *        @OA\Property(property="title", type="string"),
 *        @OA\Property(property="excerpt", type="string"),
 *        @OA\Property(property="url", type="string"),
 *        @OA\Property(property="slug", type="string"),
 *        @OA\Property(property="thumbnail_url", type="string"),
 *        @OA\Property(property="cats", type="array", @OA\Items(ref="#/components/schemas/cat")),
 *        @OA\Property(property="status", type="string"),
 *        @OA\Property(property="hierarchy", type="string"),
 *        @OA\Property(property="type", type="string"),
 * ),
 * @OA\Schema(
 *        title="Post",
 *        schema="post",
 *        type="object",
 *        @OA\Property(property="id", type="string", format="uuid"),
 *        @OA\Property(property="dateTime", type="string", format="date-time"),
 *        @OA\Property(property="title", type="string"),
 *        @OA\Property(property="excerpt", type="string"),
 *        @OA\Property(property="url", type="string"),
 *        @OA\Property(property="slug", type="string"),
 *        @OA\Property(property="thumbnail_url", type="string"),
 *        @OA\Property(property="cats", type="array", @OA\Items(ref="#/components/schemas/cat")),
 *        @OA\Property(property="status", type="string"),
 * ),
 * @OA\Schema(
 *        title="Login",
 *        schema="login",
 *        type="object",
 *        @OA\Property(property="token", type="string"),
 *        @OA\Property(property="id", type="string", format="uuid"),
 * )
 *
 **/
final class OpenApiSpecification
{
}
