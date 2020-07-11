<?php

namespace App\Console\Commands;

use App\Gameplays;
use App\Games;
use App\Players;
use Faker\Generator as Faker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dump($this->generatePlayers(), 'done generating players');
        dump($this->generateGames(), 'done generating games');
        dump($this->generateGamePlays(), 'done generating game plays');
        return 0;
    }

    public function generatePlayers()
    {
        $players = [];
        for ($i=0; $i < 10000; $i++) {
            $data = [
                'name' => $this->faker->name,
                'nickname' => $this->faker->firstName,
                'email' => $this->faker->email,
                'password' => Hash::make($this->faker->password),
                'last_login' => now()
            ];
            array_push($players, $data);
        }
        return Players::insert($players);
    }

    public function generateGames()
    {
        // make a single query of all the data instead of one by one
        $games = [
            'Call of Duty',
            'Mortal Kombat',
            'FIFA',
            'Just Cause',
            'Apex Legend'
        ];

        $years = [
            '2010',
            '2011',
            '2012',
            '2013',
            '2014',
            '2015',
            '2016',
            '2017',
            '2018',
            '2019',
            '2020'
        ];

        $queryArray = [];

        for ($i=0; $i < 11; $i++) {

            // dump( new \DateTime($years[$i].'-01-01T01:00:00.000000Z'), 'date');
            // dump($years[$i], 'year');
            // die();
            foreach ($games as $key => $name) {
                $data = [
                    'name' => $name,
                    'version' => $years[$i],
                    'created_at' => new \DateTime($years[$i].'-01-01T01:00:00.000000Z'), //use year
                    'updated_at' =>  new \DateTime($years[$i].'-01-01T01:00:00.000000Z'),
                ];
                array_push($queryArray, $data);
            }
        }

        return Games::insert($queryArray);
    }

    public function generateGamePlays()
    {

        $players = Players::all()->skip(0)->take(1500)->toArray();

        $games = Games::all();
        $startDate = new \DateTime('2010-01-01T05:42:58.000000Z');

        for ($i=1; $i < 3836; $i++) {

            // represent 1500 players each day
            foreach ($players as $key => $player) {

                $currentDate = $startDate->getTimestamp() + ($i * 24 * 60 * 60);
                $isNotValid = true;
                $countSafe = 0;
                $gamePlayed = null;
                while ($isNotValid || $countSafe === count($games)) {
                    $countSafe += 1;
                    $gameIndex = rand(0, count($games) - 1);
                    $gamePlayed = $games[$gameIndex];

                    if($currentDate > $gamePlayed->created_at->getTimestamp()) {
                        $isNotValid = false;
                    }
                }


                $gamemi = Gameplays::create([
                    'gameId' => $gamePlayed->id,
                    'playerId' => $player['id'],
                    'isHost' => true,
                    'created_at' =>  new \DateTime('@' . $currentDate),
                    'updated_at' => new \DateTime('@' . $currentDate),
                ]);
            }
        }
    }
}
