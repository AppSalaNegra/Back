<?php

namespace App\Users\Application;

use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Endpoint para cambio de contraseña de un usuario.
 * Primero valida que el usuario exista y que la contraseña actual sea correcta.
 * */

class UserChangePassword extends UserAction
{
    public function __construct(UsersRepository $repository, private readonly FindUserById $finder)
    {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $userId = $data['id'];
        $password = hash('sha256', $data['password']);
        $newPassword = $data['newPassword'];

        $email = $this->finder->findUserById($userId)->email();
        $user = $this->repository->findByEmailAndPassword($email, $password);
        if (null === $user) {
            throw new UserNotFound();
        }
        $user->changePassword(hash('sha256', $newPassword));
        $this->repository->save($user);
        return $this->respondWithData();
    }
}
