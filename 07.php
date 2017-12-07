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

    // Additionne de manière récursive les poids d'une tour et ses dépendances
    $getWeight = function ($item) use ($names, &$getWeight) {
      $weight = $item['weight'];

      foreach ($item['above'] as $name) {
        $weight += $getWeight($names[$name]);
      }

      return $weight;
    };

    $done = false;
    $current = $towerBase;
    $aboves = $baseData['above'];

    do {
      $weights = [];

      foreach ($aboves as $name) {
        $weights[$name] = $getWeight($names[$name]);
      }

      asort($weights);

      $first = reset($weights);
      $second = next($weights);
      $last = end($weights);

      if ($first === $second && $first !== $last) {
        $wrong = array_search($last, $weights);
      } elseif ($first !== $last) {
        $wrong = array_search($first, $weights);
      } else {
        $done = true;
        $sibling = null;

        // Récupération d'une des tours au même niveau
        foreach ($names as $name => $data) {
          if (in_array($current, $data['above'])) {
            $first = reset($data['above']);
            $sibling = $current === $first ? end($data['above']) : $first;

            break;
          }
        }

        $badWeight = $getWeight($names[$current]);
        $goodWeight = $getWeight($names[$sibling]);
        $diff = abs($badWeight - $goodWeight);

        echo 'Result2: '.(abs($names[$current]['weight'] - $diff))."\n";
      }

      $aboves = $names[$wrong]['above'];
      $current = $wrong;
    } while (!$done);
