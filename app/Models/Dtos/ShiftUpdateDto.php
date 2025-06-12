<?php

namespace App\Models\Dtos;

final class ShiftUpdateDto
{
	public function __construct(
		private int $id,
		private string $name,
		private string $startTime,
		private string $endTime,
		private string $description
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

	public function getStartTime(): string
	{
		return $this->startTime;
	}

	public function getEndTime(): string
	{
		return $this->endTime;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['id'],
			$data['name'],
			$data['start_time'],
			$data['end_time'],
			$data['description']
		);
	}
}
