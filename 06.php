<?php

    $input = trim(file_get_contents('./inputs/06.txt'));
    $arr = explode("\t", $input);

    $passed = [];
    $alreadySeen = false;
    $size = count($arr);
    $steps = 0;
    $diff = 0;

    do {
        $max = max($arr);
        $index = array_search($max, $arr);

        $arr[$index] = 0; // blank current

        ++$index; // next block

        for ($x = $max; $x > 0; $x--) {
            if ($index >= $size) {
                $index = 0;
            }

            ++$arr[$index];

            ++$index;
        }

        $hash = md5(serialize($arr));

        ++$steps;

        if (!in_array($hash, $passed)) {
            $passed[] = $hash;
        } else {
            $diff = $steps - (array_search($hash, $passed) + 1);
            $alreadySeen = true;
        }
    } while (!$alreadySeen);

    echo 'Result: '.$steps."\n";
    echo 'Result2: '.$diff."\n";
