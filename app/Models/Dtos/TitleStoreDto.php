<?php

namespace App\Models\Dtos;

final class TitleStoreDto
{
	public function __construct(
		private string $name,
		private string $basicSalary,
		private string $penaltyPerLate,
		private string $mealAllowancePerPresent,
		private string $transportAllowancePerPresent,
		private string $overTimePayPerHours
	) {
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getBasicSalary(): string
	{
		return $this->basicSalary;
	}

	public function getPenaltyPerLate(): string
	{
		return $this->penaltyPerLate;
	}

	public function getMealAllowancePerPresent(): string
	{
		return $this->mealAllowancePerPresent;
	}

	public function getTransportAllowancePerPresent(): string
	{
		return $this->transportAllowancePerPresent;
	}

	public function getOverTimePayPerHours(): string
	{
		return $this->overTimePayPerHours;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['name'],
			$data['basic_salary'],
			$data['penalty_per_late'],
			$data['meal_allowance_per_present'],
			$data['transport_allowance_per_present'],
			$data['overTime_pay_per_hours']
		);
	}
}
