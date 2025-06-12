<?php

namespace App\Models\Dtos;

final class UserAdminStoreDto
{
    public function __construct(
        private string  $name,
        private string  $email,
        private ?string $emailVerifiedAt,
        private string  $password,
        private ?string $rememberToken,
        private ?string $profilePicture,
        private ?string $level,
        private ?string $status,

    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->emailVerifiedAt;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }


    public
    static function fromJson(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['email_verified_at'],
            $data['password'],
            $data['remember_token'],
            $data['profile_picture'],
            $data['level'],
            $data['status'],
        );
    }
}
