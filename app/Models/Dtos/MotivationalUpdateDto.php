<?php

namespace App\Models\Dtos;

final class MotivationalUpdateDto
{
	public function __construct(private int $id, private string $word)
	{
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getWord(): string
	{
		return $this->word;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['id'],
			$data['word']
		);
	}
}
