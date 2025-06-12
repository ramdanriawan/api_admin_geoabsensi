<?php

namespace App\Models\Dtos;

final class UserShiftStoreDto
{
	public function __construct(private int $userId, private int $shiftId)
	{
	}

	public function getUserId(): int
	{
		return $this->userId;
	}

	public function getShiftId(): int
	{
		return $this->shiftId;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['user_id'],
			$data['shift_id']
		);
	}
}
