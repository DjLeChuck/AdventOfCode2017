<?php

    $input = trim(file_get_contents('./inputs/01.txt'));
    $arr = str_split($input);
    $sum = 0;
    $length = count($arr);
    $mid = floor($length / 2);
    $sum2 = 0;

    for ($i = 0; $i < $length; $i++) {
        $number = (int) $arr[$i];

        // Partie 1
        if ($i === $length - 1) {
            $next = (int) reset($arr);
        } else {
            $next = (int) $arr[$i + 1];
        }

        if ($number === $next) {
            $sum += $number;
        }

        // Partie 2
        if ($i < $mid) {
            $other = (int) $arr[$mid + $i];
        } else {
            $other = (int) $arr[$i - $mid];
        }

        if ($number === $other) {
            $sum2 += $number;
        }
    }

    echo 'Result: '.$sum."\n";
    echo 'Result 2: '.$sum2."\n";
