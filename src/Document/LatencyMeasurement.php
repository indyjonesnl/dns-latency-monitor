<?php

namespace App\Document;

use App\Repository\LatencyMeasurementRepository;
use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as Mongo;
use Doctrine\ODM\MongoDB\Types\Type;

#[Mongo\Document(repositoryClass: LatencyMeasurementRepository::class)]
class LatencyMeasurement
{
    #[Mongo\Id]
    private ?string $id = null;

    #[Mongo\Field(type: Type::FLOAT)]
    private ?float $latencyInMilliseconds = null;

    #[Mongo\Field(type: Type::DATE)]
    private DateTime $measurementTime;

    public function __construct(
        #[Mongo\File\Metadata(targetDocument: DnsEndpoint::class)]
        private readonly DnsEndpoint $dnsEndpoint,
    )
    {
        $this->measurementTime = new DateTime();
    }

    public function getDnsEndpoint(): DnsEndpoint
    {
        return $this->dnsEndpoint;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setLatencyInMilliseconds(?float $latencyInMilliseconds): self
    {
        $this->latencyInMilliseconds = $latencyInMilliseconds;
        return $this;
    }

    public function getMeasurementTime(): DateTime
    {
        return $this->measurementTime;
    }

    public function getLatencyInMilliseconds(): ?float
    {
        return $this->latencyInMilliseconds;
    }
}