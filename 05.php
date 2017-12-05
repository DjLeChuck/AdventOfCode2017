<?php

    $input = trim(file_get_contents('./inputs/05.txt'));
    $arr = explode("\n", $input);

    $tab = $arr;
    $tab2 = $arr;
    $steps = 0;
    $steps2 = 0;
    $total = count($arr);
    $x = 0;
    $x2 = 0;

    do {
        // Valeur actuelle
        $value = $tab[$x];

        // Augmentation de cette dernière
        ++$tab[$x];

        // Avance jusqu'à la valeur avant modification
        $x += $value;

        // Nombre d'étapes
        ++$steps;
    } while ($x < $total);

    // Part 2: 19759170 -> too low

    do {
        // Valeur actuelle
        $value2 = $tab2[$x2];

        // Augmentation de cette dernière
        if ($value2 >= 3) {
            --$tab2[$x2];
        } else {
            ++$tab2[$x2];
        }

        // Avance jusqu'à la valeur avant modification
        $x2 += $value2;

        // Nombre d'étapes
        ++$steps2;
    } while ($x2 < $total);

    echo 'Result: '.$steps.'<br>';
    echo 'Result2: '.$steps2;
