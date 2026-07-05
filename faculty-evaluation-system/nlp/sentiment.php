<?php

require_once "dictionary.php";

function analyzeSentiment($text){

    global $positiveWords;
    global $negativeWords;
    global $stopWords;

    $text = strtolower($text);

    $text = preg_replace("/[^a-zA-Z ]/", "", $text);

    $words = explode(" ", $text);

    $positive = 0;
    $negative = 0;

    foreach($words as $word){

        if(in_array($word,$stopWords)){
            continue;
        }

        if(in_array($word,$positiveWords)){
            $positive++;
        }

        if(in_array($word,$negativeWords)){
            $negative++;
        }

    }

    $total = $positive + $negative;

    if($total == 0){

        return [
            'sentiment'=>'Neutral',
            'confidence'=>50
        ];

    }

    if($positive > $negative){

        return [

            'sentiment'=>'Positive',

            'confidence'=>round(($positive/$total)*100,2)

        ];

    }

    if($negative > $positive){

        return [

            'sentiment'=>'Negative',

            'confidence'=>round(($negative/$total)*100,2)

        ];

    }

    return [

        'sentiment'=>'Neutral',

        'confidence'=>50

    ];

}