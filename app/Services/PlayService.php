<?php

namespace App\Services;

use App\Contracts\PlayInterface;
use App\Helpers\CardHelper;
use App\Models\Play;
use App\Models\User;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;


class PlayService implements PlayInterface
{

    public const WON = 'WON';
    public const TIE = 'TIE';
    public const LOST = 'LOST';

    /**
     * @param int|null $handSize
     * @return array
     */
    public function generateHand(int $handSize = null): array
    {
        return CardHelper::randomCards($handSize);
    }

    /**
     * @param int|null $handSize
     * @return array
     */
    public function generateDistinctHand(int $handSize = null): array
    {
        return CardHelper::randomCards( noOfCards: $handSize, distinct: true);
    }

    /**
     * @param array $userHand
     * @param array $gameHand
     * @return array
     */
    public function getPlayScore(array $userHand, array $gameHand): array
    {
        $userScore = 0;
        $cpuScore = 0;
        $resultHand = [];

        foreach ($userHand as $index => $userCard) {
            $userCardValue = array_search($userCard, CardHelper::VALID_CARDS);
            $gameCardValue = array_search($gameHand[$index],CardHelper::VALID_CARDS);

            if ($userCardValue > $gameCardValue) {
                $userScore++;
                $resultHand[] = self::WON;
            } else if ($userCardValue < $gameCardValue) {
                $cpuScore++;
                $resultHand[] = self::LOST;
            } else {
                $resultHand[] = self::TIE;
            }
        }

        if ($userScore > $cpuScore) {
            $userStatus = self::WON;
        } else if ($userScore < $cpuScore) {
            $userStatus = self::LOST;
        } else {
            $userStatus = self::TIE;
        }

        return [
            'user_score' => $userScore,
            'cpu_score' => $cpuScore,
            'result' => $userStatus,
            'resultHand' => $resultHand
        ];
    }

    /**
     * @param User $user
     * @param array $result
     * @return void
     */
    public function storePlayResult(User $user, array $result): void
    {
        Play::create([
            'user_id' => $user->id,
            'user_score' => $result['playScore']['user_score'],
            'game_score' => $result['playScore']['cpu_score'],
            'user_hand' => $result['data']['cards'],
            'cpu_hand' => $result['cpuHand'],
            'result' => $result['playScore']['result'],
        ]);

        $user_winning_percent = $user->plays()->selectRaw("round(( sum(case when plays.result = 'WON' then 1 else 0 end)/count(*) * 100 ),2) as winning_percent")->first();

        $user->update([
            'user_winning_percent' => $user_winning_percent->winning_percent
        ]);

    }

    /**
     * @param int $leaderboardSize
     * @return CursorPaginator
     */
    public function getLeaderboard(int $leaderboardSize): CursorPaginator
    {
        return DB::table("users")->leftJoin("plays", function ($join) {
            $join->on("users.id", "=", "plays.user_id");
        })->selectRaw("users.name, users.id, users.user_winning_percent, count(distinct plays.id) as total_games, sum(case when plays.result = 'WON' then 1 else 0 end) as wins,
            sum(case when plays.result = 'LOST' then 1 else 0 end) as losses,
            sum(case when plays.result = 'TIE' then 1 else 0 end) as tie,
            round(( sum(case when plays.result = 'WON' then 1 else 0 end)/count(*) * 100 ),2) as winning_percent,
            max(plays.created_at) as latest_game,
            max(case when plays.result = 'WON' then plays.created_at else null end) as last_win,
            max(case when plays.result = 'LOST' then plays.created_at else null end) as last_lost")
            ->orderBy("users.user_winning_percent", "desc")
            ->orderBy("users.id")
            ->groupBy("users.id")
            ->cursorPaginate($leaderboardSize);
    }
}
