<?php

namespace App\Models\Dtos;

final class MotivationalStoreDto
{
	public function __construct(private string $word)
	{
	}

	public function getWord(): string
	{
		return $this->word;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['word']
		);
	}
}
