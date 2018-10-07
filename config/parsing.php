<?php
/**
 * @author Afanasyev Pavel <bupyc9@gmail.com>
 */

return [
    'sources' => [
        [
            'strategy' => \App\Parser\Strategies\FreeProxyListStrategy::class,
            'url' => 'https://free-proxy-list.net/',
        ],
    ],
];