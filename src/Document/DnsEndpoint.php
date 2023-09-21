<?php

namespace App\Document;

use App\Repository\DnsEndpointRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Types\Type;
use Stringable;

#[Document(repositoryClass: DnsEndpointRepository::class)]
class DnsEndpoint implements Stringable
{
    #[Id]
    private ?string $id = null;

    #[Field(type: Type::STRING)]
    private string $ip;

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function __toString(): string
    {
        return $this->getIp();
    }
}