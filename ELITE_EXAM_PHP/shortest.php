<?php
    function shortestWord($value) {
    $words = explode(" ", $value);
    $shortest = $words[0];

        foreach ($words as $word) {
            if (strlen($word) < strlen($shortest)) {
                $shortest = $word;
            }
        }

        return $shortest;
    }

    echo shortestWord("TRUE FRIENDS ARE ME AND YOU") . "\n";
    echo shortestWord("I AM THE LEGENDARY VILLAIN");
?>

