<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Pagination\CursorPaginator;

interface PlayInterface
{
    /**
     * Generate a new hand with valid cards
     *
     * @param int $handSize
     *
     * @return array
     */
    public function generateHand(int $handSize): array;

    /**
     * Get the score from a play
     *
     * @param array $userHand
     * @param array $gameHand
     *
     * @return array
     */
    public function getPlayScore(array $userHand, array $gameHand): array;

    /**
     * Save the game's result to the database
     *
     * @param User $user
     * @param array $result
     * @return void
     * @throws \Throwable
     */
    public function storePlayResult(User $user, array $result): void;

    /**
     * Get leaderboard for X amount of users
     *
     * @param int $leaderboardSize number of users to display
     * @return CursorPaginator
     */
    public function getLeaderboard(int $leaderboardSize): CursorPaginator;
}
