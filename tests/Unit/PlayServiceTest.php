<?php

namespace Tests\Unit;
use App\Services\PlayService;
use App\Helpers\CardHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

use Tests\TestCase;

class PlayServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testGeneratedHandIsValid(): void
    {
        $playService =  $this->app->make(PlayService::class);
        $generatedHand = $playService->generateHand();

        foreach($generatedHand as $card) {
            $this->assertContains($card, CardHelper::VALID_CARDS);
        }
    }

    public function testGeneratedHandIsValidWhenSizeIsProvided(): void
    {
        $playService =  $this->app->make(PlayService::class);
        $generatedHand = $playService->generateHand(5);

        foreach($generatedHand as $card) {
            $this->assertContains($card, CardHelper::VALID_CARDS);
        }
    }

    public function testGeneratedDistinctHandIsValid(): void
    {
        $playService =  $this->app->make(PlayService::class);
        $generatedHand = $playService->generateDistinctHand();

        foreach($generatedHand as $card) {
            $this->assertContains($card, CardHelper::VALID_CARDS);
        }

        $this->assertTrue(count($generatedHand) === count(array_flip($generatedHand)));
    }

    public function testGeneratedDistinctHandIsValidWhenSizeIsProvided(): void
    {
        $playService =  $this->app->make(PlayService::class);
        $generatedHand = $playService->generateDistinctHand(5);

        foreach($generatedHand as $card) {
            $this->assertContains($card, CardHelper::VALID_CARDS);
        }

        $this->assertTrue(count($generatedHand) === count(array_flip($generatedHand)));
    }

    public function testGetPlayScore(): void {

        $userHand = ['A', '2', '3', 'K', '7'];
        $cpuHand = ['Q', '2', '5', 'Q', '5'];
        $expectedResult = [
                    "user_score" => 3,
                    "cpu_score" => 1,
                    "result" => "WON",
                    "resultHand" => [
                      "WON",
                      "TIE",
                      "LOST",
                      "WON",
                      "WON",
                    ],
                  ];

        $playService =  $this->app->make(PlayService::class);
        $actualResult = $playService->getPlayScore($userHand, $cpuHand);

        $this->assertEquals($expectedResult, $actualResult);

    }

    public function testStorePlayResult(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $playScore = [
                    "user_score" => 3,
                    "cpu_score" => 1,
                    "result" => "WON",
                    "resultHand" => [
                      "WON",
                      "TIE",
                      "LOST",
                      "WON",
                      "WON",
                    ],
                  ];
        $data = [
            'distinct' => false,
            'cards' => ['A', '2', '3', 'K', '7']
        ];

        $cpuHand = ['Q', '2', '5', 'Q', '5'];

        $playService =  $this->app->make(PlayService::class);
        $actualResult = $playService->storePlayResult($user, compact(['playScore', 'data', 'cpuHand']));

        $this->assertDatabaseHas('plays',

            [
                "user_id" => $user->id,
                "user_hand" => json_encode(['A', '2', '3', 'K', '7']),
                "cpu_hand" => json_encode(['Q', '2', '5', 'Q', '5'])
            ]

        );

    }

}
