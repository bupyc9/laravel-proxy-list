<?php

namespace App\Parser;

use Illuminate\Support\Collection;

/**
 * @author Afanasyev Pavel <bupyc9@gmail.com>
 */
interface StrategyInterface
{
    /**
     * @param string $url
     * @return Collection|Item[]
     * @throws ParserException
     */
    public function execute(string $url): Collection;
}