<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GamesTest extends TestCase
{
    use RefreshDatabase;
    private $url = '/api/v1';

    /**
     * A get games feature test.
     *
     * @return void
     */
    public function testGetGames()
    {
        $response = $this->get($this->url . '/games');

        dump($response->json());
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'msg',
            'data' => [
                'games'
            ]
        ]);
    }
}
