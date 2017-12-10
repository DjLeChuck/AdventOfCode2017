<?php

    $input = trim(file_get_contents('./inputs/10.txt'));
    $lengths = explode(',', $input);
    $list = range(0, 255);

    $position = 0;
    $skip = 0;
    $lengthsCount = count($lengths);

    foreach ($lengths as $i => $offset) {
        $fullSkip = $position + $skip;

        // Extraction de la séquence
        $extract = array_slice($list, $fullSkip, $offset);

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

            array_splice($list, $fullSkip, $extractCount, $endExtract);
            array_splice($list, 0, $extractDiff, $beginExtract);
        } else {
            array_splice($list, $fullSkip, $offset, $extract);
        }

        // Ne pas incrémenter $skip lors du premier passage
        if (0 < $i) {
            ++$skip;
        }

        $position = $offset;

        var_dump('Offset: '.$offset.' - List: '.implode(', ', $list));

        // Si dernier passage, on en refait un
        /*if ($i === $lengthsCount - 1) {
            $lengths[] = ;
        }*/
    }

    //var_dump($list);
