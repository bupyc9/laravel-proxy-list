<?php

namespace App\Jobs;

use App\CheckProxy;
use App\Proxy;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CheckProxyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Proxy
     */
    private $proxy;

    public function __construct(Proxy $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function handle(): void
    {
        $client = new Client();

        $proxyUrl = 'tcp://' . $this->proxy->ip_address . ':' . $this->proxy->port;
        $checkProxy = $this->proxy->checkProxy;
        if (null === $checkProxy) {
            $checkProxy = new CheckProxy();
        }

        try {
            $response = $client->request(
                'GET',
                'http://checkip.dyndns.org/',
                [
                    RequestOptions::PROXY => [$this->proxy->protocol => $proxyUrl],
                    RequestOptions::TIMEOUT => 10,
                ]
            );

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                throw new \RuntimeException('Returned not status 200');
            }

            $checkProxy->status = CheckProxy::STATUS_OK;
        } catch (GuzzleException|Throwable $e) {
            $checkProxy->status = CheckProxy::STATUS_BAD;
        }

        $checkProxy->checked_at = Carbon::now();
        $this->proxy->checkProxy()->save($checkProxy);
    }
}
