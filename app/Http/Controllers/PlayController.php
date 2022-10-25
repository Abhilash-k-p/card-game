<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayRequest;
use App\Services\PlayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PlayController extends Controller
{

    /**
     * @param PlayRequest $playRequest
     * @param PlayService $playService
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function start(PlayRequest $playRequest, PlayService $playService): RedirectResponse
    {
        try {
            /**
             * Validate data
             */
            $data = $playRequest->validated();
            /**
             * Get CPU cards
             */
            $cpuHand = isset($data['distinct']) && $data['distinct'] === true ? $playService->generateDistinctHand(count($data['cards'])) : $playService->generateHand(count($data['cards']));
            /**
             * Get Result
             */
            $playScore = $playService->getPlayScore($data['cards'], $cpuHand);
            /**
             * Store Result
             */
            $playService->storePlayResult(Auth::user(), compact(['playScore', 'data', 'cpuHand']));
            /**
             * Redirect with Result
             */
            return redirect()->route('game')->with('gameResult', [
                'userCardSequence' => $data['cards'],
                'gameCardSequence' => $cpuHand,
                'playScore' => $playScore
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param PlayService $playService
     * @return JsonResponse
     */
    public function getLeaderboard(PlayService $playService): JsonResponse
    {
        /**
         * Get Leader Board data
         */
        $leaderBoardData = $playService->getLeaderboard(1);

        /**
         * Return Data
         */
        return response()->json(
            $leaderBoardData,
            Response::HTTP_OK
        );
    }
}
