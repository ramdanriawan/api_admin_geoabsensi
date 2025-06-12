<?php

namespace App\Models\Dtos;

final class ShiftStoreDto
{
	public function __construct(
		private string $name,
		private string $startTime,
		private string $endTime,
		private string $description
	) {
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
			$data['name'],
			$data['start_time'],
			$data['end_time'],
			$data['description']
		);
	}
}
