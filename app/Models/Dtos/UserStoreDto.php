<?php

namespace App\Models\Dtos;

final class UserStoreDto
{
	public function __construct(
		private string $name,
		private string $password,
		private string $email
	) {
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getPassword(): string
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
			$data['name'],
			$data['password'],
			$data['email']
		);
	}
}
