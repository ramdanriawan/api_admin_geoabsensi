<?php

namespace App\Models\Dtos;

final class PlatformStoreDto
{
    public function __construct(
        private int $applicationId,
        private string $name) {

    }

    public function getApplicationId(): int
    {
        return $this->applicationId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromJson(array $data): self
    {
        return new self(
            $data['application_id'],
            $data['name']
        );
    }

    public function getId(): int
    {
        return $this->id;
    }
}
