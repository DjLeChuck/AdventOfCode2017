<?php

    $input = trim(file_get_contents('./inputs/08.txt'));
    $arr = explode("\n", $input);
    $data = [];
    $maxEver = 0;
    $doAction = function ($action, $var, $value) use (&$data) {
        switch ($action) {
            case 'inc':
                $data[$var] += $value;
                break;
            case 'dec':
                $data[$var] -= $value;
                break;
            default:
                throw new \Exception(sprintf('Action "%s" inconnue.', $action));
        }
    };
    $conditionIsValid = function ($left, $operator, $right) {
        // Je n'utiliserais pas d'eval ! è_é
        switch ($operator) {
            case '>':
                return $left > $right;
                break;
            case '<':
                return $left < $right;
                break;
            case '>=':
                return $left >= $right;
                break;
            case '<=':
                return $left <= $right;
                break;
            case '==':
                return $left === $right;
                break;
            case '!=':
                return $left !== $right;
                break;
            default:
                throw new \Exception(sprintf('Opérateur "%s" inconnu.', $operator));
        }
    };

    foreach ($arr as $line) {
        list(
            $var,  $action,  $value,
            $dummy,
            $conditionVar,  $conditionOperator,  $conditionValue
        ) = explode(' ', $line);

        $value = (int) $value;
        $conditionValue = (int) $conditionValue;

        if (!array_key_exists($var, $data)) {
            $data[$var] = 0;
        }

        if (!array_key_exists($conditionVar, $data)) {
            $data[$conditionVar] = 0;
        }

        if ($conditionIsValid($data[$conditionVar], $conditionOperator, $conditionValue)) {
            $doAction($action, $var, $value);

            $maxEver = max($data[$var], $maxEver);
        }
    }

    echo 'Result: '.max($data)."\n";
    echo 'Result2: '.$maxEver."\n";
