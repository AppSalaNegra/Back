<?php

namespace App\User\Application\Actions;

use App\User\Domain\UserNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class UserLoginAction extends UserAction
{
    protected function action(): Response
    {
        $data = $this->getFormData();
        $email = $data['email'];
        $password = hash('sha256', $data['password']);
        $user = $this->userRepository->findUserByEmailAndPassword($email, $password);
        if (null !== $user) {
            return $this->respondWithData();
        }
        throw new UserNotFoundException();
    }
}
