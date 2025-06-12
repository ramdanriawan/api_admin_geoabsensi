<?php

namespace App\Models\Dtos;

final class EmployeeOffDayStoreDto
{
	public function __construct(private int $employeeId, private int $offTypeId, private int $quota)
	{
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
