<?php

namespace App\Repository;

use App\Document\DnsEndpoint;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/** @extends DocumentRepository<DnsEndpoint> */
final class DnsEndpointRepository extends DocumentRepository
{
    public function __construct(DocumentManager $dm)
    {
        parent::__construct($dm, $dm->getUnitOfWork(), $dm->getClassMetadata(DnsEndpoint::class));
    }

    /** @return DnsEndpoint[] */
    public function findAll(): array
    {
        return parent::findAll();
    }

    public function save(DnsEndpoint... $dnsEndpoints): void
    {
        foreach($dnsEndpoints as $dnsEndpoint) {
            $this->getDocumentManager()->persist($dnsEndpoint);
        }
        $this->getDocumentManager()->flush();
    }
}