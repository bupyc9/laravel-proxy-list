<?php

namespace App\Parser;

/**
 * @author Afanasyev Pavel <bupyc9@gmail.com>
 */
interface ParserContextInterface
{
    public function __construct(StrategyInterface $strategy);

    public function setStrategy(StrategyInterface $strategy): self;

    /**
     * @param string $url
     * @return int
     * @throws ParserException
     */
    public function executeStrategy(string $url): int;
}