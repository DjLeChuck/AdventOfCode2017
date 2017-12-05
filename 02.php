<?php

    $input = trim(file_get_contents('./inputs/02.txt'));
    $arr = explode("\n", $input);
    $checksum = 0;
    $checksum2 = 0;

    // Result 2: 768 -> too high

    foreach ($arr as $row) {
        $values = explode("\t", $row);

        // Partie 1
        list($min, $max) = [min($values), max($values)];

        $checksum += $max - $min;

        // Partie 2
        foreach ($values as $key => $value) {
            foreach ($values as $keyTwo => $valueTwo) {
                if ($key === $keyTwo) {
                    continue;
                }

                if (0 === $value % $valueTwo) {
                    $checksum2 += $value / $valueTwo;
                }
            }
        }
    }

    echo 'Result: '.$checksum."\n";
    echo 'Result2: '.$checksum2."\n";
