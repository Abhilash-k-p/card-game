<?php

namespace App\Helpers;


class CardHelper {

    public const VALID_CARDS = [
        '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'
    ];

    public static function randomCards($noOfCards = null, $distinct = false): array
    {
        if ($noOfCards === null && !$distinct)
            $noOfCards = rand(1, 20);
        else if(($noOfCards === null || $noOfCards > count(self::VALID_CARDS)) && $distinct)
            $noOfCards = rand(1, count(Self::VALID_CARDS));

        $randomCards = [];

        for ($i = 0; $i < $noOfCards;) {
            $card = self::randomCard();
            if($distinct && !in_array($card, $randomCards)) {
                $randomCards[] = $card;
                $i++;
            } else if(!$distinct) {
                $randomCards[] = $card;
                $i++;
            }
        }

        return $randomCards;
    }

    public static function randomCard(): string
    {
        return self::VALID_CARDS[
            rand(0, count(CardHelper::VALID_CARDS) - 1)
        ];
    }

}
