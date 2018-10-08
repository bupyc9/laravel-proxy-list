<?php

use Faker\Generator as Faker;

$factory->define(
    \App\Proxy::class, function (Faker $faker) {
    return [
        'ip_address' => $faker->ipv4,
        'port' => random_int(1, 65536),
        'country' => $faker->country,
        'protocol' => $faker->randomElement(['http', 'https']),
        'anonymity' => $faker->randomElement(
            [
                \App\Proxy::ANONYMITY_ANONYMOUS,
                \App\Proxy::ANONYMITY_NO,
                \App\Proxy::ANONYMITY_HEIGHT
            ]
        ),
    ];
}
);
