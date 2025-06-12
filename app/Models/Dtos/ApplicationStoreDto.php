<?php

namespace App\Models\Dtos;

final class ApplicationStoreDto
{
	public function __construct(
		private string $version,
		private string $name,
		private string $phone,
		private string $email,
		private string $developerName,
		private string $brand,
		private string $website,
		private string $releaseDate,
		private string $lastUpdate,
		private string $termsUrl,
		private string $privacyPolicyUrl,
		private int $maximumRadiusInMeters,
		private int $minimumVisitInMinutes,
		private int $isActive
	) {
	}

	public function getVersion(): string
	{
		return $this->version;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getPhone(): string
	{
		return $this->phone;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getDeveloperName(): string
	{
		return $this->developerName;
	}

	public function getBrand(): string
	{
		return $this->brand;
	}

	public function getWebsite(): string
	{
		return $this->website;
	}

	public function getReleaseDate(): string
	{
		return $this->releaseDate;
	}

	public function getLastUpdate(): string
	{
		return $this->lastUpdate;
	}

	public function getTermsUrl(): string
	{
		return $this->termsUrl;
	}

	public function getPrivacyPolicyUrl(): string
	{
		return $this->privacyPolicyUrl;
	}

	public function getMaximumRadiusInMeters(): int
	{
		return $this->maximumRadiusInMeters;
	}

	public function getIsActive(): int
	{
		return $this->isActive;
	}


    public function getMinimumVisitInMinutes(): int
    {
        return $this->minimumVisitInMinutes;
    }

	public static function fromJson(array $data): self
	{
		return new self(
			$data['version'],
			$data['name'],
			$data['phone'],
			$data['email'],
			$data['developer_name'],
			$data['brand'],
			$data['website'],
			$data['release_date'],
			$data['last_update'],
			$data['terms_url'],
			$data['privacy_policy_url'],
			$data['maximum_radius_in_meters'],
			$data['minimum_visit_in_minutes'],
			$data['is_active'],
		);
	}

}
