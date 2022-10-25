<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Play;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function testNewGameCreated(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userHand = [
            'distinct' => false,
            'cards' => ['A', '2', 'Q', '5']
        ];
        $this->postJson(
            '/play',
            $userHand
        )
            ->assertRedirect('/game')
            ->assertValid();
    }

    public function testNewDistinctGameCreated(): void
    {
        $user = User::factory()->create();
                $this->actingAs($user);

                $userHand = [
                    'distinct' => true,
                    'cards' => ['A', '2', 'Q', '5']
                ];
        $this->postJson(
            '/play',
            $userHand
        )
            ->assertRedirect('/game')
            ->assertValid();
    }

    /**
     * Test a New game with invalid card sequence
     */
    public function testNewGameError(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userHand = [
            'distinct' => false,
            'cards' => ['1', 'A', 'd', 'e', 'k']
        ];

        $response = $this->postJson('/play', $userHand);

        $response
            ->assertUnprocessable()
            ->assertValid(['user_id'])
            ->assertInvalid(['cards'])
            ->assertJsonValidationErrors('cards')
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    /**
     * Test a New game with a valid card sequence
     */
    public function testLeaderboardData(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get('/leaderboard')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'name',
                        'total_games',
                        'wins'
                    ],
                ],
            ]);
    }
}
