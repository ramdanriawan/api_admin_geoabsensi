<?php

namespace App\Models\Dtos;

final class TripTypeStoreDto
{
	public function __construct(private string $name)
	{
	}

	public function getName(): string
	{
		return $this->name;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['name']
		);
	}
}
