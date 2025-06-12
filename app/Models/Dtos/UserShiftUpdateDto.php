<?php

namespace App\Models\Dtos;

final class UserShiftUpdateDto
{
	public function __construct(
		private int $id,
		private int $userId,
		private int $shiftId
	) {
	}

	public function getId(): int
	{
		return $this->id;
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
			$data['id'],
			$data['user_id'],
			$data['shift_id']
		);
	}
}
