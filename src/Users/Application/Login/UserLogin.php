<?php

namespace App\Users\Application\Login;

use App\Users\Application\Authentication\Token;
use App\Users\Application\UserAction;
use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;

class UserLogin extends UserAction
{
    public function __construct(UsersRepository $repository, private readonly Token $token)
    {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data     = $this->getFormData();
        $email    = $data['email'];
        $password = hash('sha256', $data['password']);
        $user     = $this->repository->findByEmailAndPassword($email, $password);
        if (null === $user) {
            throw new UserNotFound();
        }
        $token = $this->token->createToken($user);
        return $this->respondWithData(['token' => $token]);
    }
}
