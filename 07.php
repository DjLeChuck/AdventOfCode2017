<?php

    $input = trim(file_get_contents('./inputs/07.txt'));
    $arr = explode("\n", $input);

    $names = [];
    $towerBase = null;

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

    // Partie 1
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

            // Dans une des tours au-dessus. On arrête.
            if (in_array($name, $oData['above'])) {
                $inSomeoneAbove = true;

                break;
            }
        }

        if (!$inSomeoneAbove) {
            $towerBase = $name;

            echo 'Result: '.$name."\n";
        }
    }

    // Partie 2
    $baseData = $names[$towerBase];

    $weights = [];

    foreach ($baseData['above'] as $name) {
        $data = $names[$name];
        $weight = $data['weight'];

        array_walk($data['above'], function ($aboveName) use (&$weight, $names) {
            $weight += $names[$aboveName]['weight'];
        });

        $weights[$name] = $weight;
    }

    asort($weights);

    $first = reset($weights);
    $second = next($weights);
    $last = end($weights);
    $wrong = null;
    $goodWeight = null;
    $badWeight = null;

    if ($first !== $second) {
        $wrong = array_search($first, $weights);
        $goodWeight = $second;
        $badWeight = $first;
    } else if ($first !== $last) {
        $wrong = array_search(end($weights), $weights);
        $goodWeight = $first;
        $badWeight = $last;
    }
var_dump($weights);
    if (null !== $wrong) {
        $diff = abs($badWeight - $goodWeight);

        echo 'Result2: '.(abs($names[$wrong]['weight'] - $diff))."\n";
    }
