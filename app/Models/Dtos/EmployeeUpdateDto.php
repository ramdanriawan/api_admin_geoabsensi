<?php

namespace App\Models\Dtos;

final class EmployeeUpdateDto
{
	public function __construct(
		private int $id,
		private int $titleId,
		private int $userId
	) {
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getTitleId(): int
	{
		return $this->titleId;
	}

	public function getUserId(): int
	{
		return $this->userId;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['id'],
			$data['title_id'],
			$data['user_id']
		);
	}
}
