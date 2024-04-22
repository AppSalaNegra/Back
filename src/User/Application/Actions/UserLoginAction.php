<?php

namespace App\User\Application\Actions;

use App\User\Domain\Exception\UserNotFound;
use Psr\Http\Message\ResponseInterface as Response;

class UserLoginAction extends UserAction
{
    protected function action(): Response
    {
        $data = $this->getFormData();
        $email = $data['email'];
        $password = hash('sha256', $data['password']);
        $user = $this->userRepository->findByEmailAndPassword($email, $password);
        if (null === $user) {
            throw new UserNotFound();
        }
        return $this->respondWithData();
    }
}
