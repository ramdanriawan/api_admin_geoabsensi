<?php

namespace App\Models\Dtos;

use Illuminate\Http\UploadedFile;

final class OrganizationUpdateDto
{
	public function __construct(
		private int $id,
		private string $name,
		private ?UploadedFile $logo,
		private string $description,
		private float $lat,
		private float $lng,
		private int $isActive
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

	public function getLogo(): ?UploadedFile
	{
		return $this->logo;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function getLat(): float
	{
		return $this->lat;
	}

	public function getLng(): float
	{
		return $this->lng;
	}

	public function getIsActive(): int
	{
		return $this->isActive;
	}

	public static function fromJson(array $data): self
	{
		return new self(
			$data['id'],
			$data['name'],
			$data['logo'],
			$data['description'],
			$data['lat'],
			$data['lng'],
			$data['is_active']
		);
	}
}
