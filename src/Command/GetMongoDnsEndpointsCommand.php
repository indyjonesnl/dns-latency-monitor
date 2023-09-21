<?php

namespace App\Command;

use App\Repository\DnsEndpointRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('endpoints')]
final class GetMongoDnsEndpointsCommand extends Command
{
    public function __construct(
        private readonly DnsEndpointRepository $dnsEndpointRepository,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $documents = $this->dnsEndpointRepository->findAll();
        $output->writeln('Count: ' . \count($documents));
        $output->writeln(implode(PHP_EOL, $documents));

        return self::SUCCESS;
    }
}