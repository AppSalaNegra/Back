<?php

namespace App\Users\Application;

use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Caso de uso "Eliminar usuario". Elimina un usuario de la base de datos.
 */
class RemoveUser extends UserAction
{
    public function __construct(UsersRepository $repository, private readonly FindUserById $finder)
    {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $userId = $data['id'];
        $user = $this->finder->findUserById($userId);
        $this->repository->remove($user);
        return $this->respondWithData();
    }
}
