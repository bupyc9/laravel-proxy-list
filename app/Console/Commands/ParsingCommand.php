<?php

namespace App\Console\Commands;

use App\Parser\ParserContext;
use App\Parser\ParserException;
use App\Parser\Strategies\FreeProxyListStrategy;
use Illuminate\Console\Command;

class ParsingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parsing {strategy} {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing proxy servers';

    private $strategies = [];

    public function __construct()
    {
        parent::__construct();

        $this->strategies[FreeProxyListStrategy::getName()] = FreeProxyListStrategy::class;
    }

    /**
     * @throws ParserException
     */
    public function handle(): void
    {
        $strategyName = $this->argument('strategy');
        if (!\array_key_exists($strategyName, $this->strategies)) {
            $this->error('Strategy not found');
            return;
        }

        $url = $this->argument('url');

        $strategy = new $this->strategies[$strategyName];
        $parserContext = new ParserContext($strategy);
        $count = $parserContext->executeStrategy($url);

        $this->info("Parsed `$count` proxies");
    }
}
