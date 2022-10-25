<?php

namespace App\Http\Controllers;

use App\Services\PlayService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \Illuminate\Http\JsonResponse;

class CardController extends Controller
{
    public function randomCards(Request $request, PlayService $playService): JsonResponse
    {
        $randomCards = $request->query('distinct') == 'true' ? $playService->generateDistinctHand() : $playService->generateHand();
        return response()->json([
          'cards' => $randomCards
        ], Response::HTTP_OK
        );
    }
}
