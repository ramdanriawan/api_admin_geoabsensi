<?php

namespace App\Models\Dtos;

final class PaySlipStoreDto
{
	public function __construct(
		private int    $userId,
		private string $periodStart,
		private string $periodEnd,
		private int    $basicSalary,
		private int    $mealAllowance,
		private int    $transportAllowance,
		private int    $overTimePay,
		private int    $bonus,
		private int    $deductionBpjsKesehatan,
		private int    $deductionBpjsKetenagakerjaan,
		private int    $deductionPph21,
		private int    $deductionLateOrLeave,
		private ?string   $note,
		private string $status
	) {
	}

	public function getUserId(): int
	{
		return $this->userId;
	}

	public function getPeriodStart(): string
	{
		return $this->periodStart;
	}

	public function getPeriodEnd(): string
	{
		return $this->periodEnd;
	}

	public function getBasicSalary(): int
	{
		return $this->basicSalary;
	}

	public function getMealAllowance(): int
	{
		return $this->mealAllowance;
	}

	public function getTransportAllowance(): int
	{
		return $this->transportAllowance;
	}

	public function getOverTimePay(): int
	{
		return $this->overTimePay;
	}

	public function getBonus(): int
	{
		return $this->bonus;
	}

	public function getDeductionBpjsKesehatan(): int
	{
		return $this->deductionBpjsKesehatan;
	}

	public function getDeductionBpjsKetenagakerjaan(): int
	{
		return $this->deductionBpjsKetenagakerjaan;
	}

	public function getDeductionPph21(): int
	{
		return $this->deductionPph21;
	}

	public function getDeductionLateOrLeave(): int
	{
		return $this->deductionLateOrLeave;
	}

	public function getNote(): ?string
	{
		return $this->note;
	}

	public function getStatus(): string
	{
		return $this->status;
	}

    public static function fromJson(array $data): self
	{
		return new self(
			$data['user_id'],
			$data['period_start'],
			$data['period_end'],
			$data['basic_salary'],
			$data['meal_allowance'],
			$data['transport_allowance'],
			$data['overTime_pay'],
			$data['bonus'],
			$data['deduction_bpjs_kesehatan'],
			$data['deduction_bpjs_ketenagakerjaan'],
			$data['deduction_pph21'],
			$data['deduction_late_or_leave'],
			$data['note'] ?? null,
			$data['status']
		);
	}
}
