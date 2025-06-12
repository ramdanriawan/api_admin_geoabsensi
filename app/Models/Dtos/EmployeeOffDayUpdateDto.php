<?php

namespace App\Models\Dtos;

final class EmployeeOffDayUpdateDto
{
	public function __construct(
		private int $id,
		private int $employeeId,
		private int $offTypeId,
        private int $quota
	) {
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getEmployeeId(): int
	{
		return $this->employeeId;
	}

	public function getOffTypeId(): int
	{
		return $this->offTypeId;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['id'],
			$data['employee_id'],
			$data['off_type_id'],
			$data['quota'],
		);
	}

    public function getQuota(): int
    {
        return $this->quota;
    }
}
