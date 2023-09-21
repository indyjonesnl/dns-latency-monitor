<?php

namespace App\Command;

use App\Document\LatencyMeasurement;
use App\Repository\DnsEndpointRepository;
use App\Repository\LatencyMeasurementRepository;
use JJG\Ping;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('latency-checks')]
final class CheckDnsLatencyCommand extends Command
{
    public function __construct(
        private readonly DnsEndpointRepository $dnsEndpointRepository,
        private readonly LatencyMeasurementRepository $latencyMeasurementRepository,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dnsEndpoints = $this->dnsEndpointRepository->findAll();

        foreach($dnsEndpoints as $dnsEndpoint) {
            $latencyMeasurement = new LatencyMeasurement($dnsEndpoint);
            $ping = new Ping($dnsEndpoint->getIp());

            $latency = $ping->ping();

            if (is_numeric($latency)) {
                $latencyMeasurement->setLatencyInMilliseconds($latency);
                $this->latencyMeasurementRepository->save($latencyMeasurement);
                $output->writeln('Measured a latency of ' . $latency . 'ms to DNS ' . $dnsEndpoint->getIp());
            } else {
                $output->writeln('Request to ' . $dnsEndpoint->getIp() . ' timed out after ' . $ping->getTimeout() . 'ms.');
            }
        }

        $output->writeln('Done with all measurements.');

        return self::SUCCESS;
    }
}