<?php

    $input = trim(file_get_contents('./inputs/07.txt'));
    $arr = explode("\n", $input);

    $names = [];

    foreach ($arr as $line) {
        $matches = [];

        preg_match('/^([a-z]*) \(([0-9]*)\)( -> ([a-z, ]*))?$/', $line, $matches);

        $name = $matches[1];
        $weight = $matches[2];
        $above = isset($matches[4]) ? explode(', ', $matches[4]) : [];

        $names[$name] = [
            'weight' => $weight,
            'above' => $above,
        ];
    }

    foreach ($names as $name => $data) {
        // Rien au-dessus ? On passe.
        if (empty($data['above'])) {
            continue;
        }

        $inSomeoneAbove = false;

        foreach ($names as $oName => $oData) {
            if ($name === $oName) {
                continue;
            }

            // Pas dans
            if (in_array($name, $oData['above'])) {
                $inSomeoneAbove = true;

                break;
            }
        }

        if (!$inSomeoneAbove) {
            echo 'Result: '.$name."\n";
        }
    }
