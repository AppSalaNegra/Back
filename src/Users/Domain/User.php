<?php

declare(strict_types=1);

namespace App\Users\Domain;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
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
    /** @ODM\Field(type="collection") */
    private array $likedEvents;

    public function __construct(
        string $email,
        string $firstName,
        string $lastName,
        string $password,
        array $likedEvents
    ) {
        $this->email = strtolower($email);
        $this->firstName = ucfirst($firstName);
        $this->lastName = ucfirst($lastName);
        $this->password = $password;
        $this->likedEvents = $likedEvents;
    }

    public function id()
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function likedEvents(): array
    {
        return $this->likedEvents;
    }

    public function addLikedEvent(string $eventId): void
    {
        $this->likedEvents[] = $eventId;
    }

    public function removeLikedEvent(string $eventId): void
    {
        $position = array_search($eventId, $this->likedEvents);
        if ($position !== false) {
            unset($this->likedEvents[$position]);
        }
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'likedEvents' => $this->likedEvents,
        ];
    }
}
