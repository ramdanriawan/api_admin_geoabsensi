<?php

namespace App\Models\Dtos;

final class UserUpdateDto
{
	public function __construct(
		private int $id,
		private string $name,
		private ?string $password,
		private string $email
	) {
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['id'],
			$data['name'],
			$data['password'],
			$data['email']
		);
	}
}
