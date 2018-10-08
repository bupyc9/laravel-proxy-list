<?php

namespace App\Console\Commands;

use App\Jobs\CheckProxyJob;
use App\Proxy;
use Illuminate\Console\Command;

class CheckProxiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run check proxies';

    public function handle(): void
    {
        $i = 0;
        Proxy::query()->each(
            function (Proxy $proxy) use (& $i) {
                CheckProxyJob::dispatch($proxy);
                $i++;
            }
        );

        $this->info("Create `$i` jobs");
    }
}
