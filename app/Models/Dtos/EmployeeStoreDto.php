<?php

namespace App\Models\Dtos;

final class EmployeeStoreDto
{
	public function __construct(private int $titleId, private int $userId)
	{
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
			$data['title_id'],
			$data['user_id']
		);
	}
}
