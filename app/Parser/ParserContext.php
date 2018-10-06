<?php

namespace App\Parser;

use App\Proxy;

/**
 * @author Afanasyev Pavel <bupyc9@gmail.com>
 */
class ParserContext implements ParserContextInterface
{
    private $strategy;

    public function __construct(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(StrategyInterface $strategy): ParserContextInterface
    {
        $this->strategy = $strategy;

        return $this;
    }

    /**
     * @param string $url
     * @return int
     * @throws ParserException
     */
    public function executeStrategy(string $url): int
    {
        $items = $this->strategy->execute($url);

        foreach ($items as $item) {
            $proxy = Proxy::query()->where(['ip_address' => $item->getIpAddress(), 'port' => $item->getPort()])->first();

            if (null === $proxy) {
                $proxy = new Proxy();
            }

            $proxy->ip_address = $item->getIpAddress();
            $proxy->port = $item->getPort();
            $proxy->protocol = \strtolower($item->getProtocol());
            $proxy->country = $item->getCountry();
            $proxy->anonymity = $item->getAnonymity();

            $proxy->save();
        }

        return \count($items);
    }
}