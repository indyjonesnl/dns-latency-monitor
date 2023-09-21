<?php

namespace App\Repository;

use App\Document\LatencyMeasurement;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/** @extends DocumentRepository<LatencyMeasurement> */
final class LatencyMeasurementRepository extends DocumentRepository
{
    public function __construct(DocumentManager $dm)
    {
        parent::__construct($dm, $dm->getUnitOfWork(), $dm->getClassMetadata(LatencyMeasurement::class));
    }

    public function save(LatencyMeasurement $latencyMeasurement): void
    {
        $this->getDocumentManager()->persist($latencyMeasurement);
        $this->getDocumentManager()->flush();
    }
}