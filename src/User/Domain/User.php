<?php

declare(strict_types=1);

namespace App\User\Domain;

use JsonSerializable;

/** @ODM\Document(collection="users") */
class User implements JsonSerializable
{
    /** @ODM\Id(strategy="AUTO") */
    private $id;
    /** @ODM\Field(type="string") */
    private string $email;
    /** @ODM\Field(type="string") */
    private string $firstName;
    /** @ODM\Field(type="string") */
    private string $lastName;
    /** @ODM\Field(type="string") */
    private string $password;


    public function __construct(string $email, string $firstName, string $lastName, string $password)
    {
        $this->email     = strtolower($email);
        $this->firstName = ucfirst($firstName);
        $this->lastName  = ucfirst($lastName);
        $this->password  = $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'        => $this->id,
            'email'     => $this->email,
            'firstName' => $this->firstName,
            'lastName'  => $this->lastName,
            'password'  => $this->password,
        ];
    }
}
