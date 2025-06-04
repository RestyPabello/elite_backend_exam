<?php
    function findWordIndexes($words, $target) {
        $indexes = [];

        foreach ($words as $index => $word) {
            if ($word === $target) {
                $indexes[] = $index;
            }
        }

        return $indexes;
    }

    $words  = ["I", "TWO", "FORTY", "THREE", "JEN", "TWO", "tWo", "Two"];
    $target = "TWO";

    $result = findWordIndexes($words, $target);
    echo "Output: INDEX " . implode(" and INDEX ", $result);

?>