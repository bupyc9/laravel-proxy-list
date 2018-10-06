<?php

namespace App\Parser\Strategies;

use App\Parser\Item;
use App\Parser\ParserException;
use App\Parser\StrategyInterface;
use App\Proxy;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author Afanasyev Pavel <bupyc9@gmail.com>
 */
class FreeProxyListStrategy implements StrategyInterface
{
    public static function getName(): string
    {
        return 'free-proxy-list';
    }

    /**
     * @param string $url
     * @return Collection|Item[]
     * @throws ParserException
     */
    public function execute(string $url): Collection
    {
        try {
            $client = new Client();
            $response = $client->request('GET', $url);

            $crawler = new Crawler();
            $crawler->addHtmlContent($response->getBody()->getContents());
            $trElements = $crawler->filter('.table-responsive .table tbody tr');
            $items = collect([]);
            foreach ($trElements as $trElement) {
                $data = [];
                $crawler = new Crawler($trElement);
                $tdElements = $crawler->filter('td');
                foreach ($tdElements as $tdElement) {
                    $data[] = $tdElement->nodeValue;
                }

                $item = new Item();

                $item->setIpAddress((string)$data[0]);
                $item->setPort((int)$data[1]);
                $item->setCountry((string)$data[3]);
                $item->setProtocol($data[6] === 'yes' ? 'https' : 'http');
                $anonymityMap = [
                    'anonymous' => Proxy::ANONYMITY_ANONYMOUS,
                    'elite proxy' => Proxy::ANONYMITY_HEIGHT,
                    'transparent' => Proxy::ANONYMITY_NO,
                ];
                $item->setAnonymity($anonymityMap[$data[4]]);

                $items->push($item);
            }

            return $items;
        } catch (InvalidArgumentException $e) {
            throw new ParserException($e->getMessage(), 0, $e);
        } catch (GuzzleException $e) {
            throw new ParserException('Guzzle: ' . $e->getMessage(), 0, $e);
        }
    }
}