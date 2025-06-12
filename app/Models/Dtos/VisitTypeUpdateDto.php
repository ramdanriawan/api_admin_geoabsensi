<?php

namespace App\Models\Dtos;

final class VisitTypeUpdateDto
{
	public function __construct(private int $id, private string $name)
	{
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['id'],
			$data['name']
		);
	}
}
