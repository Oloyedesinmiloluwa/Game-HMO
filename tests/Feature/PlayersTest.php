<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayersTest extends TestCase
{
    use RefreshDatabase;
    private $url = '/api/v1';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetPlayers()
    {
        $response = $this->get($this->url . '/players');

        // dump($response->json());
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'msg',
            'data' => [
                'players'
            ]
        ]);
    }
}
