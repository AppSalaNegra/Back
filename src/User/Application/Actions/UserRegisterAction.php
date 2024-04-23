<?php

namespace App\User\Application\Actions;

use App\User\Domain\Exception\UserAlreadyExists;
use App\User\Domain\User;
use Psr\Http\Message\ResponseInterface as Response;

class UserRegisterAction extends UserAction
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
        $this->userRepository->save($user);

        return $this->respondWithData(['registered' => 'ok']);
    }

    /**
     * @throws UserAlreadyExists
     */
    private function ensureEmailIsUnique(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);
        if (null !== $user) {
            throw new UserAlreadyExists();
        }
    }
}
