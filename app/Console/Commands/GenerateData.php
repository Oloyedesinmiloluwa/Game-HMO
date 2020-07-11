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
        dump($this->generatePlayers());
        dump($this->generateGames());
        dump($this->generateGamePlays());
        return 0;
    }

    public function generateData()
    {

        $game = Games::create([
            'name' => 'Mortal Kombat',
            'version' => '2010'
        ]);
        return $game;
    }

    public function generatePlayers()
    {
        //10000
        $players = [];
        for ($i=0; $i < 10; $i++) {
            $data = [
                'name' => $this->faker->name,
                'nickname' => $this->faker->firstName,
                'email' => $this->faker->email,
                'password' => Hash::make($this->faker->password),
                'last_login' => now()// new \DateTime()
            ];
            array_push($players, $data);
        }
        return Players::insert($players);

        // Players::create(
        //     [
        //         'name' => $this->faker->name,
        //         'nickname' => $this->faker->firstName,
        //         'email' => $this->faker->email,
        //         'password' => Hash::make($this->faker->password),
        //         'last_login' => now()// new \DateTime()
        //     ]
        //     );
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

        //3,835 days of gaming can start from 2010
        // at least 1500 players must have a game play per day and one of them can host or not
        // the system should handle who started a game and the invitees but each player has a separate record
            // with only max of 4 players
            // and they must have the same game version
        // add game versions as the years in the loop, may not have to
        // instead add games and their versions separately

        $players = Players::all()->skip(0)->take(3)->toArray();
        // dump($players, 'players');
        // die();

        $games = Games::all();
        // dump($games[1], 'games format');
        // die();
        $startDate = new \DateTime('2010-01-01T05:42:58.000000Z');
        // dump($startDate, 'sgtart date');
        // die();
        // try {
        //     //code...
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        for ($i=1; $i < 12; $i++) { //3836

            // represent 1500 players each day
            foreach ($players as $key => $player) {

                // //games may not have value
                // foreach ($games as $key => $game) {

                // }
                $currentDate = $startDate->getTimestamp() + ($i * 24 * 60 * 60);
                $isNotValid = true;
                $countSafe = 0;
                $gamePlayed = null;
                while ($isNotValid || $countSafe === count($games)) {
                    $countSafe += 1;
                    $gameIndex = rand(0, count($games) - 1);
                    // dump($gameIndex, 'index');
                    $gamePlayed = $games[$gameIndex];
                    // dump($gamePlayed, 'played');
                    // die();
                    if($currentDate > $gamePlayed->created_at->getTimestamp()) {
                        $isNotValid = false;
                    }
                }

                // dump(new \DateTime('@' . $currentDate), 'date');die();

                // dump($gamePlayed, 'played');
                // die();
                // dump($player, 'player');
                // die();
                $gamemi = Gameplays::create([
                    'gameId' => $gamePlayed->id, //make _
                    'playerId' => $player['id'],
                    'isHost' => true,
                    'created_at' =>  new \DateTime('@' . $currentDate),
                    'updated_at' => new \DateTime('@' . $currentDate),
                ]);
                dump($gamemi, 'gameplayed');
                // use year added
            }
        }
    }
}
