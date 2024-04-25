<?php

namespace App\Users\Application\Actions;

use App\Users\Application\Authentication\Token;
use App\Users\Domain\Exception\UserNotFound;
use Psr\Http\Message\ResponseInterface as Response;

class UserLoginAction extends UserAction
{
    protected function action(): Response
    {
        $data     = $this->getFormData();
        $email    = $data['email'];
        $password = hash('sha256', $data['password']);
        $user     = $this->repository->findByEmailAndPassword($email, $password);
        if (null === $user) {
            throw new UserNotFound();
        }
        $token = Token::createToken($user);
        return $this->respondWithData(['token' => $token]);
    }
}
