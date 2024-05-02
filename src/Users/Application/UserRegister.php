<?php

namespace App\Users\Application;

use App\Users\Domain\Exception\UserAlreadyExists;
use App\Users\Domain\User;
use Psr\Http\Message\ResponseInterface as Response;

class UserRegister extends UserAction
{
    protected function action(): Response
    {
        $data = $this->getFormData();
        $email = $data['email'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $password = $data['password'];
        $this->ensureEmailIsUnique($email);
        $user = new User($email, $firstName, $lastName, hash('sha256', $password), []);
        $this->repository->save($user);

        return $this->respondWithData(['registered' => 'ok']);
    }

    /**
     * @throws UserAlreadyExists
     */
    private function ensureEmailIsUnique(string $email): void
    {
        $user = $this->repository->findByEmail($email);
        if (null !== $user) {
            throw new UserAlreadyExists();
        }
    }
}