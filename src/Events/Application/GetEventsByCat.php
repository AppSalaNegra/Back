<?php

namespace App\Events\Application;

use App\Events\Domain\UnknowCategory;
use Psr\Http\Message\ResponseInterface as Response;

final class GetEventsByCat extends EventAction
{
    protected function action(): Response
    {
        $data = $this->getFormData();
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
}
