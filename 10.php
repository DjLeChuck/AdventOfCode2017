<?php

    $input = trim(file_get_contents('./inputs/10.txt'));
    $lengths = explode(',', $input);
    $list = range(0, 255);

    // Test values
    $position = 0;
    $skip = 0;
    $lengthsCount = count($lengths);
    $listCount = count($list);

    foreach ($lengths as $i => $offset) {
        // Extraction de la séquence
        $extract = array_slice($list, $position, $offset);

        // Si pas assez d'éléments à la fin du tableau, on prend depuis le début
        $extractCount = count($extract);
        $extractDiff = $offset - $extractCount;

        if ($offset > $extractCount) {
            $extract = array_merge(
                $extract,
                array_slice($list, 0, $extractDiff)
            );
        }

        // Inversion des valeurs
        $extract = array_reverse($extract);

        // Remplacement de l'extraction
        if ($offset > $extractCount) {
            $endExtract = array_slice($extract, 0, $extractCount);
            $beginExtract = array_slice($extract, $extractCount, $extractDiff);

            array_splice($list, $position, $extractCount, $endExtract);
            array_splice($list, 0, $extractDiff, $beginExtract);
        } else {
            array_splice($list, $position, $offset, $extract);
        }

        $position += $offset + $skip;

        if ($position > $listCount) {
            $position -= $listCount;
        }

        ++$skip;
    }

    echo 'Result: '.($list[0] * $list[1])."\n";
