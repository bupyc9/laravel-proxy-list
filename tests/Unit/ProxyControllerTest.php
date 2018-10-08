<?php

namespace Tests\Unit;

use App\Proxy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProxyControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndex(): void
    {
        factory(Proxy::class, 1)->create();

        $response = $this->json('GET', route('api.proxies.index'));

        $response
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'created_at',
                        'updated_at',
                        'ip_address',
                        'port',
                        'protocol',
                        'country',
                        'anonymity',
                    ],
                ]
            );
    }
}
