<?php

namespace App\Posts\Infrastructure;

use App\Posts\Domain\Post;
use App\Posts\Domain\PostEncodeFailed;
use DateTime;
use Throwable;

/*
 * Clase que se encarga de parsear los datos de la API de Actua a mi modelo de datos. Si falla tira excepción
*/
class PostEncoder
{
    public function parseDataToPost(array $postData): Post
    {
        try {
            $dateTime = DateTime::createFromFormat("Y-m-d\TH:i:s", $postData['dateTime']);
            $title = $postData['title'];
            $excerpt = $postData['excerpt'];
            $url = $postData['url'];
            $slug = $postData['slug'];
            $thumbnail_url = $postData['thumbnail_url'];
            $cats = is_bool($postData['cats']) ? [] : $postData['cats'];
            $status = $postData['status'];
            return new Post($dateTime, $title, $excerpt, $url, $slug, $thumbnail_url, $cats, $status);
        } catch (Throwable) {
            throw new PostEncodeFailed();
        }
    }
}
