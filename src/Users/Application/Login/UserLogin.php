<?php

namespace App\Users\Application\Login;

use App\Users\Application\Authentication\Token;
use App\Users\Application\UserAction;
use App\Users\Domain\Exception\UserNotFound;
use Psr\Http\Message\ResponseInterface as Response;

class UserLogin extends UserAction
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
