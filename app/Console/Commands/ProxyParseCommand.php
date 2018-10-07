<?php

namespace App\Console\Commands;

use App\Parser\ParserContext;
use App\Parser\ParserException;
use App\Parser\StrategyInterface;
use Illuminate\Console\Command;

class ProxyParseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing proxy servers';

    /**
     * @throws ParserException
     */
    public function handle(): void
    {
        $sources = config('parsing.sources');

        foreach ($sources as $source) {
            $strategy = new $source['strategy'];
            if (!$strategy instanceof StrategyInterface) {
                $this->error("Strategy `{$source['strategy']}` not implement interface " . StrategyInterface::class);
                continue;
            }
            if (!\filter_var($source['url'], FILTER_VALIDATE_URL)) {
                $this->error("Invalid url `{$source['url']}`");
                continue;
            }

            $parserContext = new ParserContext($strategy);
            $count = $parserContext->executeStrategy($source['url']);

            $this->info("Parsed `$count` proxies through strategy `{$source['strategy']}`");
        }
    }
}
