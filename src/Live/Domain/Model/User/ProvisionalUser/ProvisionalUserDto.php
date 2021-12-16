<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User\ProvisionalUser;

final class ProvisionalUserDto
{
    public function __construct(
        private string $id,
        private string $email,
        private string $password,
        private string $date,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
